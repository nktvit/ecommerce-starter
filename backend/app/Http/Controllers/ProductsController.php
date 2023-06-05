<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductsRequest;
use App\Http\Requests\UpdateProductsRequest;
use App\Models\Products;
use App\Services\ProductsService;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;

class ProductsController extends Controller
{
    protected ProductsService $productsService;
    public function __construct(ProductsService $productsService)
    {
        $this->productsService = $productsService;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->productsService->getAllProducts();
    }

    /**
     * @param StoreProductsRequest $request
     * @return JsonResponse
     */
    public function store(StoreProductsRequest $request): JsonResponse
    {
        return $this->productsService->create($request);
    }

    /**
     * @param string $slug
     * @return JsonResponse
     */
    public function show(string $slug): JsonResponse
    {
        return $this->productsService->getProduct($slug);
    }

    /**
     * @param UpdateProductsRequest $request
     * @return JsonResponse
     */
    public function update(UpdateProductsRequest $request): JsonResponse
    {
        return $this->productsService->update($request);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return $this->productsService->destroy($id);
    }
}
