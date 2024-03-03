<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\ViewService;
use Illuminate\Http\JsonResponse;

class ViewController extends Controller {
	public function __construct(protected ViewService $service) {}

	public function count(String $appVersion): JsonResponse {
		$result = $this->service->getPageViews($appVersion);
		return response()->json($result);
	}
}
