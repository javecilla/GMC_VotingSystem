<?php

namespace App\Repositories;

use App\Interfaces\IRepository;
use App\Models\AppVersion;
use App\Models\Campus;

/**
 *
 */
class CampusRepository implements IRepository {

	public function getAll(String $appVersionName = ""): object {
		$appVersion = AppVersion::where('name', $appVersionName)->first();
		if ($appVersion) {
			return Campus::where('app_version_id', $appVersion->avid)->get();
		} else {
			return Campus::all();
		}
	}

	public function getOne(int $id): object {}
	public function create(array $attributes): array {}
	public function update(array $attributes): array {}
	public function delete(int $id): array {}
}