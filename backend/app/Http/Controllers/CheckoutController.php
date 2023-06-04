<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCheckoutGuestRequest;
use App\Http\Requests\StoreCheckoutUserRequest;
use App\Services\CheckoutService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    protected CheckoutService $checkoutService;
    public function __construct(CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * @param StoreCheckoutGuestRequest $request
     * @return null
     */
    public function storeGuest(StoreCheckoutGuestRequest $request): JsonResponse
    {
        $request->validated();

        return $this->checkoutService->createGuestOrder($request);
    }

    /**
     * @param StoreCheckoutUserRequest $request
     * @return JsonResponse
     */
    public function storeUser(StoreCheckoutUserRequest $request): JsonResponse
    {
        $request->validated();

        return $this->checkoutService->createUserOrder($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
