<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campus>
 */
class CampusFactory extends Factory {
	/**
	 * Define the model's default state.
	 */
	public function definition(): array {
		return [
			'scid' => 1,
			'app_version_id' => 1,
			'name' => 'Golden Minds Colleges of Sta.Maria Campus',
			'created_at' => NOW(),
			'updated_at' => null,
		];
	}
}
