<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TicketReport>
 */
class TicketReportFactory extends Factory {
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array {
		return [
			'app_version_id' => 1,
			'name' => 'test', //fake()->unique()->name()
			'email' => 'test@gmail.com', //fake()->unique()->safeEmail()
			'message' => 'test test', //fake()->paragraph()
			'image' => null,
			'status' => 1, //not fixed as default
			'created_at' => now(),
			'updated_at' => null,
		];
	}
}
