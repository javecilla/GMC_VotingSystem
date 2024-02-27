"use-strict";

const DASHBOARD_URI = 'admin/dashboard';
const DASHBOARD_INDEX_URI = $('#indexUri').data('iurl');
// APP_VERSION & CSRF_TOKEN (variable)-> wp-admin/themes/scripts/main.js

const getMostVotesCandidates = async (limit) => {
	$.ajax({
		url: `/${APP_VERSION}/${DASHBOARD_URI}/most/votes/candidates/limit/${limit}`,
		method: 'get',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
		success: (data) => {
			//console.log(data);
			const candidatesNames = data.map(candidate => candidate.candidate.name);
			const totalVotePoints = data.map(candidate => candidate.total_points);

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

const getPendingVerifiedTotalAmount = async () => {
	$.ajax({
		url: `/${APP_VERSION}/${DASHBOARD_URI}/count/all`,
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

const getRecentlyVoters = async (limit, offset) => {
	$.ajax({
		url: `/${APP_VERSION}/${DASHBOARD_URI}/load/limit/${limit}/offset/${offset}`,
		method: 'get',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
		success: (data) => {
			//console.log(data);
			displayRecentlyVotes(data);
		},
		erorr: (xhr, status, error) => {
			const response = JSON.parse(xhr.responseText);
			toastr.erorr(response.message);
		} 
	});
};

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
 

const getDataPageViews = async () => {
	const ctxPageViews = $('#pageViewChart');
  new Chart(ctxPageViews, {
    type: 'line',
    data: {
      labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7'],
      datasets: [{
        label: '# Page Views by Day',
        data: [50, 75, 100, 120, 90, 110, 130],
        fill: true, // To make it a line instead of an area
        borderColor: '#363b42', // Set your custom color here
        borderWidth: 2,
        pointBackgroundColor: '#363b42', // Set your custom color for data points
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
};