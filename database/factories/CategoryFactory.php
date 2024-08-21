<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory {
	public function definition(): array {
		return [
			'ctid' => 1,
			'app_version_id' => 1,
			'name' => 'Lakan',
			'created_at' => NOW(),
			'updated_at' => null,
		];
	}
}
