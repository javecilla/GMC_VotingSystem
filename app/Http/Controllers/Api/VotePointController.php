<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Auth\InvalidRecaptchaException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\VoteCreateRequest;
use App\Services\Auth\RecaptchaService;
use App\Services\VotePointService;
use App\Services\VoteService;
use Illuminate\Http\JsonResponse;

class VotePointController extends Controller {
	public function __construct(protected VotePointService $votePointService,
		protected RecaptchaService $recaptchaService,
		protected VoteService $voteService) {}

	public function retrieve(String $appVersion): JsonResponse {
		$result = $this->votePointService->getAllVotePoints($appVersion);
		return response()->json($result);
	}

	public function show(String $appVersion, int $votePointsId): JsonResponse {
		$result = $this->votePointService->getOneVotePoints($votePointsId);
		return response()->json($result);
	}

	public function store(VoteCreateRequest $request): JsonResponse {
		try {
			$this->recaptchaService->verify($request->validated('g_recaptcha_response'));
			$result = $this->voteService->createNewVote($request->validated());

			return response()->json($result);
		} catch (InvalidRecaptchaException $recaptchaException) {
			return response()->json(['success' => false, 'message' => $recaptchaException->getMessage()]);
		}
	}
}
