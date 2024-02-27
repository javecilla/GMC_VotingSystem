<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ReportCreateRequest;
use App\Services\Auth\RecaptchaService;
use App\Services\TicketReportService;
use Illuminate\Http\JsonResponse;

class TicketReportController extends Controller {
	public function __construct(protected TicketReportService $ticketReportService,
		protected RecaptchaService $recaptchaService, ) {}

	public function store(ReportCreateRequest $request): JsonResponse {
		try {
			$this->recaptchaService->verify($request->validated('g_recaptcha_response'));
			$result = $this->ticketReportService->createNewTicketReport($request->validated());

			return response()->json($result);
		} catch (InvalidRecaptchaException $recaptchaException) {
			return response()->json(['success' => false, 'message' => $recaptchaException->getMessage()]);
		}
	}
}
