<?php

namespace App\Http\Controllers\App\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller {
	// Show login form
	public function create(Request $request) {
		return view('auth.login');
	}

}
