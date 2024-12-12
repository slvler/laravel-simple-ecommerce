<?php

namespace App\Providers;

use App\Http\Repositories\Cart\CartRepository;
use App\Http\Repositories\Cart\CartRepositoryInterface;
use App\Http\Repositories\CartItem\CartItemRepository;
use App\Http\Repositories\CartItem\CartItemRepositoryInterface;
use App\Http\Repositories\Order\OrderRepository;
use App\Http\Repositories\Order\OrderRepositoryInterface;
use App\Http\Repositories\Product\ProductRepository;
use App\Http\Repositories\Product\ProductRepositoryInterface;
use App\Http\Repositories\User\UserRepository;
use App\Http\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
        $this->app->bind(CartItemRepositoryInterface::class, CartItemRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
