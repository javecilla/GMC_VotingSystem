(function($) {
	"use-strict";

	const INDEX_URI = $('#indexURI').val();
	const ACTIVE_CANDIDATE = $('#candidateInfo').data('id') ?? '1';

	$(window).on('load', function() {
		getAllCandidates();
		getAllCategory();
		getAllAmountOfPayment();
		getOneCandidatesById(ACTIVE_CANDIDATE);
		window.history.replaceState(null, null, INDEX_URI);
	});

	$(document).on('input', '.search_input', function() {
		const searchQuery = $(this).val().trim();
		const currentUrl = window.location.href.split('?')[0];
		const newUrl = currentUrl + (searchQuery ? '?search=' + encodeURIComponent(searchQuery) : '');
		window.history.replaceState(null, null, newUrl);
		if(searchQuery) {
			filterCandidatesBySearch(searchQuery);
		} else {
			getAllCandidates();
		}
	});

	$(document).on('click', '#castVoteOpenModal', function() {
		const candidateId = $(this).data('id');
		const candidateName = $(this).data('name');
		const candidateNo = $(this).data('no');
		showStep(1, candidateId);
		updateProgressBar(1);
		$('#candidateInfo').text(`${candidateName} : ${candidateNo}`);
		$('#castVoteModal').modal('show');
		$('#candidateSelected').val(candidateId);
	});



	$(document).on('click', '#amountPaymentButtonSelected', function() {
		const votePointsId = $(this).data('id');
		$('#guideTextLabel').html("<b>Please scan the qr code below. After scan it click next button to proceed.</b>");
		$('#nextStepButton').removeAttr('disabled');
		$('#amountPaymentSelected').val(votePointsId);
		$('#amtOfPayment').removeClass('is-invalid');
		$('.amtOfPaymentError').text('');
		getQRCodeOfPaymentsById(votePointsId);
	});

	$(document).on('click', '#nextStepButton', function() {
		const dataFirstStep = {
			'app_version_name': $('#appVersionName').val(),
			'candidate_id': $('#candidateSelected').val(),
			'email': $('#email').val(),
			'contact_no': $('#contactno').val(),
			'vote_points_id': $('#amountPaymentSelected').val(),
		};

		if(validateFirstStepVoteForm(dataFirstStep)) {
			//store the data in first step form in localstorage
			localStorage.setItem('step1Data', JSON.stringify(dataFirstStep));
			showStep(2, dataFirstStep.candidate_id);
			updateProgressBar(2);
		}
	});

	$(document).on('click', '#submitMyVote', function() {
		$('#g-recaptcha-response').val(grecaptcha.getResponse());
		const dataSecondStep = {
			'g_recaptcha_response': $('#g-recaptcha-response').val(),
			'referrence_no': $('#referenceNo').val()
		};

		if(validateSecondStepVoteForm(dataSecondStep)) {
			localStorage.setItem('step2Data', JSON.stringify(dataSecondStep));
			const combinedData = combineLocalStorageData();
			storeSubmittedVotes(combinedData);
		}
	});

	$(document).on('click', '#voteAgainButton', function() {
		const oldData = localStorage.getItem('step1Data');
		const data = JSON.parse(oldData);
		$('#email').val(data.email);
		$('#contactno').val(data.contact_no);
		showStep(1, data.candidate_id);
		updateProgressBar(1);
	});

	$(document).on('click', '#doneAndExitButton, #castVoteCloseModal', function() {
		window.history.replaceState(null, null, INDEX_URI);
		$('#castVoteModal').modal('hide');
		$('#email').val('');
		$('#contactno').val('');
		$('#amountPaymentSelected').val('');
		getAllAmountOfPayment();
		localStorage.clear();
	});

	$(document).on('input', '#referenceNo', function() {
		$(this).removeClass('is-invalid');
	});

	$(document).on('input', '#email', function() {
		$(this).removeClass('is-invalid');
	});

	$(document).on('input', '#contactno', function() {
		$(this).removeClass('is-invalid');
	});

	$('#backToTop').hide();
  // back to top
  $(window).scroll(function() {
   	if ($(this).scrollTop() > 150) {
     	$('#backToTop').show().fadeIn();
		} else {
      $('#backToTop').hide().fadeOut();
    }
  });

  $('#backToTop').click(function(e) {
    e.preventDefault();
    $('html, body').animate({ scrollTop: 0 }, 'slow');
 	});

})(jQuery)