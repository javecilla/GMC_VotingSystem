(($) => {
	"use-strict";

	const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

	$(document).on('click', '#logoutButton', function(e) {
		e.preventDefault();
		
		$.post({
			url: "/api/logout/user",
			data: { 'uid': $(this).data('uid') },
			headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
			success: (response) => {
				window.location.href=response.redirect;
			},
			error: (xhr, status, error) => {
				console.log(xhr.responseText);
			}
		});
	});
})(jQuery)