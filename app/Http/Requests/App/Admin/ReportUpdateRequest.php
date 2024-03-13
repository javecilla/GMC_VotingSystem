<?php

namespace App\Http\Requests\App\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ReportUpdateRequest extends FormRequest {

	public function authorize(): bool {
		return true;
	}

	public function rules(): array {
		return [
			'trid' => 'required',
			'fromEmail' => 'required',
			'toEmail' => 'required',
			'name' => 'required',
			'replyMessage' => 'required',
		];
	}
}
