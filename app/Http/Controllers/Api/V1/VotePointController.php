<?php

namespace App\Http\Controllers\Api\V1;

use App\Services\VotePointService;
use App\Http\Resources\Api\VotePointResource;
use App\Http\Requests\App\Admin\VotePointCreateRequest;
use App\Http\Requests\App\Admin\VotePointUpdateRequest;
use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\UpdateDataException;
  use App\Exceptions\App\Admin\DeleteDataException;
  use App\Exceptions\App\Admin\DuplicateDataException;
	use App\Exceptions\App\Admin\ChangesOccuredException;
	use App\Http\Controllers\Controller;
	use Illuminate\Database\Eloquent\ModelNotFoundException;
	use Illuminate\Http\JsonResponse;
	use Illuminate\Support\Facades\Response;

class VotePointController extends Controller {

	public function __construct(protected VotePointService $service) {}

	public function getRecordsAll(String $appVersionName) {
		try {
			$votePoint = $this->service->getAllVotePoints($appVersionName);

			return VotePointResource::collection($votePoint);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured. Code[VPID]']);
		}
	}

	public function getRecordsOne(String $appVersionName, String $votePointsId) {
		try {
			$votePoint = $this->service->getOneVotePoints($votePointsId);

			return VotePointResource::make($votePoint);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured. Code[VPID]']);
		}
	}

	public function store(VotePointCreateRequest $request): JsonResponse {
		try {
			$this->service->createVotePoints($request->validated());

			return Response::json(['success' => true, 'message' => 'Vote points created successfully.']);
		} catch (CreateDataException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured during creation. Code[VPID]']);
		}
	}

	public function update(VotePointUpdateRequest $request): JsonResponse {
		try {
			$this->service->updateVotePoints($request->validated());

			return Response::json(['success' => true, 'message' => 'Vote points updated successfully.']);
		} catch (ChangesOccuredException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage(), 'type' => 'info']);
		} catch (DuplicateDataException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage(), 'type' => 'warning']);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (UpdateDataException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured during updation. Code[VPID]']);
		}
	}

	public function destroy(String $appVersionName, String $votePointsId): JsonResponse {
		try {
			$this->service->deleteVotePoints($votePointsId);

			return Response::json(['success' => true, 'message' => 'Vote point deleted successfully']);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (DeleteDataException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured during deletion. Code[VPID]']);
		}
	}
}