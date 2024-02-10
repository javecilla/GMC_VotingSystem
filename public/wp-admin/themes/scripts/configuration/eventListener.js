(function($){
	
	"use-strict";

	const APP_VERSION = $('.app-content').data('app');
	const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

	/*
	|--------------------------------------------------------------------------
	| Laod all the data when page is load
	|--------------------------------------------------------------------------
	 */
	$(window).on('load', function() {
		getAllApplicationVersions(APP_VERSION, CSRF_TOKEN);
		getAllCategoryByVersion(APP_VERSION, CSRF_TOKEN);
		getAllVotePointsByVersion(APP_VERSION, CSRF_TOKEN);
	});

	/*
	|--------------------------------------------------------------------------
	| Configuration >>> Application Version
	|--------------------------------------------------------------------------
	*/

	// Make the Application Version [Name and Title] editable 
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
		getAllApplicationVersions(APP_VERSION, CSRF_TOKEN);
	});

	// Update Application Version [Name and Title] 
	$(document).on('click', '.appVersionButtonSave', function() {
		const avid = $(this).data('id');
		const versionName = $(this).closest('tr').find(`.editNameVersion_${avid}`).text();
		const versionTitle = $(this).closest('tr').find(`.editTitleVersion_${avid}`).text();
		updateApplicationVersion(APP_VERSION, CSRF_TOKEN, avid, versionName, versionTitle);
	});

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

		createNewApplicationVersion(APP_VERSION, CSRF_TOKEN, versionName, versionTitle);
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
		  deleteApplicationVersion(APP_VERSION, CSRF_TOKEN, avid);
		});
	});

	/*
	|--------------------------------------------------------------------------
	| Configuration >>> Category
	|--------------------------------------------------------------------------
	*/
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
		getAllCategoryByVersion(APP_VERSION, CSRF_TOKEN);
	});

	$(document).on('click', '.categoryButtonSave', function() {
		const ctid = $(this).data('id');
		const avid = $(this).data('avid');
		const categoryName = $(this).closest('tr').find(`.editCategoryName_${ctid}`).text();

		if(isEmpty(categoryName)) {
			toastr.info("Category name is required.");
			return;
		}

		updateCategory(APP_VERSION, CSRF_TOKEN, ctid, avid, categoryName);
	});

	$(document).on('click', '#createCategoryButton', function() {
		runSpinner();
		const categoryName = $('#newCategory').val();
		const appVersionIdSelected = $('#appVersionSelected').val();
		
		if(isEmpty(appVersionIdSelected)) {
			$('#appVersionSelected').addClass('is-invalid');
			stopSpinner();
			return;
		}

		if(isEmpty(categoryName)) {
			$('#newCategory').addClass('is-invalid');
			stopSpinner();
			return;
		}

		createNewCategory(APP_VERSION, CSRF_TOKEN, appVersionIdSelected, categoryName);
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
		  deleteCategory(APP_VERSION, CSRF_TOKEN, ctid);
		});
	});

	/*
	|--------------------------------------------------------------------------
	| Configuration >>> Vote Points
	|--------------------------------------------------------------------------
	*/
	$(document).on('click', '.votePointButtonEdit', function() {
		const vpid = $(this).data('id');
		$(`.editVoteAmount_${vpid}`).attr('contenteditable', 'true').addClass('form-control');
		$(`.editVotePoint_${vpid}`).attr('contenteditable', 'true').addClass('form-control');
		$(`.editVotePoint-icon_${vpid}`).addClass('d-none'); 
		$(`.saveVotePoint-icon_${vpid}`).removeClass('d-none');
		$(`.closeVotePoint-icon_${vpid}`).removeClass('d-none');
		$(`.deleteVotePoint-icon_${vpid}`).addClass('d-none');
	});

	$(document).on('click', '.votePointButtonClose', function() {
		const vpid = $(this).data('id');
		$(`.editVoteAmount_${vpid}`).attr('contenteditable', 'false').removeClass('form-control');
		$(`.editVotePoint_${vpid}`).attr('contenteditable', 'false').removeClass('form-control');
		$(`.editVotePoint-icon_${vpid}`).removeClass('d-none'); 
		$(`.saveVotePoint-icon_${vpid}`).addClass('d-none');
		$(`.closeVotePoint-icon_${vpid}`).addClass('d-none');
		$(`.deleteVotePoint-icon_${vpid}`).removeClass('d-none');
		getAllVotePointsByVersion(APP_VERSION, CSRF_TOKEN);
	});

	$(document).on('click', '.votePointButtonSave', function() {
		const vpid = $(this).data('id');
		const avid = $(this).data('avid');
		const voteAmount = $(this).closest('tr').find(`.editVoteAmount_${vpid}`).text();
		const votePoint = $(this).closest('tr').find(`.editVotePoint_${vpid}`).text();

		if (isEmpty(voteAmount) || isEmpty(votePoint)) {
      toastr.info('Vote amount and vote point is required.');
      return;
    }

		if (isNaN(voteAmount) || isNaN(votePoint)) {
      toastr.info('Vote amount and vote point must be numeric.');
      return;
    }

		updateVotePoints(APP_VERSION, CSRF_TOKEN, vpid, avid, voteAmount, votePoint);
	});

	$(document).on('click', '#createVotingPointsButton', function() {
		runSpinner();
		const voteAmount = $('#newAmount').val();
		const votePoint = $('#newPoints').val();
		const appVersionIdSelected = $('#appVersionSelectedVP').val();
		
		if(isEmpty(appVersionIdSelected)) {
			$('#appVersionSelectedVP').addClass('is-invalid');
			stopSpinner();
			return;
		}

		if(isEmpty(voteAmount)) {
			$('#newAmount').addClass('is-invalid');
			stopSpinner();
			return;
		}

		if(isEmpty(votePoint)) {
			$('#newPoints').addClass('is-invalid');
			stopSpinner();
			return;
		}

		createNewVotePoints(APP_VERSION, CSRF_TOKEN, appVersionIdSelected, voteAmount, votePoint);
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
		  deleteVotePoints(APP_VERSION, CSRF_TOKEN, vpid);
		});
	});

	$(document).on('change', '#appVersionSelected, #versionFilterSelected, #appVersionSelectedVP, #versionFilterSelectedVP', function() {
		$('#appVersionSelected').removeClass('is-invalid');
		$('#appVersionSelectedVP').removeClass('is-invalid');
		const avid = $('#versionFilterSelected').val();
		const avidvp = $('#versionFilterSelectedVP').val();
		getAllCategoryByVersion(avid, CSRF_TOKEN);
		getAllVotePointsByVersion(avidvp, CSRF_TOKEN);
	});

	// Remove the error style input
	$(document).on('input', '#newVotingTitle, #newVotingVersion, #newCategory', function() {
		$('#newVotingTitle').removeClass('is-invalid');
		$('#newVotingVersion').removeClass('is-invalid');

		$('#newCategory').removeClass('is-invalid');
	});

	//clean input amount and points
	$(document).on('keyup', '.newAmount, .newPoints', function() {
		$('#newAmount').removeClass('is-invalid');
		$('#newPoints').removeClass('is-invalid');
		const inputAmount = $('.newAmount').val();
		const inputPoint = $('.newPoints').val();
    const cleanAmount = inputAmount.replace(/[^0-9]/g, ''); 
    const cleanPoint = inputPoint.replace(/[^0-9]/g, ''); 
    $('.newAmount').val(cleanAmount);
    $('.newPoints').val(cleanPoint);
	});

})(jQuery)