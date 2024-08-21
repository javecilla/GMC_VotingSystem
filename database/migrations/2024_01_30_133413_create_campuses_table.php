<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::create('campuses', function (Blueprint $table) {
			$table->bigIncrements('scid');
			// app version relation
			$table->unsignedBigInteger('app_version_id');
			$table->foreign('app_version_id')
				->references('avid')->on('app_versions')
			// if the version model is deletde this campus will delete also
				->onDelete('CASCADE')
			// if the version model is update this campus will update too
				->onUpdate('CASCADE');
			$table->string('name');

			$table->unique(['app_version_id', 'name']);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::dropIfExists('campuses');
	}
};
