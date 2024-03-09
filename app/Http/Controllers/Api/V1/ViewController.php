<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\ViewService;

class ViewController extends Controller {
	public function __construct(protected ViewService $service) {}

	public function count(String $appVersionName) {
		try {
			return $this->service->getPageViews($appVersionName);
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, $e->getMessage()]);
		} catch (\Throwable $e) {
			return response()->json(['success' => false, $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured. Code[VID-D]']);
		}
	}
}
