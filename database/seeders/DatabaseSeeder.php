<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\AppVersion;
use App\Models\Campus;
use App\Models\Candidate;
use App\Models\Category;
use App\Models\TicketReport;
use App\Models\User;
use App\Models\Vote;
use App\Models\VotePoint;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
	protected string $password;

	public function run(): void {
		User::factory()->create();
		AppVersion::factory()->create();
		Campus::factory()->create();
		Category::factory()->create();
		VotePoint::factory()->create();
		Candidate::factory()->create();
		Vote::factory()->create();
		TicketReport::factory()->create();
	}
}
