<?php

namespace App\Http\Services;

use App\Http\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Support\Facades\Redis;

class ProductService
{
    const product_prefix = "products:";
    private ProductRepositoryInterface $productRepository;
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    public function index()
    {
        $redis = Redis::connection();

        if ($redis->exists(self::product_prefix.'all'))
        {
            $products = $redis->get(self::product_prefix.'all');
            $products = collect(json_decode($products, true));
        }else{
            $products = $this->productRepository->all();
            $redis->set(self::product_prefix.'all', $products->toJson());
        }
        return $products;
    }
    public function show(int $id)
    {
        $redis = Redis::connection();

        if ($redis->exists(self::product_prefix.'show:'.$id))
        {
            $product = $redis->get(self::product_prefix.'show:'.$id);
            $product = (object)json_decode($product, true);
        }else{
            $product = $this->productRepository->findOrFail($id);
            $redis->set(self::product_prefix.'show:'.$id, $product->toJson());
        }

        return $product;
    }

    public function store(array $data)
    {
        return $this->productRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->productRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->productRepository->delete($id);
    }

    public function find($id)
    {
        return $this->productRepository->findOrFail($id);
    }

}
