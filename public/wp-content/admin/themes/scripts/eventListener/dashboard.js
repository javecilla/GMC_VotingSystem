$(document).ready(function() {
	"use-strict";

	$(window).on('load', function() {

		setTimeout(function() {
			getPendingVerifiedTotalAmount();
			getTotalTicketReports();
		}, 1000);

		setTimeout(function() {
			getMostVotesCandidates(5);
			getPageViewsPerDay(7);
		}, 2000);

		setTimeout(function() {
			getRecentlyVoters(5, 0);
			getTicketReports(5, 0);
		}, 3000);
	});
});