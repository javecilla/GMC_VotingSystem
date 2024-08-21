<?php

namespace App\Services;

use App\Exceptions\App\Admin\SendMailException;
use App\Mail\TicketReportReplyMail;
use Illuminate\Support\Facades\Mail;

class EmailService {
	public function sendTicketReportReplyMessage(array $data) {
		$mail = Mail::to($data['toEmail'])->send(new TicketReportReplyMail($data));
		if (!$mail) {
			throw new SendMailException('Failed to send reply email.', 422);
		}

		return;
	}
}