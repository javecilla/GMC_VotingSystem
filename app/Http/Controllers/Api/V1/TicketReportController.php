<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ReportCreateRequest;
use App\Services\Auth\RecaptchaService;
use App\Services\TicketReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\ModelNotFoundException;

class TicketReportController extends Controller {
	public function __construct(protected TicketReportService $ticketReportService,
		protected RecaptchaService $recaptchaService) {}

	public function getRecordsLimit(String $appVersionName, int $limit, int $offset) {
		try {
			return $this->ticketReportService->loadMoreReports($appVersionName, $limit, $offset);
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured. Code[TRID]']);
		}
	}

	public function countNotFixReport(String $appVersionName): JsonResponse {
		try {
			return $this->ticketReportService->countAllTicketReportsByStatus($appVersionName);
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured. Code[TRID]']);
		}
	}

	public function store(ReportCreateRequest $request): JsonResponse {
		try {
			$this->recaptchaService->verify($request->validated('g_recaptcha_response'));
			return $this->ticketReportService->createNewTicketReport($request->validated());
		} catch (InvalidRecaptchaException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured during submision reports. Code[TRID]']);
		}
	}
}