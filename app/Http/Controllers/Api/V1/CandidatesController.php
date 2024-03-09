<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DeleteDataException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Http\Controllers\Controller;
use App\Http\Requests\App\Admin\CandidateCreateRequest;
use App\Http\Requests\App\Admin\CandidateUpdateRequest;
use App\Services\CandidateService;
use App\Services\VoteService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class CandidatesController extends Controller {
	public function __construct(protected CandidateService $service,
		protected VoteService $voteService) {}

	public function getRecordsAll(String $appVersionName) {
		try {
			return $this->service->getAllCandidates($appVersionName);
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured. Code[CDID]']);
		}
	}

	public function getRecordsOne(String $appVersionName, int $candidateId) {
		try {
			return $this->service->getOneCandidate($candidateId);
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured. Code[CDID]']);
		}
	}

	public function getBySearch(String $appVersionName, String $search) {
		try {
			return $this->service->getFilterSearchCandidates($appVersionName, $search);
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured. Code[CDID]']);
		}
	}

	public function getByCategory(String $appVersionName, int $categoryId) {
		try {
			return $this->service->getCandidatesByCategory($appVersionName, $categoryId);
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured. Code[CDID]']);
		}
	}

	public function getRecordsLimit(String $appVersionName, int $limit, int $offset) {
		try {
			return $this->service->loadMoreCandidates($appVersionName, $limit, $offset);
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured. Code[CDID]']);
		}
	}

	public function store(CandidateCreateRequest $request): JsonResponse {
		try {
			return $this->service->createCandidate($request->validated());
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (CreateDataException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured during creation. Code[CDID]']);
		}
	}

	public function update(CandidateUpdateRequest $request): JsonResponse {
		try {
			return $this->service->updateCandidate($request->all());
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (UpdateDataException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured during updation. Code[CDID]']);
		}
	}

	public function destroy(String $appVersionName, int $candidateId): JsonResponse {
		try {
			return $this->service->deleteCandidate($candidateId);
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (DeleteDataException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured during deletion. Code[CDID]']);
		}
	}

	public function getOverallRanking(String $appVersionName, int $limit) {
		try {
			return $this->voteService->getMostVotesCandidates($appVersionName, $limit);
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured. Code[CDID-VID]']);
		}
	}

	public function getCategoryRanking(String $appVersionName, int $limit) {
		try {
			return $this->voteService->getMostVotesCandidatesByCategory($appVersionName, $limit);
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured. Code[CDID-VID]']);
		}
	}
}