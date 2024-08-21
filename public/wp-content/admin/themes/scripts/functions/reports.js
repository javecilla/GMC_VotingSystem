"use-strict";

const TICKET_REPORTS_URI = 'admin/manage/ticket/reports';
const REPORTS_INDEX_URI = $('#indexUri').data('iurl');
// APP_VERSION & CSRF_TOKEN (variable)-> wp-content/admin/themes/scripts/main.js

const loadMoreReportsRecord = async (limit, offset) => {
  $.ajax({
    url: `/api/${APP_VERSION}/${TICKET_REPORTS_URI}/limit/records/${limit}/${offset}`,
    method: 'get',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
    success: (data) => {
      if (offset > 0) {
        $('#prevPaginateBtn').removeAttr('disabled');
      } else {
        $('#prevPaginateBtn').attr('disabled', true);
      }

      if (data.length < limit) {
        $('#nextPaginateBtn').attr('disabled', true);
      } else {
        $('#nextPaginateBtn').removeAttr('disabled');
      }
      window.history.replaceState(null, null, REPORTS_INDEX_URI);
      ticketReportsTable(data);
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

const getReportInformationById = async (ticketReportId) => {
	$.ajax({
		url: `/api/${APP_VERSION}/${TICKET_REPORTS_URI}/id/${ticketReportId}`,
		method: 'get',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
		success: (response) => {
			ticketReportsModal(response);
		},
		error: (xhr, status, error) => {
			const response = JSON.parse(xhr.responseText);
			toastr.error(response.message);
		}
	});
};

const filterReportsBySearch = async (search) => {
	$.ajax({
		url: `/api/${APP_VERSION}/${TICKET_REPORTS_URI}/search/${search}`,
		method: 'get',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
		success: (response) => {
			ticketReportsTable(response);
		},
		error: (xhr, status, error) => {
			const response = JSON.parse(xhr.responseText);
			toastr.error(response.message);
		}
	});
};

const filterReportsByStatus = async (status) => {
	$.ajax({
		url: `/api/${APP_VERSION}/${TICKET_REPORTS_URI}/status/${status}`,
		method: 'get',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
		success: (response) => {
			if(status == 0) {
				writeURI('status', 'fixed');
				$('#cardLabelTxt').text('List of All Fixed Tickets Report');
				$('.all, .pending').removeClass('active');
				$('.fixed').addClass('active');
			} else if(status == 1) {
				writeURI('status', 'pending');
				$('#cardLabelTxt').text('List of All Pending Tickets Report');
				$('.all, .fixed').removeClass('active');
				$('.pending').addClass('active');
			} else {
				writeURI('', '');
				$('#cardLabelTxt').text("List of All Issue's Reports");
				$('.fixed, .pending').removeClass('active');
				$('.all').addClass('active');
			}
			ticketReportsTable(response);
		},
		error: (xhr, status, error) => {
			const response = JSON.parse(xhr.responseText);
			toastr.error(response.message);
		}
	});
};

const getTotalNotFixedTicketReports = async () => {
	$.ajax({
    url: `/api/${APP_VERSION}/${TICKET_REPORTS_URI}/count/not/fix`,
    method: 'get',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
    success: (data) => {
      $('.report-badge').text(data.totalReports);
      $('#totalIssueReport').text(data.totalReports);
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

const sendEmailReplyMessage = async (dataForm) => {
	runSpinner();
	$('#sendEmailButton').attr('disabled', true).addClass('text-white');
	$.ajax({
    url: `/api/${APP_VERSION}/${TICKET_REPORTS_URI}/send/email`,
    method: 'patch',
    data: dataForm,
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
    success: (response) => {
    	if(response.success) {
				loadMoreReportsRecord(5, 0); //reload the data again
				$('#replyMessageEmail').click().modal('hide'); //hide modal
				//clear inputs
				$('#reportTicketId').val('');
				$('#toEmail').val('');
				$('#replyMessage').val('');
				//back the uri to default
				writeURI('', '');
    		toastr.success(response.message);
    	} else {
    		toastr.warning(response.message);
    	}
    	stopSpinner();
    	$('#sendEmailButton').removeAttr('disabled', 'disabled').addClass('text-white');;
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

// function that render html data
const ticketReportsTable = (data) => {
	let reportDataBody = `<table class="table table-hover table-striped">`;
	if(typeof data === 'object' && data !== null && data.length > 0) {
		Object.keys(data).forEach(key => {
			reportDataBody += `
				<tr class="reportDataBtn mouse-pointer" title="From: ${data[key].email}" data-id="${data[key].trid}">
				  <td>
				    <img src="/wp-content/admin/uploads/profile.jpg" alt="img" width="40" height="40" class="rounded-circle flex-shrink-0">
				  </td>
				  <td>
				  	<span class="badge text-bg-${data[key].status == 0 ? 'success' : 'secondary'}">
				  		${data[key].status_name}
				  	</span>
				  </td>
				  <td>${data[key].name}</td>
				  <td>${data[key].message_ellipsis}</td>
				 	<td>${data[key].created_at}</td>
				</tr>
			`;
		});
	} else {
		reportDataBody += `
			<tr>
				<td rowspan="5" class="text-center">
					<h4 class="text-secondary mt-2">No record found. <i class="fa-solid fa-face-sad-tear"></i></h4>
				</td>
			</tr>
		`;
	}
	reportDataBody += `</table>`;

	$('#reportDataBody').html(reportDataBody);
};



const ticketReportsModal = (data) => {
	Object.keys(data).forEach(key => {
		if(data[key].status == 0) { //fixed
			$('#status').removeClass('text-bg-light').addClass('text-bg-success');
			$('#openEmailFormModal').attr('disabled', true).text('Nothing to take action');
		} else if(data[key].status == 1) {
			$('#status').removeClass('text-bg-light').addClass('text-bg-secondary');
			$('#openEmailFormModal').removeAttr('disabled', 'disabled').html(`Marked this tickets as fixed and generate email to <b>${data[key].email}</b>`);
		}

		$('#status').text(data[key].status_name);
		$('#dateCreated').val(data[key].created_at);
		$('#dateUpdated').val(data[key].updated_at);
		$('#fromEmail').val(data[key].email);
		$('#name').val(data[key].name);
		$('#message').val(data[key].message);
		$('#reportImage').attr('src', `${data[key].image}`);
		$('#reportTicketId').val(data[key].trid);
	});
};
