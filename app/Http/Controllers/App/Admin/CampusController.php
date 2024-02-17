<?php

namespace App\Http\Controllers\App\Admin;

use App\Http\Controllers\Controller;
use App\Services\CampusService;
use Illuminate\Http\JsonResponse;

class CampusController extends Controller {
	public function __construct(protected CampusService $service) {}

	public function retrieve(String $appVersion): JsonResponse {
		$result = $this->service->getAllCategory($appVersion);
		return response()->json($result);
	}
}
