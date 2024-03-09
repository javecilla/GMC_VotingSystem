"use-strict";

const VOTES_URI = 'admin/manage/votes';
const VOTES_INDEX_URI = $('#indexUri').data('iurl');
// APP_VERSION & CSRF_TOKEN (variable)-> wp-content/admin/themes/scripts/main.js

const getAllVotes = async () => {
	$.ajax({
		url: `/api/${APP_VERSION}/${VOTES_URI}/all/records`,
		method: 'get',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
		success: (data) => {
			window.history.replaceState(null, null, VOTES_INDEX_URI);
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

const loadMoreVotesRecord = async (limit, offset) => {
	$.ajax({
		url: `/api/${APP_VERSION}/${VOTES_URI}/limit/records/${limit}/${offset}`,
		method: 'get',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
		success: (data) => {
			//kapag ang offset is greater than 0, prev button will be undisabled
			if (offset > 0) {
				window.history.replaceState(null, null, VOTES_INDEX_URI);
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

			displayAllVotes(data);
		},
		error: (xhr, status, error) => {
			const response = JSON.parse(xhr.responseText);
			toastr.error(response.message);
		}
	});
};

const getOneVotes = async (votes) => {
	$.ajax({
		url: `/api/${APP_VERSION}/${VOTES_URI}/id/${votes}`,
		method: 'get',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
		success: (data) => {
			displayOneVotes(data);
			displayEditFormVotes(data);
		},
		error: (xhr, status, error) => {
			const response = JSON.parse(xhr.responseText);
			toastr.error(response.message);
		}
	});
};

const countAllVotes = async () => {
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

const filterVotesByStatus = async (status) => {
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

const filterVotesBySearch = async (search) => {
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

const createNewVote = async (dataForm) => {
	runSpinner();
	$.ajax({
		url: `/api/${APP_VERSION}/${VOTES_URI}/store`,
		method: 'post',
		data: dataForm,
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
		success: (response) => {
			if(response.success) {
				getAllVotes();
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

const updateVotes = async (votes, dataForm) => {
	runSpinner();
	$.ajax({
		url: `/api/${APP_VERSION}/${VOTES_URI}/id/${votes}/update`,
		method: 'patch',
		data: dataForm,
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
		success: (response) => {
			if(response.success) {
				getAllVotes();
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

const updateVotesByStatus = async (votes, status) => {
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
			getAllVotes();
			countAllVotes();
		},
		error: (xhr, status, error) => {
			const reponse = JSON.parse(xhr.responseText);
			toastr.error(response.message);
		}

	});
};

const deleteVotes = async (votes) => {
	$.ajax({
		url: `/api/${APP_VERSION}/${VOTES_URI}/id/${votes}/destroy`,
		method: 'delete',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
		success: (response) => {
			if(response.success) {
				$(`.votesItem_${votes}`).remove();
				getAllVotes();
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

	if(Array.isArray(data) && data.length > 0) {
		Object.keys(data).forEach(key => {
			votesRecordsItem += `<tr class="votesItem_${data[key].vid}">
				<td>${data[key].vid}</td>
				<td>${data[key].candidate?.cdid}</td>
				<td>₱ ${data[key].vote_point?.amount}</td>
				<td>${data[key].vote_point?.point}</td>
				<td>${boldLastPart(data[key].referrence_no)}</td>
				<td>
					${data[key].status == '0' ? //verified(0)->pending(1)
        		`<a href="javascript:void(0)" data-id="${data[key].vid}" data-status="1" class="updateStatusBtn badge text-bg-success opacity-4 rounded-5 text-decoration-none text-white status-btn" title="verified">Verified</a>` :
    			data[key].status == '1' ? //pending(1)->verified(0)
        		`<a href="javascript:void(0)" data-id="${data[key].vid}" data-status="0" class="updateStatusBtn badge text-bg-secondary opacity-4 rounded-5 text-decoration-none text-white status-btn" title="pending">Pending</a>` :
        	data[key].status == '2' ? //spam(2)->pending(1)
        		`<a href="javascript:void(0)" data-id="${data[key].vid}" data-status="1" class="updateStatusBtn badge text-bg-danger opacity-4 rounded-5 text-decoration-none text-white status-btn" title="spam">Spam</a>` :
    			''}
				</td>
				<td>${data[key].contact_no}</td>
				<td>${formatDate(data[key].created_at)}</td>
				<td class="text-end">
				<a href="javascript:void(0)" data-id="${data[key].vid}" title="view more information on this vote" class="viewModalBtn btn btn-primary btn-sm btn-view">
					<i class="fa-solid fa-eye"></i>&nbsp;
				</a>
				<a href="javascript:void(0)" data-id="${data[key].vid}" title="edit vote information" class="editModalBtn btn btn-secondary btn-sm btn-edit text-white">
					<i class="fa-solid fa-pen-to-square"></i>&nbsp;
				</a>
				${data[key].status == '0' ? //verified(0)->pending(1)
					`<a href="javascript:void(0)" id="verifiedBtn" data-id="${data[key].vid}" title="this vote is verified" class="btn btn-ligth btn-sm btn-verified" style="border: 1px solid #f5f5f5;">
						<i class="fa-solid fa-circle-check"></i>&nbsp;
					</a>` :
					data[key].status == '1' ? //pending(1)->spam(2)
					`<a href="javascript:void(0)" id="spamBtn" data-status="2" data-id="${data[key].vid}" title="flag this vote if you think this is spam" class="btn btn-danger btn-sm btn-spam">
						<i class="fa-solid fa-circle-minus"></i>&nbsp;
					</a>` : 
					data[key].status == '2' ? //spam(2)->delete()
					`<a href="javascript:void(0)" id="deleteBtn" data-id="${data[key].vid}" title="delete this vote permanently." class="btn btn-danger btn-sm btn-delete" style="padding-left: 13px;">
						<i class="fa-solid fa-trash"></i>&nbsp;
					</a>` :
					''				
				}
			</td>
		</tr>`;
		});
	
	} else {
		votesRecordsItem += `<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td rowspan="9">
				<h4 class="text-center text-secondary mt-2">No record found. <i class="fa-solid fa-face-sad-tear"></i></h4>
			</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>`;
	}

	$('#votesRecordsBody').html(votesRecordsItem);
};

const displayOneVotes = (data) => {
	let showVoteData = ``;

	if(Array.isArray(data) && data.length > 0) {
		Object.keys(data).forEach(key => {
			showVoteData += `
				<div class="row mt-2">
		      <div class="col-sm-3"><label for="votersName" class="col-form-label fw-bold">Voters Info</label></div>
		      <div class="col-sm-9">
		      	<div class="row">
		      		<div class="col-md-6">
		      			<small class="text-muted">Email</small>
		      			<input type="text" class="form-control w-100"  id="votersName" value="${data[key].email}" readonly/>
		      		</div>
		      		<div class="col-md-6">
		      			<small class="text-muted">Contact no.</small>
		      			<input type="text" class="form-control w-100"  id="votersContact" value="${data[key].contact_no}" readonly/>
		      		</div>
		      	</div>
		      </div>
		    </div>
		    <hr class="text-muted"/>
		    <div class="row mt-2">
		     	<div class="col-sm-3">
		        <label for="candidates" class="col-form-label fw-bold">Candidate Info</label>
		      </div>
		     	<div class="col-sm-9" id="candidateSelectDataBody">
		     		<div class="row">
		      		<div class="col-md-6">
		      			<small class="text-muted">Name</small>
		      			<input type="text" class="form-control w-100"  id="candidateName" value="${data[key].candidate?.name}" readonly/>
		      		</div>
		      		<div class="col-md-6">
		      			<small class="text-muted">Number</small>
		      			<input type="text" class="form-control w-100"  id="candidateNo" value="${data[key].candidate.candidate_no}" readonly/>
		      		</div>
		      	</div>
		      </div>
		    </div>

		    <div class="row mt-2">
		      <div class="col-sm-3">
		       	<label for="candidates" class="col-form-label fw-bold">Amount & Points</label>
		      </div>
		      <div class="col-sm-9" id="voteAmountSelectDataBody">
		      	<div class="row">
		      		<div class="col-md-6">
		      			<small class="text-muted">Amount</small>
		      			<input type="text" class="form-control w-100" id="voteAmount" value="${data[key].vote_point?.amount}" readonly/>
		      		</div>
		      		<div class="col-md-6">
		      			<small class="text-muted">Points</small>
		      			<input type="text" class="form-control w-100" id="votePoint" value="${data[key].vote_point?.point}" readonly/>
		      		</div>
		      	</div>
		      </div>
		   	</div>

		   	<div class="row mt-2">
		      <div class="col-sm-3">
		       	<label for="votersContact" class="col-form-label fw-bold">Referrence no.</label>
		      </div>
		      <div class="col-sm-9">
		        <input type="text" class="form-control w-100" id="referrenceNo" value="${data[key].referrence_no}" readonly/>
		      </div>
		    </div>
		    <hr class="text-muted"/>

		    <div class="row mt-2">
		      <div class="col-sm-3">
		       	<label for="candidates" class="col-form-label fw-bold">Timestamps</label>
		      </div>
		      <div class="col-sm-9" id="voteAmountSelectDataBody">
		      	<div class="row">
		      		<div class="col-md-6">
		      			<small class="text-muted">Voted at</small>
		      			<input type="text" class="form-control w-100" id="createdAt" value="${formatDate(data[key].created_at)}" readonly/>
		      		</div>
		      		<div class="col-md-6">
		      			<small class="text-muted">Update at</small>
		      			<input type="text" class="form-control w-100" id="updatedAt" value="${formatDate(data[key].updated_at) ?? 'No changes occured'}" readonly/>
		      		</div>
		      	</div>
		      </div>
		   	</div>
			`;
		});
	
	} else {
		showVoteData += `<h4 class="text-center text-secondary mt-2">No record found. <i class="fa-solid fa-face-sad-tear"></i></h4>`;
	}

	$('#showVotesRecordsBody').html(showVoteData);
};

const displayEditFormVotes = (data) => {
	if(Array.isArray(data) && data.length > 0) {
		Object.keys(data).forEach(key => {
			$('#activeCandidate').val(data[key].candidate?.name);
			$('#activeAmount').val(data[key].vote_point?.amount);
			$('#editVotersName').val(data[key].email);
			$('#editVotersContact').val(data[key].contact_no);
			$('#editReferrenceNo').val(data[key].referrence_no);
			$('#vid').val(data[key].vid);
		});
	}
};
