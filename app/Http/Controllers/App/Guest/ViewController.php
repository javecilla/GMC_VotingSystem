<?php

namespace App\Http\Controllers\App\Guest;

use App\Http\Controllers\Controller;
use App\Models\AppVersion;
use App\Models\View;
use Illuminate\Http\Request;

class ViewController extends Controller {
	public function main(Request $request) {
		$appVersion = AppVersion::where('name', env('APP_VERSION'))->first();
		if ($appVersion) {
			views($appVersion)->record();
		}

		return view('guest.main');
	}

	public function index(Request $request) {
		return view('guest.index');
	}
}
