$(document).ready(function() {
	"use-strict";

	$(window).on('load', function() {
		getOverallCandidatesRanking(5);
		getCandidatesRankingByCategory(3);
	});
});