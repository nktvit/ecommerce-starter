<?php

namespace App\Services;

use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Models\Cart;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;

class CartService
{
    use HttpResponses;

    /**
     * @param StoreCartRequest $request
     * @return JsonResponse
     */

    public function showCart(int $userId): JsonResponse
    {
        if (empty($userId)) {
            return $this->error([], 'User id is required', 404);
        }

        $cart = Cart::where('user_id', $userId)->with('product')->get();

        return $this->success($cart);
    }

    public function addItemToCart(StoreCartRequest $request): JsonResponse
    {
        $request->validated();

        $userId = $request->post('user_id');
        $productId = $request->post('product_id');
        $quantity = (int) $request->post('quantity');

        $itemOnCart = Cart::where('user_id', $userId)->where('product_id', $productId)->first();
        if (!$itemOnCart) {
            $cartItem = Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity
            ]);

            return $this->success($cartItem, 'Success added item to cart');
        }

        $itemOnCart->quantity += $quantity;
        $itemOnCart->save();

        return $this->success($itemOnCart, 'Success added item to cart');
    }

   public function update(UpdateCartRequest $request) {
        $request->validated();

        $cartItemId = $request->post('cart_item_id');
        $quantity = (int) $request->post('quantity');

        $cartItem = Cart::find($cartItemId);
        if (!$cartItem) {
            $this->error([], 'Not found cart item', 404);
        }

       $cartItem->quantity = $quantity;
       $cartItem->save();

       return $this->success($cartItem, 'Success added item to cart');
   }

    /**
     * @param int $cartItemId
     * @return JsonResponse
     */
    public function deleteItem(int $cartItemId): JsonResponse
   {
       $cart = Cart::find($cartItemId);
       if (!$cart) {
           $this->error([], 'Not found item on cart', 404);
       }

       Cart::destroy($cartItemId);
       return $this->success([], 'Success item delete');
   }

    /**
     * @param int $userId
     * @return JsonResponse
     */
    public function deleteAll(int $userId): JsonResponse
   {
       if (!$userId) {
           $this->error([], 'user_id parameter is required', 404);
       }

       $queryCart = Cart::where('user_id', $userId);

       if ($queryCart->get()->isEmpty()) {
           return $this->error([], 'Not found item on cart', 404);
       }

       $queryCart->delete();
       return $this->success([], 'Cart success delete');
   }
}
