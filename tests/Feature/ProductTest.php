<?php

namespace Tests\Feature;

use App\Enums\ProductStatus;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_index(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/products');

        #dd($response->getContent());
        $response->assertStatus(200);
    }

    public function test_index_without_token()
    {
        $response = $this->get('/api/products');
        $response->assertStatus(401);
    }

    public function test_index_invalid_token()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer invalid_token',
        ])->get('/api/products');
        $response->assertStatus(401);
    }

    public function test_show()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        Product::create([
            'name' => 'item',
            'slug' => Str::slug('item'),
            'price' => rand(10,1000),
            'stock' => 100,
            'status' => ProductStatus::ACTIVE->name
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/products/1');

        #dd($response->getContent());
        $response->assertStatus(200);
    }

    public function test_store()
    {
        $user = User::create([
            'name' => 'name',
            "email" => "johndoe@gmail.com",
            "password" => Hash::make('password'),
            'is_admin' => true
        ]);

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/products', [
            'name' => 'item',
            'slug' => Str::slug('item'),
            'price' => rand(10,1000),
            'stock' => 100,
            'status' => ProductStatus::ACTIVE->name
        ]);

        #dd($response->getContent());

        $response->assertStatus(201);
    }

    public function test_update()
    {
        $user = User::create([
            'name' => 'name',
            "email" => "johndoe@gmail.com",
            "password" => Hash::make('password'),
            'is_admin' => true
        ]);

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
        ])->putJson('/api/products/'.$product->id, [
            'stock' => 100,
            'status' => ProductStatus::ACTIVE->name
        ]);

        #dd($response->getContent());

        $response->assertStatus(200);
    }

    public function test_delete()
    {
        $user = User::create([
            'name' => 'name',
            "email" => "johndoe@gmail.com",
            "password" => Hash::make('password'),
            'is_admin' => true
        ]);

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
        ])->delete('/api/products/'.$product->id);

        #dd($response->getContent());

        $response->assertStatus(200);
    }


}
