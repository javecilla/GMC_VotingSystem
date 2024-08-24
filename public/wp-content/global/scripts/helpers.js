const isEmpty = (field) => {
  return field === "";
};

const updateTime = (targetElement) => {
    $(targetElement).text(new Date().toLocaleTimeString([], { hour12: true }));
  };

// Debounce
const debounce = (func, delay) => {
  let timeoutId;
  return (...args) => {
    if(timeoutId) {
      clearTimeout(timeoutId);
    }
    timeoutId = setTimeout(() => {
      func.apply(this, args);
    }, delay);
  };
}

//#time helper
const calculateHours = (startTime, endTime) => {
  const [startHours, startMinutes] = startTime.split(":").map(Number);
  const [endHours, endMinutes] = endTime.split(":").map(Number);
  const start = new Date(0, 0, 0, startHours, startMinutes, 0);
  const end = new Date(0, 0, 0, endHours, endMinutes, 0);
  const diff = (end - start) / (1000 * 60 * 60); // difference in hours
  return diff;
};

//clock
const updateClock = () => {
  const now = new Date();
  const date = now.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
  const day = now.toLocaleDateString('en-US', { weekday: 'long' });
  const time = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true });
  $('.clock').text(`${date} ( ${day} ) ${time}`);
};

const determineTimeAMorPM = (time) => {
  const [h, m] = time.split(":").map(Number);
  const period = h >= 12 ? 'PM' : 'AM';
  const hour = h % 12 || 12; // Convert hour to 12-hour format and handle the case for 12 PM and 12 AM
  return `${hour}:${m.toString().padStart(2, '0')} ${period}`;
};

const formatDateTime = (dateTimeString) => {
  // Create a Date object from the input string
  const date = new Date(dateTimeString);
  // Define month names
  const monthNames = [
    "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
  ];
  // Extract date components
  const month = monthNames[date.getMonth()];
  const day = date.getDate();
  const year = date.getFullYear();
  // Extract time components
  let hours = date.getHours();
  const minutes = date.getMinutes();
  const ampm = hours >= 12 ? 'PM' : 'AM';
  // Convert to 12-hour format
  hours = hours % 12;
  hours = hours ? hours : 12; // the hour '0' should be '12'
  // Format minutes to have two digits
  const minutesFormatted = minutes < 10 ? '0' + minutes : minutes;
  // Format the final string
  const formattedDateTime = `${month} ${day}, ${year} - ${hours}:${minutesFormatted} ${ampm}`;

  return formattedDateTime;
}

const resetCaptcha = () => {
  grecaptchaResponse = '';
  $('#g-recaptcha-response').val('');
  grecaptcha.reset();
};

const disabledButton = (elementId) => {
  $(elementId).css('cursor', 'no-drop').prop('disabled', true);
};

const enableButton = (elementId) => {
  $(elementId).css('cursor', 'pointer').prop('disabled', false);
};

const runSpinner = () => {
  $('.loading-spinner').show();
  $('.arrow-icon').hide();
};

const stopSpinner = () => {
  $('.loading-spinner').hide();
  $('.arrow-icon').show();
};

const openModal = (modalId) => {
  $(modalId).attr('data-backdrop', 'static').modal('show');
};

const closeModal = (modalId) => {
  $(modalId).modal('hide');
};

const addURLParams = (paramName, paramValue) => {
  //push url param without page reloading
  const url = new URL(window.location);
  url.searchParams.set(paramName, paramValue);
  window.history.pushState({ path: url.href }, '', url.href);
};

const removeURLParams = (paramName) => {
  //remove the search param from the URL
  const url = new URL(window.location);
  url.searchParams.delete(paramName);
  window.history.pushState({ path: url.href }, '', url.href);
};

const generateRandomNumber = (length) => {
  let randomNumber = '';
  for (let i = 0; i < length; i++) {
      randomNumber += Math.floor(Math.random() * 10);
  }
  return randomNumber;
};

const formatReadableDate = (date) => {
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  return new Date(date).toLocaleDateString('en-US', options);
};

const calculateAge = (dateRegistration, birthDay) => {
  const start_date = new Date(birthDay);
  const end_date = new Date(dateRegistration);
  const time_difference = end_date.getTime() - start_date.getTime();
  const days_difference = time_difference / (1000 * 3600 * 24);
  const age = Math.round(days_difference / 365.25);
  return age;
};

const generatePassword = (length = 12) => {
  const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+[]{}|;:,.<>?";
  let password = "";
  for (let i = 0; i < length; i++) {
      const randomIndex = Math.floor(Math.random() * charset.length);
      password += charset[randomIndex];
  }
  return password;
};

const isValidEmail = (email) => {
  // Regex for validating email format
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailPattern.test(email);
};

const isValidContactNo = (contactNo) => {
  const MAX_LENGTH = 11;
  return contactNo.length == MAX_LENGTH;
};

const isValidReferrenceNo = (referrenceNo) => {
  const MAX_LENGTH = 13;
  return referrenceNo.length <= MAX_LENGTH;
};

const writeURI = (paramNames, query) => {
  const currentUrl = window.location.href.split('?')[0];
  const newUrl = currentUrl + (query ? '?'+paramNames+'=' + encodeURIComponent(query) : '');
  return window.history.replaceState(null, null, newUrl);
};

// Function to compact all data stored on local storage
const combineLocalStorageData = () => {
  const allData = {};

  // Iterate through the localStorage keys for steps 1 to 4
  for (let count = 1; count <= 4; count++) {
    const storedData = localStorage.getItem(`step${count}Data`);
    if (storedData) {
      const parsedData = JSON.parse(storedData);
      Object.assign(allData, parsedData);
    }
  }

  return allData;
};

// Functions that track the  form steps
const updateProgressBar = (step) => {
  $('#progressbar li').removeClass('active');
  for (let i = 1; i <= step; i++) {
    $(`#progressbar li:nth-child(${i})`).addClass('active');
  }

  $(`.form-step[data-step="${step}"]`).fadeIn();
  $(`.form-step[data-step]:not([data-step="${step}"])`).hide();
};

// Functions to handle form navigation between steps
const showStep = (step, candidateId) => {
  const mode = $(`.form-step[data-step="${step}"]`).data('mode');
  $('.form-step').hide();
  $(`.form-step[data-step="${step}"]`).show();

  // Update URL without page reload
  const currentUrl = window.location.href.split('?')[0];
  const newUrl = currentUrl + (candidateId ? '?ctid=' + encodeURIComponent(candidateId) + '&step=' + step + '&form_mode=' + mode + '&cvote=true': '');
  window.history.replaceState(null, null, newUrl);
};