<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VotePoint>
 */
class VotePointFactory extends Factory {
	public function definition(): array {
		return [
			'vpid' => 1,
			'app_version_id' => 1,
			'amount' => 100.00,
			'point' => 50,
			'created_at' => now(),
			'updated_at' => null,
		];
	}
}
