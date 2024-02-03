<?php

namespace App\Http\Middleware;

use App\Models\AppVersion;
use Closure;
use Illuminate\Http\Request;

//use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ValidateAppVersion {
	public function handle(Request $request, Closure $next) {
		$version = $request->route('version');

		// Check if the version exists in the AppVersion model
		if (!AppVersion::where('name', $version)->exists()) {
			// throw new NotFoundHttpException('Version not found');
			abort(404);
		}

		return $next($request);
	}
}
