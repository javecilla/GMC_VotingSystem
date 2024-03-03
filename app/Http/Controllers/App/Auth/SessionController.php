<?php

namespace App\Http\Controllers\App\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\SessionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SessionController extends Controller {
	public function __construct(protected SessionService $sessionService) {
	}

	public function check(Request $request): JsonResponse {
		$checkingResult = $this->sessionService->forget($request);
		return response()->json($checkingResult);
	}

}
