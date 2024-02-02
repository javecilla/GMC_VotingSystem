<?php

namespace App\Http\Controllers\App\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Admin\CategoryCreateRequest;
use App\Http\Requests\App\Admin\CategoryUpdateRequest;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller {
	public function __construct(protected CategoryService $categoryService) {}

	//get all the category
	public function retrieveAll(String $appVersionName): JsonResponse {
		$result = $this->categoryService->getAll($appVersionName);
		return response()->json($result);
	}

	//get specific category base on what version it is
	public function retrieveByAppVersion(String $appVersionName): JsonResponse {
		$result = $this->categoryService->getAllByVersion($appVersionName);
		return response()->json($result);
	}

	public function update(CategoryUpdateRequest $request): JsonResponse {
		$result = $this->categoryService->update($request->validated());
		return response()->json($result);
	}

	public function store(CategoryCreateRequest $request): JsonResponse {
		$result = $this->categoryService->create($request->validated());
		return response()->json($result);
	}

	public function destroy(String $appVersionName, int $categoryId): JsonResponse {
		$result = $this->categoryService->delete($categoryId);
		return response()->json($result);
	}
}
