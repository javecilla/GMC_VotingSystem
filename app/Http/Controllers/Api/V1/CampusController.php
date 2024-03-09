<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DeleteDataException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Http\Controllers\Controller;
use App\Http\Requests\App\Admin\CampusCreateRequest;
use App\Http\Requests\App\Admin\CampusUpdateRequest;
use App\Services\CampusService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class CampusController extends Controller {

	public function __construct(protected CampusService $service) {}

	public function getRecordsAll(String $appVersionName) {
		try {
			return $this->service->getAllCampus($appVersionName);
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured. Code[SCID]']);
		}
	}

	public function store(CampusCreateRequest $request): JsonResponse {
		try {
			return $this->service->createCampus($request->validated());
		} catch (CreateDataException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured during creatation. Code[SCID]']);
		}
	}

	public function update(CampusUpdateRequest $request): JsonResponse {
		try {
			return $this->service->updateCampus($request->validated());
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (UpdateDataException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured during updation. Code[SCID]']);
		}
	}

	public function destroy(String $appVersion, int $campusId): JsonResponse {
		try {
			return $this->service->deleteCampus($campusId);
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (DeleteDataException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured during deletion. Code[SCID]']);
		}
	}
}