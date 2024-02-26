<?php

namespace App\Services;

use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DeleteDataException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Repositories\VotePointRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class VotePointService {

	public function __construct(protected VotePointRepository $repository) {}

	public function getAllVotePoints(String $versionName): object {
		return $this->repository->getAll($versionName);
	}

	public function getOneVotePoints(int $votePointsId): object {
		return $this->repository->getOne($votePointsId);
	}

	public function createVotePoints(array $data): array {
		try {
			$filteredData = Arr::only($data, ['app_version_id', 'amount', 'point', 'image']);
			return $this->repository->create($filteredData);
		} catch (ModelNotFoundException $e) {
			return ['success' => false, 'message' => 'Vote Point not found'];
		} catch (CreateDataException $e) {
			return ['success' => false, 'message' => $e->getMessage()];
		} catch (\Exception $e) {
			\Log::error('Error' . $e->getMessage());
			return ['success' => false, 'message' => 'An error occurred during updation.'];
		}
	}

	public function updateVotePoints(array $data): array {
		try {
			if (!$this->hasChangesOccurred($data)) {
				return ['success' => false, 'message' => 'No changes occured', 'type' => 'info'];
			}

			if ($this->isDuplicateVotePoint($data)) {
				return ['success' => false, 'message' => 'Cannot duplicate vote points or amount.', 'type' => 'warning'];
			}

			$filteredData = Arr::only($data, ['vpid', 'amount', 'point', 'image']);
			return $this->repository->update($filteredData);
		} catch (ModelNotFoundException $e) {
			return ['success' => false, 'message' => 'Vote Point not found'];
		} catch (UpdateDataException $e) {
			return ['success' => false, 'message' => $e->getMessage()];
		} catch (\Exception $e) {
			\Log::error('Error:' . $e->getMessage());
			return ['success' => false, 'message' => 'An error occurred during updation.'];
		}
	}

	public function deleteVotePoints(int $votePointId): array {
		try {
			return $this->repository->delete($votePointId);
		} catch (ModelNotFoundException $e) {
			return ['success' => false, 'message' => 'Vote point not found'];
		} catch (DeleteDataException $e) {
			return ['success' => false, 'message' => $e->getMessage()];
		} catch (\Exception $e) {
			return ['success' => false, 'message' => 'An error occurred during deletion.'];
		}
	}

	private function isDuplicateVotePoint(array $data): bool {
		return $this->repository->amountExists($data['amount'], $data['app_version_id'], $data['vpid'])
		|| $this->repository->pointExists($data['point'], $data['app_version_id'], $data['vpid']);
	}

	private function hasChangesOccurred(array $data): bool {
		$votePoint = $this->repository->findVotePoint((int) $data['vpid']);
		$votePoint->fill($data);

		return $votePoint->isDirty();
	}
}