<?php

namespace App\Http\Requests\App\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest {

	public function authorize(): bool {
		return true;
	}

	public function rules(): array {
		return [
			'email' => 'required|email',
			'password' => 'required',
			'g-recaptcha-response' => 'required',
		];
	}

	public function messages() {
		return [
			'email.required' => 'Email is required! Please enter your email.',
			'password.required' => 'Password is required! Please enter your password.',
			'g-recaptcha-response.required' => 'Please checked the recaptcha checkbox.',
		];
	}
}
