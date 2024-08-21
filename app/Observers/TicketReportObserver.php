<?php

namespace App\Observers;

use App\Models\TicketReport;
use Illuminate\Support\Facades\Cache;

class TicketReportObserver {
	/**
	 * Handle the TicketReport "created" event.
	 */
	public function created(TicketReport $ticketReport): void {
		$this->forgetTicketReportCache($ticketReport);
	}

	/**
	 * Handle the TicketReport "updated" event.
	 */
	public function updated(TicketReport $ticketReport): void {
		$this->forgetTicketReportCache($ticketReport);
	}

	/**
	 * Handle the TicketReport "deleted" event.
	 */
	public function deleted(TicketReport $ticketReport): void {
		$this->forgetTicketReportCache($ticketReport);
	}

	protected function forgetTicketReportCache(TicketReport $ticketReport): void {
		Cache::forget('ticketReportMore:' . $ticketReport->app_version_id);
		Cache::forget('ticketReportCount:' . $ticketReport->app_version_id);
		Cache::forget('ticketReportStatus:' . $ticketReport->status);
		Cache::forget('ticketReportSearch:');
	}
}
