<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketReportReplyMail extends Mailable {
	use Queueable, SerializesModels;

	public $data;
	public $appName;

	/**
	 * Create a new message instance.
	 */
	public function __construct(array $data) {
		$this->data = $data;
		$this->appName = 'Online Voting System ' . env('APP_VERSION') . ' - Golden Minds Colleges';
	}

	/**
	 * Get the message envelope.
	 */
	public function envelope(): Envelope {
		$subject = '<no-reply>' . $this->appName;
		return new Envelope(
			from: new Address(env('MAIL_FROM_ADDRESS'), $this->appName),
			subject: $subject,

		);
	}

	/**
	 * Get the message content definition.
	 */
	public function content(): Content {
		return new Content(
			markdown: 'mails.reply.report'
		);
	}

	/**
	 * Get the attachments for the message.
	 *
	 * @return array<int, \Illuminate\Mail\Mailables\Attachment>
	 */
	public function attachments(): array {
		return [];
	}
}
