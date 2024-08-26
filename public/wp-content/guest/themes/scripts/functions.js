"use-strict";

const appVersion = $('.main-content').data('app');
const csrfToken = $('meta[name="csrf-token"]').attr('content');
const votingTitle = $('.main-content').data('vtitle');
const INDEX_URI = $('#indexURI').val();

const getAllCandidates = () => {
	$.ajax({
		url: `/api/${encodeURIComponent(appVersion)}/candidates`,
		method: 'get',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': csrfToken },
		success: (data) => {
			displayCandidates(data);
			window.history.replaceState(null, null, INDEX_URI);
		},
		error: (xhr, status, error) => {
			const response = JSON.parse(xhr.responseText);
			toastr.error(response.message);
		}
	});
};

const getAllCategory = () => {
	$.ajax({
		url: `/api/${encodeURIComponent(appVersion)}/category`,
		method: 'get',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': csrfToken },
		success: (data) => {
			displayCategories(data);
		},
		error: (xhr, status, error) => {
			const response = JSON.parse(xhr.responseText);
			toastr.error(response.message);
		}
	});
};

const getAllAmountOfPayment = () => {
	$.ajax({
		url: `/api/${encodeURIComponent(appVersion)}/amount/vote-points`,
		method: 'get',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': csrfToken },
		success: (data) => {
			displayAmountOfPayments(data);
		},
		error: (xhr, status, error) => {
			const response = JSON.parse(xhr.responseText);
			toastr.error(response.message);
		}
	});
};

const getQRCodeOfPaymentsById = (votePointsId) => {
	$.ajax({
		url: `/api/${encodeURIComponent(appVersion)}/${encodeURIComponent(votePointsId)}/vote-points`,
		method: 'get',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': csrfToken },
		success: (data) => {
			displayQRCodeOfPayments(data);
		},
		error: (xhr, status, error) => {
			const response = JSON.parse(xhr.responseText);
			toastr.error(response.message);
		}
	});
};

const getOneCandidatesById = (candidateId) => {
	$.ajax({
		url: `/api/${encodeURIComponent(appVersion)}/${encodeURIComponent(candidateId)}/candidates`,
		method: 'get',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': csrfToken },
		success: (data) => {
			displayCandidatesById(data);
		},
		error: (xhr, status, error) => {
			const response = JSON.parse(xhr.responseText);
			toastr.error(response.message);
		}
	});
};

const getCountTotalVoters = () => {
	$.ajax({
		url: `/api/${encodeURIComponent(appVersion)}/count/all/votes`,
		method: 'get',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': csrfToken },
		success: (data) => {
			$('#totalVotes').text(data.totalVotes);
			//toastr.success(data.message);
		},
		error: (xhr, status, error) => {
			const response = JSON.parse(xhr.responseText);
			toastr.error(response.message);
		}
	});
};

const getCountTotalPageViews = () => {
	$.ajax({
		url: `/api/${encodeURIComponent(appVersion)}/count/page/views`,
		method: 'get',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': csrfToken },
		success: (data) => {
			$('#totalPageViews').text(data.totalPageViews);
			//toastr.success(data.message);
		},
		error: (xhr, status, error) => {
			const response = JSON.parse(xhr.responseText);
			toastr.error(response.message);
		}
	});
};

const filterCandidatesBySearch = (searchQuery) => {
	$.ajax({
		url: `/api/${encodeURIComponent(appVersion)}/${encodeURIComponent(searchQuery)}/search`,
		method: 'get',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': csrfToken },
		success: (data) => {
			displayCandidates(data);
		},
		error: (xhr, status, error) => {
			const response = JSON.parse(xhr.responseText);
			toastr.error(response.message);
		}
	});
};

const filterCandidatesByCategory = (categoryQuery) => {
	$.ajax({
		url: `/api/${encodeURIComponent(appVersion)}/${encodeURIComponent(categoryQuery)}/category`,
		method: 'get',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': csrfToken },
		success: (data) => {
			writeURI('category', categoryQuery);
			displayCandidates(data);
		},
		error: (xhr, status, error) => {
			const response = JSON.parse(xhr.responseText);
			toastr.error(response.message);
		}
	});
};

