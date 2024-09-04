"use-strict";

const VOTES_URI = 'admin/manage/votes';
const VOTES_INDEX_URI = $('#indexUri').data('iurl');
// APP_VERSION & CSRF_TOKEN (variable)-> wp-content/admin/themes/scripts/main.js

// const getAllVotes = () => {
// 	$.ajax({
// 		url: `/api/${APP_VERSION}/${VOTES_URI}/all/records`,
// 		method: 'get',
// 		dataType: 'json',
// 		headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
// 		success: (data) => {
// 			window.history.replaceState(null, null, VOTES_INDEX_URI);
// 			$('#cardLabelTxt').text('List of All Votes');
// 			$('.spam, .verified, .pending').removeClass('active');
// 			$('.all').addClass('active');
// 			displayAllVotes(data);
// 		},
// 		error: (xhr, status, error) => {
// 			const response = JSON.parse(xhr.responseText);
// 			toastr.error(response.message);
// 		}
// 	});
// };

const loadMoreVotesRecord = (limit, offset) => {
	$.ajax({
		url: `/api/${APP_VERSION}/${VOTES_URI}/limit/records/${limit}/${offset}`,
		method: 'get',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
		success: (data) => {
			//kapag ang offset is greater than 0, prev button will be undisabled
			if (offset > 0) {
        $('#prevPaginateBtn').removeAttr('disabled');
     	} else {
     		//otherwise, it will be disabled
     		$('#prevPaginateBtn').attr('disabled', true);
     	}

			// If the number of records fetched is less than the limit, disable the next button
      if (data.length < limit) {
        $('#nextPaginateBtn').attr('disabled', true);
      } else {
        $('#nextPaginateBtn').removeAttr('disabled');
      }

			$('#cardLabelTxt').text('List of All Votes');
			$('.spam, .verified, .pending').removeClass('active');
			$('.all').addClass('active');

			displayAllVotes(data);
		},
		error: (xhr, status, error) => {
			const response = JSON.parse(xhr.responseText);
			toastr.error(response.message);
		}
	});
};

const getOneVotes = (votes) => {
	$.ajax({
		url: `/api/${APP_VERSION}/${VOTES_URI}/id/${votes}`,
		method: 'get',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
		success: (response) => {
			displayOneVotes(response);
			displayEditFormVotes(response);
		},
		error: (xhr, status, error) => {
			const response = JSON.parse(xhr.responseText);
			toastr.error(response.message);
		}
	});
};

const countAllVotes = () => {
	$.ajax({
		url: `/api/${APP_VERSION}/${VOTES_URI}/count/pending/verified/spam`,
		method: 'get',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
		success: (counted) => {
			$('#totalAllPending').text(counted.pending);
			$('#totalVerifiedVotes').text(counted.verified);
			$('#totalSpamVotes').text(counted.spam);
		},
		error: (xhr, status, error) => {
			const response = JSON.parse(xhr.responseText);
			toastr.error(response.message);
		}
	});
};

const filterVotesByStatus = (status) => {
	$.ajax({
		url: `/api/${APP_VERSION}/${VOTES_URI}/status/${status}`,
		method: 'get',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': VOTES_URI },
		success: (data) => {
			if(status == 0) {
				writeURI('status', 'verified');
				$('#cardLabelTxt').text('List of All Verified Votes');
				$('.all, .pending, .spam').removeClass('active');
				$('.verified').addClass('active');
			} else if(status == 1) {
				writeURI('status', 'pending');
				$('#cardLabelTxt').text('List of All Pending Votes');
				$('.all, .verified, .spam').removeClass('active');
				$('.pending').addClass('active');
			} else if(status == 2) {
				writeURI('status', 'spam');
				$('#cardLabelTxt').text('List of All Spam Votes');
				$('.all, .verified, .pending').removeClass('active');
				$('.spam').addClass('active');
			} else {
				writeURI('', '');
				$('#cardLabelTxt').text('');
				$('.spam, .verified, .pending').removeClass('active');
				$('.all').addClass('active');
			}

			displayAllVotes(data);
		},
		error: (xhr, status, error) => {
			const response = JSON.parse(xhr.responseText);
			toastr.error(response.message);
		}
	});
};

