<?php

namespace App\Services;

use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DeleteDataException;
use App\Http\Resources\Api\AppVersionResource;
use App\Models\AppVersion;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * This Services class will be the base of business logic
 */

class AppVersionService {

	// Get all the application version
	public function getAllAppVersion() {
		return Cache::remember('appVersions', 60 * 60 * 24, function () {
			$appVersion = AppVersion::orderBy('created_at', 'desc')->get();
			return AppVersionResource::collection($appVersion);
		});
	}

	// Create new record of application version
	public function createAppVersion(array $data) {
		return DB::transaction(function () use ($data) {
			$created = AppVersion::query()->create([
				'name' => data_get($data, 'name', null),
				'title' => data_get($data, 'title', null),
				'created_at' => data_get($data, 'created_at', now()),
				'updated_at' => data_get($data, 'updated_at', null),
			]);

			if (!$created) {
				throw new CreateDataException('Failed to create version');
			}

			return response()->json(['success' => true,
				'message' => 'New application version created successfully']);
		});
	}

	// Update version by its id
	public function updateAppVersion(array $data) {
		if (!$this->hasChangesOccurred($data)) {
			return response()->json(['success' => false, 'message' => 'No changes occured', 'type' => 'info']);
		}

		if (!$this->isValidToUpdate($data)) {
			return response()->json(['success' => false, 'message' => 'Cannot duplicate version name or title.', 'type' => 'warning']);
		}

		$appVersion = AppVersion::findOrFail($data['avid']);
		return DB::transaction(function () use ($appVersion, $data) {
			$updated = $appVersion->update([
				'name' => data_get($data, 'name', $appVersion->name),
				'title' => data_get($data, 'title', $appVersion->title),
				'updated_at' => data_get($data, 'updated_at', now()),
			]);

			if (!$updated) {
				throw new UpdateDataException('Failed to update app version');
			}

			return response()->json(['success' => true, 'message' => 'Application version updated successfully.']);
		});
	}

	// Delete existing record of application version
	public function deleteAppVersion(int $appVersionId) {
		$appVersion = AppVersion::findOrFail($appVersionId);
		return DB::transaction(function () use ($appVersion) {
			$deleted = $appVersion->delete();
			if (!$deleted) {
				throw new DeleteDataException('Failed to delete version');
			}

			return response()->json(['success' => true, 'message' => 'Application version deleted successfully']);
		});
	}

	// This check if there is any changes occured or not
	private function hasChangesOccurred(array $data): bool {
		$appVersion = AppVersion::findOrFail($data['avid']);
		$appVersion->fill($data);
		return $appVersion->isDirty();
	}

	// Title and Name must be unique, but only if it's changing
	private function isValidToUpdate(array $data): bool {
		return ($this->titleExists($data['title'], $data['avid'])
			|| $this->nameExists($data['name'], $data['avid']))
		? false
		: true;
	}

	// Check if any other version has the same title
	private function titleExists(string $title, int $appVersionId): bool {
		return AppVersion::where('title', $title)->where('avid', '<>', $appVersionId)->exists();
	}

	// Check if any other version has the same name
	private function nameExists(string $name, int $appVersionId): bool {
		return AppVersion::where('name', $name)->where('avid', '<>', $appVersionId)->exists();
	}
}