<?php

namespace Tests\Feature;

use App\Enums\CartStatus;
use App\Enums\OrderStatus;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class OrderTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_index(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $cart = Cart::where('user_id', $user->id)
            ->where('status',CartStatus::ACTIVE->name)
            ->first();

        $user->orders()->create([
            'total_amount' => 250,
            'status' => OrderStatus::ACTIVE->name
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/orders');

        $response->assertStatus(200);
    }

    public function test_store(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $cart = Cart::create([
            'user_id' => $user->id,
            'status' => CartStatus::ACTIVE->name
        ]);

        $user->orders()->create([
            'total_amount' => 250,
            'status' => OrderStatus::ACTIVE->name
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/orders', [
            'cart_id' => $cart->id
        ]);

        $response->assertStatus(200);
    }

    public function test_show(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => 250,
            'status' => OrderStatus::ACTIVE->name
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/orders/'.$order->id);

        $response->assertStatus(200);
    }
}
