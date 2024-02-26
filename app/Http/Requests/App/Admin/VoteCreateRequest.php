<?php

namespace App\Http\Requests\App\Admin;

use App\Models\AppVersion;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VoteCreateRequest extends FormRequest {

	public function authorize(): bool {
		return true;
	}

	public function rules(): array {
		return [
			'app_version_name' => 'required',
			'candidate_id' => 'required',
			'vote_points_id' => 'required',
			'contact_no' => 'required',
			'email' => 'required',
			'referrence_no' => [
				'required',
				Rule::unique('votes')->where(function ($query) {
					$appVersion = AppVersion::where('name', $this->app_version_name)->first();
					return $query->where('app_version_id', $appVersion->avid)
						->where('referrence_no', $this->referrence_no);
				}),
			],
		];
	}
}