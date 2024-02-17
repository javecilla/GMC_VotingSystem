<?php

namespace App\Http\Controllers\App\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Admin\CandidateCreateRequest;
use App\Services\CandidateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CandidatesController extends Controller {
	public function __construct(protected CandidateService $service) {}

	public function index(Request $request) {
		return view('admin.candidates.index');
	}

	public function create(Request $request) {
		return view('admin.candidates.create');
	}

	public function store(CandidateCreateRequest $request): JsonResponse {
		$result = $this->service->createCandidate($request->validated());
		return response()->json($result);
	}

	public function retrieves(String $appVersion): JsonResponse {
		$result = $this->service->getAllCandidates($appVersion);
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
}
