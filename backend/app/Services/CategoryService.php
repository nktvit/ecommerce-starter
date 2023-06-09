<?php

namespace App\Services;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

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
    public function show(string $slug): JsonResponse
    {
        $category = Category::with('products')->where('slug', $slug)->first();
        if (!$category) {
            return $this->error([], 'Not found category', 404);
        }
        return $this->success($category);
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
        $category->slug = Str::slug($title);
        $category->parent_id = $parent_id;
        $category->save();

        return $this->success($category, 'Success create category ID: ' . $category->id);
    }


    /**
     * @param string $slug
     * @return JsonResponse
     */
    public function delete(string $slug): JsonResponse
    {
        $category = Category::where('slug', $slug)->first();
        if (!$category) {
            return $this->error([], 'Not found category', 404);
        }

        Category::destroy($category->id);

        return $this->success([], 'Success delete category ID: ' . $category->id);
    }
}
