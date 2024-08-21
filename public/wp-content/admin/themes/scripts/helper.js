// Update the seconds in calendar @Top Navigation Bar
const updateTime = (targetElement) => {
  $(targetElement).text(new Date().toLocaleTimeString([], { hour12: true }));
};

// Check field if empty or not
const isEmpty = (field) => {
	return field === "";
};

const runSpinner = () => {
	$('.loading-spinner').removeClass('d-none');
};

const stopSpinner = () => {
	$('.loading-spinner').addClass('d-none');
};

// Function that validate image file
const isValidImageFile = (file) => {
	// Check if a file is selected
	if (file) {
		// Check the file type/format
		const validFileFormat = [
			'image/png', 'image/jpeg', 'image/jpg',
			'image/PNG', 'image/JPEG', 'image/JPG'
		];
		const fileType = file.type; // Convert to lowercase for case-insensitive comparison
		if(validFileFormat.includes(fileType)) {
			return { isValid: true, error: 'meron' }; // Valid file type
		} else {
			// Invalid file type
      return { isValid: false, error: 'Invalid Image file type. Please upload an image with the format PNG, JPG, or JPEG.' };
		}
	} else {
		// No file selected
		return { isValid: false, error: 'Image file is required! Please select a file.' };
	}
};

const removeEditedImage = (file) => {
	$('.removeImageButton').addClass('d-none');
	$('#imageLabel').removeClass('d-none');
	$('#cardCandidateImage').css('background-image', `url(${file})`);
	$('#candidateImage').val("");
};

const triggerFileUpload = (vpid) => {
  $(`.imageFileUpload_${vpid}`).click();
};

// Function to validate email if valid
const isValidEmail = (email) => {
	const REGX_EMAIL = /^([a-zA-z]+)([0-9]+)?(@)([a-zA-Z]{5,10}(.)([a-zA-Z]+))$/i;
	return (REGX_EMAIL.test(email)) ? true : false;
};

const formatDate = (timestamp) => {
	const date = new Date(timestamp);
	const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
	const month = months[date.getMonth()];
	const day = date.getDate();
	const year = date.getFullYear();
	let hour = date.getHours();
	const minute = (date.getMinutes() < 10 ? '0' : '') + date.getMinutes();
  const period = hour >= 12 ? 'PM' : 'AM';
  // Convert hour from 24-hour to 12-hour format
  hour = hour % 12 || 12;
  return `${month} ${day}, ${year} - ${hour}:${minute} ${period}`;
};

const boldLastPart = (referrenceNo) => {
	let boldPart = referrenceNo.slice(-4);
	let normalPart = referrenceNo.slice(0, -4);

	return `${normalPart}<b>${boldPart}`;
};

const writeURI = (paramsName, requestQuery) => {
	const currentUrl = window.location.href.split('?')[0];
	const newUrl = currentUrl + (requestQuery ? '?' +paramsName+ '=' + encodeURIComponent(requestQuery) : '');
	window.history.replaceState(null, null, newUrl);
};

const checkFormData = (formData) => {
  //check data form field value
  var formDataArray = [];
  formData.forEach((value, key) => {
    formDataArray.push({ [key]: value });
  });
  console.log(formDataArray);
};

const generateReferrenceNo = () => {
  let referrenceNumber = '';
  for (let i = 0; i < 9; i++) {
    referrenceNumber += Math.floor(Math.random() * 10);
  }
  return `${referrenceNumber}0000`;
};

const generatePhoneNumber = () => {
  let phoneNumber = '';
  for (let i = 0; i < 9; i++) {
    phoneNumber += Math.floor(Math.random() * 10);
  }
  return `09${phoneNumber}`;
};

const formatTextEllipsis = (text, length) => {
 	let words = text.split(' ');
  if (words.length > length) {
    text = words.slice(0, length).join(' ') + ' ...';
  }

  return text;
};