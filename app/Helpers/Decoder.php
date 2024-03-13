<?php

namespace App\Helpers;

use Vinkla\Hashids\Facades\Hashids;

class Decoder {
	public static final function decodeIds(String $id): int {
		$decodedIds = Hashids::decode($id);
		return $decodedIds[0];
	}
}