<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\CartService;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Share cart count with all views
        View::composer('*', function ($view) {
            try {
                $cartService = app(CartService::class);
                $cartCount = $cartService->getCartCount();
                $view->with('cartCount', $cartCount);
            } catch (\Exception $e) {
                $view->with('cartCount', 0);
            }
        });
    }
}