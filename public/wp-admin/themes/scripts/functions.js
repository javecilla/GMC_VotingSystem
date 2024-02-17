/*
|--------------------------------------------------------------------------
| Configuration >>> Application Version
|--------------------------------------------------------------------------
*/

// Get ALl Application Version
const getAllApplicationVersions = (appVersion, csrfToken) => {
  $.ajax({
    url: `/${appVersion}/admin/configuration/app-versions/`,
    method: 'get',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': csrfToken },
    success: (data) => {
      
      let tableData = ``;

      let selectData = `<select class="form-select" id="appVersionSelected">
        <option selected value="">-- SELECT --</option>`;
      let selectFilter = `<select class="form-select" id="versionFilterSelected">
        <option selected value="${appVersion}">${appVersion}</option>`;
      let selectDataVP = `<select class="form-select" id="appVersionSelectedVP">
        <option selected value="">-- SELECT --</option>`;
      let selectFilterVP = `<select class="form-select" id="versionFilterSelectedVP">
        <option selected value="${appVersion}">${appVersion}</option>`;
      //check if the return data in an object format and not null
      if(typeof data === 'object' && data !== null) {
        Object.keys(data).forEach(key => {
          tableData += `
            <tr class="appVersionItem_${data[key].avid}">
              <td>
                <small data-name="${data[key].name}" 
                  class="editNameVersion_${data[key].avid}">
                  ${data[key].name}
                </small>
              </td>
              <td>
                <small data-title="${data[key].title}" 
                  class="editTitleVersion_${data[key].avid}">
                  ${data[key].title}
                  </small>
              </td>
              <td class="text-end">
                <a href="javascript:void(0)" data-id="${data[key].avid}" 
                  class="appVersionButtonEdit edit-icon_${data[key].avid}">
                  <i class="fa-solid fa-pen-to-square fs-5 me-2 text-muted"></i>
                </a>
                <a href="javascript:void(0)" data-id="${data[key].avid}" 
                  class="appVersionButtonSave save-icon_${data[key].avid} d-none">
                  <i class="fa-solid fa-floppy-disk fs-5 me-2 text-muted"></i>
                </a>
                <a href="javascript:void(0)" data-id="${data[key].avid}" 
                  class="appVersionButtonClose close-icon_${data[key].avid} d-none">
                  <i class="fa-solid fa-circle-xmark fs-5 me-2 text-muted"></i>
                </a>
                <a href="javascript:void(0)" data-id="${data[key].avid}" 
                  class="appVersionButtonDelete delete-icon_${data[key].avid}">
                  <i class="fa-solid fa-trash fs-5 me-2 text-muted"></i>
                </a>
              </td>
            </tr>
          `;

          selectData += `<option value="${data[key].avid}">${data[key].name}</option>`;
          selectFilter += `<option value="${data[key].name}">${data[key].name}</option>`;
          selectDataVP += `<option value="${data[key].avid}">${data[key].name}</option>`;
          selectFilterVP += `<option value="${data[key].name}">${data[key].name}</option>`;
        });
        
      } else {
        tableData += `
          <tr class="text-center">
            <td></td>
            <td class="text-center"> {{ __('Something went wrong') }} 
              <i class="fa-solid fa-face-sad-tear"></i>
            </td>
            <td></td>
          </tr>
        `;
      }

      selectData += `</select>`;
      selectFilter += `</select>`;
      selectDataVP += `</select>`;
      selectFilterVP += `</select>`;

      $('#versionDataBody').html(tableData);

      $('.selectDataBody').html(selectData);
      $('.selectFilterBody').html(selectFilter);
      $('.selectDataBodyVP').html(selectDataVP);
      $('.selectFilterBodyVP').html(selectFilterVP);
      

    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

// Update Application Version
const updateApplicationVersion = (appVersion, csrfToken, avid, name, title) => {
  $.ajax({
    url: `/${appVersion}/admin/configuration/app-versions/${avid}/update`,
    method: 'patch',
    data: { 
      'app_version_id': appVersion,
      'avid': avid,
      'name': name,
      'title': title,
    },
    dataType: 'json',
    headers: { 
      'X-CSRF-TOKEN': csrfToken,
    },
    success: (response) => {
      if(response.success) {
        getAllApplicationVersions(appVersion, csrfToken);
        toastr.success(response.message);
        $(`.editNameVersion_${avid}`).attr('contenteditable', 'false').removeClass('form-control');
        $(`.editTitleVersion_${avid}`).attr('contenteditable', 'false').removeClass('form-control');
        $(`.save-icon_${avid}`).addClass('d-none');
        $(`.close-icon_${avid}`).addClass('d-none');
        $(`.edit-icon_${avid}`).removeClass('d-none');
        $(`.delete-icon_${avid}`).removeClass('d-none');
      } else {
         if(response.type === 'info') {
          toastr.info(response.message);
        } else if(response.type === 'warning') {
          toastr.warning(response.message);
        } else {
          toastr.error(response.message);
        }

        $(`.editNameVersion_${avid}`).attr('contenteditable', 'true').addClass('form-control');
        $(`.editTitleVersion_${avid}`).attr('contenteditable', 'true').addClass('form-control');
        $(`.save-icon_${avid}`).removeClass('d-none');
        $(`.close-icon_${avid}`).removeClass('d-none');
        $(`.edit-icon_${avid}`).addClass('d-none');
        $(`.delete-icon_${avid}`).addClass('d-none');
      }
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  }); 
};

// Create New Application Version
const createNewApplicationVersion = (appVersion, csrfToken, name, title) => {
  $.ajax({
    url: `/${appVersion}/admin/configuration/app-versions/store`,
    method: 'post',
    data: {
      'name': name,
      'title': title,
    },
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': csrfToken },
    success: (response) => {
      if(response.success) {
        $('#newVotingTitle').val('');
        $('#newVotingVersion').val('');
        getAllApplicationVersions(appVersion, csrfToken);
        toastr.success(response.message);
      } else {
        toastr.error(response.message);
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

// Delete Application Version
const deleteApplicationVersion = (appVersion, csrfToken, avid) => {
  $.ajax({
    url: `/${appVersion}/admin/configuration/app-versions/${avid}/destroy`,
    method: 'delete',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': csrfToken },
    success: (response) => {
      if(response.success) {
        $(`.appVersionItem_${avid}`).remove();
        getAllApplicationVersions(appVersion, csrfToken);
        toastr.success(response.message);
      } else {
        toastr.error(response.message);
      }
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};


/*
|--------------------------------------------------------------------------
| Configuration >>> Category
|--------------------------------------------------------------------------
*/

// Get ALl Category Records base on Application Version
const getAllCategoryByVersion = (appVersion, csrfToken) => {
  $.ajax({
    url: `/${appVersion}/admin/configuration/category/`,
    method: 'get',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': csrfToken },
    success: (data) => {
      let tableData = ``;
      let selectCategoryData = `<select id="categorySelected" class="form-select">
        <option selected value="">-- SELECT --</option>`;
      if(typeof data === 'object' && data !== null) {
        Object.keys(data).forEach(key => {
          tableData += `
            <tr class="categoryItem_${data[key].ctid}">
              <td>
                <small id="colFormLabel" class="editCategoryName_${data[key].ctid} mb-0">
                  ${data[key].name}
                </small>
              </td>
              <td class="text-end">
                <a href="javascript:void(0)" data-id="${data[key].ctid}" 
                  class="categoryButtonEdit editCategory-icon_${data[key].ctid}">
                  <i class="fa-solid fa-pen-to-square fs-5 me-2 text-muted"></i>
                </a>
                <a href="javascript:void(0)" data-id="${data[key].ctid}" 
                  data-avid="${data[key].app_version_id}"
                  class="categoryButtonSave saveCategory-icon_${data[key].ctid} d-none">
                  <i class="fa-solid fa-floppy-disk fs-5 me-2 text-muted"></i>
                </a>

                <a href="javascript:void(0)" data-id="${data[key].ctid}" 
                  class="categoryButtonClose closeCategory-icon_${data[key].ctid} d-none">
                  <i class="fa-solid fa-circle-xmark fs-5 me-2 text-muted"></i>
                </a>
                <a href="javascript:void(0)" data-id="${data[key].ctid}" 
                  class="categoryButtonDelete deleteCategory-icon_${data[key].ctid}">
                  <i class="fa-solid fa-trash fs-5 me-2 text-muted"></i>
                </a>
              </td>
            </tr>
          `; 

          selectCategoryData += `<option value="${data[key].ctid}">${data[key].name}</option>`;
        });
      } else {
        tableData += `
          <tr class="text-center">
            <td></td>
            <td class="text-center"> {{ __('Something went wrong') }} 
              <i class="fa-solid fa-face-sad-tear"></i>
            </td>
            <td></td>
          </tr>
        `;
      }
      selectCategoryData += `</select>`;

      $('#categoryBody').html(tableData);
      $('.selectCategoryBody').html(selectCategoryData);
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

// Update Category Name
const updateCategory = (appVersion, csrfToken, ctid, avid, name) => {
  $.ajax({
    url: `/${appVersion}/admin/configuration/category/${ctid}/update`,
    method: 'patch',
    data: { 
      'app_version_id': avid,
      'ctid': ctid,
      'name': name,
    },
    dataType: 'json',
    headers: { 
      'X-CSRF-TOKEN': csrfToken 
    },
    success: (response) => {
      if(response.success) {
        getAllCategoryByVersion(appVersion, csrfToken);
        toastr.success(response.message);
        $('#versionFilterSelected').val(appVersion);
        $(`.editCategoryName_${ctid}`).attr('contenteditable', 'false').removeClass('form-control');
        $(`.editCategory-icon_${ctid}`).removeClass('d-none');
        $(`.saveCategory-icon_${ctid}`).addClass('d-none');
        $(`.closeCategory-icon_${ctid}`).addClass('d-none');
        $(`.deleteCategory-icon_${ctid}`).removeClass('d-none');
      } else {
        if(response.type === 'info') {
          toastr.info(response.message);
        } else if(response.type === 'warning') {
          toastr.warning(response.message);
        } else {
          toastr.error(response.message);
        }

        $(`.editCategoryName_${ctid}`).attr('contenteditable', 'true').addClass('form-control');
        $(`.editCategory-icon_${ctid}`).addClass('d-none');
        $(`.saveCategory-icon_${ctid}`).removeClass('d-none');
        $(`.closeCategory-icon_${ctid}`).removeClass('d-none');
        $(`.deleteCategory-icon_${ctid}`).addClass('d-none');
      }
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

// Create New Application Version
const createNewCategory = (appVersion, csrfToken, avid, name) => {
  $.ajax({
    url: `/${appVersion}/admin/configuration/category/store`,
    method: 'post',
    data: {
      'app_version_id': avid,
      'name': name,
    },
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': csrfToken },
    success: (response) => {
      if(response.success) {
        $('#newCategory').val('');
        $('#appVersionSelected').val('');
        $('#versionFilterSelected').val(appVersion);
        getAllCategoryByVersion(appVersion, csrfToken);
        toastr.success(response.message);
      } else {
        toastr.error(response.message);
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

// Delete Category
const deleteCategory = (appVersion, csrfToken, ctid) => {
  $.ajax({
    url: `/${appVersion}/admin/configuration/category/${ctid}/destroy`,
    method: 'delete',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': csrfToken },
    success: (response) => {
      if(response.success) {
        $(`.categoryItem_${ctid}`).remove();
        $('#versionFilterSelected').val(appVersion);
        getAllCategoryByVersion(appVersion, csrfToken);
        toastr.success(response.message);
      } else {
        toastr.error(response.message);
      }
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

/*
|--------------------------------------------------------------------------
| Configuration >>> Vote Points
|--------------------------------------------------------------------------
*/
const getAllVotePointsByVersion = (appVersion, csrfToken) => {
  $.ajax({
    url: `/${appVersion}/admin/configuration/vote-points/`,
    method: 'get',
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': csrfToken
    },
    success: (data) => {
     let tableData = ``;
     Object.keys(data).forEach(key => {
      tableData += `
        <tr class="votingPointsItem_${data[key].vpid}">
          <td>
            <small data-amount="${data[key].amount}" 
              class="editVoteAmount_${data[key].vpid}">
              ${data[key].amount}
            </small>
          </td>
          <td>
            <small data-point="${data[key].point}" 
              class="editVotePoint_${data[key].vpid}">
              ${data[key].point}
            </small>
          </td>
          <td class="text-end">
            <a href="javascript:void(0)" data-id="${data[key].vpid}" 
              class="votePointButtonEdit editVotePoint-icon_${data[key].vpid}">
              <i class="fa-solid fa-pen-to-square fs-5 me-2 text-muted"></i>
            </a>
            <a href="javascript:void(0)" data-id="${data[key].vpid}" 
              data-avid="${data[key].app_version_id}"
              class="votePointButtonSave 
              saveVotePoint-icon_${data[key].vpid} d-none">
              <i class="fa-solid fa-floppy-disk fs-5 me-2 text-muted"></i>
            </a>
            <a href="javascript:void(0)" data-id="${data[key].vpid}" 
              class="votePointButtonClose closeVotePoint-icon_${data[key].vpid} d-none">
              <i class="fa-solid fa-circle-xmark fs-5 me-2 text-muted"></i>
            </a>
            <a href="javascript:void(0)" data-id="${data[key].vpid}" 
              class="votePointButtonDelete deleteVotePoint-icon_${data[key].vpid}">
              <i class="fa-solid fa-trash fs-5 me-2 text-muted"></i>
            </a>
          </td>
        </tr>
      `;
     });

     $('#equivalentVotePointsBody').html(tableData);
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

const updateVotePoints = (appVersion, csrfToken, vpid, avid, voteAmount, votePoint) => {
  $.ajax({
    url: `/${appVersion}/admin/configuration/vote-points/${vpid}/update`,
    method: 'patch',
    data: { 
      'vpid': vpid,
      'app_version_id': avid,
      'amount': voteAmount,
      'point': votePoint,
    },
    dataType: 'json',
    headers: { 
      'X-CSRF-TOKEN': csrfToken 
    },
    success: (response) => {
      if(response.success) {
        getAllVotePointsByVersion(appVersion, csrfToken);
        toastr.success(response.message);
        $('#versionFilterSelectedVP').val(appVersion);
        $(`.editVoteAmount_${vpid}`).attr('contenteditable', 'false').removeClass('form-control');
        $(`.editVotePoint_${vpid}`).attr('contenteditable', 'false').removeClass('form-control');
        $(`.editVotePoint-icon_${vpid}`).removeClass('d-none'); 
        $(`.saveVotePoint-icon_${vpid}`).addClass('d-none');
        $(`.closeVotePoint-icon_${vpid}`).addClass('d-none');
        $(`.deleteVotePoint-icon_${vpid}`).removeClass('d-none');
      } else {
        if(response.type === 'info') {
          toastr.info(response.message);
        } else if(response.type === 'warning') {
          toastr.warning(response.message);
        } else {
          toastr.error(response.message);
        }

        $(`.editVoteAmount_${vpid}`).attr('contenteditable', 'true').addClass('form-control');
        $(`.editVotePoint_${vpid}`).attr('contenteditable', 'true').addClass('form-control');
        $(`.editVotePoint-icon_${vpid}`).addClass('d-none'); 
        $(`.saveVotePoint-icon_${vpid}`).removeClass('d-none');
        $(`.closeVotePoint-icon_${vpid}`).removeClass('d-none');
        $(`.deleteVotePoint-icon_${vpid}`).addClass('d-none');
      }
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

const createNewVotePoints = (appVersion, csrfToken, avid, amount, point) => {
  $.ajax({
    url: `/${appVersion}/admin/configuration/vote-points/store`,
    method: 'post',
    data: {
      'app_version_id': avid,
      'amount': amount,
      'point': point,
    },
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': csrfToken },
    success: (response) => {
      if(response.success) {
        $('#newAmount').val('');
        $('#newPoints').val('');
        $('#appVersionSelectedVP').val('');
        $('#versionFilterSelectedVP').val(appVersion);
        getAllVotePointsByVersion(appVersion, csrfToken);
        toastr.success(response.message);
      } else {
        toastr.error(response.message);
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

const deleteVotePoints = (appVersion, csrfToken, vpid) => {
  $.ajax({
    url: `/${appVersion}/admin/configuration/vote-points/${vpid}/destroy`,
    method: 'delete',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': csrfToken },
    success: (response) => {
       if(response.success) {
        $(`.votingPointsItem_${vpid}`).remove();
        $('#versionFilterSelectedVP').val(appVersion);
        getAllVotePointsByVersion(appVersion, csrfToken);
        toastr.success(response.message);
      } else {
        toastr.error(response.message);
      }
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

/*
|--------------------------------------------------------------------------
| Configuration >>> School Campus
|--------------------------------------------------------------------------
*/
const getAllCampusByVersion = (appVersion, csrfToken) => {
  $.ajax({
    url: `/${appVersion}/admin/configuration/campus`,
    method: 'get',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': csrfToken },
    success: (data) => {
      let selectCampusData = `<select id="campusSelected" class="form-select">
        <option selected value="">-- SELECT --</option>`;
      if(typeof data === 'object' && data !== null) {
        Object.keys(data).forEach(key => {
          selectCampusData += `<option value="${data[key].scid}">${data[key].name}</option>`;
        });
      } 
      selectCampusData += `</select>`;

      $('.selectCampusBody').html(selectCampusData);
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

/*
|--------------------------------------------------------------------------
| Candidate Management
|--------------------------------------------------------------------------
*/
const getAllCandidatesByVersion = (appVersion, csrfToken) => {
  $.ajax({
    url: `/${appVersion}/admin/manage/candidates/retrieves`,
    method: 'get',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': csrfToken },
    success: (data) => {
      let candidatesDataBody = `<div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-1">`;
      if(typeof data === 'object' && data !== null) { 
        Object.keys(data).forEach(key => {
          candidatesDataBody += `
            <div class="col candidatesItem_${data[key].cdid}">
              <div class="card card-cover h-100 overflow-hidden border-0 text-bg-dark rounded-4 shadow-lg" 
                style="background-image: url('/storage/${data[key].image}');
                height: 60vh!important;">
                <div id="cardOverlay" class="d-flex flex-column h-100 p-4 pb-3 text-white text-shadow-1">
                  <h4 class="pt-5 mt-5 mb-5 display-6 lh-1"></h4>
                    <ul class="d-flex list-unstyled mt-auto">
                      <li class="me-auto" style="margin-top: 5px">
                        <a href="javascript:void(0)" class="button-links d-flex align-items-center text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="fa-solid fa-ellipsis button-links-icon"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                          <a id="viewCandidateButton" data-id="${data[key].cdid}" 
                            class="dropdown-item" 
                            href="/${appVersion}/admin/manage/candidates/${data[key].cdid}/show">
                            <i class="fa-solid fa-eye"></i>&nbsp; View</li>
                          </a>
                          <a id="editCandidateButton" data-id="${data[key].cdid}" 
                            class="dropdown-item" 
                            href="/${appVersion}/admin/manage/candidates/${data[key].cdid}/edit"><li>
                            <i class="fa-solid fa-pen-to-square"></i>&nbsp; Edit</li>
                          </a>
                          <a class="dropdown-item" href="javascript:void(0)"><li>
                            <i class="fa-solid fa-trash"></i>&nbsp; Delete</li>
                          </a>
                        </ul>
                      </li>
                      <li class="d-flex align-items-center">
                        <label class="fw-bold"  style="font-size: 20px;">
                          <span id="candidateNameText">${data[key].name}</span>
                          <span>&nbsp;:&nbsp;</span>
                          <span id="candidateNoText">${data[key].candidate_no}</span>
                        </label>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          `;
        });
      }
      candidatesDataBody += `</div>`;
      
      $('.candidatesDataRecords').html(candidatesDataBody);
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

const getOneCandidatesByVersion = (appVersion, csrfToken, cdid) => {
  $.ajax({
    url: `/${appVersion}/admin/manage/candidates/${cdid}/retrieve`,
    method: 'get',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': csrfToken },
    success: (data) => {
      let editDataBody = ``;
      Object.keys(data).forEach(key => {
        editDataBody += `
          <div class="container">
            <div class="row">
              <div class="col-md-5">
                <div class="card card-cover h-100 overflow-hidden border-0 text-bg-dark rounded-4 shadow-lg"
                  id="cardCandidateImage"
                  style="background-image: url('/storage/${data[key].image}');
                height: 65vh!important;">
                  <div id="cardOverlay" class="d-flex flex-column h-100 p-4 pb-3 text-white text-shadow-1">
                    <h4 class="pt-5 mt-5 mb-5 display-6 lh-1"></h4>
                    <ul class="d-flex list-unstyled mt-auto">
                      <li class="me-auto" style="margin-top: 5px">
                        <a href="javascript:void(0)" class="button-links d-flex align-items-center text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="fa-solid fa-ellipsis button-links-icon"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                          <a class="dropdown-item" href="javascript:void(0)"><li>
                            <i class="fa-solid fa-eye"></i>&nbsp; View</li>
                          </a>
                          <a class="dropdown-item" href="javascript:void(0)"><li>
                            <i class="fa-solid fa-pen-to-square"></i>&nbsp; Edit</li>
                          </a>
                          <a class="dropdown-item" href="javascript:void(0)"><li>
                            <i class="fa-solid fa-trash"></i>&nbsp; Delete</li>
                          </a>
                        </ul>
                      </li>
                      <li class="d-flex align-items-center">
                        <svg class="bi me-1" width="1em" height="1em"><use xlink:href="#geo-fill"/></svg>
                        <label class="fw-bold"  style="font-size: 20px;">
                          <span id="candidateNameText">Candidate Name</span>
                          <span>&nbsp;:&nbsp;</span>
                          <span id="candidateNoText">00</span>
                        </label>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>

              <div class="col-md-7">
                <form method="post" action="#" id="campusCreateForm" class="mt-3">
                  <div class="row mb-3">
                    <label for="candidateAppVersion" class="col-sm-2 col-form-label">
                      Version
                    </label>
                    <div class="col-sm-10">
                      <small class="text-muted">
                        Select the version of voting you want to add this candidate
                      </small>
                      <div class="selectDataBody">
        
                      </div>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="selectCampus" class="col-sm-2 col-form-label">
                      Campus
                    </label>
                    <div class="col-sm-10">
                      <small id="campusLabel" class="text-muted">
                        Select the campus candidate. Leave it blank if not applicable.
                      </small>
                      <div class="selectCampusBody">

                      </div>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="candidateCategory" class="col-sm-2 col-form-label">
                      Category
                    </label>
                    <div class="col-sm-10">
                      <div class="selectCategoryBody">
                   
                      </div>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="candidateInfo" class="col-sm-2 col-form-label">Info</label>
                    <div class="col-sm-10" id="candidateInfo">
                      <div class="row">
                        <div class="col-8">
                          <input type="text" class="form-control" placeholder="Name"
                          id="candidateName"/>
                        </div>
                        <div class="col-4">
                          <input type="text" class="form-control" placeholder="Candidate no."
                          id="candidateNo"/>
                        </div>
                      </div>

                      <div class="form-floating mt-3">
                        <textarea class="form-control" placeholder="Leave a comment here" id="candidateMottoDescription"></textarea>
                        <label for="candidateMottoDescription"><small class="text-muted">
                          Candidate motto or description. Leave it blank if not applicable.
                        </small></label>
                      </div>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label class="col-sm-2 col-form-label"
                    style="cursor: pointer;">
                      <span id="imageLabel">Image</span>
                      <small id="removeImageButton"class="d-none">
                        <i class="fa-solid fa-trash"></i> Remove
                      </small>
                    </label>
                    <div class="col-sm-10 ">
                      <input type="file" class="form-control imageFile" id="candidateImage"
                      accept="image/png, image/jpg, image/jpeg" />
                      <div class="invalid-feedback imageValidationFeedBack"></div>
                    </div>
                  </div>
                  <button type="submit" id="createNewCandidate"
                    class="btn btn-light w-100 btn-add">
                    Create
                    <i class="fas fa-spinner fa-spin loading-spinner d-none"></i>
                  </button>
                </form>
              </div>
            </div>
          </div>
        `;
      });

      $('#editDataBody').html(editDataBody);
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

const createNewCandidate = (appVersion, csrfToken, avid, scid, ctid, candidateNo, candidateName, candidateMotto, candidateImage) => {
  runSpinner();
  //toastr.success("validated");
  const formData = new FormData();
  formData.append('app_version_id', avid);
  formData.append('school_campus_id', scid);
  formData.append('category_id', ctid);
  formData.append('candidate_no', candidateNo);
  formData.append('name', candidateName);
  formData.append('motto_description', candidateMotto);
  formData.append('image', candidateImage);
  //checkFormData(formData);
  $.ajax({
    url: `/${appVersion}/admin/manage/candidates/store`,
    method: 'post',
    data: formData,
    processData: false, 
    contentType: false,
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': csrfToken },
    success: (response) => {
      if(response.success) {
        $('#campusCreateForm')[0].reset();
        
        $('#removeImageButton').addClass('d-none');
        $('#imageLabel').removeClass('d-none'); 
        $('#cardCandidateImage').css('background-image', `url('/wp-admin/uploads/noimg-yet.PNG')`);
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

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/
const logoutUser = (appVersion, uid, csrfToken) => {
  $.ajax({
    url: `/${appVersion}/logout/user`,
    method: 'post',
    data: { 'uid': uid },
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': csrfToken },
    success: (response) => {
      window.location.href=response.redirect;
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

const checkUserSession = (appVersion, csrfToken) => {
  $.ajax({
    url: `/${appVersion}/check/user/session`,
    method: 'post',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': csrfToken },
    success: (response) => {
      console.log(response.message);
      if (!response.active) {
        Swal.fire({
          title: "Session Timeout",
          html: "For security reasons, system automatically logging you out due to inactivity. Please log in again to continue accessing your account.",
          showConfirmButton: false,
        });
        //automaticall logout the user after 9s
        setTimeout(() => {
          window.location.href = response.redirect;
        }, 9000);
      }
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};


/*
|--------------------------------------------------------------------------
| Debugger Helper
|--------------------------------------------------------------------------
*/
const checkFormData = (formData) => {
  //check data form field value
  var formDataArray = [];
  formData.forEach((value, key) => {
    formDataArray.push({ [key]: value });
  });
  console.log(formDataArray);
};