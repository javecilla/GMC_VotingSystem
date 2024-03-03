<?php

namespace App\Http\Controllers\App\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TicketReportController extends Controller {
	public function index(Request $request) {
		return view('admin.reports.index');
	}
}
