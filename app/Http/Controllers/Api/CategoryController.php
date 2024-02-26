<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller {
	public function __construct(protected CategoryService $service) {}

	public function retrieve(String $appVersion): JsonResponse {
		$result = $this->service->getAllCategory($appVersion);
		return response()->json($result);
	}
}
