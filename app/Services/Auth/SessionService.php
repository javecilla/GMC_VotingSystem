<?php

namespace App\Services\Auth;

class SessionService {
	public function remove($sessionName, $request): array {
		$request->session()->forget($sessionName);
		return ['success' => true, 'message' => 'Session Deleted'];
	}
}