const filterVotesBySearch = (search) => {
	$.ajax({
		url: `/api/${APP_VERSION}/${VOTES_URI}/search/${search}`,
		method: 'get',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': VOTES_URI },
		success: (data) => {
			displayAllVotes(data);
		},
		error: (xhr, status, error) => {
			const response = JSON.parse(xhr.responseText);
			toastr.error(response.message);
		}
	});
};

const getTotalOfSummaryVotes = () => {
	$.ajax({
		url: `/api/${APP_VERSION}/${VOTES_URI}/summary`,
		method: 'get',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
		success: (data) => {
			let summaryOfVotesData = ``;
			if(typeof data === 'object' && data !== null && data.length  > 0) {
				Object.keys(data).forEach(key => {
					summaryOfVotesData += `
						<tr>
							<td>${data[key].candidate_no}</td>
							<td>${data[key].category}</td>
							<td>${data[key].candidate_name}</td>
							<td>${data[key].total_current_points}</td>
						</tr>
					`;
				});
			} else {
				summaryOfVotesData += `
					<tr>
			  		<td colspan="4">
							<h4 class="text-center text-secondary mt-2">{{ __('No Record Found.') }} <i class="fa-solid fa-face-sad-tear"></i></h4>
						</td>
					</tr>
				`;
			}

			$('#summaryOfVotesData').html(summaryOfVotesData);
		},
		error: (xhr, status, error) => {
			const response = JSON.parse(xhr.responseText);
			toastr.error(response.message);
		}
	});
};

const createNewVote = (dataForm) => {
	runSpinner();
	$.ajax({
		url: `/api/${APP_VERSION}/${VOTES_URI}/store`,
		method: 'post',
		data: dataForm,
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
		success: (response) => {
			if(response.success) {
				loadMoreVotesRecord(30, 0);
				writeURI('page', 1);
				$('#candidateSelected').val('');
				$('#amountSelected').val('');
				$('#votersContact').val(generatePhoneNumber());
				$('#referrenceNo').val(generateReferrenceNo());
				toastr.success(response.message);
			} else {
				toastr.warning(response.message);
			}

			stopSpinner();
		},
		error: (xhr, status, error) => {
			const response = JSON.parse(xhr.responseText);
			toastr.error(response.message);
			stopSpinner();
		}
	});
};

const updateVotes = (votes, dataForm) => {
	runSpinner();
	$.ajax({
		url: `/api/${APP_VERSION}/${VOTES_URI}/id/${votes}/update`,
		method: 'patch',
		data: dataForm,
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
		success: (response) => {
			if(response.success) {
				loadMoreVotesRecord(30, 0);
			writeURI('page', 1);
				toastr.success(response.message);
			} else {
				if(response.type === 'info') {
          toastr.info(response.message);
        } else if(response.type === 'warning') {
          toastr.warning(response.message);
        } else {
          toastr.error(response.message);
        }
			}

			stopSpinner();
		},
		error: (xhr, status, error) => {
			const response = JSON.parse(xhr.responseText);
			toastr.error(response.message);
			stopSpinner();
		}
	});
};

const updateVotesByStatus = (votes, status) => {
	$.ajax({
		url: `/api/${APP_VERSION}/${VOTES_URI}/id/${votes}/status/${status}/update`,
		method: 'patch',
		data: {
			'vid': votes,
			'status': status
		},
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
		success: (response) => {
			if(response.success) {
				toastr.success(response.message);
			} else {
				toastr.error(response.message);
			}
			loadMoreVotesRecord(30, 0);
			writeURI('page', 1);
			countAllVotes();
		},
		error: (xhr, status, error) => {
			const reponse = JSON.parse(xhr.responseText);
			toastr.error(response.message);
		}

	});
};

const deleteVotes = (votes) => {
	$.ajax({
		url: `/api/${APP_VERSION}/${VOTES_URI}/id/${votes}/destroy`,
		method: 'delete',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
		success: (response) => {
			if(response.success) {
				$(`.votesItem_${votes}`).remove();
				loadMoreVotesRecord(limit, offset);
			writeURI('page', page);
				countAllVotes();
				toastr.success(response.message);
			} else {
				toastr.warning(response.message);
			}
		},
		error: (xhr, status, error) => {
			const response = JSON.parse(xhr.responseText);
			toastr.error(response.message);
		}
	});
};

