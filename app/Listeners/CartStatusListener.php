<?php

namespace App\Listeners;

use App\Http\Repositories\Cart\CartRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CartStatusListener
{
    private CartRepository $cartRepository;
    /**
     * Create the event listener.
     */
    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $data['status'] = $event->status;
        $this->cartRepository->update($event->id, $data);
    }
}
