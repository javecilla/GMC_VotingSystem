<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\App\Admin\ChangesOccuredException;
use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DeleteDataException;
use App\Exceptions\App\Admin\DuplicateDataException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Http\Controllers\Controller;
use App\Http\Requests\App\Admin\CampusCreateRequest;
use App\Http\Requests\App\Admin\CampusUpdateRequest;
use App\Http\Resources\Api\CampusResource;
use App\Services\CampusService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class CampusController extends Controller {

	public function __construct(protected CampusService $service) {}

	public function getRecordsAll(String $appVersionName) {
		try {
			$campus = $this->service->getAllCampus($appVersionName);

			return CampusResource::collection($campus);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured. Code[SCID]']);
		}
	}

	public function store(CampusCreateRequest $request): JsonResponse {
		try {
			$this->service->createCampus($request->validated());

			return Response::json(['success' => true, 'message' => 'Campus created successfully']);
		} catch (CreateDataException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured during creatation. Code[SCID]']);
		}
	}

	public function update(CampusUpdateRequest $request): JsonResponse {
		try {
			$this->service->updateCampus($request->validated());

			return Response::json(['success' => true, 'message' => 'Campus updated successfully']);
		} catch (ChangesOccuredException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage(), 'type' => 'info']);
		} catch (DuplicateDataException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage(), 'type' => 'warning']);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (UpdateDataException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured during updation. Code[SCID]']);
		}
	}

	public function destroy(String $appVersion, String $campusId): JsonResponse {
		try {
			$this->service->deleteCampus($campusId);

			return Response::json(['success' => true, 'message' => 'Campus deleted successfully']);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (DeleteDataException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured during deletion. Code[SCID]']);
		}
	}
}