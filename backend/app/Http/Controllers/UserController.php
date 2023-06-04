<?php

namespace App\Http\Controllers;

use App\Http\Requests\Addresses\StoreUserBillingAddressRequest;
use App\Http\Requests\Addresses\StoreUserBillingAndShippingAddressRequest;
use App\Http\Requests\Addresses\StoreUserShippingAddressRequest;
use App\Http\Requests\Addresses\UpdateUserBillingAddressRequest;
use App\Http\Requests\Addresses\UpdateUserShippingAddressRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Services\AddressesService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    protected AddressesService $addressesService;
    public function __construct(AddressesService $addressesService)
    {
        $this->addressesService = $addressesService;
    }

    /**
     * @param StoreUserBillingAndShippingAddressRequest $request
     * @return JsonResponse
     */
    public function createShippingAndBillingAddress(StoreUserBillingAndShippingAddressRequest $request): JsonResponse
    {
        return $this->addressesService->createShippingAndBillingAddress($request);
    }

    /**
     * @param StoreUserShippingAddressRequest $request
     * @return JsonResponse
     */
    public function createShippingAddress(StoreUserShippingAddressRequest $request): JsonResponse
    {
        return $this->addressesService->createShippingAddress($request);
    }

    /**
     * @param StoreUserBillingAddressRequest $request
     * @return JsonResponse
     */
    public function createBillingAddress(StoreUserBillingAddressRequest $request): JsonResponse
    {
        return $this->addressesService->createBillingAddress($request);
    }

    /**
     * @param UpdateUserShippingAddressRequest $request
     * @return JsonResponse
     */
    public function updateShippingAddress(UpdateUserShippingAddressRequest $request): JsonResponse
    {
        return $this->addressesService->updateShippingAddress($request);
    }

    /**
     * @param UpdateUserBillingAddressRequest $request
     * @return JsonResponse
     */
    public function updateBillingAddress(UpdateUserBillingAddressRequest $request): JsonResponse
    {
        return $this->addressesService->updateBillingAddress($request);
    }

    /**
     * @param User $user
     * @return void
     */
    public function destroy(User $user)
    {

    }
}
