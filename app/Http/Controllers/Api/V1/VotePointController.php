<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Admin\VotePointCreateRequest;
use App\Http\Requests\App\Admin\VotePointUpdateRequest;
use App\Services\VotePointService;
use Illuminate\Http\JsonResponse;

class VotePointController extends Controller {

	public function __construct(protected VotePointService $votePointService) {}

	public function getRecordsAll(String $appVersionName): JsonResponse {
		$result = $this->votePointService->getAllVotePoints($appVersionName);
		return response()->json($result);
	}

	public function store(VotePointCreateRequest $request): JsonResponse {
		$result = $this->votePointService->createVotePoints($request->validated());
		return response()->json($result);
	}

	public function update(VotePointUpdateRequest $request): JsonResponse {
		$result = $this->votePointService->updateVotePoints($request->validated());
		return response()->json($result);
	}

	public function destroy(String $appVersionName, int $votePointsId): JsonResponse {
		$result = $this->votePointService->deleteVotePoints($votePointsId);
		return response()->json($result);
	}

	public function show(String $appVersion, int $votePointsId): JsonResponse {
		$result = $this->votePointService->getOneVotePoints($votePointsId);
		return response()->json($result);
	}
}