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
			'name' => fake()->unique()->name(),
			'email' => fake()->unique()->safeEmail(),
			'message' => fake()->paragraph(),
			'image' => 'reports/lSEfnaCLORYuv0qWSW5QHUlSY8juTtJFcE1UFiQs.png',
			'status' => 1, //not fixed as default
			'created_at' => now(),
			'updated_at' => null,
		];
	}
}
