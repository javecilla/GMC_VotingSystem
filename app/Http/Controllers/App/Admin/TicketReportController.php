<?php

namespace App\Http\Controllers\App\Admin;

use App\Http\Controllers\Controller;
use App\Services\TicketReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TicketReportController extends Controller {
	public function __construct(protected TicketReportService $service) {}

	public function index(Request $request) {
		return view('admin.reports.index');
	}

	public function loadMoreData(String $appVersion, int $limit, int $offset): JsonResponse {
		$result = $this->service->loadMoreReports($appVersion, $limit, $offset);
		return response()->json($result);
	}

	public function counts(String $appVersion): JsonResponse {
		$result = $this->service->countAllTicketReportsByStatus($appVersion);
		return response()->json($result);
	}
}