// @Function that display data
const displayAllVotes = (data) => {
	let votesRecordsItem = ``;
	if(typeof data === 'object' && data !== null && data.length > 0) {
		Object.keys(data).forEach(key => {
			votesRecordsItem += `<tr class="votesItem_${data[key].vid}">
				<td>₱ ${data[key].votePoint?.amount}.00</td>
				<td>${data[key].votePoint?.point}</td>
				<td>${boldLastPart(data[key].referrence_no)}</td>
				<td>
					${(data[key].status == 0 ? `<a href="javascript:void(0)" data-id="${data[key].vid}" data-status="1" class="updateStatusBtn badge text-bg-success opacity-4 rounded-5 text-decoration-none text-white status-btn" title="verified">Verified</a>` :
					(data[key].status == 1 ? `<a href="javascript:void(0)" data-id="${data[key].vid}" data-status="0" class="updateStatusBtn badge text-bg-secondary opacity-4 rounded-5 text-decoration-none text-white status-btn" title="pending">Pending</a>` :
					(data[key].status == 2 ? `<a href="javascript:void(0)" data-id="${data[key].vid}" data-status="1" class="updateStatusBtn badge text-bg-danger opacity-4 rounded-5 text-decoration-none text-white status-btn" title="spam">Spam</a>` : '')))}
				</td>
				<td>${data[key].created_at}</td>
				<td class="text-end">
					<a href="javascript:void(0)" data-id="${data[key].vid}" title="view more information on this vote" class="viewModalBtn btn btn-primary btn-sm btn-view"><i class="fa-solid fa-eye"></i>&nbsp;</a>
					<a href="javascript:void(0)" data-id="${data[key].vid}" title="edit vote information" class="editModalBtn btn btn-secondary btn-sm btn-edit text-white"><i class="fa-solid fa-pen-to-square"></i>&nbsp;</a>
					${(data[key].status == 0 ? `<a href="javascript:void(0)" id="verifiedBtn" data-id="${data[key].vid}" title="this vote is verified" class="btn btn-ligth btn-sm btn-verified" style="border: 1px solid #f5f5f5;"><i class="fa-solid fa-circle-check"></i>&nbsp;</a>` :
						(data[key].status == 1 ? `<a href="javascript:void(0)" id="spamBtn" data-status="2" data-id="${data[key].vid}" title="flag this vote if you think this is spam" class="btn btn-danger btn-sm btn-spam"><i class="fa-solid fa-circle-minus"></i>&nbsp;</a>` :
						(data[key].status == 2 ? `<a href="javascript:void(0)" id="deleteBtn" data-id="${data[key].vid}" title="delete this vote permanently." class="btn btn-danger btn-sm btn-delete" style="padding-left: 13px;"><i class="fa-solid fa-trash"></i>&nbsp;</a>` : '')))}
				</td>
			</tr>`;
		});
	} else {
		votesRecordsItem += `<tr>
			<td colspan="6">
				<h4 class="text-center text-secondary mt-2">No record found. <i class="fa-solid fa-face-sad-tear"></i></h4>
			</td>
		</tr>`;
	}

	$('#votesRecordsBody').html(votesRecordsItem);
};

const displayOneVotes = (data) => {
	$('.votersName').val(data.email);
	$('.votersContact').val(data.contact_no);
	$('.candidateName').val(data.candidate.name);
	$('.candidateNo').val(data.candidate.candidate_no);
	$('.voteAmount').val(data.votePoint.amount);
	$('.votePoint').val(data.votePoint.point);
	$('.referrenceNo').val(data.referrence_no);
	$('.createdAt').val(data.created_at);
	$('.updatedAt').val(data.updated_at);
};

const displayEditFormVotes = (data) => {
	$('#activeCandidate').val(data.candidate.name);
	$('#activeAmount').val(data.votePoint.amount);
	$('#editVotersName').val(data.email);
	$('#editVotersContact').val(data.contact_no);
	$('#editReferrenceNo').val(data.referrence_no);
	$('#vid').val(data.vid);
};