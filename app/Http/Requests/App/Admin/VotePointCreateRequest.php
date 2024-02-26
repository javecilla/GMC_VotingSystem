<?php

namespace App\Http\Requests\App\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VotePointCreateRequest extends FormRequest {

	public function authorize(): bool {
		return true;
	}

	public function rules(): array {
		return [
			'app_version_id' => 'required',
			'amount' => [
				'required',
				// this check if the amount s is already exist in database 'vote_points'
				// for particular app version id then it will not accept
				Rule::unique('vote_points')->where(function ($query) {
					return $query->where('app_version_id', $this->app_version_id)
						->where('amount', $this->amount);
				}),
			],
			'point' => [
				'required',
				Rule::unique('vote_points')->where(function ($query) {
					return $query->where('app_version_id', $this->app_version_id)
						->where('point', $this->point);
				}),
			],
			'image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
		];
	}

	public function messages(): array {
		return [
			'amount.unique' => 'Cannot create vote points because this amount is already exist',
			'point.unique' => 'Cannot create vote amount because this points is already exist',
		];
	}
}
