(($) => {
	"use-strict";

	updateTime('#time'); // Update time on page load

  // Update time every second at @Top Navigation Bar
  setInterval(function() {
    updateTime('#time');
  }, 1000);

  // toastr config style
	toastr.options = {
		"debug": false,
		"rtl": false,
		"newestOnTop": false,
		"preventDuplicates": false,
		"progressBar": true,
		"showDuration": "500",
	  "hideDuration": "2500",
		"timeOut": 5000,
		"extendedTimeOut": 0,
		"closeButton": true,
		"closeMethod": 'fadeOut',
		"closeEasing": 'swing',
		"hideEasing": "linear",
		"showMethod": "fadeIn",
	  "hideMethod": "fadeOut",
		"positionClass": 'toast-bottom-right',
	};

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