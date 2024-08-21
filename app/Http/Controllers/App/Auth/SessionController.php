<?php

namespace App\Http\Controllers\App\Auth;

use App\Exceptions\App\Admin\InvalidSessionException;
use App\Http\Controllers\Controller;
use App\Services\Auth\SessionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SessionController extends Controller {
	public function __construct(protected SessionService $sessionService) {}

	public function check(Request $request): JsonResponse {
		try {
			$this->sessionService->forget($request);

			return Response::json(['active' => true, 'message' => 'active.']);
		} catch (InvalidSessionException $e) {
			return Response::json(['active' => false, 'message' => 'inactive.', 'redirect' => route('login.create')]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured. Code [SID]']);
		}
	}
}
