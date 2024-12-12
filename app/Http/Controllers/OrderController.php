<?php

namespace App\Http\Controllers;

use App\Enums\CartStatus;
use App\Events\CartStatusEvent;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderShowResource;
use App\Http\Services\CartService;
use App\Http\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private OrderService $orderService;
    private CartService $cartService;
    public function __construct(
        OrderService $orderService,
        CartService $cartService
    )
    {
        $this->orderService = $orderService;
        $this->cartService = $cartService;
    }
    public function index()
    {
        $orders = $this->orderService->index();

        return response()->json([
            'message' => 'Orders listed successfully',
            'success' => true,
            'data' => OrderResource::make($orders)
        ], 200);
    }

    public function store(OrderStoreRequest $request)
    {
        $validate = $request->validated();

        $cart = $this->cartService->getAllWhere($validate);

        if (!$cart){
            return response()->json([
                'success' => false,
                'message' => "no items added to cart",
            ],500);
        }

        $order = $this->orderService->store($cart);
        if ($order){
            return response()->json([
                'success' => true,
                'message' => "order created successfully",
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => "an error occurred while creating an order",
            ],500);
        }
    }

    public function show(int $id)
    {
        $order = $this->orderService->show($id);

        return new OrderShowResource($order);
    }
}
