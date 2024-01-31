<?php

namespace App\Http\Controllers\App\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfigurationController extends Controller {
	public function index(Request $request) {
		return view('admin.configuration.index');
	}
}
