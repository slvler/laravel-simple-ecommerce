<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductShowResource;
use App\Http\Resources\ProductStoreResource;
use App\Http\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ProductController extends Controller
{
    private ProductService $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function index()
    {
        $product = $this->productService->index();

        return response()->json([
            'message' => 'Products retrieved successfully.',
            'success' => true,
            'data' => ProductResource::make($product),
        ], 200);
    }

    public function show(int $id)
    {
        $product = $this->productService->show($id);

        return new ProductShowResource($product);
    }

    public function store(ProductStoreRequest $request)
    {
        $validate = $request->validated();

        $product = $this->productService->store($validate);
        if ($product){
            return new ProductStoreResource($product);
        }else{
            return response()->json([
                'success' => false,
                'message' => "product create failed",
            ],500);
        }
    }

    public function update($id, ProductUpdateRequest $request)
    {
        $validate = $request->validated();

        $product = $this->productService->update($id, $validate);

        if ($product){
            return new ProductShowResource($product);
        }else{
            return response()->json([
                'success' => false,
                'message' => "product update failed",
            ],500);
        }
    }

    public function delete($id)
    {
        $product = $this->productService->delete($id);
        if ($product){
            return response()->json([
                'success' => true,
                'message' => "product successfully deleted",
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => "product deletion process error",
            ],500);
        }
    }
}
