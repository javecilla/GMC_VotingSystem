<?php

namespace App\Services;

use App\Repositories\TicketReportRepository;

// use App\Exceptions\App\Admin\CreateDataException;
// use App\Exceptions\App\Admin\DeleteDataException;
// use App\Exceptions\App\Admin\UpdateDataException;
// use Illuminate\Database\Eloquent\ModelNotFoundException;
// use Illuminate\Support\Arr;

class TicketReportService {
	public function __construct(protected TicketReportRepository $repository) {}

	public function loadMoreReports(String $appVersion, int $limit, int $offset): object {
		return $this->repository->loadMoreData($appVersion, $limit, $offset);
	}

	public function countAllTicketReportsByStatus(String $appVersion): array {
		return $this->repository->count($appVersion);
	}

}