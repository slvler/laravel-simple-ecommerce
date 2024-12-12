<?php

namespace Tests\Feature;

use App\Enums\CartStatus;
use App\Enums\ProductStatus;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class CartTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_index(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $user->cart()->create([
            'status' => CartStatus::ACTIVE->name
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/cart');

        $response->assertStatus(200);
    }

    public function test_store(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $product = Product::create([
            'name' => 'item',
            'slug' => Str::slug('item'),
            'price' => rand(10,1000),
            'stock' => 100,
            'status' => ProductStatus::ACTIVE->name
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/cart/items', [
            'product_id' => $product->id,
            "quantity" => 22
        ]);

        $response->assertStatus(201);
    }

    public function test_update(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $cart = Cart::create([
            'user_id' => $user->id,
            'status' => CartStatus::ACTIVE->name
        ]);

        $product = Product::create([
            'name' => 'item',
            'slug' => Str::slug('item'),
            'price' => rand(10,1000),
            'stock' => 100,
            'status' => ProductStatus::ACTIVE->name
        ]);

        $cartItem = CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => $product->price,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson('/api/cart/items/'.$cartItem->id, [
            "quantity" => 22
        ]);

        $response->assertStatus(200);
    }

    public function test_delete()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $cart = Cart::create([
            'user_id' => $user->id,
            'status' => CartStatus::ACTIVE->name
        ]);

        $product = Product::create([
            'name' => 'item',
            'slug' => Str::slug('item'),
            'price' => rand(10,1000),
            'stock' => 100,
            'status' => ProductStatus::ACTIVE->name
        ]);

        $cartItem = CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => $product->price,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->delete('/api/cart/items/'.$cartItem->id);

        $response->assertStatus(200);

    }
}
