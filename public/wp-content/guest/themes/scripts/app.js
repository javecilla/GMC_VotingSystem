(function($) {
	"use-strict";

	$(window).on('load', function() {
		setTimeout(function() {
			getAllCandidates();
		}, 1000);

		setTimeout(function() {
			getAllCategory();
			getAllAmountOfPayment();
		}, 500);

		setTimeout(function() {
			getCountTotalVoters();
			getCountTotalPageViews();
		}, 200);

	});

	$(document).on('submit', '#submitReportForm', function(e) {
		e.preventDefault();
		$('#g-recaptcha-response').val(grecaptcha.getResponse());
		const fullName = $('#fullName').val();
		const email = $('#email').val();
		const message = $('#message').val();
		const concernImage = $('#concernImage')[0];

		if(validateReportForm(fullName, email, message)) {
			const formData = new FormData();
			formData.append('name', fullName);
			formData.append('email', email);
			formData.append('message', message);
			formData.append('image', concernImage.files[0]);
			formData.append('app_version_name', $('.main-content').data('app'));
			formData.append('g_recaptcha_response', $('#g-recaptcha-response').val());

			storeSubmittedReport(formData);
		}
	});

	$(document).on('input', '.fullName', function() {
		$(this).removeClass('is-invalid');
	});

	$(document).on('input', '.email', function() {
		$(this).removeClass('is-invalid');
	});

	$(document).on('input', '.message', function() {
		$(this).removeClass('is-invalid');
	});

	$(document).on('input', '.search_input', function() {
		const searchQuery = $(this).val();
		if(isEmpty(searchQuery)) {
			getAllCandidates();
		}
	});

	$(document).on('submit', '#searchForm', function(e) {
		e.preventDefault();
		const searchQuery = $('.search_input').val().trim();
		writeURI('search', searchQuery);
		filterCandidatesBySearch(searchQuery);
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
		// $('#email').val(data.email);
		// $('#contactno').val(data.contact_no);
		$('#referenceNo').val('');
		showStep(1, data.candidate_id);
		updateProgressBar(1);
	});

	$(document).on('click', '#doneAndExitButton, #castVoteCloseModal', function() {
		window.history.replaceState(null, null, INDEX_URI);
		$('#castVoteModal').modal('hide');
		// $('#email').val('');
		// $('#contactno').val('');
		$('#referenceNo').val('');
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

	$(document).on('click', '#showCandidateOpenModal', function() {
		const candidateId = $(this).data('id');
		const candidateName = $(this).data('name');
		const candidateNo = $(this).data('no');
		writeURI('cshow=true&ctid', candidateId);
		$('#showCandidateInfoModal').modal('show');
		getOneCandidatesById(candidateId);
	});

	$(document).on('click', '#showCandidateInfoModalClose', function() {
		$('#showCandidateInfoModal').modal('hide');
		window.history.replaceState(null, null, INDEX_URI);
	})

	$(document).on('click', '#copyLinkButton', function() {
    const cdid = $(this).data('id');
    $(`.share_${cdid}`).addClass('d-none');
    $(`.check_${cdid}`).removeClass('d-none');

    // Create a temporary textarea element to copy the URI
    const tempTextarea = document.createElement('textarea');
    tempTextarea.value = 'https://voting.goldenmindsbulacan.com/';
    document.body.appendChild(tempTextarea);

    // Select the text within the textarea and copy it to the clipboard
    tempTextarea.select();
    document.execCommand('copy');

    // Remove the temporary textarea
    document.body.removeChild(tempTextarea);

    // Show share link and hide checkmark after 1 second
    setTimeout(function() {
        $(`.share_${cdid}`).removeClass('d-none');
        $(`.check_${cdid}`).addClass('d-none');
    }, 1000);
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