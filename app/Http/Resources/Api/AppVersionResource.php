<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Vinkla\Hashids\Facades\Hashids;

class AppVersionResource extends JsonResource {
	public function toArray(Request $request): array {
		return [
			'avid' => Hashids::encode($this->avid),
			'name' => $this->name,
			'title' => $this->title,
			'created_at' => $this->created_at->format('F d, Y - h:i A'),
			'updated_at' => $this->updated_at != null ? $this->updated_at->format('F d, Y - h:i A') : 'No changes occured.',
		];
	}
}
