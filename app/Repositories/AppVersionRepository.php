<?php

namespace App\Repositories;

use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Interfaces\IRepository;
use App\Models\AppVersion;
use Illuminate\Support\Facades\DB;

class AppVersionRepository implements IRepository {
	public function create(array $attributes): array {
		return DB::transaction(function () use ($attributes) {
			$created = AppVersion::query()->create([
				'name' => data_get($attributes, 'name', 'Unnamed'),
				'title' => data_get($attributes, 'title', 'Untitled'),
				'updated_at' => data_get($attributes, 'updated_at', null),
			]);

			if (!$created) {
				throw new CreateDataException('Something went wrong! Failed to create version');
			}

			return ['success' => true, 'message' => 'New application version created successfully'];
		});
	}

	public function update(array $attributes): array {
		$appVersion = $this->findAppVersion($attributes['avid']);

		return DB::transaction(function () use ($appVersion, $attributes) {
			$updated = $appVersion->update([
				'name' => data_get($attributes, 'name', $appVersion->name),
				'title' => data_get($attributes, 'title', $appVersion->title),
			]);

			if (!$updated) {
				throw new UpdateDataException('Something went wrong! Failed to update version');
			}

			return ['success' => true, 'message' => 'Application version updated successfully.'];
		});
	}

	public function titleExists(string $title, int $avid): bool {
		// Check if any other version has the same title
		return AppVersion::where('title', $title)
			->where('avid', '<>', $avid)
			->exists();
	}

	public function nameExists(string $name, int $avid): bool {
		// Check if any other version has the same name
		return AppVersion::where('name', $name)
			->where('avid', '<>', $avid)
			->exists();
	}

	public function findAppVersion(int $avid): AppVersion {
		// Find the app version in db that match to the request
		return AppVersion::findOrFail($avid);
	}
}