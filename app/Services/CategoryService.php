<?php

namespace App\Services;

use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Http\Resources\Api\CategoryResource;
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
				return CategoryResource::collection($category);
			});
	}

	public function createCategory(array $data) {
		return DB::transaction(function () use ($data) {
			$created = Category::query()->create([
				'app_version_id' => data_get($data, 'app_version_id', null),
				'name' => data_get($data, 'name', null),
				'created_at' => data_get($data, 'created_at', now()),
				'updated_at' => data_get($data, 'updated_at', null),
			]);

			if (!$created) {
				throw new CreateDataException('Failed to create new category');
			}

			return response()->json(['success' => true, 'message' => 'New category created successfully']);
		});
	}

	public function updateCategory(array $data) {
		if (!$this->hasChangesOccurred($data)) {
			return response()->json(['success' => false, 'message' => 'No changes occured', 'type' => 'info']);
		}

		if ($this->isDuplicateCategory($data)) {
			return response()->json(['success' => false, 'message' => 'Cannot duplicate category.', 'type' => 'warning']);
		}

		$category = Category::findOrFail($data['ctid']);
		return DB::transaction(function () use ($category, $data) {
			$updated = $category->update(['name' => data_get($data, 'name', $category->name)]);
			if (!$updated) {
				throw new UpdateDataException('Failed to update category');
			}

			return response()->json(['success' => true, 'message' => 'Category updated successfully.']);
		});
	}

	public function deleteCategory(int $categoryId) {
		$category = Category::findOrFail($categoryId);
		return DB::transaction(function () use ($category) {
			$deleted = $category->delete();
			if (!$deleted) {
				throw new DeleteDataException('Failed to delete category');
			}

			return response()->json(['success' => true, 'message' => 'Category deleted successfully']);
		});
	}

	private function isDuplicateCategory(array $data): bool {
		return $this->nameExists($data['name'], $data['app_version_id'], $data['ctid']);
	}

	private function hasChangesOccurred(array $data): bool {
		$category = Category::findOrFail($data['ctid']);
		$category->fill($data);

		return $category->isDirty();
	}

	private function nameExists(string $name, int $avid, int $ctid): bool {
		return Category::where('name', $name)
			->where('app_version_id', $avid)
			->where('ctid', '<>', $ctid)
			->exists();
	}
}