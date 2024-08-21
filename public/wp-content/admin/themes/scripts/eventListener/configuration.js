(function($) {

	"use-strict";

	$(window).on('load', function() {
		setTimeout(function() {
			getAllApplicationVersions();
		}, 500);

		setTimeout(function() {
			getAllCampus();
		}, 1000);

		setTimeout(function() {
			getAllCategories();
		}, 1500);

		setTimeout(function() {
			getAllVotePoints();
		}, 2000);
	});

	/*
		|--------------------------------------------------------------------------
		| Configuration >>> Application Version
		|--------------------------------------------------------------------------
	*/

	// Add New Application Version
	$(document).on('click', '#createNewVersionButton', function() {
		runSpinner();
		const versionTitle = $('#newVotingTitle').val();
		const versionName = $('#newVotingVersion').val();

		if(isEmpty(versionName)) {
			$('#newVotingVersion').addClass('is-invalid');
			stopSpinner();
			return;
		}

		if(isEmpty(versionTitle)) {
			$('#newVotingTitle').addClass('is-invalid');
			stopSpinner();
			return;
		}

		createNewApplicationVersion(versionName, versionTitle);
	});

	$(document).on('input', '#newVotingVersion', function() {
		$(this).removeClass('is-invalid');
	});

	$(document).on('input', '#newVotingTitle', function() {
		$(this).removeClass('is-invalid');
	});

	$(document).on('click', '.appVersionButtonEdit', function() {
		const avid = $(this).data('id');
		$(`.editNameVersion_${avid}`).attr('contenteditable', 'true').addClass('form-control');
		$(`.editTitleVersion_${avid}`).attr('contenteditable', 'true').addClass('form-control');
		$(`.save-icon_${avid}`).removeClass('d-none');
		$(`.close-icon_${avid}`).removeClass('d-none');
		$(`.edit-icon_${avid}`).addClass('d-none');
		$(`.delete-icon_${avid}`).addClass('d-none');
	});

	// Close the editable Application Version [Name and Title]
	$(document).on('click', '.appVersionButtonClose', function() {
		const avid = $(this).data('id');
		$(`.editNameVersion_${avid}`).attr('contenteditable', 'false').removeClass('form-control');
		$(`.editTitleVersion_${avid}`).attr('contenteditable', 'false').removeClass('form-control');
		$(`.save-icon_${avid}`).addClass('d-none');
		$(`.close-icon_${avid}`).addClass('d-none');
		$(`.edit-icon_${avid}`).removeClass('d-none');
		$(`.delete-icon_${avid}`).removeClass('d-none');
		getAllApplicationVersions();
	});

	// Update Application Version [Name and Title]
	$(document).on('click', '.appVersionButtonSave', function() {
		const avid = $(this).data('id');
		const versionName = $(this).closest('tr').find(`.editNameVersion_${avid}`).text();
		const versionTitle = $(this).closest('tr').find(`.editTitleVersion_${avid}`).text();
		updateApplicationVersion(avid, versionName, versionTitle);
	});

	// Delete the Application Version
	$(document).on('click', '.appVersionButtonDelete', function() {
		const avid = $(this).data('id');
		const versionName = $(this).closest('tr').find(`.editNameVersion_${avid}`).text();
		const versionTitle = $(this).closest('tr').find(`.editTitleVersion_${avid}`).text();
		const deleteConfirm = Swal.mixin({
			customClass: {
			  confirmButton: "btn btn-lg btn-secondary me-2",
			  cancelButton: "btn btn-lg btn-light",
			},
  		buttonsStyling: false
		});

		deleteConfirm.fire({
      title: "Confirm Deletion",
      html: `Are you sure you want to delete this application version <b>${versionName}</b>? Deleting an app version will also remove all associated records from <b>${versionTitle}</b>. This action cannot be undone.`,
      showConfirmButton: true,
      confirmButtonText: "Okay",
      showCancelButton: true,
      cancelButtonText: "Cancel",
    }).then(function(response) {
    	if(!response.isConfirmed) {
    		return false;
		  }
		  deleteApplicationVersion(avid);
		});
	});

	/*
		|--------------------------------------------------------------------------
		| Configuration >>> Campus
		|--------------------------------------------------------------------------
	*/
	$(document).on('click', '#createCampusButton', function() {
		runSpinner();
		const campusName = $('#newCampus').val();
		const appVersionIdSelected = $('#appVersionSelectedCampus').val();

		if(isEmpty(appVersionIdSelected)) {
			$('#appVersionSelectedCampus').addClass('is-invalid');
			stopSpinner();
			return;
		}

		if(isEmpty(campusName)) {
			$('#newCampus').addClass('is-invalid');
			stopSpinner();
			return;
		}

		createNewCampus(appVersionIdSelected, campusName);
	});

	$(document).on('click', '.campusButtonEdit', function() {
		const scid = $(this).data('id');
		$(`.editCampusName_${scid}`).attr('contenteditable', 'true').addClass('form-control');
		$(`.editCampus-icon_${scid}`).addClass('d-none');
		$(`.saveCampus-icon_${scid}`).removeClass('d-none');
		$(`.closeCampus-icon_${scid}`).removeClass('d-none');
		$(`.deleteCampus-icon_${scid}`).addClass('d-none');
	});

	$(document).on('click', '.campusButtonClose', function() {
		const scid = $(this).data('id');
		$(`.editCampusName_${scid}`).attr('contenteditable', 'false').removeClass('form-control');
		$(`.editCampus-icon_${scid}`).removeClass('d-none');
		$(`.saveCampus-icon_${scid}`).addClass('d-none');
		$(`.closeCampus-icon_${scid}`).addClass('d-none');
		$(`.deleteCampus-icon_${scid}`).removeClass('d-none');
		getAllCampus();
	});

	$(document).on('click', '.campusButtonSave', function() {
		const scid = $(this).data('id');
		const avid = $(this).data('avid');
		const campusName = $(this).closest('tr').find(`.editCampusName_${scid}`).text();

		if(isEmpty(campusName)) {
			toastr.info("Campus name is required.");
			return;
		}

		updateCampus(scid, avid, campusName);
	});

	$(document).on('click', '.campusButtonDelete', function() {
		const scid = $(this).data('id');
		const campusName = $(this).closest('tr').find(`.editCampusName_${scid}`).text();
		const deleteConfirm = Swal.mixin({
			customClass: {
			  confirmButton: "btn btn-lg btn-secondary me-2",
			  cancelButton: "btn btn-lg btn-light",
			},
  		buttonsStyling: false
		});

		deleteConfirm.fire({
      title: "Confirm Deletion",
      html: `Are you sure you want to delete this campus <b>${campusName}</b>? Deleting an category will also remove all associated records. This action cannot be undone.`,
      showConfirmButton: true,
      confirmButtonText: "Okay",
      showCancelButton: true,
      cancelButtonText: "Cancel",
    }).then(function(response) {
    	if(!response.isConfirmed) {
    		return false;
		  }
		  deleteCampus(scid);
		});
	});

	$(document).on('change', '#appVersionSelectedCampus', function() {
		$(this).removeClass('is-invalid');
	});

	// Remove the error style input
	$(document).on('input', '#newCampus', function() {
		$(this).removeClass('is-invalid');
	});

	/*
		|--------------------------------------------------------------------------
		| Configuration >>> Category
		|--------------------------------------------------------------------------
	*/
	$(document).on('click', '#createCategoryButton', function() {
		runSpinner();
		const categoryName = $('#newCategory').val();
		const appVersionIdSelected = $('#appVersionSelectedCategory').val();

		if(isEmpty(appVersionIdSelected)) {
			$('#appVersionSelectedCategory').addClass('is-invalid');
			stopSpinner();
			return;
		}

		if(isEmpty(categoryName)) {
			$('#newCategory').addClass('is-invalid');
			stopSpinner();
			return;
		}

		createNewCategory(appVersionIdSelected, categoryName);
	});

	$(document).on('click', '.categoryButtonEdit', function() {
		const ctid = $(this).data('id');
		$(`.editCategoryName_${ctid}`).attr('contenteditable', 'true').addClass('form-control');
		$(`.editCategory-icon_${ctid}`).addClass('d-none');
		$(`.saveCategory-icon_${ctid}`).removeClass('d-none');
		$(`.closeCategory-icon_${ctid}`).removeClass('d-none');
		$(`.deleteCategory-icon_${ctid}`).addClass('d-none');
	});

	$(document).on('click', '.categoryButtonClose', function() {
		const ctid = $(this).data('id');
		$(`.editCategoryName_${ctid}`).attr('contenteditable', 'false').removeClass('form-control');
		$(`.editCategory-icon_${ctid}`).removeClass('d-none');
		$(`.saveCategory-icon_${ctid}`).addClass('d-none');
		$(`.closeCategory-icon_${ctid}`).addClass('d-none');
		$(`.deleteCategory-icon_${ctid}`).removeClass('d-none');
		getAllCategories();
	});

	$(document).on('click', '.categoryButtonSave', function() {
		const ctid = $(this).data('id');
		const avid = $(this).data('avid');
		const categoryName = $(this).closest('tr').find(`.editCategoryName_${ctid}`).text();

		if(isEmpty(categoryName)) {
			toastr.info("Category name is required.");
			return;
		}

		updateCategory(ctid, avid, categoryName);
	});

	$(document).on('click', '.categoryButtonDelete', function() {
		const ctid = $(this).data('id');
		const categoryName = $(this).closest('tr').find(`.editCategoryName_${ctid}`).text();
		const deleteConfirm = Swal.mixin({
			customClass: {
			  confirmButton: "btn btn-lg btn-secondary me-2",
			  cancelButton: "btn btn-lg btn-light",
			},
  		buttonsStyling: false
		});

		deleteConfirm.fire({
      title: "Confirm Deletion",
      html: `Are you sure you want to delete this category <b>${categoryName}</b>? Deleting an category will also remove all associated records. This action cannot be undone.`,
      showConfirmButton: true,
      confirmButtonText: "Okay",
      showCancelButton: true,
      cancelButtonText: "Cancel",
    }).then(function(response) {
    	if(!response.isConfirmed) {
    		return false;
		  }
		  deleteCategory(ctid);
		});
	});

	$(document).on('change', '#appVersionSelectedCategory', function() {
		$(this).removeClass('is-invalid');
	});

	// Remove the error style input
	$(document).on('input', '#newCategory', function() {
		$(this).removeClass('is-invalid');
	});

	/*
		|--------------------------------------------------------------------------
		| Configuration >>> Vote Points
		|--------------------------------------------------------------------------
	*/
	$(document).on('click', '#createVotingPointsButton', function() {
		const voteAmount = $('#newAmount').val();
		const votePoint = $('#newPoints').val();
		const appVersionIdSelected = $('#appVersionSelectedVotePoints').val();
		const qrCodeImage = $('#qrCodeImage')[0];
		let imageFile = qrCodeImage.files[0];

		if(validateVotePointsForm(voteAmount, votePoint, appVersionIdSelected, imageFile)) {
	  	createNewVotePoints(appVersionIdSelected, voteAmount, votePoint, imageFile);
	  }
	});

	$(document).on('click', '.votePointButtonEdit', function() {
		const vpid = $(this).data('id');
		$(`.editVoteAmount_${vpid}`).attr('contenteditable', 'true').addClass('form-control');
		$(`.editVotePoint_${vpid}`).attr('contenteditable', 'true').addClass('form-control');
		$(`.editVotePointImage-icon_${vpid}`).removeClass('d-none');
		$(`.editVotePoint-icon_${vpid}`).addClass('d-none');
		$(`.saveVotePoint-icon_${vpid}`).removeClass('d-none');
		$(`.closeVotePoint-icon_${vpid}`).removeClass('d-none');
		$(`.deleteVotePoint-icon_${vpid}`).addClass('d-none');
	});

	$(document).on('click', '.votePointButtonClose', function() {
		const vpid = $(this).data('id');
		$(`.editVoteAmount_${vpid}`).attr('contenteditable', 'false').removeClass('form-control');
		$(`.editVotePoint_${vpid}`).attr('contenteditable', 'false').removeClass('form-control');
		$(`.editVotePointImage-icon_${vpid}`).addClass('d-none');
		$(`.editVotePoint-icon_${vpid}`).removeClass('d-none');
		$(`.saveVotePoint-icon_${vpid}`).addClass('d-none');
		$(`.closeVotePoint-icon_${vpid}`).addClass('d-none');
		$(`.deleteVotePoint-icon_${vpid}`).removeClass('d-none');
		$(`.imageFileUpload_${vpid}`).val("");
    $('#removeImageButton').addClass('d-none');
    $('#imageLabel').removeClass('d-none');
		getAllVotePoints();
	});

	$(document).on('click', '.votePointButtonSave', function() {
		const vpid = $(this).data('id');
		const avid = $(this).data('avid');
		const voteAmount = $(this).closest('tr').find(`.editVoteAmount_${vpid}`).text();
		const votePoint = $(this).closest('tr').find(`.editVotePoint_${vpid}`).text();
		const qrCodeImage = $(`.imageFileUpload_${vpid}`)[0];
		let imageFile = qrCodeImage.files[0];

		if (isEmpty(voteAmount) || isEmpty(votePoint)) {
      toastr.info('Vote amount and vote point is required.');
      return;
    }

		if (isNaN(voteAmount) || isNaN(votePoint)) {
      toastr.info('Vote amount and vote point must be numeric.');
      return;
    }

		updateVotePoints(vpid, avid, parseInt(voteAmount), parseInt(votePoint), imageFile);
	});

	$(document).on('click', '.votePointButtonDelete', function() {
		const vpid = $(this).data('id');
		const deleteConfirm = Swal.mixin({
			customClass: {
			  confirmButton: "btn btn-lg btn-secondary me-2",
			  cancelButton: "btn btn-lg btn-light",
			},
  		buttonsStyling: false
		});

		deleteConfirm.fire({
      title: "Confirm Deletion",
      html: `Are you sure you want to delete this vote points? Deleting an category will also remove all associated records. This action cannot be undone.`,
      showConfirmButton: true,
      confirmButtonText: "Okay",
      showCancelButton: true,
      cancelButtonText: "Cancel",
    }).then(function(response) {
    	if(!response.isConfirmed) {
    		return false;
		  }
		  deleteVotePoints(vpid);
		});
	});

	$(document).on('change', '#appVersionSelectedVotePoints', function() {
		$(this).removeClass('is-invalid');
	});

	//clean input amount and points
	$(document).on('input', '.newAmount', function() {
		$(this).removeClass('is-invalid');
		const inputAmount = $(this).val();
		const cleanAmount = inputAmount.replace(/[^0-9]/g, '');
		$(this).val(cleanAmount);
	});

	$(document).on('keyup', '.newPoints', function() {
		$(this).removeClass('is-invalid');
		const inputPoint = $(this).val();
    const cleanPoint = inputPoint.replace(/[^0-9]/g, '');
    $(this).val(cleanPoint);
	});

	$(document).on('change', '#qrCodeImage', function() {
		$(this).removeClass('is-invalid');
		$('#removeImageButton').removeClass('d-none');
		$('.removeImageButton').removeClass('d-none');
		$('#imageLabel').addClass('d-none');
	});

	$(document).on('click', '#removeImageButton', function() {
		$(this).addClass('d-none');
		$('#imageLabel').removeClass('d-none');
		$('#qrCodeImage').val("");
	});
})(jQuery)