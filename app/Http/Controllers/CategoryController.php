<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Traits\JsonResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use JsonResponseTrait;
    public function __construct(protected CategoryService $categoryService) {}

    /**
     * @throws Exception
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:categories,name|max:255',
        ]);

        $category = $this->categoryService->create($validated);

        return $this->success($category,  'Category created successfully', 201);
    }

    public function index(): JsonResponse
    {
        $categories = $this->categoryService->getAll();

        return $this->success($categories);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->categoryService->delete($id);

        return $this->success([] , 'Category deleted successfully');
    }
}
