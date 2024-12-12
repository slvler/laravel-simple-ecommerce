<?php

namespace App\Http\Repositories\Order;

use App\Models\Order;

class OrderRepository implements OrderRepositoryInterface
{
    private Order $model;
    public function __construct(Order $model)
    {
        $this->model = $model;
    }
    public function all()
    {
        return $this->model->where('user_id', auth()->id())->get();
    }

    public function findOrFail(int $id): Order
    {
        return $this->model->findOrFail($id);
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }
}
