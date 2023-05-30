<?php

namespace App\Services;

use App\Models\Orders;
use App\Traits\HttpResponses;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class OrdersService
{
    use HttpResponses;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllOrders(): \Illuminate\Http\JsonResponse
    {
        return $this->success(Orders::all());
    }

    /**
     * @param $ids
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOrder($id): \Illuminate\Http\JsonResponse
    {

        $order = Orders::select()
            ->where(['id' => $id])
            ->with('user')
            ->get();

        if (!$order) {
            return $this->error([], 'Not found order', 404);
        }
        return $this->success($order);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        if (!Orders::destroy($id)) {
            return $this->error([], 'Not found order', 404);
        }

        return $this->success([
            'order_id' => $id
        ], 'Successful deleted order');
    }
}
