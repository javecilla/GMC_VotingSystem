<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder {
	protected string $password;

	public function run(): void {
		User::factory()->create([
			'uid' => 1,
			'name' => 'Jerome Avecilla',
			'is_admin' => 1,
			'email' => 'jeromesavc@gmail.com',
			'email_verified_at' => now(),
			'password' => $this->password ??= Hash::make('password'),
			'remember_token' => Str::random(10),
		]);
	}
}
