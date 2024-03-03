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

      displayLimitTicketReports(data);
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

const displayLimitTicketReports = (data) => {
	let reportDataBody = `<div class="list-group">`;
	let dashboardReportDataBody = `<div class="list-group">`;
	if(typeof data === 'object' && data !== null) {
		Object.keys(data).forEach(key => {
			reportDataBody += `
				<a href="javascript:void(0)" class="list-group-item list-group-item-action d-flex gap-2 py-2 border-0" aria-current="true" style="background: transparent;">
					<img src="/wp-content/admin/uploads/profile.jpg" alt="img" width="50" height="50" class="rounded-circle flex-shrink-0">
						<div class="d-flex gap-2 w-100 justify-content-between">
							<div>
							  <h6 class="mb-1 text-muted">From: ${data[key].name} <small>(${data[key].email})</small></h6>
							  <p class="mb-1 opacity-75">${formatTextEllipsis(data[key].message, 10)} <span style="font-size: 16px;">Read More</span></p>
							</div>
						<small class="opacity-50 text-nowrap">${formatDate(data[key].created_at)}</small>
					</div>
				</a>
				<hr class="text-muted"/>
			`;

			dashboardReportDataBody += `
				<a href="#" class="list-group-item list-group-item-action d-flex gap-2 py-2 border-0" aria-current="true">
					<img src="/wp-content/admin/uploads/profile.jpg" alt="img" width="32" height="32" class="rounded-circle flex-shrink-0">
					<div class="d-flex gap-2 w-100 justify-content-between">
						<div>
							<h6 class="mb-0">From: ${data[key].email}</h6>
							<p class="mb-0 opacity-75">${formatTextEllipsis(data[key].message, 10)} Read More</p>
						</div>
						<small class="opacity-50 text-nowrap">New</small>
					</div>
				</a>
				<hr class="text-muted"/>
			`;
		});
	} else {
		reportDataBody += `
			<a href="#" class="list-group-item list-group-item-action d-flex gap-2 py-2 border-0" aria-current="true" style="background: transparent;">
				<h4 class="text-center text-secondary mt-2">No record found. <i class="fa-solid fa-face-sad-tear"></i></h4>
			</a>
		`;

		dashboardReportDataBody += `
			<a href="#" class="list-group-item list-group-item-action d-flex gap-2 py-2 border-0" aria-current="true" style="background: transparent;">
				<h4 class="text-center text-secondary mt-2">No record found. <i class="fa-solid fa-face-sad-tear"></i></h4>
			</a>
		`;
	}
	reportDataBody += `</div>`;
	dashboardReportDataBody += `</div>`;

	$('#reportDataBody').html(reportDataBody);
	$('#dashboardReportDataBody').html(dashboardReportDataBody);
};

