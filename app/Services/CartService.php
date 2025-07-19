<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;   
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class CartService
{
    protected $redis;
    protected $cartKey = 'cart:';
    protected $ttl = 86400; // 24 hours

    public function __construct()
    {
       // For now, let's just use session storage directly
       $this->redis = null; // Force session storage for debugging
       
       // Use a simple cart key that will be consistent across requests
       $this->cartKey = Auth::check() ? 'user_cart_' . Auth::id() : 'guest_cart';
    }

    public function addToCart($productId, $quantity = 1)
    {
        $product = Product::find($productId);
        if (!$product) {
            throw new \Exception('Product not found');
        }

        if (!$product->is_active) {
            throw new \Exception('Product is not available');
        }

        $cart = $this->getCart();
        
        // If product already exists in cart, add to existing quantity
        if (isset($cart[$productId])) {
            $newQuantity = (int)$cart[$productId] + (int)$quantity;
        } else {
            $newQuantity = (int)$quantity;
        }

        // Check stock availability
        if ($newQuantity > $product->quantity) {
            throw new \Exception('Insufficient stock. Available: ' . $product->quantity);
        }

        $cart[$productId] = $newQuantity;
        $this->saveCart($cart);
        
        return [
            'success' => true,
            'message' => 'Product added to cart successfully',
            'cart_count' => $this->getCartCount()
        ];
    }

    public function removeFromCart($productId)
    {
        $cart = $this->getCart();
        
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            $this->saveCart($cart);
            
            return [
                'success' => true,
                'message' => 'Product removed from cart',
                'cart_count' => $this->getCartCount()
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Product not found in cart'
        ];
    }

    public function updateQuantity($productId, $quantity)
    {
        $product = Product::find($productId);
        if (!$product) {
            throw new \Exception('Product not found');
        }

        $quantity = (int)$quantity;
        if ($quantity <= 0) {
            return $this->removeFromCart($productId);
        }

        // Check stock availability
        if ($quantity > $product->quantity) {
            throw new \Exception('Insufficient stock. Available: ' . $product->quantity);
        }

        $cart = $this->getCart();
        $cart[$productId] = $quantity;
        $this->saveCart($cart);
        
        return [
            'success' => true,
            'message' => 'Cart updated successfully',
            'cart_count' => $this->getCartCount()
        ];
    }

    public function getCart()
    {
        return session()->get($this->cartKey, []);
    }

    public function getCartWithProducts()
    {
        $cart = $this->getCart();
        $cartItems = [];
        
        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => (int)$quantity,
                    'subtotal' => $product->price * $quantity
                ];
            }
        }
        
        return $cartItems;
    }

    public function getCartCount()
    {
        $cart = $this->getCart();
        return array_sum($cart);
    }

    public function getCartTotal()
    {
        $cartItems = $this->getCartWithProducts();
        return array_sum(array_column($cartItems, 'subtotal'));
    }

    public function clearCart()
    {
        session()->forget($this->cartKey);
        
        return [
            'success' => true,
            'message' => 'Cart cleared successfully',
            'cart_count' => 0
        ];
    }

    public function transferGuestCartToUser($userId)
    {
        // Get current guest cart
        $guestCart = $this->getCart();
        
        if (empty($guestCart)) {
            return;
        }
        
        // Update cart key to user-based
        $this->cartKey = 'user_cart_' . $userId;
        
        // Get existing user cart if any
        $userCart = $this->getCart();
        
        // Merge carts (user cart takes precedence for existing products)
        foreach ($guestCart as $productId => $quantity) {
            if (isset($userCart[$productId])) {
                $userCart[$productId] = (int)$userCart[$productId] + (int)$quantity;
            } else {
                $userCart[$productId] = (int)$quantity;
            }
        }
        
        // Save merged cart
        $this->saveCart($userCart);
        
        // Clear guest cart
        session()->forget('guest_cart');
    }

    protected function saveCart($cart)
    {
        if (empty($cart)) {
            session()->forget($this->cartKey);
        } else {
            session()->put($this->cartKey, $cart);
        }
        session()->save(); // Force save session
    }
}








