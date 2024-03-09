<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryObserver {
	/**
	 * Handle the Category "created" event.
	 */
	public function created(Category $category): void {
		$this->forgetCategoryCache($category);
	}

	/**
	 * Handle the Category "updated" event.
	 */
	public function updated(Category $category): void {
		$this->forgetCategoryCache($category);
	}

	/**
	 * Handle the Category "deleted" event.
	 */
	public function deleted(Category $category): void {
		$this->forgetCategoryCache($category);
	}

	protected function forgetCategoryCache(Category $category): void {
		Cache::forget('categories:' . $category->app_version_id);
	}
}
