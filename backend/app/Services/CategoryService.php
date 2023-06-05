<?php

namespace App\Services;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;

class CategoryService
{
    use HttpResponses;

    /**
     * @return JsonResponse
     */
    public function getAllCategories(): JsonResponse
    {
        $categories = Category::with('childrenRecursive')->whereNull('parent_id')->get();
        if (!$categories || $categories->isEmpty()) {
            return $this->error([], 'Not found categories', 404);
        }
        return $this->success(CategoryResource::collection($categories), 'Show list categories');
    }

    /**
     * @param string $slug
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $cateory = Category::with('products')->where('id', $id)->first();
        if (!$cateory) {
            return $this->error([], 'Not found category', 404);
        }
        return $this->success($cateory);
    }

    /**
     * @param StoreCategoryRequest $request
     * @return JsonResponse
     */
    public function create(StoreCategoryRequest $request): JsonResponse
    {
        $title = $request->post('title');
        $parent_id = $request->post('parent_id');

        if ($parent_id) {
            $parentCategory = Category::find($parent_id);
        }
        if ($parent_id && !$parentCategory) {
            return $this->error([], 'Not found parent category by ID: ' . $parent_id, 404);
        }

        $category = new Category;
        $category->title = $title;
        $category->parent_id = $parent_id;
        $category->save();

        return $this->success($category, 'Success create category ID: ' . $category->id);
    }


    /**
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        if (!Category::destroy($id)) {
            return $this->error([], 'Not found category', 404);
        }

        return $this->success([], 'Success delete category ID: ' . $id);
    }
}
