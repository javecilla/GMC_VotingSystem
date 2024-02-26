<?php

namespace App\Http\Controllers\App\Admin;

use App\Http\Controllers\Controller;
use App\Services\VoteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller {

	public function __construct(protected VoteService $voteService) {}

	public function index(Request $request) {
		return view('admin.dashboard.index');
	}

	public function getMostVotes(String $appVersion, int $limit): JsonResponse {
		$result = $this->voteService->getMostVotesCandidates($appVersion, $limit);
		return response()->json($result);
	}

	public function counts(String $appVersion): JsonResponse {
		$result = $this->voteService->countAllVotesByStatus($appVersion);
		return response()->json($result);
	}

	public function retrievesLimit(String $appVersion, int $limit, int $offset): JsonResponse {
		$result = $this->voteService->loadMoreVotes($appVersion, $limit, $offset);
		return response()->json($result);
	}
}
