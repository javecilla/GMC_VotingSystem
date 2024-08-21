<?php

namespace App\Services;

use App\Exceptions\App\Admin\ChangesOccuredException;
use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DuplicateDataException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Helpers\Decoder;
use App\Models\AppVersion;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CategoryService {

	public function getAllCategory(String $appVersionName) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		return Cache::remember('categories:' . $appVersion->avid, 60 * 60 * 24,
			function () use ($appVersion) {
				$category = Category::orderBy('created_at', 'desc')
					->where('app_version_id', $appVersion->avid)->get();

				return $category;
			});
	}

	public function createCategory(array $data) {
		return DB::transaction(function () use ($data) {
			$avid = Decoder::decodeIds($data['app_version_id']);
			$created = Category::query()->create([
				'app_version_id' => $avid,
				'name' => data_get($data, 'name', null),
				'created_at' => data_get($data, 'created_at', now()),
				'updated_at' => data_get($data, 'updated_at', null),
			]);
			if (!$created) {
				throw new CreateDataException('Failed to create new category', 422);
			}

			return;
		});
	}

	public function updateCategory(array $data) {
		$data['ctid'] = Decoder::decodeIds($data['ctid']);

		if(!$this->hasChangesOccurred($data)) {
			throw new ChangesOccuredException('No changes occured.');
		}

		if($this->nameExists($data)) {
			throw new DuplicateDataException('Cannot duplicate category.');
		}

		$category = Category::findOrFail($data['ctid']);
		return DB::transaction(function () use ($category, $data) {
			$updated = $category->update(['name' => data_get($data, 'name', $category->name)]);
			if (!$updated) {
				throw new UpdateDataException('Failed to update category', 422);
			}

			return;
		});
	}

	public function deleteCategory(String $categoryId) {
		$ctid = Decoder::decodeIds($categoryId);
		$category = Category::findOrFail($ctid);
		return DB::transaction(function () use ($category) {
			$deleted = $category->delete();
			if (!$deleted) {
				throw new DeleteDataException('Failed to delete category.', 422);
			}

			return;
		});
	}

	private function hasChangesOccurred(array $data): bool {
		$category = Category::findOrFail($data['ctid']);
		$category->fill(['name' => data_get($data, 'name', $category->name)]);

		return $category->isDirty();
	}

	private function nameExists(array $data): bool {
    return Category::where('name', $data['name'])
      ->where('app_version_id', $data['app_version_id'])
      ->where('ctid', '<>', $data['ctid'])
      ->exists();
	}

}