const storeSubmittedVotes = (dataForm) => {
	$('.loading-spinner').removeClass('d-none');
  $('.arrow-icon').addClass('d-none');
  $('#submitMyVote').css('cursor', 'no-drop').prop('disabled', true);

	$.ajax({
		url: `/api/${appVersion}/vote/client/store`,
		method: 'post',
		data: dataForm,
		dataType: 'json',
		headers: {'X-CSRF-TOKEN': csrfToken},
		success: (response) => {
			if(response.success) {
				showStep(3, dataForm.candidate_id);
				updateProgressBar(3);
				toastr.success(response.message);
			} else {
				toastr.error(response.message);
			}

			$('.loading-spinner').addClass('d-none');
		  $('.arrow-icon').removeClass('d-none');
		  $('#submitMyVote').css('cursor', 'pointer').prop('disabled', false);
			grecaptcha.reset();
		},
		error: (xhr, status, error) => {
			const response = JSON.parse(xhr.responseText);
			toastr.error(response.message);
			$('#referenceNo').val('').addClass('is-invalid');

			$('.loading-spinner').addClass('d-none');
		  $('.arrow-icon').removeClass('d-none');
		  $('#submitMyVote').css('cursor', 'pointer').prop('disabled', false);
		  grecaptcha.reset();
		}
	});
};

const storeSubmittedReport = (dataForm) => {
	runSpinner();
	$('#submitReportBtn').attr('disabled', true);
	$.ajax({
		url: `/api/${appVersion}/report/store`,
		method: 'post',
		data: dataForm,
		processData: false,
    contentType: false,
		dataType: 'json',
		headers: {'X-CSRF-TOKEN': csrfToken},
		success: (response) => {
			if(response.success) {
				$('#submitReportForm')[0].reset();
				toastr.success(response.message);
			} else {
				toastr.error(response.message);
			}

			stopSpinner();
			$('#submitReportBtn').removeAttr('disabled');
			grecaptcha.reset();
		},
		error: (xhr, status, error) => {
			const response = JSON.parse(xhr.responseText);
			toastr.error(response.message);
			stopSpinner();
			$('#submitReportBtn').removeAttr('disabled');
			grecaptcha.reset();
		}
	});
};

// Functions displays components
const displayCandidates = (data) => {
	let dataListofCandidatesItem = `<div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 ">`;
		if(typeof data === 'object' && data !== null) {
			Object.keys(data).forEach(key => {
				dataListofCandidatesItem += `
					<div class="col">
				    <div class="card card-cover h-100 overflow-hidden border-0 text-bg-dark rounded-4 shadow-lg"
				      style="background-image: url(${data[key].image}); height: 65vh!important;">
				      <div id="cardOverlay" class="d-flex flex-column h-100 p-4 pb-3 text-white text-shadow-1">
				        <h4 class="pt-5 mt-5 mb-5 display-6 lh-1"></h4>
				          <ul class="d-flex list-unstyled mt-auto">
				            <li class="me-auto" style="margin-top: 5px">
				            <a href="javascript:void(0)" class="btn btn-light" id="showCandidateOpenModal"
				            	data-id="${data[key].cdid}"
				            	data-name="${data[key].name}"
				            	data-no="${data[key].candidate_no}"
				            	data-bs-toggle="tooltip" data-bs-placement="bottom"
									   	data-bs-custom-class="custom-tooltip"
									   	data-bs-title="View more information">
				            	<i class="fa-solid fa-eye text-muted"></i>
				            </a>
				            <a href="javascript:void(0)" class="btn btn-primary" id="castVoteOpenModal"
				            	data-id="${data[key].cdid}"
				            	data-name="${data[key].name}"
				            	data-no="${data[key].candidate_no}"
				             	data-bs-toggle="tooltip" data-bs-placement="bottom"
									    data-bs-custom-class="custom-tooltip"
									    data-bs-title="Cast vote for this candidate">
				              Vote
				            </a>
				          </li>
				          <li class="d-flex align-items-center me-1">
				            <label class="fw-bold"  style="font-size: 20px;">
                      <span id="candidateNameText">${data[key].name}</span>
                    </label>
				          </li>
				        </ul>
				      </div>
				    </div>
			   </div>
			`;
		});
	} else {
		dataListofCandidatesItem += `
	    <center class="mt-3">
	      <div class="text-muted mt-3">
	        <i class="fa-solid fa-face-sad-tear  fs-4"></i>
	        <span class="fs-4">&nbsp; No record found.</span>
	      </div>
	    </center>
    `;
	}
	dataListofCandidatesItem += `</div>`;

	$('#dataListOfCandidatesBody').html(dataListofCandidatesItem);
};

