<?php

namespace App\Http\Resources\App;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Vinkla\Hashids\Facades\Hashids;

class TicketReportResource extends JsonResource {
	public function toArray(Request $request): array {
		return [
			'trid' => Hashids::encode($this->trid),
			'app_version_id' => $this->app_version_id,
			'name' => $this->name,
			'email' => $this->email,
			'message' => $this->message,
			'message_ellipsis' => Str::limit($this->message, 70),
			'image' => $this->image != null ? '/storage/' . $this->image : '/wp-content/admin/uploads/reports_default.PNG',
			'status' => $this->status,
			'status_name' => $this->status == 0 ? 'Fixed' : 'Pending',
			'created_at' => $this->created_at->format('F d, Y - h:i A'), //March 10, 2024 - 04:40 PM
			'updated_at' => $this->updated_at != null ? $this->updated_at->format('F d, Y - h:i A') : 'No changes occured.',
			//data for relation
			'appVersion' => $this->appVersion,
		];
	}
}
