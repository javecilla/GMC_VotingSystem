<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AppVersionService;

class AppVersionController extends Controller {
	public function __construct(AppVersionService $appVersionService) {
		$this->appVersionService = $appVersionService;
	}

	public function index($appVersion) {
		$data = $this->appVersionService->getAll($appVersion);
		return response()->json($data);
	}

	private $appVersionService;
}
