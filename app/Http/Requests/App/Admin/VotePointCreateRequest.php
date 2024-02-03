<?php

namespace App\Http\Requests\App\Admin;

use Illuminate\Foundation\Http\FormRequest;

class VotePointCreateRequest extends FormRequest {

	public function authorize(): bool {
		return true;
	}

	public function rules(): array {
		return [
			'app_version_id' => 'required',
			'amount' => 'required',
			'point' => 'required',
		];
	}
}
