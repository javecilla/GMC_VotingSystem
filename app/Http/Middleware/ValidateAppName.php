<?php

namespace App\Http\Middleware;

use App\Models\AppVersion;
use Closure;
use Illuminate\Http\Request;

//use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ValidateAppName {
	public function handle(Request $request, Closure $next) {
		$votingTitle = $request->route('title');

		// Check if the version exists in the AppVersion model
		if (!AppVersion::where('title', $votingTitle)->exists()) {
			// throw new NotFoundHttpException('Version not found');
			abort(404);
		}

		return $next($request);
	}
}
