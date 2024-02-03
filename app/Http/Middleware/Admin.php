<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin {

	public function handle(Request $request, Closure $next): Response {
		//check if sending request is an admin or not
		if (!auth()->check() || !auth()->user()->is_admin) {
			abort(403);
		}
		return $next($request);
	}
}
