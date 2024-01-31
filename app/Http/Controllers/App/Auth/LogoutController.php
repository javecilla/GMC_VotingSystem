<?php

namespace App\Http\Controllers\App\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Auth\UserLogoutRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class LogoutController extends Controller {
	public function __construct(protected UserService $userService
	) {
	}

	public function destroy(UserLogoutRequest $request): JsonResponse {
		$result = $this->userService->logout($request);
		return response()->json($result);
	}
}
