<?php

namespace App\Http\Controllers\App\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Admin\VersionCreateRequest;
use App\Http\Requests\App\Admin\VersionUpdateRequest;
use App\Services\AppVersionService;
use Illuminate\Http\JsonResponse;

class AppVersionController extends Controller {

	public function __construct(protected AppVersionService $appVersionService) {
	}

	public function retrieve(String $appVersionName): JsonResponse {
		$result = $this->appVersionService->getAll($appVersionName);
		return response()->json($result);
	}

	public function update(VersionUpdateRequest $request): JsonResponse {
		$result = $this->appVersionService->update($request->validated());
		return response()->json($result);
	}

	public function store(VersionCreateRequest $request): JsonResponse {
		$result = $this->appVersionService->create($request->validated());
		return response()->json($result);
	}

	public function destroy(String $appVersionName, int $appVersionId): JsonResponse {
		$result = $this->appVersionService->delete($appVersionId);
		return response()->json($result);
	}

}
