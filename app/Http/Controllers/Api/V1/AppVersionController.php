<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DeleteDataException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Http\Controllers\Controller;
use App\Http\Requests\App\Admin\VersionCreateRequest;
use App\Http\Requests\App\Admin\VersionUpdateRequest;
use App\Services\AppVersionService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

/**
 * This Controller class is the handle of http request
 */

class AppVersionController extends Controller {

	public function __construct(protected AppVersionService $service) {
	}

	public function getRecordsAll() {
		try {
			return $this->service->getAllAppVersion();
		} catch (\Throwable $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured. Code[AVID]']);
		}
	}

	public function store(VersionCreateRequest $request): JsonResponse {
		try {
			return $this->service->createAppVersion($request->validated());
		} catch (CreateDataException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured during creatation. Code[AVID]']);
		}
	}

	public function update(VersionUpdateRequest $request): JsonResponse {
		try {
			return $this->service->updateAppVersion($request->validated());
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (UpdateDataException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured during updation. Code[AVID]']);
		}
	}

	public function destroy(String $appVersionName, int $appVersionId): JsonResponse {
		try {
			return $this->service->deleteAppVersion($appVersionId);
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (DeleteDataException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured during deletion. Code[AVID]']);
		}
	}
}