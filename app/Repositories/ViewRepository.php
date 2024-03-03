<?php

namespace App\Repositories;

use App\Interfaces\IRepository;
use App\Models\AppVersion;
use Carbon\Carbon;
use CyrildeWit\EloquentViewable\Support\Period;

class ViewRepository implements IRepository {
	public function getAll(String $condition = ""): object {}
	public function getOne(int $id): object {}
	public function create(array $attributes): array {}
	public function update(array $attributes): array {}
	public function delete(int $id): array {}

	public function pageViews(String $appVersion): array {
		$appVersion = AppVersion::where('name', $appVersion)->first();
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

	public function pageViewsPerDay(String $appVersion, int $limit): array {
		$appVersion = AppVersion::where('name', $appVersion)->first();
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