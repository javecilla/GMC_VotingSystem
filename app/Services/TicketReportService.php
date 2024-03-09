<?php

namespace App\Services;

use App\Exceptions\App\Admin\CreateDataException;
use App\Models\AppVersion;
use App\Models\TicketReport;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TicketReportService {

	public function loadMoreReports(String $appVersionName, int $limit, int $offset) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		return Cache::remember('ticketReportMore:' . $appVersion->avid, 60 * 60 * 24,
			function () use ($appVersion, $limit, $offset) {
				$ticketReport = TicketReport::with(['appVersion'])
					->where('app_version_id', $appVersion->avid)
					->orderBy('created_at', 'desc')
					->skip($offset)
					->take($limit)
					->get();
				//\Illuminate\Support\Facades\Log::info($ticketReport);
				return $ticketReport;
			});
	}

	public function countAllTicketReportsByStatus(String $appVersionName) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		return Cache::remember('ticketReportCount:' . $appVersion->avid, 60 * 60 * 24, function () use ($appVersion) {
			$ticketReports = TicketReport::where('app_version_id', $appVersion->avid)
				->where('status', 1)
				->count();
			//\Log::info($ticketReports);
			return response()->json(['success' => true, 'totalReports' => $ticketReports]);
		});
	}

	public function createNewTicketReport(array $data) {
		$appVersion = AppVersion::where('name', $data['app_version_name'])->firstOrFail();
		return DB::transaction(function () use ($appVersion, $data) {
			$file = isset($data['image']) ? $data['image'] : null;

			if ($file instanceof \Illuminate\Http\UploadedFile  && $file->isValid()) {
				//store the uploaded file in the 'storage/candidates/filename' folder
				$path = Storage::disk('public')->put('reports', $file);
				// Assign the stored path to the 'image' key in the data array
				$data['image'] = $path;
			} else {
				// If no image is submitted, set it to null
				$data['image'] = null;
			}

			$created = TicketReport::query()->create([
				'app_version_id' => $appVersion->avid,
				'name' => data_get($data, 'name', null),
				'email' => data_get($data, 'email', null),
				'message' => data_get($data, 'message', null),
				'image' => $data['image'],
				'created_at' => data_get($data, 'created_at', now()),
				'updated_at' => data_get($data, 'updated_at', null),
			]);

			if (!$created) {
				throw new CreateDataException("Failed to submit ticket report");
			}

			return response()->json(['success' => true, 'message' => 'Report submitted successfully.']);
		});
	}
}