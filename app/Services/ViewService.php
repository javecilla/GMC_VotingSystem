<?php

namespace App\Services;

use App\Models\AppVersion;
use Carbon\Carbon;
use CyrildeWit\EloquentViewable\Support\Period;

class ViewService {
	//count the views page unique base on its coockie stored in database
	public function getPageViews(String $appVersionName) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		$totalPageViews = views($appVersion)
			->remember()
			->unique()
			->count();
		//\Illuminate\Support\Facades\Log::info($totalPageViews);
		return [
			'success' => true,
			'message' => 'Tested',
			'totalPageViews' => $totalPageViews,
		];
	}

	//count the views page per day
	public function getPageViewsPerDay(String $appVersionName, int $limit) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		$endDate = Carbon::now();
		$pageViewsPerDay = [];

		for ($i = 0; $i < $limit; $i++) {
			$date = $endDate->copy()->subDays($i);
			$formattedDate = $date->isoFormat('MMMM DD');

			$viewsCount = views($appVersion)
				->period(Period::create($date->toDateString(), $date->copy()->endOfDay()))
				->remember()
				->unique()
				->count();

			$pageViewsPerDay[] = [
				'name' => $formattedDate,
				'total_views' => $viewsCount,
			];
		}
		//\Illuminate\Support\Facades\Log::info($pageViewsPerDay);
		return [
			'success' => true,
			'message' => 'Tested',
			'totalPageViews' => $pageViewsPerDay,
		];
	}
}