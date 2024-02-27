<?php

namespace App\Services;

use App\Exceptions\App\Admin\CreateDataException;
use App\Repositories\TicketReportRepository;

// use App\Exceptions\App\Admin\DeleteDataException;
// use App\Exceptions\App\Admin\UpdateDataException;
// use Illuminate\Database\Eloquent\ModelNotFoundException;
// use Illuminate\Support\Arr;
use Illuminate\Support\Arr;

class TicketReportService {
	public function __construct(protected TicketReportRepository $repository) {}

	public function loadMoreReports(String $appVersion, int $limit, int $offset): object {
		return $this->repository->loadMoreData($appVersion, $limit, $offset);
	}

	public function countAllTicketReportsByStatus(String $appVersion): array {
		return $this->repository->count($appVersion);
	}

	public function createNewTicketReport(array $data): array {
		try {
			$filteredData = Arr::only($data, [
				'app_version_name', 'name', 'email', 'message', 'image',
			]);
			return $this->repository->create($filteredData);
		} catch (CreateDataException $e) {
			return ['success' => true, 'message' => $e->getMessage()];
		} catch (\Exception $e) {
			\Illuminate\Support\Facades\Log::info($e->getMessage());
			return ['success' => true, 'message' => 'Something went wrong! Failed to submit ticket report.'];

		}
	}

}