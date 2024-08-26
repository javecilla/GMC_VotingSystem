<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\App\Admin\ChangesOccuredException;
use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DeleteDataException;
use App\Exceptions\App\Admin\DuplicateDataException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Http\Controllers\Controller;
use App\Http\Requests\App\Admin\CandidateCreateRequest;
use App\Http\Requests\App\Admin\CandidateUpdateRequest;
use App\Http\Resources\Api\CandidateResource;
use App\Services\CandidateService;
use App\Services\VoteService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class CandidatesController extends Controller {
	public function __construct(
		protected CandidateService $service,
		protected VoteService $voteService) {}

	public function getRecordsAll(string $appVersionName) {
		try {
			$candidate = $this->service->getAllCandidates($appVersionName);

			return CandidateResource::collection($candidate);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured. Code[CDID]']);
		}
	}

	public function getRecordsOne(string $appVersionName, string $candidateId) {
		try {
			$candidate = $this->service->getOneCandidate($candidateId);

			return CandidateResource::make($candidate);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured. Code[CDID]']);
		}
	}

	public function getBySearch(string $appVersionName, string $search) {
		try {
			$candidate = $this->service->getFilterSearchCandidates($appVersionName, $search);

			return CandidateResource::collection($candidate);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured. Code[CDID]']);
		}
	}

	public function getByCategory(string $appVersionName, string $categoryId) {
		try {
			$candidate = $this->service->getCandidatesByCategory($appVersionName, $categoryId);

			return CandidateResource::collection($candidate);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured. Code[CDID]']);
		}
	}

	public function getRecordsLimit(string $appVersionName, int $limit, int $offset) {
		try {
			$candidate = $this->service->loadMoreCandidates($appVersionName, $limit, $offset);

			return CandidateResource::collection($candidate);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured. Code[CDID]']);
		}
	}

	public function store(CandidateCreateRequest $request): JsonResponse {
		try {
			$this->service->createCandidate($request->validated());

			return Response::json(['success' => true, 'message' => 'New candidate created successfully']);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (CreateDataException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured during creation. Code[CDID]']);
		}
	}

	public function update(CandidateUpdateRequest $request): JsonResponse {
		try {
			$this->service->updateCandidate($request->validated());

			return Response::json(['success' => true, 'message' => 'Candidate updated successfully.']);
		} catch (ChangesOccuredException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage(), 'type' => 'info']);
		} catch (DuplicateDataException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage(), 'type' => 'warning']);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (UpdateDataException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured during updation. Code[CDID]']);
		}
	}

	public function destroy(string $appVersionName, string $candidateId): JsonResponse {
		try {
			$this->service->deleteCandidate($candidateId);

			return Response::json(['success' => true, 'message' => 'Candidate deleted successfully']);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (DeleteDataException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured during deletion. Code[CDID]']);
		}
	}

	public function getOverallRanking(string $appVersionName, int $limit) {
		try {
			$candidates = $this->service->getCandidatesWithMostVotes($appVersionName, $limit);

			return CandidateResource::collection($candidates);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured. Code[VID-CDID]']);
		}
	}

	public function getCategoryRanking(string $appVersionName, int $limit) {
		try {
			$candidates = $this->service->getCandidatesWithMostVotesByCategory($appVersionName, $limit);

			return Response::json($candidates);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured. Code[CDID-VID]']);
		}
	}
}