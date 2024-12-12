<?php

namespace App\Http\Services;

use App\Http\Repositories\Cart\CartRepositoryInterface;
use App\Http\Repositories\CartItem\CartItemRepositoryInterface;

class CartItemService
{
    private CartItemRepositoryInterface $cartItemRepository;
    public function __construct(CartItemRepositoryInterface $cartItemRepository)
    {
        $this->cartItemRepository = $cartItemRepository;
    }
    public function find($id)
    {
        return $this->cartItemRepository->findOrFail($id);
    }

    public function existsCartItem(array $data)
    {
        return $this->cartItemRepository->existsCartItem($data);
    }

    public function store(array $data)
    {
        return $this->cartItemRepository->store($data);
    }

    public function update($id, array $data)
    {
        $cartItem = $this->find($id);

        if ($data['quantity'] > $cartItem->product->stock || ($cartItem->quantity + $data['quantity']) > $cartItem->product->stock ) {
            return false;
        }

        return $this->cartItemRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->cartItemRepository->delete($id);
    }

}
