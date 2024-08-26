<?php

namespace App\Services;

use App\Exceptions\Auth\InvalidLoginException;

class UserService {
	const MAX_LOGIN_ATTEMPTS = 3; //set the maximum login attempts

	public function login($request) {
		$user = $request->only('email', 'password');
		//then check if there is a login attemp in sesion counter
		$loginAttempts = $request->session()->get('loginAttempts', 0);
		//check if this user attempting to login is valid or not
		if (auth()->attempt($user)) {
			$loggedInUser = auth()->user();
			//if valid then, reset the login attempt session upon successful
			$request->session()->forget('loginAttempts');
			//create new session for user currently loggedin
			$request->session()->regenerate();
			//upon login successfull, track the last activity time
			$request->session()->put('last_activity', now());

			return;
		} else {
			$loginAttempts++; //increment attemp if login is failed
			$request->session()->put('loginAttempts', $loginAttempts);
			//then check if login attempt is reach the maximum login attempt
			if ($loginAttempts >= self::MAX_LOGIN_ATTEMPTS) {
				throw new InvalidLoginException('i');
			} else {
				throw new InvalidLoginException('Invalid Credentials.');
			}
		}
	}

	public function logout($request) {
		auth()->logout(); //logout
		$request->session()->invalidate();
		$request->session()->regenerateToken();
		return;
	}
}