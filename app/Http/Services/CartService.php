<?php

namespace App\Http\Services;

use App\Enums\CartStatus;
use App\Enums\OrderStatus;
use App\Http\Repositories\Cart\CartRepositoryInterface;

class CartService
{
    private CartRepositoryInterface $cartRepository;
    private ProductService $productService;
    private CartItemService $cartItemService;
    public function __construct(
        CartRepositoryInterface $cartRepository,
        ProductService $productService,
        CartItemService $cartItemService
    )
    {
        $this->cartRepository = $cartRepository;
        $this->productService = $productService;
        $this->cartItemService = $cartItemService;
    }
    public function index()
    {
        return $this->cartRepository->all();
    }

    public function exits()
    {
        return $this->cartRepository->exists(auth()->id());
    }

    public function getAllWhere(array $data)
    {
        $control['id'] = $data['cart_id'];
        $control['user_id'] = auth()->id();
        $control['status'] = OrderStatus::ACTIVE->name;

        return $this->cartRepository->getAllWhere($control);
    }

    public function store(array $data)
    {
        $product = $this->productService->find($data['product_id']);
        $data['price'] = $product->price;

        if ($this->exits())
        {
            $control = $this->cartItemService->existsCartItem([
                'product_id' => $data['product_id']
            ]);
            if ($control)
            {
                return $this->cartItemService->update($control->id, $data);
            }else{
                $cart = $this->cartRepository->find(auth()->id());
                $data['cart_id'] = $cart->id;

                if (!$product->stock || $data['quantity'] > $product->stock){
                    return false;
                }
                return $this->createNewCartItem($data);
            }
        }

        if (!$product->stock || $data['quantity'] > $product->stock){
            return false;
        }

        $data['user_id'] = auth()->id();
        $data['status'] = CartStatus::ACTIVE->name;

        return $this->cartRepository->store($data);

    }

    protected function createNewCartItem($data)
    {
        $data['user_id'] = auth()->id();
        $data['status'] = CartStatus::ACTIVE->name;

        return $this->cartItemService->store($data);
    }
}
