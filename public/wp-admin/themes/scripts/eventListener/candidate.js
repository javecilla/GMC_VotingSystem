(function($) {
	"use-strict";

	const APP_VERSION = $('.app-content').data('app');
	const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	const CDID = ($('#candidateId').val()) ? $('#candidateId').val() : '1';

	$(window).on('load', function() {
		getAllApplicationVersions(APP_VERSION, CSRF_TOKEN);
		getAllCampusByVersion(APP_VERSION, CSRF_TOKEN);
		getAllCategoryByVersion(APP_VERSION, CSRF_TOKEN);
		getAllCandidatesByVersion(APP_VERSION, CSRF_TOKEN);
		getOneCandidatesByVersion(APP_VERSION, CSRF_TOKEN, CDID);
	});

	$(document).on('submit', '#campusCreateForm', function(e) {
		e.preventDefault();

		const avid = $('#appVersionSelected').val();
		const scid = $('#campusSelected').val();
		const ctid = $('#categorySelected').val();
		const candidateName = $('#candidateName').val();
		const candidateNo = $('#candidateNo').val();
		const candidateMotto = $('#candidateMottoDescription').val();
		const candidateImage = $('#candidateImage')[0]; 
		let imageFile = candidateImage.files[0]; 

	  if(validateCampusForm(avid, ctid, candidateName, imageFile)) {
	  	createNewCandidate(APP_VERSION, CSRF_TOKEN, avid, scid, ctid, candidateNo, candidateName, candidateMotto, imageFile);
	  }		
	});

	$(document).on('change', '#appVersionSelected', function() {
		$(this).removeClass('is-invalid');					
	});

	$(document).on('change', '#categorySelected', function() {
		$(this).removeClass('is-invalid');		
	});

	$(document).on('change', '#candidateImage', function() {
		$(this).removeClass('is-invalid');			
		$('#removeImageButton').removeClass('d-none');
		$('#imageLabel').addClass('d-none');	
		if(this.files && this.files[0]) {
	 		const reader = new FileReader();
	 		reader.onload = function(e) {
	 			$('#cardCandidateImage').css('background-image', `url(${e.target.result})`);
	 		};
 			reader.readAsDataURL(this.files[0]);
 		}
	});

	$(document).on('click', '#removeImageButton', function() {
		$(this).addClass('d-none');
		$('#imageLabel').removeClass('d-none');	
		$('#cardCandidateImage').css('background-image', `url('/wp-admin/uploads/noimg-yet.PNG')`);
		$('#candidateImage').val(""); 
	});

	$(document).on('input', '#candidateName', function() {
		$(this).removeClass('is-invalid');
		$('#candidateNameText').text($(this).val());		
	}); 

	$(document).on('input', '#candidateNo', function() {
		$(this).removeClass('is-invalid');
		$('#candidateNoText').text($(this).val());		
	});

})(jQuery)