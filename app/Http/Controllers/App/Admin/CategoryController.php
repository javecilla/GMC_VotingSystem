<?php

namespace App\Http\Controllers\App\Admin;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller {
	public function __construct(protected CategoryService $categoryService) {}

	public function retrieve(String $appVersionName): JsonResponse {
		$result = $this->categoryService->getAll($appVersionName);
		return response()->json($result);
	}
}
