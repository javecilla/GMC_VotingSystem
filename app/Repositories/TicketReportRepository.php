<?php

namespace App\Repositories;

use App\Exceptions\App\Admin\CreateDataException;
use App\Interfaces\IRepository;
use App\Models\AppVersion;
use App\Models\TicketReport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TicketReportRepository implements IRepository {
	public function getAll(String $condition = ""): object {}
	public function getOne(int $id): object {}

	public function create(array $attributes): array {
		$appVersion = AppVersion::where('name', $attributes['app_version_name'])->first();
		return DB::transaction(function () use ($appVersion, $attributes) {
			$file = isset($attributes['image']) ? $attributes['image'] : null;

			if ($file instanceof \Illuminate\Http\UploadedFile  && $file->isValid()) {
				//store the uploaded file in the 'storage/candidates/filename' folder
				$path = Storage::disk('public')->put('reports', $file);
				// Assign the stored path to the 'image' key in the data array
				$attributes['image'] = $path;
			} else {
				// If no image is submitted, set it to null
				$attributes['image'] = null;
			}

			$created = TicketReport::query()->create([
				'app_version_id' => $appVersion->avid,
				'name' => data_get($attributes, 'name', null),
				'email' => data_get($attributes, 'email', null),
				'message' => data_get($attributes, 'message', null),
				'image' => $attributes['image'],
				'updated_at' => null,
			]);

			if (!$created) {
				throw new CreateDataException("Failed to submit ticket report");
			}

			return ['success' => true, 'message' => 'Report submitted successfully.'];
		});
	}

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

		//\Log::info($ticketReports);
		return ['success' => true, 'totalReports' => $ticketReports];
	}

}