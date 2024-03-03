<?php

namespace App\Repositories;

use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DeleteDataException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Interfaces\IRepository;
use App\Models\AppVersion;
use Illuminate\Support\Facades\DB;

/**
 * This Repository class will be the communicator to model and handle database transaction
 */

class AppVersionRepository implements IRepository {

	# @Override
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

	# @Override
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

	# @Override
	public function delete(int $avid): array {
		$appVersion = $this->findAppVersion($avid);
		return DB::transaction(function () use ($appVersion) {
			$deleted = $appVersion->delete();
			if (!$deleted) {
				throw new DeleteDataException('Something went wrong! Failed to delete version');
			}

			return ['success' => true, 'message' => 'Application version deleted successfully'];
		});
	}

	# @Override
	public function getAll(String $condition = ""): object {
		return AppVersion::orderBy('created_at', 'desc')->get();
	}

	# @Override
	public function getOne(int $avid): object {
		return AppVersion::where('avid', $avid)->get();
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