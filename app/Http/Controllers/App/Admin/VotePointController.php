<?php

namespace App\Http\Controllers\App\Admin;

use App\Http\Controllers\Controller;
use App\Services\VotePointService;
use Illuminate\Http\JsonResponse;

class VotePointController extends Controller {
	public function __construct(protected VotePointService $votePointService) {}

	public function retrieveByAppVersion(String $appVersionName): JsonResponse {
		$result = $this->votePointService->getAllByVersion($appVersionName);
		return response()->json($result);
	}

}