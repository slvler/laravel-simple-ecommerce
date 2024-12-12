<?php

namespace App\Http\Repositories\Cart;

use App\Enums\OrderStatus;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;

class CartRepository implements CartRepositoryInterface
{
    private Cart $model;
    public function __construct(Cart $model)
    {
        $this->model = $model;
    }
    public function all()
    {
       return $this->model
           ->where('user_id', auth()->id())
           ->with(['cartItems' => function ($query) {
               $query->select('id', 'cart_id', 'product_id','quantity','price');
           }])
           ->first();
    }
    public function find($user_id)
    {
        return $this->model
            ->where('user_id', $user_id)
            ->first();
    }

    public function getAllWhere(array $data)
    {
        return $this->model
            ->where($data)
            ->first();
    }
    public function exists($user_id)
    {
        return $this->model
            ->where('user_id', $user_id)
            ->exists();
    }

    public function store(array $data): Cart|bool
    {
        try{
            DB::beginTransaction();

            $cart = $this->model->create([
                'user_id' => $data['user_id'],
                'status' => $data['status']
            ]);

            $cart->cartItems()->create([
                'product_id' => $data['product_id'],
                'quantity' => $data['quantity'],
                'price' => $data['price']
            ]);
            DB::commit();
            return $cart;
        }catch(\Exception $e){
            DB::rollback();
            return false;
        }
    }

    public function update(int $id, array $data)
    {
        return $this->model->whereId($id)
            ->update($data);
    }
}

