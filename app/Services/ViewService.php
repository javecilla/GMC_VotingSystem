<?php

namespace App\Services;

use App\Models\AppVersion;

class ViewService {
	public function getAllTotalCount(String $appVersion): array {
		$appVersion = AppVersion::where('name', 'v1.2')->first();
		$totalPageViews = views($appVersion)->remember()->count();
		//\Illuminate\Support\Facades\Log::info($totalPageViews);
		return [
			'success' => true,
			'message' => 'Tested',
			'totalPageViews' => $totalPageViews,
		];
	}

	public function getAllTotalCountPerDay(String $appVersion): array {
		$appVersion = AppVersion::where('name', 'v1.2')->first();
		$totalPageViews = views($appVersion)->remember()->count();
		//\Illuminate\Support\Facades\Log::info($totalPageViews);
		return [
			'success' => true,
			'message' => 'Tested',
			'totalPageViews' => $totalPageViews,
		];
	}
}