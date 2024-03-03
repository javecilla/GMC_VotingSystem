<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ReportCreateRequest;
use App\Services\Auth\RecaptchaService;
use App\Services\TicketReportService;
use Illuminate\Http\JsonResponse;

class TicketReportController extends Controller {
	public function __construct(protected TicketReportService $ticketReportService,
		protected RecaptchaService $recaptchaService) {}

	public function getRecordsLimit(String $appVersion, int $limit, int $offset): JsonResponse {
		$result = $this->ticketReportService->loadMoreReports($appVersion, $limit, $offset);
		return response()->json($result);
	}

	public function countNotFixReport(String $appVersion): JsonResponse {
		$result = $this->ticketReportService->countAllTicketReportsByStatus($appVersion);
		return response()->json($result);
	}

	public function store(ReportCreateRequest $request): JsonResponse {
		try {
			$this->recaptchaService->verify($request->validated('g_recaptcha_response'));
			$result = $this->ticketReportService->createNewTicketReport($request->validated());

			return response()->json($result);
		} catch (InvalidRecaptchaException $recaptchaException) {
			return response()->json(['success' => false, 'message' =>
				$recaptchaException->getMessage()]);
		}
	}
}