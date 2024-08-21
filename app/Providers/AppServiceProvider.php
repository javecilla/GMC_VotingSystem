<?php

namespace App\Providers;

use App\Models\AppVersion;
use App\Models\Campus;
use App\Models\Candidate;
use App\Models\Category;
use App\Models\TicketReport;
use App\Models\Vote;
use App\Models\VotePoint;
use App\Observers\AppVersionObserver;
use App\Observers\CampusObserver;
use App\Observers\CandidateObserver;
use App\Observers\CategoryObserver;
use App\Observers\TicketReportObserver;
use App\Observers\VoteObserver;
use App\Observers\VotePointObserver;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use L5Swagger\L5SwaggerServiceProvider;

class AppServiceProvider extends ServiceProvider {
	/**
	 * Register any application services.
	 */
	public function register(): void {
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

		//format the return data in resource collection
		JsonResource::withoutWrapping();

		//models event observer
		Campus::observe(CampusObserver::class);
		AppVersion::observe(AppVersionObserver::class);
		Category::observe(CategoryObserver::class);
		VotePoint::observe(VotePointObserver::class);
		Candidate::observe(CandidateObserver::class);
		Vote::observe(VoteObserver::class);
		TicketReport::observe(TicketReportObserver::class);
	}
}
