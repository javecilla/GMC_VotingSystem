<?php

namespace App\Services;

use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DeleteDataException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Repositories\CandidateRepository;
use App\Repositories\VoteRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class CandidateService {
	public function __construct(protected CandidateRepository $repository,
		protected VoteRepository $voteRepository) {}

	public function createCandidate(array $data): array {
		try {
			$filteredData = Arr::only($data, [
				'app_version_id', 'school_campus_id', 'category_id',
				'candidate_no', 'name', 'motto_description', 'image',
			]);
			return $this->repository->create($filteredData);
		} catch (CreateDataException $e) {
			return ['success' => false, 'message' => $e->getMessage()];
		} catch (\Exception $e) {
			\Illuminate\Support\Facades\Log::Error($e->getMessage());
			return ['success' => false, 'message' => 'An error occurred during creation.'];
		}
	}

	public function updateCandidate(array $data): array {
		try {
			if (!$this->hasChangesOccurred($data)) {
				return ['success' => false, 'message' => 'No changes occured', 'type' => 'info'];
			}

			if ($this->isDuplicateCandidate($data)) {
				return ['success' => false, 'message' => 'Cannot duplicate candidate.', 'type' => 'warning'];
			}

			$filteredData = Arr::only($data, [
				'cdid', 'app_version_id', 'school_campus_id', 'category_id',
				'candidate_no', 'name', 'motto_description', 'image',
			]);
			return $this->repository->update($filteredData);
		} catch (ModelNotFoundException $e) {
			return ['success' => false, 'message' => 'Candidate not found.'];
		} catch (UpdateDataException $e) {
			return ['success' => false, 'message' => $e->getMessage()];
		} catch (\Exception $e) {
			\Illuminate\Support\Facades\Log::info('error: ' . $e->getMessage());
			return ['success' => false, 'message' => 'An error occurred during updation.'];
		}
	}

	public function deleteCandidate(int $candidateId): array {
		try {
			return $this->repository->delete($candidateId);
		} catch (ModelNotFoundException $e) {
			return ['success' => false, 'message' => 'Candidate not found'];
		} catch (DeleteDataException $e) {
			return ['success' => false, 'message' => $e->getMessage()];
		} catch (\Exception $e) {
			return ['success' => false, 'message' => 'An error occurred during deletion.'];
		}
	}

	public function getAllCandidates(String $appVersionName): object {
		return $this->repository->getAll($appVersionName);
	}

	public function getFilterSearchCandidates(String $appVersionName, String $searchQuery): object {
		return $this->repository->filterSearch($appVersionName, $searchQuery);
	}

	public function getCandidatesByCategory(String $appVersionName, int $categoryId): object {
		return $this->repository->getByCategory($appVersionName, $categoryId);
	}

	public function getOneCandidate(int $candidateId): object {
		return $this->repository->getOne($candidateId);
	}

	public function loadMoreCandidates(String $appVersion, int $limit, int $offset): object {
		return $this->repository->loadMoreData($appVersion, $limit, $offset);
	}

	private function isDuplicateCandidate(array $data): bool {
		// Name must be unique, but only if it's changing
		return $this->repository->nameExists($data['name'], (int) $data['app_version_id'], (int) $data['cdid']);
	}

	private function hasChangesOccurred(array $data): bool {
		// This check if there is any changes occured or not
		$candidate = $this->repository->findCandidate($data['cdid']);
		$candidate->fill($data);

		return $candidate->isDirty();
	}
}