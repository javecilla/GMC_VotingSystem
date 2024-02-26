<?php

namespace App\Http\Controllers\App\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Admin\VoteCreateRequest;
use App\Http\Requests\App\Admin\VoteUpdateRequest;
use App\Services\VoteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VotesController extends Controller {

	public function __construct(protected VoteService $service) {}

	public function index(Request $request) {
		return view('admin.votes.index');
	}

	public function retrieves(String $appVersion): JsonResponse {
		$result = $this->service->getAllVotes($appVersion);
		return response()->json($result);
	}

	public function loadMoreData(String $appVersion, int $limit, int $offset): JsonResponse {
		$result = $this->service->loadMoreVotes($appVersion, $limit, $offset);
		return response()->json($result);
	}

	public function retrieve(String $appVersion, int $votesId): JsonResponse {
		$result = $this->service->getOneVotes($appVersion, $votesId);
		return response()->json($result);
	}

	public function counts(String $appVersion): JsonResponse {
		$result = $this->service->countAllVotesByStatus($appVersion);
		return response()->json($result);
	}

	public function updateByStatus(Request $request): JsonResponse {
		$result = $this->service->updateVotesByStatus($request->all());
		return response()->json($result);
	}

	public function getByStatus(String $appVersion, int $status): JsonResponse {
		$result = $this->service->getVotesByStatus($appVersion, $status);
		return response()->json($result);
	}

	public function getBySearch(String $appVersion, String $search): JsonResponse {
		$result = $this->service->getVotesBySearch($appVersion, $search);
		return response()->json($result);
	}

	public function store(VoteCreateRequest $request): JsonResponse {
		$result = $this->service->createNewVote($request->validated());
		return response()->json($result);
	}

	public function update(VoteUpdateRequest $request): JsonResponse {
		//\Illuminate\Support\Facades\Log::info($request->validated());
		$result = $this->service->updateVote($request->validated());
		return response()->json($result);
	}

	public function destroy(String $appVersion, int $votesId): JsonResponse {
		$result = $this->service->deleteVote($appVersion, $votesId);
		return response()->json($result);
	}

}
