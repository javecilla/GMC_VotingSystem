<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\Api\CreateDataException;
use App\Exceptions\App\Admin\SendMailException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ReportCreateRequest;
use App\Http\Requests\App\Admin\ReportUpdateRequest;
use App\Http\Resources\App\TicketReportResource;
use App\Services\Auth\RecaptchaService;
use App\Services\EmailService;
use App\Services\TicketReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\ModelNotFoundException;
use Illuminate\Support\Facades\Response;

class TicketReportController extends Controller {
	public function __construct(
		protected TicketReportService $ticketReportService,
		protected RecaptchaService $recaptchaService,
		protected EmailService $emailService) {}

	public function getRecordsLimit(string $appVersionName, int $limit, int $offset) {
		try {
			$ticketReport = $this->ticketReportService->loadMoreReports($appVersionName, $limit, $offset);

			return TicketReportResource::collection($ticketReport);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured. Code[TRID]']);
		}
	}

	public function getRecordsOne(string $appVersionName, string $ticketReportId) {
		try {
			$ticketReport = $this->ticketReportService->getTicketReportsById($ticketReportId);

			return TicketReportResource::collection($ticketReport);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured. Code[TRID]']);
		}
	}

	public function getRecordsByStatus(string $appVersionName, int $status) {
		try {
			$ticketReport = $this->ticketReportService->getTicketReportsByStatus($appVersionName, $status);

			return TicketReportResource::collection($ticketReport);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured. Code[TRID]']);
		}
	}

	public function getRecordsBySearch(string $appVersionName, string $search) {
		try {
			$ticketReport = $this->ticketReportService->getTicketReportsBySearch($appVersionName, $search);

			return TicketReportResource::collection($ticketReport);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured. Code[TRID]']);
		}
	}

	public function countNotFixReport(string $appVersionName): JsonResponse {
		try {
			$totalReports = $this->ticketReportService->countAllTicketReportsByStatus($appVersionName);

			return Response::json(['success' => true, 'totalReports' => $totalReports]);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured. Code[TRID]']);
		}
	}

	public function store(ReportCreateRequest $request): JsonResponse {
		try {
			$this->recaptchaService->verify($request->validated('g_recaptcha_response'));
			$this->ticketReportService->createNewTicketReport($request->validated());

			return Response::json(['success' => true, 'message' => 'Report submitted successfully.']);
		} catch (InvalidRecaptchaException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (CreateDataException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured during submision reports. Code[TRID]']);
		}
	}

	public function update(ReportUpdateRequest $request): JsonResponse {
		try {
			$this->ticketReportService->updateTicketReport($request->validated());
			$this->emailService->sendTicketReportReplyMessage($request->validated());

			return Response::json(['success' => true, 'message' => 'Ticket updated and emailed successfully.']);
		} catch (SendMailException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (UpdateDataException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured during updation reports. Code[TRID]']);
		}
	}
}
