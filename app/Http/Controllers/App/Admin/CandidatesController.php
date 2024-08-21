<?php

namespace App\Http\Controllers\App\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CandidatesController extends Controller {
	public function index(Request $request) {
		return view('admin.candidates.index');
	}

	public function show(String $appVersion, int $cdid) {
		return view('admin.candidates.show');
	}

	public function create(Request $request) {
		return view('admin.candidates.create');
	}

	public function edit(String $appVersion, int $cdid) {
		return view('admin.candidates.edit');
	}

	public function ranking(Request $request) {
		return view('admin.candidates.ranking');
	}
}
