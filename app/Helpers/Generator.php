<?php

namespace App\Helpers;

class Generator {

	public static function generateReferrenceNumber() {
		$referrenceNumber = '';
		for ($i = 0; $i < 9; $i++) {
			$referrenceNumber .= mt_rand(0, 9);
		}

		return $referrenceNumber . '0000';
	}

	public static function generatePhoneNumber() {
		$phoneNumber = ''; //09 772465533
		for ($i = 0; $i < 9; $i++) {
			$phoneNumber .= mt_rand(0, 9);
		}

		return '09' . $phoneNumber;
	}
}