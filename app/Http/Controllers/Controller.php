<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController {
	use AuthorizesRequests, ValidatesRequests;
	/**
	 * @OA\Info(
	 * 	title="Swagger with Laravel",
	 * 	version="1.0.0",
	 * )
	 * @OA\SecurityScheme(
	 * 	type="http",
	 * 	securityScheme="brearerAuth"
	 * 	scheme="brearer",
	 * 	brearerFormat="JWT",
	 * )
	 */
}
