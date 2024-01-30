<?php

namespace App\Services;

class CategoryService {
	public function getAll(String $version): array {
		return ['success' => true, 'message' => 'at api category service'];
	}
}