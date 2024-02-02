<?php

namespace App\Services;

use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DeleteDataException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Models\AppVersion;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class CategoryService {
	public function getAll(String $version): object {
		return Category::all();
	}

	public function getAllByVersion(String $version): object {
		$appVersion = AppVersion::where('name', $version)->first();
		if ($appVersion) {
			return Category::where('app_version_id', $appVersion->avid)->get();
		} else {
			return Category::none();
		}
	}

	public function update(array $data): array {
		try {
			$category = Category::findOrFail($data['ctid']);
			return DB::transaction(function () use ($category, $data) {
				$category->fill($data);
				if (!$category->isDirty()) {
					return ['success' => false, 'message' => 'No changes occurred.', 'type' => 'warning'];
				}

				$data['updated_at'] = now();
				$result = $category->update($data);
				if (!$result) {
					throw new UpdateDataException('Something went wrong! Failed to updated category');
				}

				return ['success' => true, 'message' => 'Category updated successfully.'];
			});
		} catch (ModelNotFoundException $e) {
			return ['success' => false, 'message' => 'Category not found'];
		} catch (UpdateDataException $e) {
			return ['success' => false, 'message' => $e->getMessage()];
		} catch (\Exception $e) {
			return ['success' => false, 'message' => 'An error occurred during deletion.'];
		}
	}

	public function create(array $data): array {
		try {
			return DB::transaction(function () use ($data) {
				$data['updated_at'] = null;
				$result = Category::create($data);
				if (!$result) {
					throw new CreateDataException('Something went wrong! Failed to create new category');
				}
				return ['success' => true, 'message' => 'New category created successfully'];
			});
		} catch (CreateDataException $e) {
			return ['success' => false, 'message' => $e->getMessage()];
		} catch (\Exception $e) {
			return ['success' => false, 'message' => 'An error occurred during deletion.'];
		}
	}

	public function delete(int $categoryId): array {
		try {
			$category = Category::findOrFail($categoryId);
			$result = $category->delete();
			if (!$result) {
				throw new DeleteDataException('Something went wrong! Failed to delete category');
			}

			return ['success' => true, 'message' => 'Category deleted successfully'];
		} catch (ModelNotFoundException $e) {
			return ['success' => false, 'message' => 'Category not found'];
		} catch (DeleteDataException $e) {
			return ['success' => false, 'message' => $e->getMessage()];
		} catch (\Exception $e) {
			return ['success' => false, 'message' => 'An error occurred during deletion.'];
		}
	}
}