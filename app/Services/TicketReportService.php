<?php

namespace App\Services;

use App\Exceptions\Api\CreateDataException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Helpers\Decoder;
use App\Models\AppVersion;
use App\Models\TicketReport;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TicketReportService {
	public function loadMoreReports(string $appVersionName, int $limit, int $offset) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		return Cache::remember('ticketReportMore:' . $appVersion->avid, 60 * 60 * 24,
			function () use ($appVersion, $limit, $offset) {
				$ticketReport = TicketReport::with(['appVersion'])
					->where('app_version_id', $appVersion->avid)
					->orderBy('created_at', 'desc')
					->skip($offset)
					->take($limit)
					->get();

				return $ticketReport;
			});
	}

	public function getTicketReportsById(string $ticketReportId) {
		$trid = Decoder::decodeIds($ticketReportId);
		return Cache::remember('ticketReportId:' . $trid, 60 * 60 * 24,
			function () use ($trid) {
				$ticketReport = TicketReport::with(['appVersion'])
					->where('trid', $trid)
					->get();

				return $ticketReport;
			});
	}

	public function getTicketReportsByStatus(string $appVersionName, int $status) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		return Cache::remember('ticketReportStatus:' . $status, 60 * 60 * 24,
			function () use ($appVersion, $status) {
				$ticketReport = TicketReport::with(['appVersion'])
					->where('app_version_id', $appVersion->avid)
					->where('status', $status)
					->orderBy('created_at', 'desc')
					->get();

				return $ticketReport;
			});
	}

	public function getTicketReportsBySearch(string $appVersionName, string $searchQuery) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		return Cache::remember('ticketReportSearch:' . $searchQuery, 60 * 60 * 24,
			function () use ($appVersion, $searchQuery) {
				$ticketReport = TicketReport::with(['appVersion'])
					->where('app_version_id', $appVersion->avid)
					->where(function ($query) use ($searchQuery) {
						$query->where('name', 'like', '%' . $searchQuery . '%')
							->orWhere('email', 'like', '%' . $searchQuery . '%')
							->orWhere('message', 'like', '%' . $searchQuery . '%');
					})
					->get();

				return $ticketReport;
			});
	}

	public function countAllTicketReportsByStatus(string $appVersionName) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		return Cache::remember('ticketReportCount:' . $appVersion->avid, 60 * 60 * 24, function () use ($appVersion) {
			$totalReportsNotFixed = TicketReport::where('app_version_id', $appVersion->avid)
				->where('status', 1)
				->count();

			return $totalReportsNotFixed;
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
				throw new CreateDataException("Failed to submit ticket report", 422);
			}

			return;
		});
	}

	public function updateTicketReport(array $data) {
		$trid = Decoder::decodeIds($data['trid']);
		$ticketReport = TicketReport::findOrFail($trid);
		return DB::transaction(function () use ($ticketReport) {
			$updated = $ticketReport->update(['status' => 0]); //0 = fixed
			if (!$updated) {
				throw new UpdateDataException('Failed to update the status of tickets.', 422);
			}

			return;
		});
	}
}