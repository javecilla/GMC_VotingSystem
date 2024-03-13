<?php

namespace App\Http\Controllers\App\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Auth\UserLogoutRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class LogoutController extends Controller {
	public function __construct(protected UserService $userService) {}

	public function destroy(UserLogoutRequest $request): JsonResponse {
		$this->userService->logout($request);
		return Response::json(['success' => true, 'redirect' => route('login.create')]);
	}
}
