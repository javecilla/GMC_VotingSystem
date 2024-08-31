<?php

namespace App\Http\Controllers\App\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VotesController extends Controller {

	public function index(Request $request) {
		return view('admin.votes.index');
	}

	public function summary(Request $request) {
		return view('admin.votes.summary');
	}
}
