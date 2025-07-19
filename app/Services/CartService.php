<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart as CartModel;
use Illuminate\Support\Facades\Log;
/*
This is a service class for the cart functionality.
It is used to manage the cart items and the cart total.
It is used to add items to the cart, remove items from the cart, update the quantity of items in the cart, and get the cart items and the cart total.
It is used to get the cart items and the cart total for the API responses.
It is used to load the cart from the database to the Redis.
It is used to transfer the guest cart to the user cart on login.
It is used to clear the cart.
----------------------------------------------
in the below implemntation we have use 2 types of cart implementation 
we have used redis for the cart items and the cart total.
we have used the database for the cart items and the cart total.
we have used the session for the guest cart.
we have used the database for the user cart.
we have used the database for the guest cart.
we have used the database for the cart items and the cart total.
we have used the database for the cart items and the cart total.
----------------------------------------------
php has a very powerful cahche memory system called php sessions it is like redis but it is usess
php sessions so here  we are using sessions for users that is not authenticated and redis for the authenticated users.
----------------------------------------------



*/ 
class CartService
{
    protected $redis;
    protected $cartKey;
    protected $ttl = 604800; // 7 days in seconds (extended from 24 hours)

    public function __construct()
    {
        try {
            $this->redis = Redis::connection();
            // Test Redis connection
            $this->redis->ping();
        } catch (\Exception $e) {
            Log::error('Redis connection failed: ' . $e->getMessage());
            // Fallback to database if Redis fails
            $this->redis = null;
        }
        
        $this->generateCartKey();
    }

    /**
     * Generate the cart key based on user authentication status
     */
    private function generateCartKey()
    {
        if (Auth::check()) {
            $this->cartKey = 'cart:user:' . Auth::id();
        } else {
            // Use session ID for guest carts
            $sessionId = session()->getId();
            $this->cartKey = 'cart:guest:' . $sessionId;
        }
    }

    /**
     * Add product to cart
     */
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
        
        // Calculate new quantity
        $currentQuantity = isset($cart[$productId]) ? (int)$cart[$productId] : 0;
        $newQuantity = $currentQuantity + (int)$quantity;

        // Check stock availability
        if ($newQuantity > $product->quantity) {
            throw new \Exception('Insufficient stock. Available: ' . $product->quantity);
        }

        $cart[$productId] = $newQuantity;
        $this->saveCart($cart);
        
        // Sync with database for authenticated users
        if (Auth::check()) {
            $this->syncCartToDatabase($productId, $newQuantity);
        }
        
