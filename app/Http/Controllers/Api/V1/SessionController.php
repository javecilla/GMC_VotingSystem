<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Auth\SessionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SessionController extends Controller {
	public function __construct(protected SessionService $sessionService) {}

	// Delete login Attemp Session
	public function destroy(Request $request, $appVersionName, $sessionName): JsonResponse {
		$this->sessionService->remove($sessionName, $request);
		return Response::json(['success' => true, 'message' => 'Session Deleted']);
	}
}
