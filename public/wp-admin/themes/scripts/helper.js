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