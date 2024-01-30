<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;

class CategoryController extends Controller {
	public function __construct(CategoryService $categoryService) {
		$this->categoryService = $categoryService;
	}

	public function index(String $appVersion) {
		$data = $this->categoryService->getAll($appVersion);
		return response()->json($data);
	}

	private $categoryService;
}
