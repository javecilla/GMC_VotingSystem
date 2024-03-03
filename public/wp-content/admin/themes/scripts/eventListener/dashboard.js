$(document).ready(function() {
	"use-strict";

	$(window).on('load', function() {
		setTimeout(function() {
			getRecentlyVoters(5, 0);
			loadMoreReportsRecord(2, 0);
		}, 1500);

		setTimeout(function() {
			getMostVotesCandidates(5);
			getPageViewsPerDay(7);
		}, 1000);

		setTimeout(function() {
			getPendingVerifiedTotalAmount();
			getTotalNotFixedTicketReports();
		}, 500);
	});
});