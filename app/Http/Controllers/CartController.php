<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function add(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'product_id' => 'required|integer|exists:products,id',
                'quantity' => 'nullable|integer|min:1'
            ]);

            $result = $this->cartService->addToCart(
                $request->product_id,
                $request->quantity ?? 1
            );

            return response()->json($result);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function remove(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'product_id' => 'required|integer'
            ]);

            $result = $this->cartService->removeFromCart($request->product_id);

            return response()->json($result);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function update(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'product_id' => 'required|integer|exists:products,id',
                'quantity' => 'required|integer|min:0'
            ]);

            $result = $this->cartService->updateQuantity(
                $request->product_id,
                $request->quantity
            );

            return response()->json($result);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function get(): JsonResponse
    {
        try {
            $cartItems = $this->cartService->getCartWithProducts();
            $cartCount = $this->cartService->getCartCount();
            $cartTotal = $this->cartService->getCartTotal();

            return response()->json([
                'success' => true,
                'cart_items' => $cartItems,
                'cart_count' => $cartCount,
                'cart_total' => number_format($cartTotal, 3)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function count(): JsonResponse
    {
        try {
            $cartCount = $this->cartService->getCartCount();

            return response()->json([
                'success' => true,
                'cart_count' => $cartCount
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function clear(): JsonResponse
    {
        try {
            $result = $this->cartService->clearCart();

            return response()->json($result);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function show()
    {
        try {
            $cartItems = $this->cartService->getCartWithProducts();
            $cartTotal = $this->cartService->getCartTotal();

            return view('cart.show', compact('cartItems', 'cartTotal'));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}