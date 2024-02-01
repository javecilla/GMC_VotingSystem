<?php

namespace App\Services;

use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DeleteDataException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Models\AppVersion;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class AppVersionService {

	// Get all the application version data by its [versionName]
	public function getAll(String $version): object {
		return AppVersion::all();
	}

	// Update version by its id
	public function update(array $data): array {
		try {
			$appVersion = AppVersion::findOrFail($data['avid']);
			return DB::transaction(function () use ($appVersion, $data) {
				$data['updated_at'] = NOW();
				$appVersion->fill($data);
				$result = $appVersion->save();
				if (!$result) {
					throw new UpdateDataException('Something went wrong! Failed to update version');
				}

				return ['success' => true, 'message' => 'Application version updated successfully.'];
			});
		} catch (ModelNotFoundException $e) {
			return ['success' => false, 'message' => 'Application version not found.'];
		} catch (UpdateDataException $e) {
			return ['success' => false, 'message' => $e->getMessage()];
		} catch (\Exception $e) {
			return ['success' => false, 'message' => 'An error occurred during updation.'];
		}
	}

	// Create new record of application version
	public function create(array $data): array {
		try {
			return DB::transaction(function () use ($data) {
				$data['updated_at'] = null;
				$result = AppVersion::create($data);
				if (!$result) {
					throw new CreateDataException('Something went wrong! Failed to create version');
				}

				return ['success' => true, 'message' => 'New application version created successfully'];
			});
		} catch (CreateDataException $e) {
			return ['success' => false, 'message' => $e->getMessage()];
		} catch (\Exception $e) {
			return ['success' => false, 'message' => 'An error occurred during creation.'];
		}
	}

	// Delete existing record of application
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

}