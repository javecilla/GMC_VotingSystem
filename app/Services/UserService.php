<?php

namespace App\Services;

class UserService {
	const MAX_LOGIN_ATTEMPTS = 3; //set the maximum login attempts

	public function login($user, $request): array {
		//then check if there is a login attemp in sesion counter
		$loginAttempts = $request->session()->get('loginAttempts', 0);
		//check if this user attempting to login is valid or not
		if (auth()->attempt($user)) {
			//if valid then, reset the login attempt session upon successful
			$request->session()->forget('loginAttempts');
			//create new session for user currently loggedin
			$request->session()->regenerate();
			//return the response
			return ['success' => true,
				'message' => 'Login successfully',
				'redirect' => route('dashboard.index', APP_VERSION),
			];
		} else {
			$loginAttempts++; //increment attemp if login is failed
			$request->session()->put('loginAttempts', $loginAttempts);
			//then check if login attempt is reach the maximum login attempt
			if ($loginAttempts >= self::MAX_LOGIN_ATTEMPTS) {
				return ['success' => false, 'message' => 'gay'];
			} else {
				return ['success' => false, 'message' => 'Invalid Credentials'];
			}
		}
	}

}