        return [
            'success' => true,
            'message' => 'Product added to cart successfully',
            'cart_count' => $this->getCartCount(),
            'cart_total' => $this->getCartTotal()
        ];
    }

    /**
     * Remove product from cart
     */
    public function removeFromCart($productId)
    {
        $cart = $this->getCart();
        
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            $this->saveCart($cart);
            
            // Remove from database for authenticated users
            if (Auth::check()) {
                CartModel::where('user_id', Auth::id())
                    ->where('product_id', $productId)
                    ->delete();
            }
            
            return [
                'success' => true,
                'message' => 'Product removed from cart',
                'cart_count' => $this->getCartCount(),
                'cart_total' => $this->getCartTotal()
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Product not found in cart'
        ];
    }

    /**
     * Update product quantity in cart
     */
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
        
        // Sync with database for authenticated users
        if (Auth::check()) {
            $this->syncCartToDatabase($productId, $quantity);
        }

        return [
            'success' => true,
            'message' => 'Cart updated successfully',
            'cart_count' => $this->getCartCount(),
            'cart_total' => $this->getCartTotal()
        ];
    }

    /**
     * Get cart from Redis with fallback
     */
    private function getCart()
    {
        if ($this->redis) {
            try {
                $cart = $this->redis->get($this->cartKey);
                return $cart ? json_decode($cart, true) : [];
            } catch (\Exception $e) {
                Log::error('Redis get failed: ' . $e->getMessage());
                return $this->getCartFromFallback();
            }
        }
        
        return $this->getCartFromFallback();
    }

    /**
     * Save cart to Redis with fallback
     */
    private function saveCart($cart)
    {
        if ($this->redis) {
            try {
                if (empty($cart)) {
                    $this->redis->del($this->cartKey);
                } else {
                    $this->redis->setex($this->cartKey, $this->ttl, json_encode($cart));
                }
                return;
            } catch (\Exception $e) {
                Log::error('Redis save failed: ' . $e->getMessage());
            }
        }
        
        $this->saveCartToFallback($cart);
    }

    /**
     * Fallback to database for authenticated users or session for guests
     */
    private function getCartFromFallback()
    {
        if (Auth::check()) {
            $cartItems = CartModel::where('user_id', Auth::id())->get();
            $cart = [];
            foreach ($cartItems as $item) {
                $cart[$item->product_id] = $item->quantity;
            }
            return $cart;
        }
        
        return session()->get('cart', []);
    }

    /**
     * Fallback save to database or session
     */
    private function saveCartToFallback($cart)
    {
        if (Auth::check()) {
            // Handled by syncCartToDatabase
            return;
        }
        
        session()->put('cart', $cart);
    }

    /**
     * Sync cart item to database for authenticated users
     */
    private function syncCartToDatabase($productId, $quantity)
    {
        CartModel::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $productId
            ],
            [
                'quantity' => $quantity
            ]
        );
    }

    /**
     * Transfer guest cart to user cart on login
     */
    public function transferGuestCartToUser($userId)
    {
        // Get guest cart
        $guestSessionId = session()->getId();
        $guestCartKey = 'cart:guest:' . $guestSessionId;
        
        if ($this->redis) {
            try {
                $guestCart = $this->redis->get($guestCartKey);
                $guestCart = $guestCart ? json_decode($guestCart, true) : [];
            } catch (\Exception $e) {
                $guestCart = session()->get('cart', []);
            }
        } else {
            $guestCart = session()->get('cart', []);
        }
        
        if (!empty($guestCart)) {
            // Get user cart
            $userCartKey = 'cart:user:' . $userId;
            
            if ($this->redis) {
                try {
                    $userCart = $this->redis->get($userCartKey);
                    $userCart = $userCart ? json_decode($userCart, true) : [];
                } catch (\Exception $e) {
                    $userCart = [];
                }
            } else {
                $userCart = [];
            }
            
            // Merge carts
            foreach ($guestCart as $productId => $quantity) {
                $product = Product::find($productId);
                if ($product && $product->is_active) {
                    $newQuantity = isset($userCart[$productId]) 
                        ? min($userCart[$productId] + $quantity, $product->quantity)
                        : min($quantity, $product->quantity);
                    
                    $userCart[$productId] = $newQuantity;
                    
                    // Sync to database
                    CartModel::updateOrCreate(
                        [
                            'user_id' => $userId,
                            'product_id' => $productId
                        ],
                        [
                            'quantity' => $newQuantity
                        ]
                    );
                }
            }
            
            // Save merged cart
            if ($this->redis) {
                try {
                    $this->redis->setex($userCartKey, $this->ttl, json_encode($userCart));
                    $this->redis->del($guestCartKey);
                } catch (\Exception $e) {
                    Log::error('Redis transfer failed: ' . $e->getMessage());
                }
            }
            
            // Clear guest session cart
            session()->forget('cart');
        }
        
        // Update cart key for authenticated user
        $this->cartKey = 'cart:user:' . $userId;
    }

    /**
     * Clear cart
     */
    public function clearCart()
    {
        if ($this->redis) {
            try {
                $this->redis->del($this->cartKey);
            } catch (\Exception $e) {
                Log::error('Redis clear failed: ' . $e->getMessage());
            }
        }
        
        if (Auth::check()) {
            CartModel::where('user_id', Auth::id())->delete();
        } else {
            session()->forget('cart');
        }
    }

    /**
     * Get cart count
     */
    public function getCartCount()
    {
        $cart = $this->getCart();
        return array_sum($cart);
    }

    /**
     * Get cart total
     */
    public function getCartTotal()
    {
        $cart = $this->getCart();
        $total = 0;
        
        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
                $total += $product->price * $quantity;
            }
        }
        
        return $total;
    }

    /**
     * Get cart items with product details
     */
    public function getCartItems()
    {
        $cart = $this->getCart();
        $items = [];
        
        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product && $product->is_active && $product->quantity > 0) {
                $items[] = [
                    'product' => $product,
                    'quantity' => min($quantity, $product->quantity),
                    'subtotal' => $product->price * min($quantity, $product->quantity)
                ];
            }
        }
        
        return $items;
    }

    /**
     * Get cart with products for API responses
     */
    public function getCartWithProducts()
    {
        return $this->getCartItems();
    }

    /**
     * Load cart from database to Redis (for authenticated users)
     */
    public function loadCartFromDatabase()
    {
        if (Auth::check() && $this->redis) {
            $cartItems = CartModel::where('user_id', Auth::id())->get();
            $cart = [];
            
            foreach ($cartItems as $item) {
                $cart[$item->product_id] = $item->quantity;
            }
            
            if (!empty($cart)) {
                try {
                    $this->redis->setex($this->cartKey, $this->ttl, json_encode($cart));
                } catch (\Exception $e) {
                    Log::error('Redis load from DB failed: ' . $e->getMessage());
                }
            }
        }
    }
}