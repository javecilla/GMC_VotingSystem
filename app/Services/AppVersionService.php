<?php

namespace App\Services;

use App\Exceptions\App\Admin\UpdateVersionException;
use App\Models\AppVersion;
use Illuminate\Support\Facades\DB;

class AppVersionService {

	// Get all the application version data by its [versionName]
	public function getAll(String $version): object {
		return AppVersion::where('name', $version)->orderBy('created_at', 'desc')->get();
	}

	// Update version by its id
	public function updateById(array $data): array {
		$appVersion = AppVersion::findOrFail($data['avid']);
		return DB::transaction(function () use ($appVersion, $data) {
			$appVersion->fill($data);
			$result = $appVersion->save();
			if (!$result) {
				throw new UpdateVersionException('Something went wrong! Failed to update version');
			}
			return ['success' => true, 'message' => 'App version updated successfully.'];
		});
	}

}