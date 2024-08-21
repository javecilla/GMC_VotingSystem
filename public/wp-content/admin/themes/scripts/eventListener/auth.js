(function($) {
	"use-strict";

	$(document).on('click', '#logoutButton', function() {
		const appVersion = $(this).data('version');
		const userId = $(this).data('uid');
		const csrfToken = $(this).data('csrf');
		logoutUser(userId);
	});

})(jQuery)