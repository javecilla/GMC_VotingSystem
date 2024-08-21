<?php

namespace App\Observers;

use App\Models\AppVersion;
use Illuminate\Support\Facades\Cache;

class AppVersionObserver {
	/**
	 * Handle the AppVersion "created" event.
	 */
	public function created(AppVersion $appVersion): void {
		Cache::forget('appVersions');
	}

	/**
	 * Handle the AppVersion "updated" event.
	 */
	public function updated(AppVersion $appVersion): void {
		Cache::forget('appVersions');
	}

	/**
	 * Handle the AppVersion "deleted" event.
	 */
	public function deleted(AppVersion $appVersion): void {
		Cache::forget('appVersions');
	}

	/**
	 * Handle the AppVersion "restored" event.
	 */
	public function restored(AppVersion $appVersion): void {
		//
	}

	/**
	 * Handle the AppVersion "force deleted" event.
	 */
	public function forceDeleted(AppVersion $appVersion): void {
		//
	}
}
