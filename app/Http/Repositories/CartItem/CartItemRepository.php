<?php

namespace App\Http\Repositories\CartItem;

use App\Models\CartItem;

class CartItemRepository implements CartItemRepositoryInterface
{
    private CartItem $model;
    public function __construct(CartItem $model)
    {
        $this->model = $model;
    }
    public function findOrFail(int $id): CartItem
    {
        return $this->model->findOrFail($id);
    }
    public function exists($user_id)
    {
        return $this->model
            ->where('user_id', $user_id)
            ->exists();
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function existsCartItem(array $data)
    {
        return $this->model
            ->where($data)
            ->first();
    }

    public function update($id, array $data): CartItem|bool
    {
        try {
            $cartItem = $this->findOrFail($id);
            $cartItem->update(['quantity' => $data['quantity']]);
            return $cartItem->fresh();
        }catch (\Throwable $throwable){
            return false;
        }
    }

    public function delete($id): bool
    {
        $cartItem = $this->findOrFail($id);

        if ($cartItem->cart->user_id == auth()->id()){
            return $cartItem->delete();
        }
        return false;
    }
}
