<?php

namespace App\Http\Repositories\Product;

use App\Models\Product;
use Illuminate\Support\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    private Product $model;
    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->select('id','name','stock','price','status')->get();
    }

    public function findOrFail(int $id): Product
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data): Product|bool
    {
        try {
            return $this->model->create($data);
        }catch (\Throwable $throwable){
            return false;
        }
    }

    public function update($id, array $data)
    {
        try {
            $product = $this->findOrFail($id);
            $product->update($data);
            return $product->fresh();
        }catch (\Throwable $throwable){
            return false;
        }
    }
    public function delete($id): bool
    {
        return $this->model->whereId($id)->delete();
    }
}
