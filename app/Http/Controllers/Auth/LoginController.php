<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\Auth\InvalidRecaptchaException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Services\Auth\RecaptchaService;
use App\Services\UserService;
use Illuminate\Http\Request;

class LoginController extends Controller {
	public function __construct(RecaptchaService $recaptchaService,
		UserService $userService) {
		$this->recaptchaService = $recaptchaService;
		$this->userService = $userService;
	}

	// Show login form
	public function create(Request $request) {
		return view('auth.login');
	}

	// Validate login request
	public function store(UserLoginRequest $loginRequest) {
		try {
			//verify the recaptcha
			$this->recaptchaService->verify($loginRequest->input('g-recaptcha-response'));
			//validate the user credentials against database
			$user = $loginRequest->only('email', 'password');
			$validationResult = $this->userService->login($user, $loginRequest);
			//return the server response to client
			return response()->json($validationResult);
		} catch (InvalidRecaptchaException $recaptchaException) {
			return response()->json(['success' => false, 'message' => $recaptchaException->getMessage()]);
		}
	}

	protected $userService;
	protected $recaptchaService;
}
