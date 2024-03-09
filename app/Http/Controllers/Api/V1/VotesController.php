<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DeleteDataException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Exceptions\Auth\InvalidRecaptchaException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\VoteCreateRequest as ClientRequest;
use App\Http\Requests\App\Admin\VoteCreateRequest as AdminRequest;
use App\Http\Requests\App\Admin\VoteUpdateRequest;
use App\Services\Auth\RecaptchaService;
use App\Services\VoteService;
use Illuminate\Http\Facades\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VotesController extends Controller {

	public function __construct(protected VoteService $service,
		protected RecaptchaService $recaptchaService) {}

	public function getRecordsAll(String $appVersionName) {
		try {
			return $this->service->getAllVotes($appVersionName);
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured. Code[VID]']);
		}
	}

	public function getRecordsLimit(String $appVersionName, int $limit, int $offset) {
		try {
			return $this->service->loadMoreVotes($appVersionName, $limit, $offset);
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured. Code[VID]']);
		}
	}

	public function getRecordsOne(String $appVersionName, int $voteId) {
		try {
			return $this->service->getOneVotes($voteId);
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured. Code[VID]']);
		}
	}

	public function getRecordsByStatus(String $appVersionName, int $status) {
		try {
			return $this->service->getVotesByStatus($appVersionName, $status);
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured. Code[VID]']);
		}
	}

	public function getRecordsBySearch(String $appVersionName, String $search) {
		try {
			return $this->service->getVotesBySearch($appVersionName, $search);
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured. Code[VID]']);
		}
	}

	public function countPendingVerifiedSpam(String $appVersionName) {
		try {
			return $this->service->countAllVotesByStatus($appVersionName);
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured. Code[VID]']);
		}
	}

	public function storeAdmin(AdminRequest $request): JsonResponse {
		try {
			return $this->service->createNewVote($request->validated());
		} catch (CreateDataException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured during creation . Code[VID]']);
		}
	}

	public function storeClient(ClientRequest $request): JsonResponse {
		try {
			$this->recaptchaService->verify($request->validated('g_recaptcha_response'));
			return $this->service->createNewVote($request->validated());
		} catch (InvalidRecaptchaException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (CreateDataException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured during vote submission . Code[VID]']);
		}
	}

	public function update(VoteUpdateRequest $request): JsonResponse {
		try {
			return $this->service->updateVote($request->validated());
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (UpdateDataException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured during updation. Code[VID]']);
		}
	}

	public function updateByStatus(Request $request): JsonResponse {
		try {
			return $this->service->updateVotesByStatus($request->all());
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (UpdateDataException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured during updation. Code[VID]']);
		}
	}

	public function destroy(String $appVersionName, int $voteId): JsonResponse {
		try {
			return $this->service->deleteVote($voteId);
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (DeleteDataException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured during updation. Code[VID]']);
		}
	}
}