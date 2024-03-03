<?php

namespace App\Services;

use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DeleteDataException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Repositories\VoteRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class VoteService {
	public function __construct(protected VoteRepository $repository) {}

	public function getAllVotes(String $appVersion): object {
		return $this->repository->getAll($appVersion);
	}

	public function loadMoreVotes(String $appVersion, int $limit, int $offset): object {
		return $this->repository->loadMoreData($appVersion, $limit, $offset);
	}

	public function getOneVotes(String $appVersion, int $votesId): object {
		return $this->repository->getOne($votesId);
	}

	public function getVotesByStatus(String $appVersion, int $status): object {
		return $this->repository->getAllByStatus($appVersion, $status);
	}

	public function getVotesBySearch(String $appVersion, String $search): object {
		return $this->repository->getAllBySearch($appVersion, $search);
	}

	public function getMostVotesCandidates(String $appVersion, int $limit): object {
		return $this->repository->getMostVotes($appVersion, $limit);
	}

	public function getMostVotesCandidatesByCategory(String $appVersion, int $limit): object {
		return $this->repository->getMostVotesCategory($appVersion, $limit);
	}

	public function countAllVotesByStatus(String $appVersion): array {
		return $this->repository->count($appVersion);
	}

	public function createNewVote(array $data): array {
		try {
			$filteredData = Arr::only($data, [
				'app_version_name', 'candidate_id', 'vote_points_id',
				'contact_no', 'email', 'referrence_no',
			]);
			return $this->repository->create($filteredData);
		} catch (CreateDataException $e) {
			return ['success' => false, 'message' => $e->getMessage()];
		} catch (\Exception $e) {
			return ['success' => false, 'message' => 'An error occurred during submission of vote. Please try again.'];
		}
	}

	public function updateVote(array $data): array {
		try {
			if (!$this->hasChangesOccurred($data)) {
				return ['success' => false, 'message' => 'No changes occured', 'type' => 'info'];
			}

			if ($this->isDuplicateVote($data)) {
				return ['success' => false, 'message' => 'Cannot duplicate vote.', 'type' => 'warning'];
			}

			$filteredData = Arr::only($data, [
				'app_version_name', 'candidate_id', 'vote_points_id',
				'contact_no', 'email', 'referrence_no', 'vid',
			]);
			return $this->repository->update($filteredData);
		} catch (ModelNotFoundException $e) {
			return ['success' => false, 'message' => 'Something went wrong! Vote ID not found.'];
		} catch (UpdateDataException $e) {
			return ['success' => false, 'message' => $e->getMessage()];
		} catch (\Exception $e) {
			return ['success' => false, 'message' => 'An error occurred during updation. Please try again later.'];
			//\Illuminate\Support\Facades\Log::info('error: ' . $e->getMessage());
		}
	}

	public function updateVotesByStatus(array $data): array {
		try {
			$filteredData = Arr::only($data, ['vid', 'status']);
			return $this->repository->updateStatus($filteredData);
		} catch (ModelNotFoundException $e) {
			return ['success' => false, 'message' => 'Something went wrong! Vote ID not found.'];
		} catch (UpdateDataException $e) {
			return ['success' => false, 'message' => $e->getMessage()];
		} catch (\Exception $e) {
			return ['success' => false, 'message' => 'An error occurred during creation. Please try again later.'];
		}
	}

	public function deleteVote(String $appVersion, int $votesId): array {
		try {
			return $this->repository->delete($votesId);
		} catch (ModelNotFoundException $e) {
			return ['success' => false, 'message' => 'Vote Id not found'];
		} catch (DeleteDataException $e) {
			return ['success' => false, 'message' => $e->getMessage()];
		} catch (\Exception $e) {
			return ['success' => false, 'message' => 'An error occurred during deletion.'];
		}
	}

	private function isDuplicateVote(array $data): bool {
		return $this->repository->referrenceNumberExists($data['referrence_no'], $data['vid']);
	}

	private function hasChangesOccurred(array $data): bool {
		$vote = $this->repository->findVote((int) $data['vid']);
		$vote->fill($data);

		return $vote->isDirty();
	}
}