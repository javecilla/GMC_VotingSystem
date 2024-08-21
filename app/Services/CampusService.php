<?php

namespace App\Services;

use App\Exceptions\App\Admin\ChangesOccuredException;
use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DuplicateDataException;
use App\Helpers\Decoder;
use App\Models\AppVersion;
use App\Models\Campus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CampusService {

	public function getAllCampus(string $appVersionName) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		return Cache::remember('campuses:' . $appVersion->avid, 60 * 60 * 24, function () use ($appVersion) {
				$campus = Campus::orderBy('created_at', 'desc')->where('app_version_id', $appVersion->avid)->get();
				return $campus;
			});
	}

	public function createCampus(array $data) {
		return DB::transaction(function () use ($data) {
			$avid = Decoder::decodeIds($data['app_version_id']);
			$created = Campus::query()->create([
				'app_version_id' => $avid,
				'name' => data_get($data, 'name', null),
				'created_at' => data_get($data, 'created_at', now()),
				'updated_at' => data_get($data, 'updated_at', null),
			]);

			if(!$created) {
				throw new CreateDataException('Failed to create new campus.', 422);
			}

			return;
		});
	}

	public function updateCampus(array $data) {
		$data['scid'] = Decoder::decodeIds($data['scid']);

		if(!$this->hasChangesOccurred($data)) {
			throw new ChangesOccuredException('No changes occured.');
		}

		if($this->nameExists($data)) {
			throw new DuplicateDataException('Cannot duplicate campus.');
		}

		$campus = Campus::findOrFail($data['scid']);
		return DB::transaction(function () use ($campus, $data) {
			$updated = $campus->update([
				'app_version_id' => data_get($data, 'app_version_id', $campus->app_version_id),
				'name' => data_get($data, 'name', $campus->name),
				'updated_at' => data_get($data, 'updated_at', now()),
			]);

			if(!$updated) {
				throw new UpdateDataException('Failed to update campus.', 422);
			}

			return;
		});
	}

	public function deleteCampus(string $campusId) {
		$scid = Decoder::decodeIds($campusId);
		$campus = Campus::findOrFail($scid);
		return DB::transaction(function () use ($campus) {
			$deleted = $campus->delete();
			if (!$deleted) {
				throw new DeleteDataException('Failed to delete campus');
			}

			return;
		});
	}

	private function hasChangesOccurred(array $data): bool {
		$campus = Campus::findOrFail($data['scid']);
		$campus->fill(['name' => data_get($data, 'name', $campus->name)]);

		return $campus->isDirty();
	}

	private function nameExists(array $data): bool {
		return Campus::where('name', $data['name'])
			->where('app_version_id', $data['app_version_id'])
			->where('scid', '<>', $data['scid'])
			->exists();
	}
}