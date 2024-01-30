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
	});

	/*
	|--------------------------------------------------------------------------
	| Make the Application Version [Name and Title] editable 
	|--------------------------------------------------------------------------
	 */
	$(document).on('click', '.appVersionButton .edit-icon', function() {
		const avid = $(this).data('id');
		$('.editNameVersion').attr('contenteditable', 'true').addClass('form-control');
		$('.editTitleVersion').attr('contenteditable', 'true').addClass('form-control');
		$('.edit-icon').addClass('d-none');
		$('.save-icon').removeClass('d-none');

		$('.appVersionButtonClose').removeClass('d-none');
		$('.appVersionButtonDelete').addClass('d-none');
	});

	/*
	|--------------------------------------------------------------------------
	| Close the editable Application Version [Name and Title]  
	|--------------------------------------------------------------------------
	 */
	$(document).on('click', '.appVersionButtonClose', function() {
		$('.editNameVersion').attr('contenteditable', 'false').removeClass('form-control');
		$('.editTitleVersion').attr('contenteditable', 'false').removeClass('form-control');
		$('.edit-icon').removeClass('d-none');
		$('.save-icon').addClass('d-none');

		$('.appVersionButtonClose').addClass('d-none');
		$('.appVersionButtonDelete').removeClass('d-none');
	});

	/*
	|--------------------------------------------------------------------------
	| Update Application Version [Name and Title] 
	|--------------------------------------------------------------------------
	 */
	$(document).on('click', '.appVersionButton .save-icon', function() {
		const avid = $(this).data('id');
		$('.editNameVersion').attr('contenteditable', 'false').removeClass('form-control');
		$('.editTitleVersion').attr('contenteditable', 'false').removeClass('form-control');
		$('.edit-icon').removeClass('d-none');
		$('.save-icon').addClass('d-none');
		$('.appVersionButtonClose').addClass('d-none');
		$('.appVersionButtonDelete').removeClass('d-none');
		//@TODO: Logic for updating
		toastr.success("App version updated successfully.");
	});

	/*
	|--------------------------------------------------------------------------
	| Delete the Application Version
	|--------------------------------------------------------------------------
	 */
	$(document).on('click', '.appVersionButtonDelete', function() {
		const avid = $(this).data('id');
		$(`.appVersionItem_${avid}`).remove();
		//@TODO: Logic for deleting
		toastr.success("App version deleted successfully.");
	});

})(jQuery)