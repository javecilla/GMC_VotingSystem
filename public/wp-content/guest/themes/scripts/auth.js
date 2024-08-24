(($) => {
	"use-strict";

	$(window).on('load', function() {
    //check if recaptcha is ready then enable login button, otherwise disable it
    if(grecaptcha) {
      enableButton('#loginButton');
      $('#loginButtonContent').html(`
				Login <i class="fa-solid fa-right-to-bracket arrow-icon"></i>
				<i class="fas fa-spinner fa-spin loading-spinner" style="display: none;"></i>
      `);

      //auto focus in input username when login page load or reload
      $('#uid').val('').focus();
      $('#password').val('');
    } else {
      disabledButton('#loginButton');
    }
  });

	$('#password').on('input', function(e) {
    if(e.originalEvent.inputType === 'deleteContentBackward') {
      $(this).val('');
    }
  });

  $(document).on('keydown', function(e) {
    if(e.keyCode == 123) {
      return false;
    }
    if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
      return false;
    }
    if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
      return false;
    }
    if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
      return false;
    }
    if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)){
      return false;
    }
  });

  const deleteSession = (sessionName) => {
    $.ajax({
      url: `${$('meta[name="identifier-URL"]').attr('content')}/api/session/${sessionName}/delete`,
      method: 'DELETE',
      dataType: 'JSON',
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      success: function(response) {
        console.info(response.message);
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
      }
    });
  };

  const startCountDown = () => {
    let remainingTime = 60;
    disabledButton('#loginButton'); //disabled the login button initially
    $('#uid').val('').removeClass('is-invalid').attr('readonly', true);
    $('#password').val('').attr('readonly', true);
    $('#notice').text("Due to the repeated many login attempts and other suspicious activties, login for your account is temporily disabled.").removeClass('text-muted').addClass('text-danger');
    $('.g-recaptcha-widgets').addClass('d-none');
    $('#g-recaptcha-response').val('');
    $('.arrow-icon').addClass('d-none');
    $('.loading-spinner').addClass('d-none');
    $('#loginButton').attr('disabled', true);
    $('#loginButtonContent').html('<span>Please wait 60 seconds to login again.</span>');


    countdownTimer = setInterval(() => {
      remainingTime--; //decrement remaining time
      //check remaining time if reach 0 then enable the login button again
      if(remainingTime <= 0) {
        clearInterval(countdownTimer);
        deleteSession('loginAttempts'); //delete the session
        enableButton('#loginButton');

      } else {
        //set real time count timer to front end
        disabledButton('#loginButton');
        $('#loginButtonContent').html(`<span>Please wait ${remainingTime} seconds to login again.</span>`);
      }
    }, 1000); //1s
  };

  $(document).on('submit', '#authForm', function(e) {
    e.preventDefault();
    runSpinner();
    disabledButton('#loginButton');

    const email = $('#uid').val();
    const password = $('#password').val();
    const grecaptchaValue = $('#g-recaptcha-response').val();
    let grecaptchaResponse = grecaptcha.getResponse();

    if(isEmpty(email) || isEmpty(password)) {
      toastr.warning("All fields is required!");
      stopSpinner();
      enableButton('#loginButton');
      return;
    }

    if(!isValidEmail(email)) {
      toastr.warning("Invalid UID!");
      stopSpinner();
      enableButton('#loginButton');
      return;
    }

    if(isEmpty(grecaptchaValue)) {
      toastr.warning("Please complete the reCAPTCHA!");
      stopSpinner();
      enableButton('#loginButton');
      return;
    }

    $.ajax({
      url: `${$('meta[name="identifier-URL"]').attr('content')}/api/validate/user`,
      method: 'POST',
      data: {
        'email': email,
        'password': password,
        'g-recaptcha-response': grecaptchaValue
      },
      dataType: 'JSON',
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      success: function(response) {
        if(response.success) {
          window.location.href=response.redirect;
        } else {
          if(response.message === "gay") {
            disabledButton('#loginButton');
            startCountDown(); // Start the countdown timer
            toastr.error("You have reached the maximum login attempts");
          } else {
            toastr.error(response.message);
          }
          $('#uid').addClass('is-invalid').focus();
          $('#password').val("");
        }

        stopSpinner();
        enableButton('#loginButton');
        resetCaptcha();
      },
      error: function(xhr, status, error) {
        if(xhr.status === 429) {
          window.location.href='/e4292024';
        } else {
          const response = JSON.parse(xhr.responseText);
          toastr.error(response.message);
        }

        stopSpinner();
        enableButton('#loginButton');
        resetCaptcha();
      }
    });
  });



})(jQuery)