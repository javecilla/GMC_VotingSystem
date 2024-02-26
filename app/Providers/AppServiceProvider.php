<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use L5Swagger\L5SwaggerServiceProvider;

class AppServiceProvider extends ServiceProvider {
	/**
	 * Register any application services.
	 */
	public function register(): void {
		define('APP_VERSION', env('APP_VERSION'));
		$this->app->register(L5SwaggerServiceProvider::class);
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void {
		// Allow the data schema to create freely database table
		Schema::defaultStringLength(191);

		//Use the bootstrap pagination ui button
		Paginator::useBootstrapFive();
	}
}