const displayCategories = (data) => {
	let dataListofCategoriesItem = `<ul class="dropdown-menu dropdown-menu-dark">
		<a class="dropdown-item active" onclick="getAllCandidates()" style="cursor: pointer"><li>All Candidates</li></a>
		<li><hr class="dropdown-divider"></li>`;
	if(Array.isArray(data) && data.length > 0) {
		Object.keys(data).forEach(key => {
			dataListofCategoriesItem += `<a class="dropdown-item"
				onclick="filterCandidatesByCategory('${data[key].ctid}')" style="cursor: pointer">
				<li>${data[key].name}</li></a>
			`;
		});
	} else {
		dataListofCategoriesItem += `<a class="dropdown-item disabled" href="#" style="cursor: default"><li>No record found.</li></a>`;
	}
	dataListofCategoriesItem += `</ul>`;

	$('#dataListOfCategoriesBody').html(dataListofCategoriesItem);
};

const displayAmountOfPayments = (data) => {
	let dataListOfAmountPaymentItem = `
		<div class="list-group form-control" id="amtOfPayment">
			<button class="list-group-item list-group-item-action" type="button" aria-current="true" disabled>
				<strong>Choose Amount of payment</strong>
			</button>
		`;

	if(Array.isArray(data) && data.length > 0) {
		Object.keys(data).forEach(key => {
			dataListOfAmountPaymentItem += `<button class="list-group-item list-group-item-action"
				id="amountPaymentButtonSelected"
				data-id="${data[key].vpid}"
				type="button">₱${data[key].amount} <i class="fa-solid fa-arrow-right"></i>
				${data[key].point} vote points
				</button>
			`;
		});
	} else {
		dataListOfAmountPaymentItem += `<button class="list-group-item list-group-item-action"
				type="button">No record found.</button>`;
	}
	dataListOfAmountPaymentItem += `</div>
		<div class="invalid-feedback amtOfPaymentError"></div>
	`;


	$('#dataListOfAmountPaymentBody').html(dataListOfAmountPaymentItem);
};

const displayQRCodeOfPayments = (data) => {
	let dataQRCodePreviewItem = `<div class="card cardAuto">`;
	if(typeof data === 'object' && data !== null) {
		dataQRCodePreviewItem += `<div id="dataQRCodePreviewBody">
			<div class="card cardAuto">
				<img src="${data.image}" alt="No selected amount of payment." id="qrCodeImage" class="img-card-top" loading="lazy"/>
			</div>
		</div>`;
	} else {
		dataQRCodePreviewItem += `<div class="card cardAuto">
			<img src="..." alt="..." id="qrCodeImage" class="img-card-top" />
		</div>`;
	}
	dataQRCodePreviewItem += `</div>`;

	$('#dataQRCodePreviewBody').html(dataQRCodePreviewItem);
};

const displayCandidatesById = (data) => {

	if(typeof data === 'object' && data !== null) {
		$('#showCardCandidateImage').css('background-image', `url(${data.image})`);
		$('#totalCurrentVotePoints').text(data.totalPoints);
		$('#totalVerifiedVoters').text(data.totalVotes);
		$('#candidateNameShow').val(data.name);
		$('#candidateCampusShow').val(data.campus.name);
		$('#candidateCategoryShow').val(data.category.name);
	} else {
		toastr.error("Something went wrong!");
	}
};