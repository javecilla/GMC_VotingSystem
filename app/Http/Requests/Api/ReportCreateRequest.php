<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ReportCreateRequest extends FormRequest {

	public function authorize(): bool {
		return true;
	}

	public function rules(): array {
		return [
			'app_version_name' => 'required',
			'name' => 'required',
			'email' => 'required',
			'message' => 'required',
			'image' => '',
			'g_recaptcha_response' => 'required',
		];
	}
}
