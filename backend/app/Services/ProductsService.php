<?php

namespace App\Services;

use App\Http\Requests\StoreProductsRequest;
use App\Http\Requests\UpdateProductsRequest;
use App\Models\Products;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;

class ProductsService
{
    use HttpResponses;

    /**
     * @return JsonResponse
     */
    public function getAllProducts(): JsonResponse
    {
        return $this->success(Products::all());
    }

    /**
     * @param $ids
     * @return JsonResponse
     */
    public function getProduct($id): JsonResponse
    {
        $product = Products::find($id);
        if (!$product) {
            return $this->error([], 'Not found product', 404);
        }
        return $this->success($product);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        if (!Products::destroy($id)) {
            return $this->error([], 'Not found product', 404);
        }

        return $this->success([
            'product_id' => $id
        ], 'Successful deleted product');
    }

    /**
     * @param StoreProductsRequest $request
     * @return JsonResponse
     */
    public function create(StoreProductsRequest $request): JsonResponse
    {
        $request->validated();

        $img = $request->file('img');
        $path = !empty($img) ?
            $img->store('products') :
            'products/default.png';

        $payloadProduct = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'img' => $path,
            'price' => (float) $request->price
        ];

        $product = Products::create($payloadProduct);

        return $this->success($product, 'Successful create product');
    }

    /**
     * @param UpdateProductsRequest $request
     * @return JsonResponse
     */
    public function update(UpdateProductsRequest $request): JsonResponse
    {
        $request->validated();

        $product = Products::find($request->id);
        if (!$product) {
            return $this->error([], 'Not found product', 404);
        }

        $img = $request->file('img');
        $path = $this->createNewPathForUpdate($product->img, $img);
        $slug = !empty($request->name) ? Str::slug($request->name) : $product->slug;

        $product->name = $request->name ?? $product->name;
        $product->slug = $slug;
        $product->description = $request->description ?? $product->description;
        $product->img = $path;
        $product->price = $request->price ? (float) $request->price : $product->price;

        $product->save();

        return $this->success($product, 'Successful update product');
    }

    public function createNewPathForUpdate(string $productImg, $img): string
    {
        $path = $productImg;
        if (!empty($img)) {
            if (Storage::exists($path)) {
                Storage::delete($path);
            }

            $path = $img->store('products');
        }

        return $path;
    }
}
