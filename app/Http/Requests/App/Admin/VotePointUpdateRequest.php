<?php

namespace App\Http\Requests\App\Admin;

use Illuminate\Foundation\Http\FormRequest;

class VotePointUpdateRequest extends FormRequest {

	public function authorize(): bool {
		return true;
	}

	public function rules(): array {
		return [
			'vpid' => 'required',
			'app_version_id' => 'required',
			'amount' => 'required',
			'point' => 'required',
			'image' => '',
		];
	}
}
