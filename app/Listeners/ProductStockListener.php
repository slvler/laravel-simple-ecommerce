<?php

namespace App\Listeners;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProductStockListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {

        foreach ($event->cart->cartItems as $item)
        {
            $stock = $item->product->stock - $item->quantity;
            Product::whereId($item->product->id)->update([
                'stock' => $stock
            ]);
        }

    }
}
