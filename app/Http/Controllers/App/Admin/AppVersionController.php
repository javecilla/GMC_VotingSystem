<?php

namespace App\Http\Controllers\App\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Admin\VersionCreateRequest;
use App\Http\Requests\App\Admin\VersionUpdateRequest;
use App\Services\AppVersionService;
use Illuminate\Http\JsonResponse;

/**
 * This Controller class is the handle of http request
 */

class AppVersionController extends Controller {

	public function __construct(protected AppVersionService $service) {
	}

	public function retrieve(String $categoryName): JsonResponse {
		$result = $this->service->getAllAppVersion($categoryName);
		return response()->json($result);
	}

	public function store(VersionCreateRequest $request): JsonResponse {
		$result = $this->service->createAppVersion($request->validated());
		return response()->json($result);
	}

	public function update(VersionUpdateRequest $request): JsonResponse {
		$result = $this->service->updateAppVersion($request->validated());
		return response()->json($result);
	}

	public function destroy(String $appVersionName, int $appVersionId): JsonResponse {
		$result = $this->service->deleteAppVersion($appVersionId);
		return response()->json($result);
	}

}
