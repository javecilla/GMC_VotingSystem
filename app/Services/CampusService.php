<?php

namespace App\Services;

use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DeleteDataException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Repositories\CampusRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

/**
 *
 */
class CampusService {
	public function __construct(protected CampusRepository $repository) {}

	public function getAllCampus(String $appVersion): object {
		return $this->repository->getAll($appVersion);
	}

	public function createCampus(array $data): array {
		try {
			$filteredData = Arr::only($data, ['app_version_id', 'name']);
			return $this->repository->create($filteredData);
		} catch (CreateDataException $e) {
			return ['success' => false, 'message' => $e->getMessage()];
		} catch (\Exception $e) {
			return ['success' => false, 'message' => 'An error occured during campus creatation.'];

		}
	}

	public function updateCampus(array $data): array {
		try {
			if (!$this->hasChangesOccurred($data)) {
				return ['success' => false, 'message' => 'No changes occured', 'type' => 'info'];
			}

			$filteredData = Arr::only($data, ['app_version_id', 'scid', 'name']);
			return $this->repository->update($filteredData);
		} catch (ModelNotFoundException $e) {
			return ['success' => false, 'message' => 'Something went wrong! Campus id not found.'];
		} catch (UpdateDataException $e) {
			return ['success' => false, 'message' => $e->getMessage()];
		} catch (\Exception $e) {
			return ['success' => false, 'message' => 'An error occured during campus updation.'];

		}
	}

	public function deleteCampus(int $campusId): array {
		try {
			return $this->repository->delete($campusId);
		} catch (ModelNotFoundException $e) {
			return ['success' => false, 'message' => 'Something went wrong! Campus id not found.'];
		} catch (DeleteDataException $e) {
			return ['success' => false, 'message' => $e->getMessage()];
		} catch (\Exception $e) {
			return ['success' => false, 'message' => 'An error occured during campus deletion.'];

		}
	}

	private function hasChangesOccurred(array $data): bool {
		$campus = $this->repository->findCampus($data['scid']);
		$campus->fill($data);

		return $campus->isDirty();
	}
}