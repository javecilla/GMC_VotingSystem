<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::create('vote_points', function (Blueprint $table) {
			$table->bigIncrements('vpid');
			// app version relation
			$table->unsignedBigInteger('app_version_id');
			$table->foreign('app_version_id')
				->references('avid')->on('app_versions')
			// if the version model is deletde this campus will delete also
				->onDelete('CASCADE')
			// if the version model is update this campus will update too
				->onUpdate('CASCADE');
			//'amount' can store up to 10 digits with 2 decimal places.
			$table->decimal('amount', 10, 2); //1000, 500, 200, 100
			$table->integer('point'); //700, 500, 150, 50
			$table->text('image')->nullable();
			$table->timestamps();

			// unique constraint for combination of app_version_id, amount, and point
			$table->unique(['app_version_id', 'amount', 'point']);
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::dropIfExists('vote_points');
	}
};
