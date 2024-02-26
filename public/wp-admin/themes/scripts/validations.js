(($) => {
	"use-strict";

	window.validateCandidateForm = (appVersion, category, candidateName, candidateImage) => {
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

	window.validateVotePointsForm = (voteAmount, votePoint, appVersionIdSelected, qrCodeImage) => {
		let isFormValid = true;

		if(isEmpty(appVersionIdSelected)) {
			$('#appVersionSelectedVP').addClass('is-invalid');
			isFormValid = false;
		}

		if(isEmpty(voteAmount)) {
			$('#newAmount').addClass('is-invalid');
			isFormValid = false;
		}

		if(isEmpty(votePoint)) {
			$('#newPoints').addClass('is-invalid');
			isFormValid = false;
		}

			// Validate image file input
		const imageValidationResult = isValidImageFile(qrCodeImage);
		if(!imageValidationResult.isValid) {
			$('.imageFile').addClass('is-invalid');
			$('.imageValidationFeedBack').text(imageValidationResult.error);
			isFormValid = false;
		}

		return isFormValid;
	};

	window.validateVoteForm = (data) => {
		let isValid = true;

		if(isEmpty(data.candidate_id) || data.candidate_id === 'undefined' || data.candidate_id === null) {
			$('.candidateSelected').addClass('is-invalid');
			$('.candidateIdError').text('This field is required! Please select candidate.');
			isValid = false;
		}

		if(isEmpty(data.vote_points_id) || data.vote_points_id === 'undefined' || data.vote_points_id === null) {
			$('.amountSelected').addClass('is-invalid');
			$('.votePointIdError').text('This field is required! Please select amount.');
			isValid = false;
		}
		
		return isValid;
	};


})(jQuery)