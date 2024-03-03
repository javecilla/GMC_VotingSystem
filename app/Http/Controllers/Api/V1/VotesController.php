<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\Auth\InvalidRecaptchaException;
use App\Http\Controllers\Controller;
use App\Http\Requests\App\Admin\VoteCreateRequest;
use App\Http\Requests\App\Admin\VoteUpdateRequest;
use App\Services\Auth\RecaptchaService;
use App\Services\VoteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VotesController extends Controller {

	public function __construct(protected VoteService $service,
		protected RecaptchaService $recaptchaService) {}

	public function getRecordsAll(String $appVersion): JsonResponse {
		$result = $this->service->getAllVotes($appVersion);
		return response()->json($result);
	}

	public function getRecordsLimit(String $appVersion, int $limit, int $offset): JsonResponse {
		$result = $this->service->loadMoreVotes($appVersion, $limit, $offset);
		return response()->json($result);
	}

	public function getById(String $appVersion, int $votes): JsonResponse {
		$result = $this->service->getOneVotes($appVersion, $votes);
		return response()->json($result);
	}

	public function countPendingVerifiedSpam(String $appVersion): JsonResponse {
		$result = $this->service->countAllVotesByStatus($appVersion);
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

	public function storeAdmin(VoteCreateRequest $request): JsonResponse {
		$result = $this->service->createNewVote($request->validated());
		return response()->json($result);
	}

	public function storeClient(VoteCreateRequest $request): JsonResponse {
		try {
			$this->recaptchaService->verify($request->validated('g_recaptcha_response'));
			$result = $this->voteService->createNewVote($request->validated());

			return response()->json($result);
		} catch (InvalidRecaptchaException $recaptchaException) {
			return response()->json(['success' => false, 'message' => $recaptchaException->getMessage()]);
		}
	}

	public function update(VoteUpdateRequest $request): JsonResponse {
		$result = $this->service->updateVote($request->validated());
		return response()->json($result);
	}

	public function updateByStatus(Request $request): JsonResponse {
		$result = $this->service->updateVotesByStatus($request->all());
		return response()->json($result);
	}

	public function destroy(String $appVersion, int $votesId): JsonResponse {
		$result = $this->service->deleteVote($appVersion, $votesId);
		return response()->json($result);
	}
}