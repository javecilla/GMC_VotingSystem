<?php

namespace App\Http\Controllers\App\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppVersionController extends Controller {
	public function show(Request $request) {
		return view('admin.configuration.show');
	}
}
