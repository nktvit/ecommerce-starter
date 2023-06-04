<?php

namespace App\Services;

use App\Http\Requests\StoreCheckoutGuestRequest;
use App\Http\Requests\StoreCheckoutUserRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CheckoutService
{
    use HttpResponses;

    public function createUserOrder(StoreCheckoutUserRequest $request)
    {
        $billingAddress = $request->post('billing_address');
        $shippingAddress = $request->post('shipping_address');
        $userId = $request->post('user_id');

        try {
            $user = User::findOrError($userId);

            $dbShippingAddress = $user->addresses()->where('uuid', $shippingAddress['uuid'])->first();
            $dbBillingAddress = $user->addresses()->where('uuid', $billingAddress['uuid'])->first();

            return $this->success([
                'billing_address' => $user->getBillingAddress(),
                'shipping_address' => $user->getBillingAddress()
            ]);
        } catch (NotFoundHttpException $foundHttpException) {
            return $this->error([], $foundHttpException->getMessage(), $foundHttpException->getStatusCode());
        } catch (\Exception $exception) {
            return $this->error([], $exception->getMessage(), $exception->getStatusCode());
        }
    }

    public function createGuestOrder(StoreCheckoutGuestRequest $request)
    {
        $billingAddress = $request->billing_address;
        $shippingAddress = $request->shipping_address;
        $cart = $request->cart;
        $email = $request->email;

    }
}
