<?php

namespace App\Services;

use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DeleteDataException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Repositories\AppVersionRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

/**
 * This Services class will be the base of business logic
 */

class AppVersionService {
	public function __construct(protected AppVersionRepository $repository) {}

	// Get all the application version
	public function getAllAppVersion(): object {
		return $this->repository->getAll();
	}

	// Create new record of application version
	public function createAppVersion(array $data): array {
		try {
			$filteredData = Arr::only($data, ['name', 'title']);
			return $this->repository->create($filteredData);
		} catch (CreateDataException $e) {
			return ['success' => false, 'message' => $e->getMessage()];
		} catch (\Exception $e) {
			return ['success' => false, 'message' => 'An error occurred during creation.'];
		}
	}

	// Update version by its id
	public function updateAppVersion(array $data): array {
		try {
			if (!$this->hasChangesOccurred($data)) {
				return ['success' => false, 'message' => 'No changes occured', 'type' => 'info'];
			}

			if (!$this->isValidToUpdate($data)) {
				return ['success' => false, 'message' => 'Cannot duplicate version name or title.', 'type' => 'warning'];
			}

			$filteredData = Arr::only($data, ['avid', 'name', 'title']);
			return $this->repository->update($filteredData);
		} catch (ModelNotFoundException $e) {
			return ['success' => false, 'message' => 'Application version not found.'];
		} catch (UpdateDataException $e) {
			return ['success' => false, 'message' => $e->getMessage()];
		} catch (\Exception $e) {
			return ['success' => false, 'message' => 'An error occurred during updation.'];
		}
	}

	// Delete existing record of application version
	public function deleteAppVersion(int $appVersionId): array {
		try {
			return $this->repository->delete($appVersionId);
		} catch (ModelNotFoundException $e) {
			return ['success' => false, 'message' => 'Application version not found.'];
		} catch (DeleteDataException $e) {
			return ['success' => false, 'message' => $e->getMessage()];
		} catch (\Exception $e) {
			return ['success' => false, 'message' => 'An error occurred during deletion.'];
		}
	}

	private function isValidToUpdate(array $data): bool {
		// Title and Name must be unique, but only if it's changing
		return ($this->repository->titleExists($data['title'], $data['avid'])
			|| $this->repository->nameExists($data['name'], $data['avid']))
		? false
		: true;
	}

	private function hasChangesOccurred(array $data): bool {
		// This check if there is any changes occured or not
		$appVersion = $this->repository->findAppVersion($data['avid']);
		$appVersion->fill($data);

		return $appVersion->isDirty();
	}

}