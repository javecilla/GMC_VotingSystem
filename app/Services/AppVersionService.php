<?php

namespace App\Services;

use App\Models\AppVersion;

class AppVersionService {
	public function getAll(String $version) {
		$appVersion = AppVersion::all();
		return $appVersion;
	}

	private $data = [];
}