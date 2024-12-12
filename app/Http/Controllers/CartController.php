<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartStoreRequest;
use App\Http\Resources\CartResource;
use App\Http\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private CartService $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }
    public function index()
    {
        $cart = $this->cartService->index();

        return response()->json([
            'message' => 'basket imaging process successful',
            'success' => true,
            'data' => CartResource::make($cart),
        ], 200);
    }

    public function store(CartStoreRequest $request)
    {
        $data = $request->validated();
        $cart = $this->cartService->store($data);

        if ($cart){
            return response()->json([
                'message' => 'product successfully added to card',
                'success' => true
            ], 201);
        }else{
            return response()->json([
                'success' => false,
                'message' => "failed to add to card",
            ],500);
        }
    }

}
