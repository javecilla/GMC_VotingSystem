<?php

namespace App\Providers;

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
		//
	}
}
