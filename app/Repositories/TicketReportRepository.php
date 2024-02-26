<?php

namespace App\Repositories;

use App\Interfaces\IRepository;
use App\Models\AppVersion;
use App\Models\TicketReport;

class TicketReportRepository implements IRepository {
	public function getAll(String $condition = ""): object {}
	public function getOne(int $id): object {}
	public function create(array $attributes): array {}
	public function update(array $attributes): array {}
	public function delete(int $id): array {}

	public function loadMoreData(String $appVersionName, int $limit, int $offset): object {
		$appVersion = AppVersion::where('name', $appVersionName)->first();
		$ticketReports = TicketReport::with(['appVersion'])
			->where('app_version_id', $appVersion->avid)
			->orderBy('created_at', 'desc')
			->skip($offset)
			->take($limit)
			->get();
		//\Illuminate\Support\Facades\Log::info($ticketReports);
		return $ticketReports;
	}

	public function count(String $appVersionName): array {
		$appVersion = AppVersion::where('name', $appVersionName)->first();
		$ticketReports = TicketReport::where('app_version_id', $appVersion->avid)
			->where('status', 1)
			->count();

		\Log::info($ticketReports);
		return ['success' => true, 'totalReports' => $ticketReports];
	}

}