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
})(jQuery)