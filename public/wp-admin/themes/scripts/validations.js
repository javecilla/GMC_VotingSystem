(($) => {
	"use-strict";

	window.validateCampusForm = (appVersion, category, candidateName, candidateImage) => {
		let isFormValid = true;

		if(isEmpty(appVersion)) {
	 		$('#appVersionSelected').addClass('is-invalid');
			isFormValid = false;
	 	}

	 	if(isEmpty(category)) {
	 		$('#categorySelected').addClass('is-invalid');
			isFormValid = false;
	 	}

	 	if(isEmpty(candidateName)) {
	 		$('#candidateName').addClass('is-invalid');
			isFormValid = false;
	 	}

	 	// Validate image file input
		const imageValidationResult = isValidImageFile(candidateImage);
		if(!imageValidationResult.isValid) {
			$('.imageFile').addClass('is-invalid');
			$('.imageValidationFeedBack').text(imageValidationResult.error);
			isFormValid = false;
		}
		
		return isFormValid;
	};

})(jQuery)