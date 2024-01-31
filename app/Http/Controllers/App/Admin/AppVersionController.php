<?php

namespace App\Http\Controllers\App\Admin;

use App\Exceptions\App\Admin\UpdateVersionException;
use App\Http\Controllers\Controller;
use App\Http\Requests\App\Admin\VersionUpdateRequest;
use App\Services\AppVersionService;
use Illuminate\Http\JsonResponse;

class AppVersionController extends Controller {

	public function __construct(protected AppVersionService $appVersionService) {
	}

	public function index(String $versionName): JsonResponse {
		$result = $this->appVersionService->getAll($versionName);
		return response()->json($result);
	}

	public function update(VersionUpdateRequest $request): JsonResponse {
		try {
			$result = $this->appVersionService->updateById($request->validated());
			return response()->json($result);
		} catch (UpdateVersionException $updateException) {
			return response()->json(['success' => false, 'message' => $updateException->getMessage()]);
		}
	}

}
