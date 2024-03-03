<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Admin\CandidateCreateRequest;
use App\Http\Requests\App\Admin\CandidateUpdateRequest;
use App\Services\CandidateService;
use App\Services\VoteService;
use Illuminate\Http\JsonResponse;

class CandidatesController extends Controller {
	public function __construct(protected CandidateService $service,
		protected VoteService $voteService) {}

	public function getRecordsAll(String $appVersion): JsonResponse {
		$result = $this->service->getAllCandidates($appVersion);
		return response()->json($result);
	}

	public function getById(String $appVersion, int $candidate): JsonResponse {
		$result = $this->service->getOneCandidate($candidate);
		return response()->json($result);
	}

	public function getBySearch(String $appVersion, String $search): JsonResponse {
		$result = $this->service->getFilterSearchCandidates($appVersion, $search);
		return response()->json($result);
	}

	public function getByCategory(String $appVersion, int $category): JsonResponse {
		$result = $this->service->getCandidatesByCategory($appVersion, $category);
		return response()->json($result);
	}

	public function getRecordsLimit(String $appVersion, int $limit, int $offset): JsonResponse {
		$result = $this->service->loadMoreCandidates($appVersion, $limit, $offset);
		return response()->json($result);
	}

	public function getOverallRanking(String $appVersion, int $limit): JsonResponse {
		$result = $this->voteService->getMostVotesCandidates($appVersion, $limit);
		return response()->json($result);
	}

	public function getCategoryRanking(String $appVersion, int $limit): JsonResponse {
		$result = $this->voteService->getMostVotesCandidatesByCategory($appVersion, $limit);
		return response()->json($result);
	}

	public function store(CandidateCreateRequest $request): JsonResponse {
		$result = $this->service->createCandidate($request->validated());
		return response()->json($result);
	}

	public function update(CandidateUpdateRequest $request): JsonResponse {
		$result = $this->service->updateCandidate($request->all());
		return response()->json($result);
	}

	public function destroy(String $appVersion, int $cdid): JsonResponse {
		$result = $this->service->deleteCandidate($cdid);
		return response()->json($result);
	}
}