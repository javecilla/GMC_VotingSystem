<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vote>
 */
class VoteFactory extends Factory {
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array {
		return [
			'vid' => 1,
			'app_version_id' => 1,
			'candidate_id' => 1,
			'vote_points_id' => 1,
			'contact_no' => '09772465533',
			'email' => 'jerometest@gmail.com',
			'referrence_no' => '1234567890123',
			'status' => 1, //pending as default
			'created_at' => NOW(),
			'updated_at' => null,
		];
	}
}
