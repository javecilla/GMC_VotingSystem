<?php

namespace App\Services;

use App\Models\Category;

class CategoryService {
	public function getAll(String $version): object {
		return Category::all();
	}
}