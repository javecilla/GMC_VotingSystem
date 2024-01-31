<?php

namespace App\Http\Controllers\App\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CandidatesController extends Controller {
	public function index(Request $request) {
		return view('admin.candidates.index');
	}

	public function create(Request $request) {
		return view('admin.candidates.create');
	}
}
