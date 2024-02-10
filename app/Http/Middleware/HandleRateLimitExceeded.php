<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class HandleRateLimitExceeded {
	public function handle(Request $request, Closure $next) {
		$response = $next($request);

		if ($response->status() === 429 && $request->route()->name('login.validate')) {
			abort(429);
		}

		return $response;
	}
}
