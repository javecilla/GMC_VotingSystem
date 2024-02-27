<?php

namespace App\Http\Controllers\App\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Admin\CandidateCreateRequest;
use App\Http\Requests\App\Admin\CandidateUpdateRequest;
use App\Services\CandidateService;
use App\Services\VoteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CandidatesController extends Controller {
	public function __construct(protected CandidateService $service,
		protected VoteService $voteService) {}

	public function index(Request $request) {
		return view('admin.candidates.index');
	}

	public function create(Request $request) {
		return view('admin.candidates.create');
	}

	public function ranking(Request $request) {
		return view('admin.candidates.ranking');
	}

	public function store(CandidateCreateRequest $request): JsonResponse {
		$result = $this->service->createCandidate($request->validated());
		return response()->json($result);
	}

	public function retrieves(String $appVersion): JsonResponse {
		$result = $this->service->getAllCandidates($appVersion);
		return response()->json($result);
	}

	public function search(String $appVersion, String $searchQuery): JsonResponse {
		$result = $this->service->getFilterSearchCandidates($appVersion, $searchQuery);
		return response()->json($result);
	}

	public function category(String $appVersion, String $ctid): JsonResponse {
		$result = $this->service->getCandidatesByCategory($appVersion, $ctid);
		return response()->json($result);
	}

	public function retrieve(String $appVersion, int $cdid): JsonResponse {

		$result = $this->service->getOneCandidate($cdid);
		return response()->json($result);
	}

	public function show(String $appVersion, int $cdid) {
		return view('admin.candidates.show');
	}

	public function edit(String $appVersion, int $cdid) {
		return view('admin.candidates.edit');
	}

	public function update(CandidateUpdateRequest $request): JsonResponse {
		//\Illuminate\Support\Facades\Log::info($request->all());
		$result = $this->service->updateCandidate($request->all());
		return response()->json($result);
	}

	public function destroy(String $appVersion, int $cdid): JsonResponse {
		$result = $this->service->deleteCandidate($cdid);
		return response()->json($result);
	}

	public function loadMoreData(String $appVersion, int $limit, int $offset): JsonResponse {
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
}
