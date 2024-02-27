<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ViewService;
use Illuminate\Http\JsonResponse;

class ViewController extends Controller {
	public function __construct(protected ViewService $service) {}

	public function count(String $appVersion): JsonResponse {
		$result = $this->service->getAllTotalCount($appVersion);
		return response()->json($result);
	}
}
