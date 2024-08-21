"use-strict";

// APP_VERSION & CSRF_TOKEN (variable)-> wp-content/admin/themes/scripts/main.js

const logoutUser = (uid) => {
  $.ajax({
    url: `/${APP_VERSION}/logout/user`,
    method: 'post',
    data: { 'uid': uid },
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
    success: (response) => {
      window.location.href=response.redirect;
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

const checkUserSession = () => {
  $.ajax({
    url: `/${APP_VERSION}/check/user/session`,
    method: 'post',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
    success: (response) => {
      console.log(response.message);
      if (!response.active) {
        Swal.fire({
          title: "Session Timeout",
          html: "For security reasons, system automatically logging you out due to inactivity. Please log in again to continue accessing your account.",
          showConfirmButton: false,
        });
        //automaticall logout the user after 9s
        setTimeout(() => {
          window.location.href = response.redirect;
        }, 9000);
      }
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};