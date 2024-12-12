<?php

namespace App\Http\Services;

use App\Enums\CartStatus;
use App\Enums\OrderStatus;
use App\Events\CartStatusEvent;
use App\Events\ProductStockEvent;
use App\Http\Repositories\Order\OrderRepositoryInterface;
use Illuminate\Support\Facades\Redis;

class OrderService
{
    const order_prefix = "orders:";
    private OrderRepositoryInterface $orderRepository;
    public function __construct(
        OrderRepositoryInterface $orderRepository,
    )
    {
        $this->orderRepository = $orderRepository;
    }

    public function index()
    {
        $redis = Redis::connection();

        if ($redis->exists(self::order_prefix.'all'))
        {
            $orders = $redis->get(self::order_prefix.'all');
            $orders = collect(json_decode($orders, true));
        }else{
            $orders = $this->orderRepository->all();
            $redis->set(self::order_prefix.'all', $orders->toJson());
        }
        return $orders;
    }

    public function show(int $id)
    {
        $redis = Redis::connection();

        if ($redis->exists(self::order_prefix.'show:'.$id))
        {
            $order = $redis->get(self::order_prefix.'show:'.$id);
            $order = (object)json_decode($order, true);
        }else{
            $order = $this->orderRepository->findOrFail($id);
            $redis->set(self::order_prefix.'show:'.$id, $order->toJson());
        }

        return $order;
    }

    public function store($cart)
    {
        $control = $this->stockControl($cart);

        if ($control)
        {
            $data['total_amount'] = $cart->cartItems->sum('subtotal');
            $data['status'] = OrderStatus::ACTIVE->name;
            $data['user_id'] = auth()->id();

            $order = $this->orderRepository->store($data);
            if ($order){
                event(new CartStatusEvent($cart->id, CartStatus::PASSIVE->name));
                event(new ProductStockEvent($cart));
            }
            return true;
        }
        return false;
    }

    private function stockControl($cart): bool
    {
        foreach ($cart->cartItems as $item)
        {
            if ($item->quantity > $item->product->stock) {
                return false;
            }
        }
        return true;
    }
}
