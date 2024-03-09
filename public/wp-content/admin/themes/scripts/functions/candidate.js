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
    success: (data) => {

      if (offset > 0) { //kapag ang offset is greater than 0, prev button will be undisabled
        $('#prevPaginateBtn').removeAttr('disabled');
      } else {  //otherwise, it will be disabled
        $('#prevPaginateBtn').attr('disabled', true);
      }

      // If the number of records fetched is less than the limit, disable the next button
      if (data.length < limit) {
        $('#nextPaginateBtn').attr('disabled', true);
      } else {
        $('#nextPaginateBtn').removeAttr('disabled');
      }
      //window.history.replaceState(null, null, $('#indexUri').data('iurl'));
      displayLimitCandidates(data);
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
    success: (data) => {
      console.log(data);
      displayCandidatesInformation(data);
      displayCandidatesVoteRecords(data);
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
    success: (data) => {
      displayLimitCandidates(data);
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
    success: (data) => {
      displayLimitCandidates(data);
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
    success: (data) => {
      displayCandidatesOverallRankingChart(data);
      displayCandidatesOverallRankingSidebar(data);
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
    success: (data) => {
      displayCandidatesRankingPerCategory(data);
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
    toastr.error("Something went wrong! Failed to display candidates");
  	candidatesInSelect += `<option value="">No record found</option>`;
  }

  candidatesInSelect += `</select><div class="invalid-feedback candidateIdError"></div>`;

  $('.candidateSelectDataBody').html(candidatesInSelect);
}; 

const displayLimitCandidates = (data) => {
  let candidatesDataBody = `<div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-1">`;
  if(typeof data === 'object' && data !== null) { 
    Object.keys(data).forEach(key => {
      candidatesDataBody += `
        <div class="col candidatesItem_${data[key].cdid}">
          <div class="card card-cover h-100 overflow-hidden border-0 text-bg-dark rounded-4 shadow-lg" style="background-image: url('/storage/${data[key].image}'); height: 60vh!important;">
            <div id="cardOverlay" class="d-flex flex-column h-100 p-4 pb-3 text-white text-shadow-1">
              <h4 class="pt-5 mt-5 mb-5 display-6 lh-1"></h4>
              <ul class="d-flex list-unstyled mt-auto">
                <li class="me-auto" style="margin-top: 5px">
                  <a href="javascript:void(0)" class="button-links d-flex align-items-center text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-ellipsis button-links-icon"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                    <a id="viewCandidateButton" data-id="${data[key].cdid}" class="dropdown-item"  href="/${APP_VERSION}/${CANDIDATES_URI}/${data[key].cdid}/show">
                      <i class="fa-solid fa-eye"></i>&nbsp; View</li>
                    </a>
                    <a id="editCandidateButton" data-id="${data[key].cdid}" class="dropdown-item" href="/${APP_VERSION}/${CANDIDATES_URI}/${data[key].cdid}/edit"><li>
                      <i class="fa-solid fa-pen-to-square"></i>&nbsp; Edit</li>
                    </a>
                    <a class="dropdown-item" href="javascript:void(0)" id="deleteCandidateButton" data-id="${data[key].cdid}" ><li>
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
    toastr.error("Something went wrong! Failed to display candidates");
    candidatesDataBody += `<center class="mt-3">
      <div class="text-muted mt-3 d-flex align-items-center justify-content-center text-center">
        <i class="fa-solid fa-face-sad-tear  fs-4"></i><span class="fs-4">&nbsp; No record found.</span>
      </div>
    </center>`;
  }
  candidatesDataBody += `</div>`;

  $('.candidatesDataRecords').html(candidatesDataBody);
};

const displayCandidatesInformation = (data) => {
  if(typeof data === 'object' && data !== null) {
    let candidateVotesRecords = ``;
    if(data.votes.length > 0) {
      data.votes.forEach(vote => {
        candidateVotesRecords += `<tr>
          <td>${vote.vid}</td>
          <td>${vote.candidate.name}</td>
          <td>₱ ${vote.vote_point.amount}</td>
          <td>${vote.vote_point.point}</td>
          <td>${boldLastPart(vote.referrence_no)}</td>
          <td>
            ${vote.status == '0' ? 
              `<a href="javascript:void(0)" class="updateStatusBtn badge text-bg-success opacity-4 rounded-5 text-decoration-none text-white status-btn" title="verified">Verified</a>` :
            vote.status == '1' ? 
              `<a href="javascript:void(0)" class="updateStatusBtn badge text-bg-secondary opacity-4 rounded-5 text-decoration-none text-white status-btn" title="pending">Pending</a>` :
            vote.status == '2' ?
              `<a href="javascript:void(0)" class="updateStatusBtn badge text-bg-danger opacity-4 rounded-5 text-decoration-none text-white status-btn" title="spam">Spam</a>` :
            ''}
          </td>
          <td>${formatDate(vote.created_at)}</td>
        </tr>`;
      });
    } else {
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
  } else { 
    toastr.error("Something went wrong! Failed to display candidates information");
  }
};

const displayCandidatesVoteRecords = (data) => {
  if(typeof data === 'object' && data !== null) {
    $('#totalCurrentVotePoints').text(data.totalVotePoints);
    $('#totalVoters').text(data.totalVotes);
    $('#totalAmount').text(data.totalAmount);
    $('#totalPendingVotes').text(data.totalPendingVotes);
    $('#totalSpamVotes').text(data.totalSpamVotes);
    $('#totalOfAllVotes').text(data.totalOfAllVotes);
    //show
    $('#showCardCandidateImage').css('background-image', `url(/storage/${data.candidate.image})`);
    $('#votingVersion').val(data.candidate.app_version.title);
    $('#campusCandidate').val(data.candidate.campus?.name === null ? '---' : data.candidate.campus?.name);
    $('#categoryCandidate').val(data.candidate.category.name);
    $('#nameCandidate').val(data.candidate.name);
    $('#noCandidate').val(data.candidate.candidate_no);
    $('#candidateMottoDescription').val(data.candidate.motto_description ?? '---');
    $('#dateCreated').val(formatDate(data.candidate.created_at));
    $('#dateUpdated').val(formatDate(data.candidate.updated_at));
    //edit
    $('#editCardCandidateImage').css('background-image', `url(/storage/${data.candidate.image})`);
    $('#editCandidateNameText').text(data.candidate.name);
    $('#editCandidateNoText').text(data.candidate.candidate_no);

    $('#editCandidateVersion').val(data.candidate.app_version.name);
    $('#editCandidateCampus').val(data.candidate.campus?.name === null ? '---' : data.candidate.campus?.name);
    $('#editCandidateCategory').val(data.candidate.category.name);
    $('#editCandidateName').val(data.candidate.name);
    $('#editCandidateNo').val(data.candidate.candidate_no);
    $('#editCandidateMottoDescription').val(data.candidate.motto_description ?? '');

    $('#editPrevPicture').val(`/storage/${data.candidate.image}`);
    $('#editActiveCandidate').val(data.candidate.cdid);
  }  else {
    toastr.error("Something went wrong! Failed to display candidates vote records.");
  }
};

const displayCandidatesOverallRankingChart = (data) => {
  const candidatesNames = data.map(candidate => candidate.candidate.name);
  const totalVotePoints = data.map(candidate => candidate.total_points);
  const totalNumberOfVoters = data.map(candidate => candidate.total_voters);

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
        <a style="background: transparent; padding: 15px" href="/${APP_VERSION}/admin/manage/candidates/${candidate.candidate.cdid}/show" class="list-group-item list-group-item-action d-flex gap-3 rounded-4" aria-current="true">
          <img src="/storage/${candidate.candidate.image}" alt="img" width="32" height="32" class="rounded-circle flex-shrink-0">
          <h6 class="mt-1">${candidate.candidate.name}</h6>
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
            <label>Ranking for ${data[category].category_name} Category</label>
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
            labels: data[category].top_candidates.map(candidate => candidate.candidate_name),
            datasets: [{
              label: 'Total Vote Points',
              data: data[category].top_candidates.map(candidate => candidate.total_points),
              fill: false,
              backgroundColor: '#949496',
              borderColor: 'rgb(201, 203, 207)',
              borderWidth: 1
            }]
          },
          options: {
            title: {
            display: true,
            text: `Ranking for ${data[category].category_name} Category`
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