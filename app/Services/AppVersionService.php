<?php

namespace App\Services;

use App\Exceptions\App\Admin\ChangesOccuredException;
use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DeleteDataException;
use App\Exceptions\App\Admin\DuplicateDataException;
use App\Helpers\Decoder;
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
			return $appVersion;
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

			if(!$created) {
				throw new CreateDataException('Failed to create version', 422);
			}

			return;
		});
	}

	// Update version by its id
	public function updateAppVersion(array $data) {
		$data['avid'] = Decoder::decodeIds($data['avid']);

		if(!$this->hasChangesOccurred($data)) {
			throw new ChangesOccuredException('No changes occured.');
		}

		if($this->nameExists($data)) {
			throw new DuplicateDataException('Cannot duplicate version name.');
		}

		if($this->titleExists($data)) {
			throw new DuplicateDataException('Cannot duplicate title name.');
		}

		$appVersion = AppVersion::findOrFail($data['avid']);
		return DB::transaction(function () use ($appVersion, $data) {
			$updated = $appVersion->update([
				'name' => data_get($data, 'name', $appVersion->name),
				'title' => data_get($data, 'title', $appVersion->title),
				'updated_at' => data_get($data, 'updated_at', now()),
			]);

			if(!$updated) {
				throw new UpdateDataException('Failed to update app version', 422);
			}

			return;
		});
	}

	// Delete existing record of application version
	public function deleteAppVersion(string $appVersionId) {
		$avid = Decoder::decodeIds($appVersionId);
		$appVersion = AppVersion::findOrFail($avid);
		return DB::transaction(function () use ($appVersion) {
			$deleted = $appVersion->delete();
			if (!$deleted) {
				throw new DeleteDataException('Failed to delete version.', 422);
			}

			return;
		});
	}

	// This check if there is any changes occured or not
	private function hasChangesOccurred(array $data): bool {
		$appVersion = AppVersion::findOrFail($data['avid']);
		$appVersion->fill([
			'name' => data_get($data, 'name', $appVersion->name),
			'title' => data_get($data, 'title', $appVersion->title),
		]);

		return $appVersion->isDirty();
	}

	// this check if title exist for specific version name
	private function titleExists(array $data): bool {
		return AppVersion::where('title', $data['title'])
			->where('name', '<>', $data['name'])
			->where('avid', '<>', $data['avid'])
			->exists();
	}

	private function nameExists(array $data): bool {
		return AppVersion::where('name', $data['name'])
			->where('title', '<>', $data['title'])
			->where('avid', '<>', $data['avid'])
			->exists();
	}
}