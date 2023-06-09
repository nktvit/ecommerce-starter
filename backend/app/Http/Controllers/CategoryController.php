<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    use HttpResponses;

    public CategoryService $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }


    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->categoryService->getAllCategories();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        return $this->categoryService->create($request);
    }

    /**
     * @param string $slug
     * @return JsonResponse
     */
    public function show(string $slug): JsonResponse
    {
        return $this->categoryService->show($slug);
    }

    /**
     * @param string $slug
     * @return JsonResponse
     */
    public function destroy(string $slug): JsonResponse
    {
        return $this->categoryService->delete($slug);
    }
}
