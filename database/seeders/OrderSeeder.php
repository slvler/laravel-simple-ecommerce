<?php

namespace Database\Seeders;

use App\Enums\CartStatus;
use App\Enums\OrderStatus;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::find(1);

        $cart = Cart::where('user_id', $user->id)
            ->where('status',CartStatus::ACTIVE->name)
            ->first();

        $user->orders()->create([
            'total_amount' => $cart->cartItems->sum('subtotal'),
            'status' => OrderStatus::ACTIVE->name
        ]);

        $cart->update([
            'status' => CartStatus::PASSIVE->name
        ]);

        foreach ($cart->cartItems as $item) {
            $stock = $item->product->stock - $item->quantity;
            Product::whereId($item->product->id)->update([
                'stock' => $stock
            ]);
        }


    }
}
