<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Exceptions\Auth\InvalidLoginException;
use App\Exceptions\Auth\InvalidRecaptchaException;
use App\Http\Controllers\Controller;
use App\Http\Requests\App\Auth\UserLoginRequest;
use App\Services\Auth\RecaptchaService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller {

	public function __construct(
		protected RecaptchaService $recaptchaService,
		protected UserService $userService) {
	}

	// Validate login request
	public function store(UserLoginRequest $loginRequest): JsonResponse {
		//\Illuminate\Support\Facades\Log::info($loginRequest->all());
		try {
			$this->recaptchaService->verify($loginRequest->validated('g-recaptcha-response'));
			$validationResult = $this->userService->login($loginRequest);

			return response()->json($validationResult);
		} catch (InvalidRecaptchaException $recaptchaException) {
			return response()->json(['success' => false, 'message' => $recaptchaException->getMessage()]);
		} catch (InvalidLoginException $loginException) {
			return response()->json(['success' => false, 'message' => $loginException->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'Something went wrong! Please try again.']);
		}
	}

}
