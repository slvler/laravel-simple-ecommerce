<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartItemUpdateRequest;
use App\Http\Services\CartItemService;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    private CartItemService $cartItemService;
    public function __construct(CartItemService $cartItemService)
    {
        $this->cartItemService = $cartItemService;
    }

    public function update($id, CartItemUpdateRequest $request)
    {
        $data = $request->validated();
        $carItem = $this->cartItemService->update($id, $data);

        if ($carItem){
            return response()->json([
                'success' => true,
                'message' => "item in cart updated successfully",
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => "product quantity update error",
            ],500);
        }
    }

    public function delete($id)
    {
        $product = $this->cartItemService->delete($id);
        if ($product){
            return response()->json([
                'success' => true,
                'message' => "cart item successfully deleted",
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => "cart item deletion process error",
            ],500);
        }
    }
}
