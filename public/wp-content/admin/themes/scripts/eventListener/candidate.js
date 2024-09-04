(function($) {
	"use-strict";

	$(window).on('load', function() {
		setTimeout(function() {
			loadMoreCandidatesRecord(9, 0);
		}, 2500);

		setTimeout(function() {
			getAllCandidates();
		}, 2000);

		setTimeout(function() {
			//getOneCandidates(isEmpty($('#candidateId').val()) ? '3' : $('#candidateId').val());
			getAllCampus();
		}, 1000);

		setTimeout(function() {
			getAllApplicationVersions();
			getAllCategories();
		}, 500);
	});

	$(document).on('submit', '#createCandidateForm', function(e) {
		e.preventDefault();
		const candidateImage = $('#candidateImage')[0];
		const dataIinput = {
			'avid': $('#appVersionSelected').val(),
			'scid': $('#campusSelected').val(),
			'ctid': $('#categorySelected').val(),
			'candidateName': $('#candidateName').val(),
			'candidateNo': $('#candidateNo').val(),
			'candidateMotto': $('#candidateMottoDescription').val(),
			'candidateImage': $('#candidateImage').val(),
			'imageFile': candidateImage.files[0],
		};

		const formData = new FormData();
	  formData.append('app_version_id', $('#appVersionSelected').val());
	  formData.append('school_campus_id', $('#campusSelected').val());
	  formData.append('category_id', $('#categorySelected').val());
	  formData.append('candidate_no', $('#candidateNo').val());
	  formData.append('name', $('#candidateName').val());
	  formData.append('motto_description', $('#candidateMottoDescription').val());
	  formData.append('image', candidateImage.files[0]);

	  if(validateCandidateForm(formData)) {
	  	createNewCandidate(formData);
	  }
	});

	$(document).on('click', '#updateCandidate', function() {
		const candidateImage = $('#editCandidateImage')[0];
		const cdid = $('#editActiveCandidate').val();
		const formData = new FormData();
		formData.append('cdid', cdid);
	  formData.append('app_version_id', $('#appVersionSelected').val());
	  formData.append('school_campus_id', $('#campusSelected').val());
	  formData.append('category_id', $('#categorySelected').val());
	  formData.append('candidate_no', $('#editCandidateNo').val());
	  formData.append('name', $('#editCandidateName').val());
	  formData.append('motto_description', $('#editCandidateMottoDescription').val());
	  formData.append('image', candidateImage.files[0]);
	  checkFormData(formData);

	  updateCandidates(cdid, formData);
	});

	$(document).on('click', '.deleteCandidateButton', function() {
		const cdid = $(this).data('id');
		const deleteConfirm = Swal.mixin({
			customClass: {
			  confirmButton: "btn btn-lg btn-secondary me-2",
			  cancelButton: "btn btn-lg btn-light",
			},
  		buttonsStyling: false
		});

		deleteConfirm.fire({
      title: "Confirm Deletion",
      html: `Are you sure you want to delete this candidate? This action cannot be undone.`,
      showConfirmButton: true,
      confirmButtonText: "Okay",
      showCancelButton: true,
      cancelButtonText: "Cancel",
    }).then(function(response) {
    	if(!response.isConfirmed) {
    		return false;
		  }
		  deleteCandidate(cdid);
		});
	});

	$(document).on('submit', '#searchForm', function(e) {
		e.preventDefault();
		const searchQuery = $('#searchCandidate').val().trim().toLowerCase();

		if(isEmpty(searchQuery)) return;

		writeURI('search', searchQuery);
		filterCandidatesBySearch(searchQuery);
	});

	$(document).on('input', '.search-input', function() {
		const searchInput = $(this).val();
		isEmpty(searchInput) ? loadMoreCandidatesRecord(9, 0) : '';
		window.history.replaceState(null, null, $('#indexUri').data('iurl'));
	});

	$(document).on('change', '#appVersionSelected', function() {
		$(this).removeClass('is-invalid');
	});

	$(document).on('change', '#categorySelected', function() {
		$(this).removeClass('is-invalid');
	});

	$(document).on('change', '#candidateImage, #editCandidateImage', function() {
		$(this).removeClass('is-invalid');
		$('#removeImageButton').removeClass('d-none');
		$('.removeImageButton').removeClass('d-none');
		$('#imageLabel').addClass('d-none');
		if(this.files && this.files[0]) {
	 		const reader = new FileReader();
	 		reader.onload = function(e) {
	 			$('#cardCandidateImage').css('background-image', `url(${e.target.result})`);
	 			$('#editCardCandidateImage').css('background-image', `url(${e.target.result})`);
	 		};
 			reader.readAsDataURL(this.files[0]);
 		}
	});

	$(document).on('click', '#removeImageButton', function() {
		$(this).addClass('d-none');

		$('#imageLabel').removeClass('d-none');
		$('#cardCandidateImage').css('background-image', `url('/wp-content/admin/uploads/noimg-yet.PNG')`);
		$('#candidateImage').val("");

		const editPrevImg = $('#editPrevPicture').val();
		$('#editCardCandidateImage').css('background-image', `url(${editPrevImg})`);
		$('#editCandidateImage').val("");
	});

	$(document).on('input', '#candidateName, #editCandidateName', function() {
		$(this).removeClass('is-invalid');
		$('#candidateNameText').text($(this).val());
		$('#editCandidateNameText').text($(this).val());
	});

	$(document).on('input', '#candidateNo, #editCandidateNo', function() {
		$(this).removeClass('is-invalid');
		$('#candidateNoText').text($(this).val());
		$('#editCandidateNoText').text($(this).val());
	});

	let offset = 0;
	let page = 1;
	let limit = 9;
	$(document).on('click', '#nextPaginateBtn', function() {
		offset += limit;
		page += 1;

		loadMoreCandidatesRecord(limit, offset);
		writeURI('page', page);
	});

	$(document).on('click', '#prevPaginateBtn', function() {
		offset -= limit;
		page -= 1;

		loadMoreCandidatesRecord(limit, offset);
		writeURI('page', page);
	});


	$(document).on('click', '.viewCandidateButton', function() {
		const cdid = $(this).data('id');
		writeURI('show=true&tab=information&cdid', cdid);
		$('.candidateId').val(cdid);
		$('#candidateInfoShow').modal('show');
		getOneCandidates(cdid);
	});

	$(document).on('click', '.editCandidateButton', function() {
		const cdid = $(this).data('id');
		writeURI('edit=true&cdid', cdid);
		$('#candidateInfoEdit').modal('show');
		getOneCandidates(cdid);
	});

	$(document).on('click', '.closeModalBtn', function() {
		writeURI('', '');
		$('#candidateInfoShow, #candidateInfoEdit').modal('hide');
	});

	$(document).on('click', '#tabInformation', function() {
		const cdid = $('.candidateId').val();
		writeURI('show=true&tab=information&cdid', cdid);
		$(this).removeClass('text-white').addClass('text-dark');
		$('#tabRecords').addClass('text-white');
    $('#tabPaneInformation').addClass('show active');
    $('#tabPaneRecords').removeClass('show active');
	});

	$(document).on('click', '#tabRecords', function() {
		const cdid = $('.candidateId').val();
		writeURI('show=true&tab=vote-records&cdid', cdid);
		$(this).removeClass('text-white').addClass('text-dark');
		$('#tabInformation').addClass('text-white');
	  $('#tabPaneInformation').removeClass('show active');
    $('#tabPaneRecords').addClass('show active');
	});
})(jQuery)