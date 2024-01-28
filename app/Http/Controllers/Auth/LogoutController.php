<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class LogoutController extends Controller {

	public function __construct(UserService $userService) {
		$this->userService = $userService;
	}

	public function destroy(Request $request) {
		auth()->logout(); //logout
		$request->session()->invalidate();
		$request->session()->regenerateToken();
		return response()->json(['success' => true, 'redirect' => route('login.create')]);
	}

	protected $userService;
}
