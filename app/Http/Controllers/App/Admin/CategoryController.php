<?php

namespace App\Http\Controllers\App\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Admin\CategoryCreateRequest;
use App\Http\Requests\App\Admin\CategoryUpdateRequest;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller {
	public function __construct(protected CategoryService $service) {}

	//get all the category
	public function retrieve(String $appVersionName): JsonResponse {
		$result = $this->service->getAllCategory($appVersionName);
		return response()->json($result);
	}

	public function store(CategoryCreateRequest $request): JsonResponse {
		$result = $this->service->createCategory($request->validated());
		return response()->json($result);
	}

	public function update(CategoryUpdateRequest $request): JsonResponse {
		$result = $this->service->updateCategory($request->validated());
		return response()->json($result);
	}

	public function destroy(String $appVersionName, int $categoryId): JsonResponse {
		$result = $this->service->deleteCategory($categoryId);
		return response()->json($result);
	}
}
