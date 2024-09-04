<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\Auth\InvalidLoginException;
use App\Exceptions\Auth\InvalidRecaptchaException;
use App\Http\Controllers\Controller;
use App\Http\Requests\App\Auth\UserLoginRequest;
use App\Services\Auth\RecaptchaService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class UserController extends Controller {

	public function __construct(
		protected RecaptchaService $recaptchaService,
		protected UserService $userService) {
	}

	// Validate login request
	public function store(UserLoginRequest $loginRequest): JsonResponse {
		try {
			\Log::info(print_r($loginRequest->all(), true));
			$this->recaptchaService->verify($loginRequest->validated('g-recaptcha-response'));
			$validationResult = $this->userService->login($loginRequest);

			return Response::json(['success' => true, 'message' => 'Login successfully',
				'redirect' => route('dashboard.index', env('APP_VERSION')),
			]);
		} catch (InvalidRecaptchaException $recaptchaException) {
			return Response::json(['success' => false, 'message' => $recaptchaException->getMessage()]);
		} catch (InvalidLoginException $loginException) {
			return Response::json(['success' => false, 'message' => $loginException->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'Something went wrong! Please try again.']);
		}
	}

}
