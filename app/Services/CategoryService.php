<?php

namespace App\Services;

use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DeleteDataException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class CategoryService {

	public function __construct(protected CategoryRepository $repository) {}

	public function getAllCategory(String $appVersionName): object {
		return $this->repository->getAll($appVersionName);
	}

	public function createCategory(array $data): array {
		try {
			$filteredData = Arr::only($data, ['app_version_id', 'name']);
			return $this->repository->create($filteredData);
		} catch (CreateDataException $e) {
			return ['success' => false, 'message' => $e->getMessage()];
		} catch (\Exception $e) {
			return ['success' => false, 'message' => 'An error occurred during creation.'];
		}
	}

	public function updateCategory(array $data): array {
		try {
			if (!$this->hasChangesOccurred($data)) {
				return ['success' => false, 'message' => 'No changes occured', 'type' => 'info'];
			}

			if ($this->isDuplicateCategory($data)) {
				return ['success' => false, 'message' => 'Cannot duplicate category.', 'type' => 'warning'];
			}

			$filteredData = Arr::only($data, ['ctid', 'name']);
			return $this->repository->update($filteredData);
		} catch (ModelNotFoundException $e) {
			return ['success' => false, 'message' => 'Category not found'];
		} catch (UpdateDataException $e) {
			return ['success' => false, 'message' => $e->getMessage()];
		} catch (\Exception $e) {
			return ['success' => false, 'message' => 'An error occurred during updation.'];
		}
	}

	public function deleteCategory(int $categoryId): array {
		try {
			return $this->repository->delete($categoryId);
		} catch (ModelNotFoundException $e) {
			return ['success' => false, 'message' => 'Category not found'];
		} catch (DeleteDataException $e) {
			return ['success' => false, 'message' => $e->getMessage()];
		} catch (\Exception $e) {
			return ['success' => false, 'message' => 'An error occurred during deletion.'];
		}
	}

	private function isDuplicateCategory(array $data): bool {
		// Name must be unique, but only if it's changing
		return $this->repository->nameExists($data['name'], $data['app_version_id'], $data['ctid']);
	}

	private function hasChangesOccurred(array $data): bool {
		// This check if there is any changes occured or not
		$category = $this->repository->findCategory($data['ctid']);
		$category->fill($data);

		return $category->isDirty();
	}
}