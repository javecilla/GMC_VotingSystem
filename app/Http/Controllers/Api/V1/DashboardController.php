<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\ViewService;
use App\Services\VoteService;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller {

	public function __construct(protected VoteService $voteService,
		protected ViewService $viewService) {}

	public function countPendingVerifiedAmount(String $appVersion): JsonResponse {
		$result = $this->voteService->countAllVotesByStatus($appVersion);
		return response()->json($result);
	}

	public function getRecentlyVoters(String $appVersion, int $limit, int $offset): JsonResponse {
		$result = $this->voteService->loadMoreVotes($appVersion, $limit, $offset);
		return response()->json($result);
	}

	public function getMostVotesCandidates(String $appVersion, int $limit): JsonResponse {
		$result = $this->voteService->getMostVotesCandidates($appVersion, $limit);
		return response()->json($result);
	}

	public function countPageViewsPerDay(String $appVersion, int $limit): JsonResponse {
		$result = $this->viewService->getPageViewsPerDay($appVersion, $limit);
		return response()->json($result);
	}
}
