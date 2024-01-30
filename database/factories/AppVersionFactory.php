<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AppVersion>
 */
class AppVersionFactory extends Factory {
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array {
		return [
			'avid' => 1,
			'name' => 'v1.1',
			'title' => 'Santa Maria Teen Model 2023',
			'created_at' => NOW(),
			'updated_at' => null,
		];
	}
}
