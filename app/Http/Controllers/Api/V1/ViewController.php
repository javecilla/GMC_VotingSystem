<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\ViewService;
use Illuminate\Support\Facades\Response;

class ViewController extends Controller {
	public function __construct(protected ViewService $service) {}

	public function count(string $appVersionName) {
		try {
			$views = $this->service->getPageViews($appVersionName);

			return Response::json(['success' => true, 'message' => 'Tested',
				'totalPageViews' => $views]);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, $e->getMessage()]);
		} catch (\Throwable $e) {
			return Response::json(['success' => false, $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured. Code[VID-D]']);
		}
	}
}
