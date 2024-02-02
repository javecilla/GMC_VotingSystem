<?php

namespace App\Services;

use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DeleteDataException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Models\AppVersion;
use App\Repositories\AppVersionRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class AppVersionService {
	public function __construct(protected AppVersionRepository $repository) {}

	// TODO: Get all the application version data by its [versionName]
	public function getAllAppVersion(String $version): object {
		return AppVersion::all();
	}

	// Create new record of application version
	public function create(array $data): array {
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
	public function update(array $data): array {
		try {
			if (!$this->changesOccurred($data)) {
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

	// TODO: Delete existing record of application
	public function delete(int $appVersionId): array {
		try {
			$appVersion = AppVersion::findOrFail($appVersionId);
			$result = $appVersion->delete();
			if (!$result) {
				throw new DeleteDataException('Something went wrong! Failed to delete version');
			}

			return ['success' => true, 'message' => 'Application version deleted successfully'];
		} catch (ModelNotFoundException $e) {
			return ['success' => false, 'message' => 'Application version not found.'];
		} catch (DeleteDataException $e) {
			return ['success' => false, 'message' => $e->getMessage()];
		} catch (\Exception $e) {
			return ['success' => false, 'message' => 'An error occurred during deletion.'];
		}
	}

	private function isValidToUpdate(array $data): bool {
		// Title must be unique, but only if it's changing
		if ($this->repository->titleExists($data['title'], $data['avid'])) {
			return false;
		}

		// Name must be unique, but only if it's changing
		if ($this->repository->nameExists($data['name'], $data['avid'])) {
			return false;
		}

		return true;
	}

	private function changesOccurred(array $data): bool {
		$appVersion = $this->repository->findAppVersion($data['avid']);
		$appVersion->fill($data);
		return $appVersion->isDirty();
	}

}