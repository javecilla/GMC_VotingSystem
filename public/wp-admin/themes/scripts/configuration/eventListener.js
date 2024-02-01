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
		getAllCategory(APP_VERSION, CSRF_TOKEN);
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
	});

	// Update Application Version [Name and Title] 
	$(document).on('click', '.appVersionButtonSave', function() {
		const avid = $(this).data('id');
		const versionName = $(this).closest('tr').find(`.editNameVersion_${avid}`).text();
		const versionTitle = $(this).closest('tr').find(`.editTitleVersion_${avid}`).text();

		const oldName = $(this).closest('tr').find(`.editNameVersion_${avid}`).data('name');
    const oldTitle = $(this).closest('tr').find(`.editTitleVersion_${avid}`).data('title');

		$(`.editNameVersion_${avid}`).attr('contenteditable', 'false').removeClass('form-control');
		$(`.editTitleVersion_${avid}`).attr('contenteditable', 'false').removeClass('form-control');
		$(`.save-icon_${avid}`).addClass('d-none');
		$(`.close-icon_${avid}`).addClass('d-none');
		$(`.edit-icon_${avid}`).removeClass('d-none');
		$(`.delete-icon_${avid}`).removeClass('d-none');

		if (oldName == versionName && oldTitle == versionTitle) {
      toastr.info("No changes occurred.");
      return;
    }


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

	// Remove the error style input
	$(document).on('input', '#newVotingTitle, #newVotingVersion', function() {
		$('#newVotingTitle').removeClass('is-invalid');
		$('#newVotingVersion').removeClass('is-invalid');
	});

	// Delete the Application Version
	$(document).on('click', '.appVersionButtonDelete', function() {
		const avid = $(this).data('id');
		const deleteConfirm = Swal.mixin({
			customClass: {
			  confirmButton: "btn btn-lg btn-secondary me-2",
			  cancelButton: "btn btn-lg btn-light",
			},
  		buttonsStyling: false
		});

		deleteConfirm.fire({
      title: "Confirm Deletion",
      html: "Are you sure you want to delete this application version? Deleting an app version will also remove all associated records. This action cannot be undone.",
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
})(jQuery)