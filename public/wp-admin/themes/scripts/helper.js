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
		const validFileFormat = ['image/png', 'image/jpeg', 'image/jpg'];
		const fileType = file.type.toLowerCase(); // Convert to lowercase for case-insensitive comparison
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

// Function to validate email if valid
const isValidEmail = (email) => {
	const REGX_EMAIL = /^([a-zA-z]+)([0-9]+)?(@)([a-zA-Z]{5,10}(.)([a-zA-Z]+))$/i;
	return (REGX_EMAIL.test(email)) ? true : false;
};

