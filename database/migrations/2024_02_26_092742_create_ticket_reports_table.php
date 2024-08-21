<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::create('ticket_reports', function (Blueprint $table) {
			$table->bigIncrements('trid');
			// app version relation
			$table->unsignedBigInteger('app_version_id');
			$table->foreign('app_version_id')
				->references('avid')->on('app_versions')
				->onDelete('CASCADE')
				->onUpdate('CASCADE');
			$table->string('name');
			$table->string('email');
			$table->text('message');
			$table->text('image')->nullable();
			$table->tinyInteger('status')->default('1')->comments('0 = fixed, 1 = not');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::dropIfExists('ticket_reports');
	}
};
