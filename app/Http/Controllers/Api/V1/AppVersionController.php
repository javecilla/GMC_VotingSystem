<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\App\Admin\ChangesOccuredException;
use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DeleteDataException;
use App\Exceptions\App\Admin\DuplicateDataException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Http\Controllers\Controller;
use App\Http\Requests\App\Admin\VersionCreateRequest;
use App\Http\Requests\App\Admin\VersionUpdateRequest;
use App\Http\Resources\Api\AppVersionResource;
use App\Services\AppVersionService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

/**
 * This Controller class is the handle of http request
 */

class AppVersionController extends Controller {

	public function __construct(protected AppVersionService $service) {
	}

	public function getRecordsAll() {
		try {
			$appVersion = $this->service->getAllAppVersion();
			return AppVersionResource::collection($appVersion);
		} catch (\Throwable $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured. Code[AVID]']);
		}
	}

	public function store(VersionCreateRequest $request): JsonResponse {
		try {
			$this->service->createAppVersion($request->validated());

			return Response::json(['success' => true, 'message' => 'New application version created successfully']);
		} catch (CreateDataException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured during creatation. Code[AVID]']);
		}
	}

	public function update(VersionUpdateRequest $request): JsonResponse {
		try {
			$this->service->updateAppVersion($request->validated());

			return Response::json(['success' => true, 'message' => 'Application version updated successfully.']);
		} catch (ChangesOccuredException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage(), 'type' => 'info']);
		} catch (DuplicateDataException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage(), 'type' => 'warning']);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (UpdateDataException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured during updation. Code[AVID]']);
		}
	}

	public function destroy(string $appVersionName, string $appVersionId): JsonResponse {
		try {
			$this->service->deleteAppVersion($appVersionId);

			return Response::json(['success' => true, 'message' => 'Application version deleted successfully']);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (DeleteDataException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured during deletion. Code[AVID]']);
		}
	}
}