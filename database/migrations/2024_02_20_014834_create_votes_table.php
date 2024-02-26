<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::create('votes', function (Blueprint $table) {
			$table->bigIncrements('vid');
			// app version relation
			$table->unsignedBigInteger('app_version_id');
			$table->foreign('app_version_id')
				->references('avid')->on('app_versions')
				->onDelete('CASCADE')
				->onUpdate('CASCADE');
			// candidates relation
			$table->unsignedBigInteger('candidate_id');
			$table->foreign('candidate_id')
				->references('cdid')->on('candidates')
				->onDelete('CASCADE')
				->onUpdate('CASCADE');
			// candidates relation
			$table->unsignedBigInteger('vote_points_id');
			$table->foreign('vote_points_id')
				->references('vpid')->on('vote_points')
				->onDelete('CASCADE')
				->onUpdate('CASCADE');
			$table->string('contact_no');
			$table->string('email');
			$table->string('referrence_no');
			// 0 = verified,
			// 1 = pending,
			// 2 = spam
			$table->tinyInteger('status')->default('1')
				->comments('0 = verified, 1 = pending, 2 = spam');

			$table->unique(['app_version_id', 'referrence_no']);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::dropIfExists('votes');
	}
};
