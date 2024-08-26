"use-strict";

const CANDIDATES_URI = 'admin/manage/candidates';
const CANDIDATES_INDEX_URI = $('#indexUri').data('iurl');
// APP_VERSION & CSRF_TOKEN (variable)-> wp-content/admin/themes/scripts/main.js

// Get all candidates (Without limit)
const getAllCandidates = async () => {
  $.ajax({
    url: `/api/${APP_VERSION}/${CANDIDATES_URI}/all/records`,
    method: 'get',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
    success: (data) => {
      displayAllCandidates(data);
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

// Get candidates (With limit)
const loadMoreCandidatesRecord = async (limit, offset) => {
  $.ajax({
    url: `/api/${APP_VERSION}/${CANDIDATES_URI}/limit/records/${limit}/${offset}`,
    method: 'get',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
    success: (response) => {
      //console.log(response);
      if (offset > 0) { //kapag ang offset is greater than 0, prev button will be undisabled
        $('#prevPaginateBtn').removeAttr('disabled');
      } else {  //otherwise, it will be disabled
        $('#prevPaginateBtn').attr('disabled', true);
      }

      // If the number of records fetched is less than the limit, disable the next button
      if (response.length < limit) {
        $('#nextPaginateBtn').attr('disabled', true);
      } else {
        $('#nextPaginateBtn').removeAttr('disabled');
      }

      displayLimitCandidates(response);
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

// Get data of candidates by its id
const getOneCandidates = async (candidate) => {
  $.ajax({
    url: `/api/${APP_VERSION}/${CANDIDATES_URI}/id/${candidate}`,
    method: 'get',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
    success: (response) => {
      displayCandidatesInformation(response);
      displayCandidatesVoteRecords(response);
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

// Filter candidates by search (name)
const filterCandidatesBySearch = async (search) => {
  $.ajax({
    url: `/api/${APP_VERSION}/${CANDIDATES_URI}/search/${search}`,
    method: 'get',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
    success: (response) => {
      displayLimitCandidates(response);
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

// Filter candidates by category
const filterCandidatesByCategory = async (category) => {
  writeURI('category', category);

  $.ajax({
    url: `/api/${APP_VERSION}/${CANDIDATES_URI}/category/${category}`,
    method: 'get',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
    success: (response) => {
      displayLimitCandidates(response);
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

// Get overall candidates ranking
const getOverallCandidatesRanking = async (limit) => {
  $.ajax({
    url: `/api/${APP_VERSION}/${CANDIDATES_URI}/ranking/overall/${limit}`,
    method: 'get',
    dataType: 'json',
    headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
    success: (response) => {

      displayCandidatesOverallRankingChart(response);
      displayCandidatesOverallRankingSidebar(response);
    },
    erorr: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

// Get the candidates ranking for each category
const getCandidatesRankingByCategory = async (limit) => {
  $.ajax({
    url: `/api/${APP_VERSION}/${CANDIDATES_URI}/ranking/category/${limit}`,
    method: 'get',
    dataType: 'json',
    headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
    success: (response) => {
      displayCandidatesRankingPerCategory(response);
    },
    erorr: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

// Create new candidate records
const createNewCandidate = async (formData) => {
  runSpinner();

  $.ajax({
    url: `/api/${APP_VERSION}/${CANDIDATES_URI}/store`,
    method: 'post',
    data: formData,
    processData: false,
    contentType: false,
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
    success: (response) => {
      if(response.success) {
        $('#createCandidateForm')[0].reset();

        $('#removeImageButton').addClass('d-none');
        $('#imageLabel').removeClass('d-none');
        $('#cardCandidateImage').css('background-image', `url('/wp-content/admin/uploads/noimg-yet.PNG')`);
        $('#candidateNameText').text('Candidate Name');
        $('#candidateNoText').text('00');
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

// Update the candidates
const updateCandidates = async (cdid, formData) =>  {
  runSpinner();
  $.ajax({
    url: `/api/${APP_VERSION}/${CANDIDATES_URI}/id/${cdid}/update`,
    method: 'post',
    data: formData,
    processData: false,
    contentType: false,
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': CSRF_TOKEN,
      'X-HTTP-Method-Override': 'patch'
    },
    success: (response) => {
      if(response.success) {
        $('#removeImageButton').addClass('d-none');
        $('#imageLabel').removeClass('d-none');
        $('#editCandidateImage').val('');
        getOneCandidates(cdid);
        loadMoreCandidatesRecord(9, 0);
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

// Delete the candidates
const deleteCandidate = async (cdid) => {
  $.ajax({
    url: `/api/${APP_VERSION}/${CANDIDATES_URI}/id/${cdid}/destroy`,
    method: 'delete',
    dataType: 'json',
    headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
    success: (response) => {
      if(response.success) {
        $(`.candidatesItem_${cdid}`).remove();
        getAllCandidates();
        loadMoreCandidatesRecord(9, 0);
        toastr.success(response.message);
      } else {
        toastr.erorr(response.message);
      }
    },
    error: (xhr, status, erorr) => {
      const response = JSON.parse(xhr.responseText);
      toastr.erorr(response.message);
    }
  })
};

//--------------function display helpers--------------//

const displayAllCandidates = (data) => {
  let candidatesInSelect = `<select class="form-select candidateSelected"><option value="" id="selectedCandidate" selected>-- SELECT --</option>`;
  if(typeof data === 'object' && data !== null) {
    Object.keys(data).forEach(key => {
      candidatesInSelect += `<option data-name="${data[key].name}" class="optionDataCandidate_${data[key].cdid}" value="${data[key].cdid}">${data[key].name}</option>`;
    });
  } else {
  	candidatesInSelect += `<option value="">No record found</option>`;
  }

  candidatesInSelect += `</select><div class="invalid-feedback candidateIdError"></div>`;

  $('.candidateSelectDataBody').html(candidatesInSelect);
};

const displayLimitCandidates = (data) => {
  let candidatesDataBody = `<div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-1">`;
  if(typeof data === 'object' && data !== null && data.length > 0) {
    Object.keys(data).forEach(key => {
      candidatesDataBody += `
        <div class="col candidatesItem_${data[key].cdid}">
          <div class="card card-cover h-100 overflow-hidden border-0 text-bg-dark rounded-4 shadow-lg" style="background-image: url('${data[key].image}'); height: 60vh!important;">
            <div id="cardOverlay" class="d-flex flex-column h-100 p-4 pb-3 text-white text-shadow-1">
              <h4 class="pt-5 mt-5 mb-5 display-6 lh-1"></h4>
              <ul class="d-flex list-unstyled mt-auto">
                <li class="me-auto" style="margin-top: 5px">
                  <a href="javascript:void(0)" class="button-links d-flex align-items-center text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-ellipsis button-links-icon"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                    <a data-id="${data[key].cdid}" class="dropdown-item viewCandidateButton"  href="javascript:void(0)">
                      <i class="fa-solid fa-eye"></i>&nbsp; View</li>
                    </a>
                    <a data-id="${data[key].cdid}" class="editCandidateButton dropdown-item" href="javascript:void(0)"><li>
                      <i class="fa-solid fa-pen-to-square"></i>&nbsp; Edit</li>
                    </a>
                    <a data-id="${data[key].cdid}" class="deleteCandidateButton dropdown-item" href="javascript:void(0)"  ><li>
                      <i class="fa-solid fa-trash"></i>&nbsp; Delete</li>
                    </a>
                  </ul>
                </li>
                <li class="d-flex align-items-center">
                  <label class="fw-bold"  style="font-size: 20px;">
                    <span id="candidateNameText">${data[key].name}</span>&nbsp;:&nbsp;
                    <span id="candidateNoText">${data[key].candidate_no}</span>
                  </label>
                </li>
              </ul>
            </div>
          </div>
        </div>
      `;
    });
  } else {
    candidatesDataBody += `<center class="mt-3 d-flex align-items-center justify-content-center text-center">
      <div class="text-muted mt-3">
        <i class="fa-solid fa-face-sad-tear  fs-4"></i><span class="fs-4">&nbsp; No record found.</span>
      </div>
    </center>`;
  }

  candidatesDataBody += `</div>`;

  $('.candidatesDataRecords').html(candidatesDataBody);
};

const displayCandidatesVoteRecords = (candidate) => {
  let candidateVotesRecords = ``;
  if(typeof candidate === 'object' && candidate !== null && candidate.votes.length > 0) {
    candidate.votes.forEach(vote => {
      candidateVotesRecords += `<tr>
        <td>${vote.vid}</td>
        <td>${vote.candidate.name}</td>
        <td>₱ ${vote.vote_point.amount}</td>
        <td>${vote.vote_point.point}</td>
        <td>${boldLastPart(vote.referrence_no)}</td>
        <td>
          ${vote.status == '0' ?
            `<a href="javascript:void(0)" class="updateStatusBtn mouse-default badge text-bg-success opacity-4 rounded-5 text-decoration-none text-white status-btn" title="verified">Verified</a>` :
          vote.status == '1' ?
            `<a href="javascript:void(0)" class="updateStatusBtn mouse-default badge text-bg-secondary opacity-4 rounded-5 text-decoration-none text-white status-btn" title="pending">Pending</a>` :
          vote.status == '2' ?
            `<a href="javascript:void(0)" class="updateStatusBtn mouse-default badge text-bg-danger opacity-4 rounded-5 text-decoration-none text-white status-btn" title="spam">Spam</a>` :
          ''}
        </td>
        <td>${formatDate(vote.created_at)}</td>
      </tr>`;
    });
  }  else {
    candidateVotesRecords += `<tr>
      <td></td>
      <td></td>
      <td></td>
      <td rowspan="7" class="text-center">
        <h4 class="text-center text-secondary mt-2">No record found. <i class="fa-solid fa-face-sad-tear"></i></h4>
      </td>
      <td></td>
      <td></td>
      <td></td>
    </tr>`;
  }

  $('#candidatesVotesRecordsBody').html(candidateVotesRecords);
};

const displayCandidatesInformation = (candidate) => {
  console.log(candidate);
  if(typeof candidate === 'object' && candidate !== null) {
    $('#totalVoters').text(candidate.totalVerified);
    $('#totalPendingVotes').text(candidate.totalPending);
    $('#totalSpamVotes').text(candidate.totalSpam);
    $('#totalAmount').text(candidate.totalAmount);
    $('#totalCurrentVotePoints').text(candidate.totalPoints);
    $('#totalOfAllVotes').text(candidate.totalVotes);

    $('#showCardCandidateImage').css('background-image', `url(${candidate.image})`);
    $('#votingVersion').val(candidate.appVersion.title);
    $('#campusCandidate').val(candidate.campus?.name);
    $('#categoryCandidate').val(candidate.category.name);
    $('#nameCandidate').val(candidate.name);
    $('#noCandidate').val(candidate.candidate_no);
    $('#candidateMottoDescription').val(candidate.motto_description);
    $('#dateCreated').val(candidate.created_at);
    $('#dateUpdated').val(candidate.updated_at);

    //edit
    $('#editCardCandidateImage').css('background-image', `url(${candidate.image})`);
    $('#editCandidateNameText').text(candidate.name);
    $('#editCandidateNoText').text(candidate.candidate_no);
    $('#editCandidateVersion').val(candidate.appVersion.name);
    $('#editCandidateCampus').val(candidate.campus?.name);
    $('#editCandidateCategory').val(candidate.category.name);
    $('#editCandidateName').val(candidate.name);
    $('#editCandidateNo').val(candidate.candidate_no);
    $('#editCandidateMottoDescription').val(candidate.motto_description);

    $('#editPrevPicture').val(candidate.image);
    $('#editActiveCandidate').val(candidate.cdid);
  }  else {
    toastr.error("Something went wrong! Failed to display candidates vote records.");
  }
};

const displayCandidatesOverallRankingChart = (data) => {
  const candidatesNames = data.map(candidate => candidate.name);
  const totalVotePoints = data.map(candidate => candidate.totalPoints);
  const totalNumberOfVoters = data.map(candidate => candidate.totalVerified);

  const ctxOverallRankingChart = $('#overallRankingChart');
  new Chart(ctxOverallRankingChart, {
    type: 'bar',
    data: {
      labels: candidatesNames,
      datasets: [
        {
          axis: 'y',
          label: "Total Vote Points",
          backgroundColor: "#363b42",
          data: totalVotePoints
        }, {
          axis: 'y',
          label: "Total Number of Voters",
          backgroundColor: "#5E6267",
          data: totalNumberOfVoters
        },
      ]
    },
    options: {
      responsive: true,
      title: {
        display: true,
        text: 'Overall Candidates Ranking'
      },
      scales: {
        y: {
          beginAtZero: true
        }
      },
      indexAxis: 'y',
    }
  });
};

const displayCandidatesOverallRankingSidebar = (data) => {
  let candidatesRankingDataBody = ``;
  data.forEach(candidate => {
    candidatesRankingDataBody += `<div style="padding: -5px;" class="d-flex flex-column flex-md-row align-items-center justify-content-center">
      <div class="list-group mt-2">
        <a style="background: transparent; padding: 15px; pointer-events: none;" href="javascript:void(0)" class="list-group-item list-group-item-action d-flex gap-3 rounded-4" aria-current="true">
          <img src="${candidate.image}" alt="img" width="32" height="32" class="rounded-circle flex-shrink-0">
          <h6 class="mt-1">${candidate.name}</h6>
        </a>
      </div>
    </div>`;
  });
  $('#candidateRankingDataBody').html(candidatesRankingDataBody);
};

const displayCandidatesRankingPerCategory = (data) => {
  let rankingPerCategory = `<div class="row">`;
    Object.keys(data).forEach((category, index) => {
      rankingPerCategory += `<div class="col-md-4">
        <div class="issue-report-card card mt-3">
          <div class="card-header">
            <i class="fa-solid fa-chart-simple fs-3"></i>&nbsp;
            <label>Ranking for ${category} </label>
          </div>
          <div class="card-body">
            <canvas id="chartRankingFor_${index}"></canvas>
          </div>
        </div>
      </div>`;

      setTimeout(() => {
        let ctxRankingCategoryChart = $(`#chartRankingFor_${index}`);
        new Chart(ctxRankingCategoryChart, {
          type: 'bar',
          data: {
            labels: Object.keys(data[category]).map(key => data[category][key].name),
            datasets: [{
              label: 'Total Vote Points',
              data: Object.keys(data[category]).map(key => data[category][key].totalPoints),
              fill: false,
              backgroundColor: '#949496',
              borderColor: 'rgb(201, 203, 207)',
              borderWidth: 1
            }]
          },
          options: {
            title: {
            display: true,
            text: `Ranking for ${category}`
          },
          responsive: true,
          scales: {
            y: {
              beginAtZero: true
            }
          },
        }
      });
    }, 1000 * index);
  });

  rankingPerCategory += `</div>`;
  $('#categoryRankingData').html(rankingPerCategory);
};