<?php

namespace App\Http\Controllers\Api\V1;

use App\Services\Auth\RecaptchaService;
use App\Services\VoteService;
use App\Http\Requests\Api\V1\VoteCreateRequest as ClientRequest;
	use App\Http\Requests\App\Admin\VoteCreateRequest as AdminRequest;
	use App\Exceptions\App\Admin\ChangesOccuredException;
	use App\Exceptions\App\Admin\CreateDataException;
	use App\Exceptions\App\Admin\DeleteDataException;
	use App\Exceptions\App\Admin\UpdateDataException;
	use App\Exceptions\Auth\InvalidRecaptchaException;
	use App\Http\Controllers\Controller;
	use App\Http\Requests\App\Admin\VoteUpdateRequest;
	use App\Http\Resources\Api\VoteResource;
	use Illuminate\Http\Facades\ModelNotFoundException;
	use Illuminate\Http\JsonResponse;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Response;

class VotesController extends Controller {

	public function __construct(
		protected VoteService $service,
		protected RecaptchaService $recaptchaService) {}

	public function getRecordsAll(string $appVersionName) {
		try {
			$vote = $this->service->getAllVotes($appVersionName);

			return VoteResource::collection($vote);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured. Code[VID]']);
		}
	}

	public function getRecordsLimit(string $appVersionName, int $limit, int $offset) {
		try {
			$vote = $this->service->loadMoreVotes($appVersionName, $limit, $offset);

			return VoteResource::collection($vote);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured. Code[VID]']);
		}
	}

	public function getRecordsOne(string $appVersionName, string $voteId) {
		try {
			$vote = $this->service->getOneVotes($voteId);

			return VoteResource::make($vote);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured. Code[VID]']);
		}
	}

	public function getRecordsByStatus(string $appVersionName, int $status) {
		try {
			$vote = $this->service->getVotesByStatus($appVersionName, $status);

			return VoteResource::collection($vote);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured. Code[VID]']);
		}
	}

	public function getRecordsBySearch(string $appVersionName, string $search) {
		try {
			$vote = $this->service->getVotesBySearch($appVersionName, $search);

			return VoteResource::collection($vote);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured. Code[VID]']);
		}
	}

	public function countPendingVerifiedSpam(string $appVersionName) {
		try {
			$vote = $this->service->countAllVotesByStatus($appVersionName);
			return Response::json($vote);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured. Code[VID]']);
		}
	}

	public function getTotalOfSummaryVotes(string $appVersionName) {
		try {
			$votes = $this->service->getTotalOfSummaryVotesCandidates($appVersionName);
			return Response::json($votes);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured. Code[VID]']);
		}
	}

	public function storeAdmin(AdminRequest $request): JsonResponse {
		try {
			$this->service->createNewVote($request->validated());

			return Response::json(['success' => true, 'message' => 'Vote created successfully.']);
		} catch (CreateDataException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured during creation . Code[VID]']);
		}
	}

	public function storeClient(ClientRequest $request): JsonResponse {
		try {
			$this->recaptchaService->verify($request->validated('g_recaptcha_response'));
			$this->service->createNewVote($request->validated());

			return Response::json(['success' => true, 'message' => 'Your vote has been successfully submitted.']);
		} catch (InvalidRecaptchaException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (CreateDataException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured during vote submission . Code[VID]']);
		}
	}

	public function update(VoteUpdateRequest $request): JsonResponse {
		try {
			$this->service->updateVote($request->validated());
			return Response::json(['success' => true, 'message' => 'Vote updated successfully.']);
		} catch (ChangesOccuredException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage(), 'type' => 'info']);
		} catch (DuplicateDataException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage(), 'type' => 'warning']);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (UpdateDataException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured during updation. Code[VID]']);
		}
	}

	public function updateByStatus(Request $request): JsonResponse {
		try {
			$this->service->updateVotesByStatus($request->all());

			return Response::json(['success' => true, 'message' => 'Vote status updated successfully.']);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (UpdateDataException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured during updation. Code[VID]']);
		}
	}

	public function destroy(string $appVersionName, string $voteId): JsonResponse {
		try {
			$this->service->deleteVote($voteId);

			return Response::json(['success' => true, 'message' => 'Vote deleted successfully']);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (DeleteDataException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured during updation. Code[VID]']);
		}
	}
}