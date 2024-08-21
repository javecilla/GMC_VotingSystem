<?php

namespace App\Services\Auth;

use App\Exceptions\Auth\InvalidRecaptchaException;

class RecaptchaService {
	public function verify($recaptchaResponse) {
		// Google reCAPTCHA verification API request
		$uriAPI = 'https://www.google.com/recaptcha/api/siteverify';
		$curlData = [
			'secret' => env('RECAPTCHA_BACKEND_KEY'),
			'response' => $recaptchaResponse,
			'remoteip' => $_SERVER['REMOTE_ADDR'],
		];

		// Initialize CURL request
		$curlOptConfig = [
			CURLOPT_URL => $uriAPI,
			CURLOPT_POST => true,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POSTFIELDS => $curlData,
			CURLOPT_SSL_VERIFYPEER => false,
		];

		$ch = curl_init();
		curl_setopt_array($ch, $curlOptConfig);
		$curlResponse = curl_exec($ch);
		if (curl_errno($ch)) {
			$errorAPI = curl_error($ch);
		}
		curl_close($ch);

		// Decode JSON data of API response array
		$captchaResponse = json_decode($curlResponse);
		// Check if recaptcha api response is valid
		if (!empty($captchaResponse) && $captchaResponse->success) {
			// success
			return ['success' => true, 'message' => 'Recaptcha validated'];
		} else {
			throw new InvalidRecaptchaException(
				!empty($errorAPI) ? $errorAPI : "Captcha error! Please try again later.", 422
			);
		}
	}
}