<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrCreateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Exception;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService
    ) {}

    public function create(UpdateOrCreateCategoryRequest $request)
    {
        try {
            $this->categoryService->create($request->only('name'));
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => __('category.created')
        ]);
    }

    /**
     * @param Category $category
     * @param UpdateOrCreateCategoryRequest $request
     * @return JsonResponse
     */
    public function update(Category $category, UpdateOrCreateCategoryRequest $request)
    {
        try {
            $this->categoryService->update($category, $request->only(['name']));
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => __('category.updated')
        ]);
    }

    /**
     * @param Category $category
     * @return JsonResponse
     */
    public function delete(Category $category)
    {
        try {
            $this->categoryService->delete($category);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => __('category.deleted')
        ]);
    }
}
