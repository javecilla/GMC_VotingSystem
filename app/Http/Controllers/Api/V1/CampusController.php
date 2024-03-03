<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\CampusService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CampusController extends Controller {
	public function __construct(protected CampusService $service) {}

	public function getRecordsAll(String $appVersion): JsonResponse {
		$result = $this->service->getAllCampus($appVersion);
		return response()->json($result);
	}

	public function store(Request $request): JsonResponse {
		$result = $this->service->createCampus($request->all());
		return response()->json($result);
	}

	public function update(Request $request): JsonResponse {
		$result = $this->service->updateCampus($request->all());
		return response()->json($result);
	}

	public function destroy(String $appVersion, int $campus): JsonResponse {
		$result = $this->service->deleteCampus($campus);
		return response()->json($result);
	}
}