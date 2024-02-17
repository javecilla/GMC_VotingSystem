<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Candidate>
 */
class CandidateFactory extends Factory {
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array {
		return [
			'cdid' => 1,
			'app_version_id' => 1,
			'school_campus_id' => 1,
			'category_id' => 1,
			'candidate_no' => '01',
			'name' => 'Zeo Natad',
			'motto_description' => null,
			'image' => 'imagetest.png',
			'created_at' => NOW(),
			'updated_at' => null,
		];
	}
}
