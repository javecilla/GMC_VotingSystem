<?php

namespace App\Services\Auth;

class SessionService {
	public function remove($sessionName, $request): array {
		$request->session()->forget($sessionName);
		return ['success' => true, 'message' => 'Session Deleted'];
	}

	public function forget($request): array {
		$lastActivity = $request->session()->get('last_activity');
		$inactiveDuration = 5000; // 600 seconds (10 minute) of inactivity

		if ($lastActivity && now()->diffInSeconds($lastActivity) > $inactiveDuration) {
			auth()->logout();
			$request->session()->invalidate();
			$request->session()->regenerateToken();
			return ['active' => false, 'message' => 'inactive.', 'redirect' => route('login.create')];
		}

		return ['active' => true, 'message' => 'active.'];
	}
}