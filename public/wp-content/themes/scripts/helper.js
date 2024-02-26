"use-strict";

const validateFirstStepVoteForm = (dataFirstStep) => {
	let isValid = true;

	if(isEmpty(dataFirstStep.email)) {
		$('.email').addClass('is-invalid');
		$('.emailError').text('This field is required! Please enter your email.');
		isValid = false;
	} 
	if(isEmpty(dataFirstStep.contact_no)) {
		$('.contactno').addClass('is-invalid');
		$('.contactnoError').text('This field is required! Please enter your contact no.');
		isValid = false;
	}
	if(isEmpty(dataFirstStep.vote_points_id)) {
		$('#amtOfPayment').addClass('is-invalid');
		$('.amtOfPaymentError').text('This field is required! Select amount of payment.');
		isValid = false;
	}

	if(!isValidEmail(dataFirstStep.email)) {
		$('.email').addClass('is-invalid');
		$('.emailError').text('Invalid email address! Please enter a valid email address.');
		isValid = false;
	}

	if(!isValidContactNo(dataFirstStep.contact_no.toString())) {
		$('.contactno').addClass('is-invalid');
		$('.contactnoError').text('Invalid contact/phone number! Please enter a valid contact/phone number.');
		isValid = false;
	}

	return isValid;
};

const validateSecondStepVoteForm = (dataSecondStep) => {
	let isValid = true;

	if(isEmpty(dataSecondStep.referrence_no)) {
		$('.referenceNo').addClass('is-invalid');
		$('.referenceNoError').text("This field is required! Please enter the referrence no.");
		isValid = false;
	}

	if(!isValidReferrenceNo(dataSecondStep.referrence_no.toString())) {
		$('.referenceNo').addClass('is-invalid');
		$('.referenceNoError').text("Invalid referrence no! Please enter a valid referrence no.");
		isValid = false;
	}

	return isValid;
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

// Functions that track the  form steps
const updateProgressBar = (step) => {
  $('#progressbar li').removeClass('active');
  for (let i = 1; i <= step; i++) {
    $(`#progressbar li:nth-child(${i})`).addClass('active');
  }

  $(`.form-step[data-step="${step}"]`).fadeIn();
  $(`.form-step[data-step]:not([data-step="${step}"])`).hide();
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
}

// @Functions helpers
const updateTime = (targetElement) => {
	  $(targetElement).text(new Date().toLocaleTimeString([], { hour12: true }));
	};

const isEmpty = (field) => {
	return field === "";
};

const isValidEmail = (email) => {
	const REGX_EMAIL = /^([a-zA-z]+)([0-9]+)?(@)([a-zA-Z]{5,10}(.)([a-zA-Z]+))$/i;
	return REGX_EMAIL.test(email);
};

const isValidContactNo = (contactNo) => {
	const MAX_LENGTH = 11;
	return contactNo.length == MAX_LENGTH;
};

const isValidReferrenceNo = (referrenceNo) => {
	const MAX_LENGTH = 13;
  return referrenceNo.length <= MAX_LENGTH;
};

const runSpinner = () => {
	$('.loading-spinner').removeClass('d-none');
};

const stopSpinner = () => {
	$('.loading-spinner').addClass('d-none');
};