(function($) {
	"use-strict";

	$(window).on('load', function() {
		loadMoreReportsRecord(5, 0);
	});

	$(document).on('click', '.allReportsBtn', function() {
		loadMoreReportsRecord(5, 0);
	});

	$(document).on('click', '.filterReportBtn', function() {
		const status = $(this).data('status');
		filterReportsByStatus(status);
	});

	$(document).on('submit', '#searchForm', function(e) {
		e.preventDefault();
		const searchInput = $('.search-input').val().trim();
		if(isEmpty(searchInput) || searchInput === "") {
			toastr.info('Please type your search query.');
			return;
		}

		writeURI('search', searchInput);
		filterReportsBySearch(searchInput);
	});

	$(document).on('input', '#search', function() {
		const searchInput = $('.search-input').val().trim();
		if(isEmpty(searchInput)) {
			writeURI('', '');
			loadMoreReportsRecord(5, 0);
		} 
	});

	//TODO:
	$(document).on('click', '.reportDataBtn', function() {
		const trid = $(this).data('id');
		writeURI('show=true&trid', trid);
		$('#ticketReportInfo').modal('show');
		getReportInformationById(trid);
	});

	$(document).on('click', '#openEmailFormModal', function() {
		const email = $('#fromEmail').val();
		writeURI('show=true&send_to', email);
		$('#toEmail').val(email);
		$('#ticketReportInfo').modal('hide');
		$('#replyMessageEmail').modal('show');
	});

	$(document).on('click', '#backToInfoBtn', function() {
		const trid = $('#reportTicketId').val();
		writeURI('show=true&trid', trid);
		$('#replyMessageEmail').modal('hide');
		$('#ticketReportInfo').modal('show');
	});

	$(document).on('click', '.closeModalBtn', function() {
		writeURI('', '');
		$('#ticketReportInfo').modal('hide');
		$('#replyMessageEmail').modal('hide');
		$('.replyMessageError').text('');
		$('#replyMessage').removeClass('is-invalid');
	});

	$(document).on('click', '#sendEmailButton', function() {
		const dataForm = {
			'trid': $('#reportTicketId').val(),
			'fromEmail': $('#fromSenderEmail').val(),
			'toEmail': $('#toEmail').val(),
			'name': $('#name').val(),
			'replyMessage': $('#replyMessage').val(),

		};

		if(isEmpty(dataForm.replyMessage)) {
			$('#replyMessage').addClass('is-invalid');
			$('.replyMessageError').text('This field is required! Please enter your reply message.');
			return;
		}

		if(isEmpty(dataForm.trid) || isEmpty(dataForm.toEmail) || isEmpty(dataForm.name)) {
			writeURI('', '');
			$('#ticketReportInfo').click().modal('hide');
			$('#replyMessageEmail').click().modal('hide');
			toastr.warning('Something went wrong! Please try again.');
			return;
		}

		sendEmailReplyMessage(dataForm);
	});

	$(document).on('input', '#replyMessage', function() {
		$(this).removeClass('is-invalid');
		$('.replyMessageError').text('');
	});

	let offset = 0;
	let page = 1;
	let limit = 5;
	$(document).on('click', '#nextPaginateBtn', function() {
		offset += limit; 
		page += 1;

		loadMoreReportsRecord(limit, offset);
		writeURI('page', page);
	});

	$(document).on('click', '#prevPaginateBtn', function() {
		offset -= limit; 
		page -= 1;

		loadMoreReportsRecord(limit, offset);
		writeURI('page', page);
	});
})(jQuery)