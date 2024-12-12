<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cart = Cart::find(1);

        Product::whereIn('id',[1,2,3,4])->get()->each(function ($item, $key) use($cart) {

            $rnd = rand(1,15);

            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $item->id,
                'quantity' => $rnd,
                'price' => $item->price,
            ]);
        });
    }
}
