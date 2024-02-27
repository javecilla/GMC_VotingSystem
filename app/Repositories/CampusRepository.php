<?php

namespace App\Repositories;

use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DeleteDataException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Interfaces\IRepository;
use App\Models\AppVersion;
use App\Models\Campus;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class CampusRepository implements IRepository {

	public function getAll(String $appVersionName = ""): object {
		$appVersion = AppVersion::where('name', $appVersionName)->first();
		return Campus::where('app_version_id', $appVersion->avid)->get();
	}

	public function getOne(int $id): object {}

	public function create(array $attributes): array {
		return DB::transaction(function () use ($attributes) {
			$created = Campus::query()->create([
				'app_version_id' => data_get($attributes, 'app_version_id', null),
				'name' => data_get($attributes, 'name', null),
				'created_at' => now(),
				'updated_at' => null,
			]);

			if (!$created) {
				throw new CreateDataException('Failed to create new campus.');
			}

			return ['success' => true, 'message' => 'Campus created successfully'];
		});
	}

	public function update(array $attributes): array {
		$campus = $this->findCampus((int) $attributes['scid']);
		return DB::transaction(function () use ($campus, $attributes) {
			$updated = $campus->update([
				'app_version_id' => data_get($attributes, 'app_version_id', $campus->app_version_id),
				'name' => data_get($attributes, 'name', $campus->name),
				'updated_at' => now(),
			]);

			if (!$updated) {
				throw new UpdateDataException('Failed to update campus.');
			}

			return ['success' => true, 'message' => 'Campus updated successfully'];
		});
	}

	public function delete(int $scid): array {
		$campus = $this->findCampus((int) $scid);
		return DB::transaction(function () use ($campus) {
			$deleted = $campus->delete();
			if (!$deleted) {
				throw new DeleteDataException('Something went wrong! Failed to delete campus');
			}

			return ['success' => true, 'message' => 'Campus deleted successfully'];
		});
	}

	public function findCampus(int $scid): Campus {
		return Campus::findOrFail($scid);
	}
}