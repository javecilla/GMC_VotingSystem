(($) => {
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

	//tool tip
  const tooltipTriggerList = $('[data-bs-toggle="tooltip"]');
  const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

  // wow animation
  const wow = new WOW({
    boxClass:     'wow',
    animateClass: 'animated',
    offset:       25,
    mobile:       true,
    live:         true
  })

  wow.init();



  
})(jQuery)