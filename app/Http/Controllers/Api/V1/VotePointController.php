<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DeleteDataException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Http\Controllers\Controller;
use App\Http\Requests\App\Admin\VotePointCreateRequest;
use App\Http\Requests\App\Admin\VotePointUpdateRequest;
use App\Services\VotePointService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class VotePointController extends Controller {

	public function __construct(protected VotePointService $service) {}

	public function getRecordsAll(String $appVersionName) {
		try {
			return $this->service->getAllVotePoints($appVersionName);
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured. Code[VPID]']);
		}
	}

	public function getRecordsOne(String $appVersionName, int $votePointsId) {
		try {
			return $this->service->getOneVotePoints($votePointsId);
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured. Code[VPID]']);
		}
	}

	public function store(VotePointCreateRequest $request): JsonResponse {
		try {
			return $this->service->createVotePoints($request->validated());
		} catch (CreateDataException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured during creation. Code[VPID]']);
		}
	}

	public function update(VotePointUpdateRequest $request): JsonResponse {
		try {
			return $this->service->updateVotePoints($request->validated());
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (UpdateDataException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured during updation. Code[VPID]']);
		}
	}

	public function destroy(String $appVersionName, int $votePointsId): JsonResponse {
		try {
			return $this->service->deleteVotePoints($votePointsId);
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (DeleteDataException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured during deletion. Code[VPID]']);
		}
	}
}