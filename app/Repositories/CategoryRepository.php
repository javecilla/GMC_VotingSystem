<?php

namespace App\Repositories;
use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DeleteDataException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Interfaces\IRepository;
use App\Models\AppVersion;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryRepository implements IRepository {

	# @Override
	public function getAll(String $appVersionName = ""): object {
		$appVersion = AppVersion::where('name', $appVersionName)->first();
		if ($appVersion) {
			//get all category by its version name
			return Category::where('app_version_id', $appVersion->avid)->get();
		} else {
			//get all category regardless sa version name niya
			return Category::all(); //Category::none();
		}
	}

	# @Override
	public function getOne(int $ctid): object {}

	# @Override
	public function create(array $attributes): array {
		return DB::transaction(function () use ($attributes) {
			$created = Category::query()->create([
				'app_version_id' => data_get($attributes, 'app_version_id', null),
				'name' => data_get($attributes, 'name', 'Unnamed'),
				'updated_at' => data_get($attributes, 'updated_at', null),
			]);

			if (!$created) {
				throw new CreateDataException('Something went wrong! Failed to create new category');
			}
			return ['success' => true, 'message' => 'New category created successfully'];
		});
	}

	# @Override
	public function update(array $attributes): array {
		$category = $this->findCategory($attributes['ctid']);

		return DB::transaction(function () use ($category, $attributes) {
			$updated = $category->update(['name' => data_get($attributes, 'name', $category->name)]);
			if (!$updated) {
				throw new UpdateDataException('Something went wrong! Failed to category');
			}

			return ['success' => true, 'message' => 'Category updated successfully.'];
		});
	}

	# @Override
	public function delete(int $ctid): array {
		$category = $this->findCategory($ctid);
		return DB::transaction(function () use ($category) {
			$deleted = $category->delete();
			if (!$deleted) {
				throw new DeleteDataException('Something went wrong! Failed to delete category');
			}

			return ['success' => true, 'message' => 'Category deleted successfully'];
		});
	}

	public function nameExists(string $name, int $ctid): bool {
		// Check if any other category has the same name
		return Category::where('name', $name)
			->where('ctid', '<>', $ctid)
			->exists();
	}

	public function findCategory(int $ctid): Category {
		// Find the category in db that match to the request
		return Category::findOrFail($ctid);
	}
}