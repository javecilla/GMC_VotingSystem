<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::create('candidates', function (Blueprint $table) {
			$table->bigIncrements('cdid');
			// app version relation
			$table->unsignedBigInteger('app_version_id');
			$table->foreign('app_version_id')
				->references('avid')->on('app_versions')
				->onDelete('CASCADE')
				->onUpdate('CASCADE');
			// school campus relation (Nullable|Not Required)
			$table->unsignedBigInteger('school_campus_id')->nullable();
			$table->foreign('school_campus_id')->nullable()
				->references('scid')->on('campuses')
				->onDelete('CASCADE')
				->onUpdate('CASCADE');
			// category relation
			$table->unsignedBigInteger('category_id');
			$table->foreign('category_id')
				->references('ctid')->on('categories')
				->onDelete('CASCADE')
				->onUpdate('CASCADE');
			$table->string('candidate_no');
			$table->string('name');
			$table->text('motto_description')->nullable();
			$table->text('image');
			$table->timestamps();

			$table->unique(['app_version_id', 'candidate_no', 'name']);
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::dropIfExists('candidates');
	}
};
