<?php

namespace App\Http\Controllers;

use App\Services\OrdersService;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;

class OrdersController extends Controller
{
    protected OrdersService $ordersService;
    public function __construct(OrdersService $ordersService)
    {
        $this->ordersService = $ordersService;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->ordersService->getAllOrders();
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        return $this->ordersService->getOrder($id);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return $this->ordersService->destroy($id);
    }
}
