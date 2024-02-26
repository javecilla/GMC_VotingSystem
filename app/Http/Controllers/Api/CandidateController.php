<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CandidateService;
use Illuminate\Http\JsonResponse;

//use Illuminate\Http\Request;

class CandidateController extends Controller {
	public function __construct(protected CandidateService $service) {}

	public function index(String $appVersion): JsonResponse {
		$result = $this->service->getAllCandidates($appVersion);
		return response()->json($result);
	}

	public function search(String $appVersion, $searchQuery): JsonResponse {
		$result = $this->service->getFilterSearchCandidates($appVersion, $searchQuery);
		return response()->json($result);
	}

	public function category(String $appVersion, String $categoryQuery): JsonResponse {
		$result = $this->service->getCandidatesByCategory($appVersion, $categoryQuery);
		return response()->json($result);
	}

	public function retrieve(String $appVersion, int $cdid): JsonResponse {
		$result = $this->service->getOneCandidate($cdid);
		return response()->json($result);
	}

}
