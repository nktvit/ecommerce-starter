<?php

namespace App\Services;

use App\Http\Requests\Addresses\StoreUserBillingAndShippingAddressRequest;
use App\Http\Requests\Addresses\StoreUserBillingAddressRequest;
use App\Http\Requests\Addresses\StoreUserShippingAddressRequest;
use App\Http\Requests\Addresses\UpdateUserBillingAddressRequest;
use App\Http\Requests\Addresses\UpdateUserShippingAddressRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AddressesService
{
    use HttpResponses;

    /**
     * @param StoreUserBillingAndShippingAddressRequest $request
     * @return JsonResponse
     */
    public function createShippingAndBillingAddress(StoreUserBillingAndShippingAddressRequest $request): JsonResponse
    {
        $userId = $request->post('user_id');
        $shippingAddress = $request->post('shipping_address');
        $billingAddress = $request->post('billing_address');

        try {
            $user = User::findOrError($userId);

            $user->addAddress($billingAddress);
            $user->addAddress($shippingAddress);

            return $this->success([
                'billing_address' => $user->getBillingAddress(),
                'shipping_address' => $user->getShippingAddress()
            ]);
        } catch (NotFoundHttpException $foundHttpException) {
            return $this->error([], $foundHttpException->getMessage(), $foundHttpException->getStatusCode());
        } catch (\Exception $exception) {
            return $this->error([], $exception->getMessage(), $exception->getStatusCode());
        }
    }

    /**
     * @param StoreUserShippingAddressRequest $request
     * @return JsonResponse
     */
    public function createShippingAddress(StoreUserShippingAddressRequest $request): JsonResponse
    {
        $userId = $request->post('user_id');
        $shippingAddress = $request->post('shipping_address');
        try {
            $user = User::findOrError($userId);
            $user->addAddress($shippingAddress);

            return $this->success([
                'shipping_address' => $user->getShippingAddress()
            ]);
        } catch (NotFoundHttpException $foundHttpException) {
            return $this->error([], $foundHttpException->getMessage(), $foundHttpException->getStatusCode());
        } catch (\Exception $exception) {
            return $this->error([], $exception->getMessage(), $exception->getStatusCode());
        }
    }

    /**
     * @param StoreUserBillingAddressRequest $request
     * @return JsonResponse
     */
    public function createBillingAddress(StoreUserBillingAddressRequest $request): JsonResponse
    {
        $userId = $request->post('user_id');
        $billingAddress = $request->post('billing_address');

        try {
            $user = User::findOrError($userId);
            $user->addAddress($billingAddress);

            return $this->success([
                'billing_address' => $user->getBillingAddress(),
            ]);
        } catch (NotFoundHttpException $foundHttpException) {
            return $this->error([], $foundHttpException->getMessage(), $foundHttpException->getStatusCode());
        } catch (\Exception $exception) {
            return $this->error([], $exception->getMessage(), $exception->getStatusCode());
        }
    }

    /**
     * @param UpdateUserShippingAddressRequest $request
     * @return JsonResponse
     */
    public function updateShippingAddress(UpdateUserShippingAddressRequest $request): JsonResponse
    {
        $userId = $request->post('user_id');
        $shippingAddress = $request->post('shipping_address');


        try {
            $user = User::findOrError($userId);

            $address = $user->addresses()->where('uuid', $shippingAddress['uuid'])->first();
            if ($address->is_shipping !== 1) {
                $this->error([], 'Uuid not equivalent shipping address', 404);
            }

            $new_attributes = [
                'street' => $shippingAddress['street'],
                'city' => $shippingAddress['city'],
                'post_code' => $shippingAddress['post_code'],
                'country' => $shippingAddress['country'],
                'is_shipping' => true,
            ];
            $user->updateAddress($address, $new_attributes);

            return $this->success([
                'shippingAddress' => $user->getShippingAddress(),
            ]);
        } catch (NotFoundHttpException $foundHttpException) {
            return $this->error([], $foundHttpException->getMessage(), $foundHttpException->getStatusCode());
        } catch (\Exception $exception) {
            return $this->error([], $exception->getMessage(), $exception->getStatusCode());
        }
    }

    /**
     * @param UpdateUserBillingAddressRequest $request
     * @return JsonResponse
     */
    public function updateBillingAddress(UpdateUserBillingAddressRequest $request): JsonResponse
    {
        $userId = $request->post('user_id');
        $billingAddress = $request->post('billing_address');


        try {
            $user = User::findOrError($userId);

            $address = $user->addresses()->where('uuid', $billingAddress['uuid'])->first();
            if ($address->is_billing !== 1) {
                return $this->error([], 'Uuid not equivalent shipping address', 404);
            }

            $new_attributes = [
                'street' => $billingAddress['street'],
                'city' => $billingAddress['city'],
                'post_code' => $billingAddress['post_code'],
                'country' => $billingAddress['country'],
                'is_billing' => true,
            ];
            $user->updateAddress($address, $new_attributes);

            return $this->success([
                'billing_address' => $user->getBillingAddress(),
            ]);
        } catch (NotFoundHttpException $foundHttpException) {
            return $this->error([], $foundHttpException->getMessage(), $foundHttpException->getStatusCode());
        } catch (\Exception $exception) {
            return $this->error([], $exception->getMessage(), $exception->getStatusCode());
        }
    }
}
