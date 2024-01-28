<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller {
	public function main(Request $request) {
		return view('guest.main');
	}

	public function index(Request $request) {
		return view('guest.index');
	}
}
