<?php

namespace App\Services;

use App\Http\Requests\StoreProductsRequest;
use App\Http\Requests\UpdateProductsRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Products;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
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
     * @param string $slug
     * @return JsonResponse
     */
    public function getProduct(string $slug): JsonResponse
    {
        $product = Products::with('categories')->where('slug', $slug)->first();
        if (!$product) {
            return $this->error([], 'Not found product', 404);
        }
        return $this->success(new ProductResource($product));
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        if ($query === null) {
            return $this->success([
                'products' => [],
                'categories' => []
            ]);
        }

        $products = Products::select('name', 'slug')
            ->where('name', 'LIKE', '%'.$query.'%')
            ->get();

        $categories = Category::select('title', 'slug')
            ->where('title', 'LIKE', '%'.$query.'%')
            ->get();

        return $this->success([
            'products' => $products,
            'categories' => $categories
        ]);
    }

    public function searchResult(Request $request)
    {
        $query = $request->get('query');
        if ($query === null) {
            return $this->success([]);
        }

        $products = Products::where('name', 'LIKE', '%'.$query.'%')->get();

        return $this->success($products);
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
            'name' => $request->post('name'),
            'slug' => Str::slug($request->post('name')),
            'description' => $request->post('description'),
            'img' => $path,
            'price' => (float) $request->post('price')
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

        $product = Products::find($request->post('id'));
        if (!$product) {
            return $this->error([], 'Not found product', 404);
        }

        $img = $request->file('img');
        $path = $this->createNewPathForUpdate($product->img, $img);
        $slug = !empty($request->name) ? Str::slug($request->post('name')) : $product->slug;

        $product->name = $request->post('name') ?? $product->name;
        $product->slug = $slug;
        $product->description = $request->post('description') ?? $product->description;
        $product->img = $path;
        $product->price = $request->post('price') ? (float) $request->price : $product->price;

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
