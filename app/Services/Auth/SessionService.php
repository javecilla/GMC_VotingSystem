<?php

namespace App\Services\Auth;

use App\Exceptions\App\Admin\InvalidSessionException;

class SessionService {
	public function remove($sessionName, $request) {
		return $request->session()->forget($sessionName);
	}

	public function forget($request) {
		$lastActivity = $request->session()->get('last_activity');
		$inactiveDuration = 5000; // 600 seconds (10 minute) of inactivity

		if ($lastActivity && now()->diffInSeconds($lastActivity) > $inactiveDuration) {
			auth()->logout();
			$request->session()->invalidate();
			$request->session()->regenerateToken();
			throw new InvalidSessionException('Inactive session.');
		}

		return;
	}
}