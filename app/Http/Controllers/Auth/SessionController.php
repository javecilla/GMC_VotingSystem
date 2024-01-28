<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\SessionService;
use Illuminate\Http\Request;

class SessionController extends Controller {
	public function __construct(SessionService $sessionService) {
		$this->sessionService = $sessionService;
	}

	// Delete login Attemp Session
	public function destroy(Request $request, $sessionName) {
		$validationResult = $this->sessionService->remove($sessionName, $request);
		return response()->json($validationResult);
	}

	protected $sessionService;
}
