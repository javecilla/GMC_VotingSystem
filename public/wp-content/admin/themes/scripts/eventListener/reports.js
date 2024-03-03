(function($) {
	"use-strict";

	$(window).on('load', function() {
		window.history.replaceState(null, null, REPORTS_INDEX_URI);
		loadMoreReportsRecord(5, 0);
	});

	let offset = 0;
	let page = 1;
	let limit = 5;
	$(document).on('click', '#nextPaginateBtn', function() {
		offset += limit; 
		page += 1;

		loadMoreReportsRecord(limit, offset);
		writeURI('page', page);
	});

	$(document).on('click', '#prevPaginateBtn', function() {
		offset -= limit; 
		page -= 1;

		loadMoreReportsRecord(limit, offset);
		writeURI('page', page);
	});
})(jQuery)