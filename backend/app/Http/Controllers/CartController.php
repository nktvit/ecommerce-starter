<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Models\Cart;
use App\Services\CartService;
use App\Services\ProductsService;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    protected CartService $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * @param $userId
     * @return JsonResponse
     */
    public function index($userId): JsonResponse
    {
        return $this->cartService->showCart($userId);
    }

    /**
     * @param StoreCartRequest $request
     * @return JsonResponse
     */
    public function addItem(StoreCartRequest $request): JsonResponse
    {
        return $this->cartService->addItemToCart($request);
    }

    /**
     * @param UpdateCartRequest $request
     * @return JsonResponse
     */
    public function update(UpdateCartRequest $request): JsonResponse
    {
        return $this->cartService->update($request);
    }

    /**
     * @param $cartItemId
     * @return JsonResponse
     */
    public function deleteItem($cartItemId): JsonResponse
    {
        return $this->cartService->deleteItem($cartItemId);
    }

    /**
     * @param $userId
     * @return JsonResponse
     */
    public function deleteAllCart($userId): JsonResponse
    {
        return $this->cartService->deleteAll($userId);
    }
}
