"use-strict";

const DASHBOARD_URI = 'admin/dashboard';
const DASHBOARD_INDEX_URI = $('#indexUri').data('iurl');
// APP_VERSION & CSRF_TOKEN (variable)-> wp-content/admin/themes/scripts/main.js

// Get the total count of the pending, verified and amount
const getPendingVerifiedTotalAmount = () => {
	$.ajax({
		url: `/api/${APP_VERSION}/${DASHBOARD_URI}/count/pending/verified/amount`,
		method: 'get',
		dataType: 'json',
		headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
		success: (data) => {
			$('#totalAllPending').text(data.pending);
			$('#totalVotersVerified').text(data.verified);
			$('#totalAmountVerified').text(data.totalAmount);
		},
		erorr: (xhr, status, error) => {
			const response = JSON.parse(xhr.responseText);
			toastr.erorr(response.message);
		}
	});
};

const getTotalTicketReports = () => {
	$.ajax({
    url: `/api/${APP_VERSION}/admin/manage/ticket/reports/count/not/fix`,
    method: 'get',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
    success: (data) => {
      $('#totalIssueReport').text(data.totalReports);
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

// Get the candidates that has most votes(points)
const getMostVotesCandidates = (limit) => {
	$.ajax({
		url: `/api/${APP_VERSION}/${DASHBOARD_URI}/most/votes/candidates/${limit}`,
		method: 'get',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
		success: (data) => {
			const candidatesNames = data.map(candidate => candidate.name);
			const totalVotePoints = data.map(candidate => candidate.totalPoints);

			const ctxmostVotesCandidatesChart = $('#mostVotesCandidatesChart');
			new Chart(ctxmostVotesCandidatesChart, {
		    type: 'bar',
		    data: {
		      labels: candidatesNames,
		      datasets: [{
		        label: 'Total Vote Points',
		        data: totalVotePoints,
		        backgroundColor: '#363b42',
		        borderWidth: 1
		      }]
		    },
		    options: {
		      scales: {
		        y: {
		          beginAtZero: true
		        }
		      }
		    }
		  });
		},
		erorr: (xhr, status, error) => {
			const response = JSON.parse(xhr.responseText);
			toastr.error(response.message);
		}
	});
};

// Get the total number of views page's each day
const getPageViewsPerDay = (limit) => {
	$.ajax({
		url: `/api/${APP_VERSION}/${DASHBOARD_URI}/count/total/page/views/${limit}/perday`,
		method: 'get',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
		success: (data) => {
			const dates = data.totalPageViews.map(views => views.name);
			const totalCounts = data.totalPageViews.map(views => views.total_views);

			const ctxPageViews = $('#pageViewChart');
		  new Chart(ctxPageViews, {
		    type: 'line',
		    data: {
		      labels: dates,
		      datasets: [{
		        label: '# Page Views',
		        data: totalCounts,
		        fill: true,
		        borderColor: '#363b42',
		        borderWidth: 2,
		        pointBackgroundColor: '#363b42',
		        pointRadius: 5,
		        pointHoverRadius: 7
		      }]
		    },
		    options: {
		      scales: {
		        x: {
		          beginAtZero: true
		        },
		        y: {
		          beginAtZero: true
		        }
		      }
		    }
		  });
		},
		error: (xhr, status, error) => {
			const response = JSON.parse(xhr.responseText);
			toastr.error(response.message);
		}
	});
};

// Get the recently voter's
const getRecentlyVoters = (limit, offset) => {
	$.ajax({
		url: `/api/${APP_VERSION}/${DASHBOARD_URI}/get/recently/voters/${limit}/${offset}`,
		method: 'get',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
		success: (data) => {
			displayRecentlyVotes(data);
		},
		erorr: (xhr, status, error) => {
			const response = JSON.parse(xhr.responseText);
			console.error(xhr.responseText);
			toastr.erorr(response.message);
		}
	});
};
// Display the recently voter's in card
const displayRecentlyVotes = (data) => {
	let recentlyVoteData = ``;
	if(typeof data === 'object' && data !== null && data.length > 0) {
		Object.keys(data).forEach(key => {
			recentlyVoteData += `<tr>
				<td>
					${data[key].status == '0' ?
	        	`<a href="javascript:void(0)" class="badge text-bg-success opacity-4 rounded-5 text-decoration-none text-white status-btn" title="verified">Verified</a>` :
	    		data[key].status == '1' ?
	        	`<a href="javascript:void(0)" class="badge text-bg-secondary opacity-4 rounded-5 text-decoration-none text-white status-btn" title="pending">Pending</a>` :
	        	data[key].status == '2' ?
	        	`<a href="javascript:void(0)" class="badge text-bg-danger opacity-4 rounded-5 text-decoration-none text-white status-btn" title="spam">Spam</a>` :
	    		''}
				</td>
				<td>${boldLastPart(data[key].referrence_no)}</td>
				<td>₱ ${data[key].votePoint.amount}</td>
				<td>${data[key].contact_no}</td>
				<td>${data[key].created_at}</td>
			</tr>`;
		});
	} else {
		recentlyVoteData += `<tr>
			<td colspan="5"><h6 class="text-center text-secondary mt-2">No record found. <i class="fa-solid fa-face-sad-tear"></i></h6></td>
		</tr>`;
	}

	$('#recentlyDataTableBody').html(recentlyVoteData);
};

// Get the issue reports
const getTicketReports = (limit, offset) => {
  $.ajax({
    url: `/api/${APP_VERSION}/admin/manage/ticket/reports/limit/records/${limit}/${offset}`,
    method: 'get',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
    success: (data) => {
			ticketReportsListGroup(data);
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};
const ticketReportsListGroup = (data) => {
	let dashboardReportDataBody = `<div class="list-group">`;
	if(typeof data === 'object' && data !== null && data.length > 0) {
		Object.keys(data).forEach(key => {
			dashboardReportDataBody += `
				<a href="#" class="list-group-item list-group-item-action d-flex gap-2 py-2 border-0" aria-current="true">
					<img src="/wp-content/admin/uploads/profile.jpg" alt="img" width="32" height="32" class="rounded-circle flex-shrink-0">
					<div class="d-flex gap-2 w-100 justify-content-between">
						<div>
							<h6 class="mb-0">From: ${data[key].email}</h6>
							<p class="mb-0 opacity-75">${data[key].message}</p>
						</div>
						<small class="opacity-50 text-nowrap">New</small>
					</div>
				</a>
				<hr class="text-muted"/>
			`;
		});
	} else {
		dashboardReportDataBody += `
			<a href="#" class="list-group-item list-group-item-action text-center" aria-current="true" style="background: transparent;">
				<h6 class="text-center text-secondary mt-2">No record found. <i class="fa-solid fa-face-sad-tear"></i></h6>
			</a>
		`;
	}
	dashboardReportDataBody += `</div>`;

	$('#dashboardReportDataBody').html(dashboardReportDataBody);
};

