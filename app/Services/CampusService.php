<?php

namespace App\Services;

use App\Exceptions\App\Admin\CreateDataException;
use App\Http\Resources\Api\CampusResource;
use App\Models\AppVersion;
use App\Models\Campus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CampusService {

	public function getAllCampus(String $appVersionName) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		return Cache::remember('campuses:' . $appVersion->avid, 60 * 60 * 24,
			function () use ($appVersion) {
				$campus = Campus::orderBy('created_at', 'desc')
					->where('app_version_id', $appVersion->avid)->get();
				return CampusResource::collection($campus);
			});
	}

	public function createCampus(array $data) {
		return DB::transaction(function () use ($data) {
			$created = Campus::query()->create([
				'app_version_id' => data_get($data, 'app_version_id', null),
				'name' => data_get($data, 'name', null),
				'created_at' => data_get($data, 'created_at', now()),
				'updated_at' => data_get($data, 'updated_at', null),
			]);

			if (!$created) {
				throw new CreateDataException('Failed to create new campus.');
			}

			return response()->json(['success' => true, 'message' => 'Campus created successfully']);
		});
	}

	public function updateCampus(array $data) {
		if (!$this->hasChangesOccurred($data)) {
			return response()->json(['success' => false,
				'message' => 'No changes occured', 'type' => 'info']);
		}

		$campus = Campus::findOrFail($data['scid']);
		return DB::transaction(function () use ($campus, $data) {
			$updated = $campus->update([
				'app_version_id' => data_get($data, 'app_version_id', $campus->app_version_id),
				'name' => data_get($data, 'name', $campus->name),
				'updated_at' => data_get($data, 'updated_at', now()),
			]);

			if (!$updated) {
				throw new UpdateDataException('Failed to update campus.');
			}

			return response()->json(['success' => true, 'message' => 'Campus updated successfully']);
		});
	}

	public function deleteCampus(int $campusId) {
		$campus = Campus::findOrFail($campusId);
		return DB::transaction(function () use ($campus) {
			$deleted = $campus->delete();
			if (!$deleted) {
				throw new DeleteDataException('Failed to delete campus');
			}

			return response()->json(['success' => true, 'message' => 'Campus deleted successfully']);
		});
	}

	private function hasChangesOccurred(array $data): bool {
		$campus = Campus::findOrFail($data['scid']);
		$campus->fill($data);

		return $campus->isDirty();
	}
}