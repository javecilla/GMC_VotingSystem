"use-strict";

const DASHBOARD_URI = 'admin/dashboard';
const DASHBOARD_INDEX_URI = $('#indexUri').data('iurl');
// APP_VERSION & CSRF_TOKEN (variable)-> wp-content/admin/themes/scripts/main.js

// Get the total count of the pending, verified and amount
const getPendingVerifiedTotalAmount = async () => {
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

// Get the recently voter's
const getRecentlyVoters = async (limit, offset) => {
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
			toastr.erorr(response.message);
		} 
	});
};

// Get the candidates that has most votes(points)
const getMostVotesCandidates = async (limit) => {
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
const getPageViewsPerDay = async (limit) => {
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

// Display the recently voter's in card
const displayRecentlyVotes = (data) => {
	let recentlyVoteData = ``;
	if(typeof data === 'object' && data !== null) {
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
				<td>₱ ${data[key].vote_point?.amount}</td>
				<td>${data[key].email}</td>
			</tr>`;
		});
	} else {
		recentlyVoteData += `<tr>
			<td></td>
			<td rowspan="4"><h6 class="text-center text-secondary mt-2">No record found. <i class="fa-solid fa-face-sad-tear"></i></h6></td>
			<td></td>
			<td></td>
		</tr>`;
	}

	$('#recentlyDataTableBody').html(recentlyVoteData);
};