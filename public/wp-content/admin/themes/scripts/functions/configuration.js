"use-strict";

/*
	|--------------------------------------------------------------------------
	| Configuration >>> Application Version
	|--------------------------------------------------------------------------
*/

const CONFIGURATION_URI = 'admin/configuration';
// APP_VERSION & CSRF_TOKEN (variable)-> wp-content/admin/themes/scripts/main.js

const getAllApplicationVersions = async () => {
  $.ajax({
    url: `/api/${APP_VERSION}/${CONFIGURATION_URI}/app-versions/all/records`,
    method: 'get',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
    success: (data) => {
      displayAppVersionsTable(data);
     	displayAppVersionsSelect(data);
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

const createNewApplicationVersion = async (name, title) => {
  $.ajax({
    url: `/api/${APP_VERSION}/${CONFIGURATION_URI}/app-versions/store`,
    method: 'post',
    data: {
      'name': name,
      'title': title,
    },
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
    success: (response) => {
      if(response.success) {
        $('#newVotingTitle').val('');
        $('#newVotingVersion').val('');
        getAllApplicationVersions();
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

const updateApplicationVersion = async (avid, name, title) => {
  $.ajax({
    url: `/api/${APP_VERSION}/${CONFIGURATION_URI}/app-versions/id/${avid}/update`,
    method: 'patch',
    data: {
      'app_version_id': APP_VERSION,
      'avid': avid,
      'name': name,
      'title': title,
    },
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': CSRF_TOKEN,
    },
    success: (response) => {
      if(response.success) {
        getAllApplicationVersions();
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

const deleteApplicationVersion = async (avid) => {
  $.ajax({
    url: `/api/${APP_VERSION}/${CONFIGURATION_URI}/app-versions/id/${avid}/destroy`,
    method: 'delete',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
    success: (response) => {
      if(response.success) {
        $(`.appVersionItem_${avid}`).remove();
        getAllApplicationVersions();
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

const displayAppVersionsTable = (data) => {
  let tableData = ``;
  if(typeof data === 'object' && data !== null) {
    Object.keys(data).forEach(key => {
      tableData += `<tr class="appVersionItem_${data[key].avid}">
        <td>
          <small data-name="${data[key].name}"
            class="editNameVersion_${data[key].avid}
            ${(data[key].name === APP_VERSION) ? 'fw-bold' : ''}">
            ${data[key].name}
          </small>
        </td>
        <td>
          <small data-title="${data[key].title}" class="editTitleVersion_${data[key].avid}
            ${(data[key].name === APP_VERSION) ? 'fw-bold' : ''}">
            ${data[key].title}
          </small>
        </td>
        <td class="text-end">
          <a href="javascript:void(0)" data-id="${data[key].avid}" class="appVersionButtonEdit edit-icon_${data[key].avid}">
            <i class="fa-solid fa-pen-to-square fs-5 me-2 text-muted"></i>
          </a>
          <a href="javascript:void(0)" data-id="${data[key].avid}" class="appVersionButtonSave save-icon_${data[key].avid} d-none">
            <i class="fa-solid fa-floppy-disk fs-5 me-2 text-muted"></i>
          </a>
          <a href="javascript:void(0)" data-id="${data[key].avid}" class="appVersionButtonClose close-icon_${data[key].avid} d-none">
            <i class="fa-solid fa-circle-xmark fs-5 me-2 text-muted"></i>
          </a>
          <a href="javascript:void(0)" data-id="${data[key].avid}" class="appVersionButtonDelete delete-icon_${data[key].avid}">
            <i class="fa-solid fa-trash fs-5 me-2 text-muted"></i>
          </a>
        </td>
      </tr>`;
    });
  } else {
    tableData += `<tr class="text-center">
      <td></td>
      <td class="text-center"> Something went wrong <i class="fa-solid fa-face-sad-tear"></i></td>
      <td></td>
    </tr>`;
  }

  $('#versionDataBody').html(tableData);
};

const displayAppVersionsSelect = (data) => {
  let selectData = `<select class="form-select" id="appVersionSelected"><option selected value="">-- SELECT --</option>`;
  let selectDataCampus = `<select class="form-select" id="appVersionSelectedCampus"><option selected value="">-- SELECT --</option>`;
  let selectDataCategory = `<select class="form-select" id="appVersionSelectedCategory"><option selected value="">-- SELECT --</option>`;
  let selectDataVotePoints = `<select class="form-select" id="appVersionSelectedVotePoints"><option selected value="">-- SELECT --</option>`;

  if(typeof data === 'object' && data !== null) {
   	Object.keys(data).forEach(key => {
      selectData += `<option value="${data[key].avid}">${data[key].name}</option>`;
      selectDataCampus += `<option value="${data[key].avid}">${data[key].name}</option>`;
      selectDataCategory += `<option value="${data[key].avid}">${data[key].name}</option>`;
      selectDataVotePoints += `<option value="${data[key].avid}">${data[key].name}</option>`;
    });
  }

  selectData += `</select>`;
  selectDataCampus += `</select>`;
  selectDataCategory += `</select>`;
  selectDataVotePoints += `</select>`

  $('.selectDataBody').html(selectData);
  $('.selectDataBodyCampus').html(selectDataCampus);
  $('.selectDataBodyCategory').html(selectDataCategory);
  $('.selectDataBodyVotePoints').html(selectDataVotePoints);
};

/*
  |--------------------------------------------------------------------------
  | Configuration >>> Campus
  |--------------------------------------------------------------------------
*/
const getAllCampus = () => {
  $.ajax({
    url: `/api/${APP_VERSION}/${CONFIGURATION_URI}/campus/all/records`,
    method: 'get',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
    success: (data) => {
      displayCampusTable(data);
      displayCampusSelect(data);
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

const createNewCampus = (avid, campusName) => {
  $.ajax({
    url: `/api/${APP_VERSION}/${CONFIGURATION_URI}/campus/store`,
    method: 'post',
    data: {
      'app_version_id': avid,
      'name': campusName
    },
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
    success: (response) => {
      if(response.success) {
        $('#newCampus').val('');
        $('#appVersionSelectedCampus').val('');
        stopSpinner();
        getAllCampus();
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

const updateCampus = async (scid, avid, campusName) => {
  $.ajax({
    url: `/api/${APP_VERSION}/${CONFIGURATION_URI}/campus/id/${scid}/update`,
    method: 'patch',
    data: {
      'app_version_id': avid,
      'scid': scid,
      'name': campusName,
    },
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': CSRF_TOKEN
    },
    success: (response) => {
      if(response.success) {
        $(`.editCampusName_${scid}`).attr('contenteditable', 'false').removeClass('form-control');
        $(`.editCampus-icon_${scid}`).removeClass('d-none');
        $(`.saveCampus-icon_${scid}`).addClass('d-none');
        $(`.closeCampus-icon_${scid}`).addClass('d-none');
        $(`.deleteCampus-icon_${scid}`).removeClass('d-none');
        getAllCampus();
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
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

const deleteCampus = async (campus) => {
  $.ajax({
    url: `/api/${APP_VERSION}/${CONFIGURATION_URI}/campus/id/${campus}/destroy`,
    method: 'delete',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
    success: (response) => {
      if(response.success) {
        $(`.campusItem_${campus}`).remove();
        getAllCampus();
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

const displayCampusTable = (data) => {
  let tableCampusData = ``;
  if(typeof data === 'object' && data !== null) {
    Object.keys(data).forEach(key => {
      tableCampusData += `<tr class="campusItem_${data[key].scid}">
        <td><small id="colFormLabel" class="editCampusName_${data[key].scid} mb-0">
          ${data[key].name}
          </small>
        </td>
        <td class="text-end">
          <a href="javascript:void(0)" data-id="${data[key].scid}" class="campusButtonEdit editCampus-icon_${data[key].scid}">
            <i class="fa-solid fa-pen-to-square fs-5 me-2 text-muted"></i>
          </a>
          <a href="javascript:void(0)" data-id="${data[key].scid}" data-avid="${data[key].app_version_id}" class="campusButtonSave saveCampus-icon_${data[key].scid} d-none">
            <i class="fa-solid fa-floppy-disk fs-5 me-2 text-muted"></i>
          </a>
          <a href="javascript:void(0)" data-id="${data[key].scid}" class="campusButtonClose closeCampus-icon_${data[key].scid} d-none">
            <i class="fa-solid fa-circle-xmark fs-5 me-2 text-muted"></i>
          </a>
          <a href="javascript:void(0)" data-id="${data[key].scid}" class="campusButtonDelete deleteCampus-icon_${data[key].scid}">
            <i class="fa-solid fa-trash fs-5 me-2 text-muted"></i>
          </a>
        </td>
      </tr>`;
    });
  } else {
    tableCampusData += `<tr class="text-center">
      <td></td>
      <td class="text-center text-muted" rowspan="2">No Record Found <i class="fa-solid fa-face-sad-tear"></i></td>
    </tr>
    `;
  }

  $('#campusDataBody').html(tableCampusData)
};

const displayCampusSelect = (data) => {
  let selectCampusData = `<select id="campusSelected" class="form-select"><option selected value="">-- SELECT --</option>`;
  if(typeof data === 'object' && data !== null) {
    Object.keys(data).forEach(key => {
      selectCampusData += `<option value="${data[key].scid}">${data[key].name}</option>`;
    });
  }
  selectCampusData += `</select>`;

  $('.selectCampusBody').html(selectCampusData);
};
/*
	|--------------------------------------------------------------------------
	| Configuration >>> Category
	|--------------------------------------------------------------------------
*/

const getAllCategories = async () => {
  $.ajax({
    url: `/api/${APP_VERSION}/${CONFIGURATION_URI}/category/all/records`,
    method: 'get',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
    success: (data) => {
      displayCategoriesTable(data);
      displayCategoriesDropdown(data);
      displayCategoriesSelect(data);
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

const createNewCategory = async (avid, name) => {
  $.ajax({
    url: `/api/${APP_VERSION}/${CONFIGURATION_URI}/category/store`,
    method: 'post',
    data: {
      'app_version_id': avid,
      'name': name,
    },
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
    success: (response) => {
      if(response.success) {
        $('#newCategory').val('');
        $('#appVersionSelectedCategory').val('');
        getAllCategories();
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

const updateCategory = async (ctid, avid, name) => {
  $.ajax({
    url: `/api/${APP_VERSION}/${CONFIGURATION_URI}/category/id/${ctid}/update`,
    method: 'patch',
    data: {
      'app_version_id': avid,
      'ctid': ctid,
      'name': name,
    },
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': CSRF_TOKEN
    },
    success: (response) => {
      if(response.success) {
        getAllCategories();
        toastr.success(response.message);
        $('#versionFilterSelected').val(APP_VERSION);
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

const deleteCategory = async (ctid) => {
  $.ajax({
    url: `/api/${APP_VERSION}/${CONFIGURATION_URI}/category/id/${ctid}/destroy`,
    method: 'delete',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
    success: (response) => {
      if(response.success) {
        $(`.categoryItem_${ctid}`).remove();
        $('#versionFilterSelected').val(APP_VERSION);
        getAllCategories();
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

const displayCategoriesTable = (data) => {
  let tableData = ``;

  if(typeof data === 'object' && data !== null) {
    Object.keys(data).forEach(key => {
      tableData += `<tr class="categoryItem_${data[key].ctid}">
        <td>
          <small id="colFormLabel" class="editCategoryName_${data[key].ctid} mb-0">
            ${data[key].name}
          </small>
        </td>
        <td class="text-end">
          <a href="javascript:void(0)" data-id="${data[key].ctid}" class="categoryButtonEdit editCategory-icon_${data[key].ctid}">
            <i class="fa-solid fa-pen-to-square fs-5 me-2 text-muted"></i>
          </a>
          <a href="javascript:void(0)" data-id="${data[key].ctid}" data-avid="${data[key].app_version_id}" class="categoryButtonSave saveCategory-icon_${data[key].ctid} d-none">
            <i class="fa-solid fa-floppy-disk fs-5 me-2 text-muted"></i>
          </a>
          <a href="javascript:void(0)" data-id="${data[key].ctid}" class="categoryButtonClose closeCategory-icon_${data[key].ctid} d-none">
            <i class="fa-solid fa-circle-xmark fs-5 me-2 text-muted"></i>
          </a>
          <a href="javascript:void(0)" data-id="${data[key].ctid}" class="categoryButtonDelete deleteCategory-icon_${data[key].ctid}">
            <i class="fa-solid fa-trash fs-5 me-2 text-muted"></i>
          </a>
        </td>
      </tr>`;
    });
  } else {
    tableData += `<tr class="text-center">
      <td></td>
      <td class="text-center"> Something went wrong <i class="fa-solid fa-face-sad-tear"></i></td>
      <td></td>
    </tr>`;
  }

  $('#categoryBody').html(tableData);
};

const displayCategoriesDropdown = (data) => {
  let filterCategoryData = `<ul class="dropdown-menu dropdown-menu-dark text-small shadow">
    <a style="cursor: pointer;" class="dropdown-item active" onclick="loadMoreCandidatesRecord(9, 0)"><li>
    <i class="fa-solid fa-server"></i>&nbsp; All Candidates</li></a><li><hr class="dropdown-divider"></li>`;
  if(typeof data === 'object' && data !== null) {
    Object.keys(data).forEach(key => {
      filterCategoryData += `<a style="cursor: pointer;" class="dropdown-item" onclick="filterCandidatesByCategory('${data[key].ctid}')">
        <li><i class="fa-solid fa-clock"></i>&nbsp; ${data[key].name}</li>
      </a>`;
    });
  }
  filterCategoryData += `</ul>`;
  $('#filterCategoryDataBody').html(filterCategoryData);
};

const displayCategoriesSelect = (data) => {
  let selectCategoryData = `<select id="categorySelected" class="form-select"><option selected value="">-- SELECT --</option>`;
  if(typeof data === 'object' && data !== null) {
    Object.keys(data).forEach(key => {
      selectCategoryData += `<option value="${data[key].ctid}">${data[key].name}</option>`;
    });
  }
  selectCategoryData += `</select>`;
  $('.selectCategoryBody').html(selectCategoryData);
};

/*
	|--------------------------------------------------------------------------
	| Configuration >>> Vote Points
	|--------------------------------------------------------------------------
*/

const getAllVotePoints = async () => {
  $.ajax({
    url: `/api/${APP_VERSION}/${CONFIGURATION_URI}/vote-points/all/records`,
    method: 'get',
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': CSRF_TOKEN
    },
    success: (data) => {
      displayVotePointsTable(data);
      displayVotePointsSelect(data);
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

const createNewVotePoints = async (avid, amount, point, image) => {
  runSpinner();

  const formData = new FormData();
  formData.append('app_version_id', avid);
  formData.append('amount', amount);
  formData.append('point', point);
  formData.append('image', image);

  $.ajax({
    url: `/api/${APP_VERSION}/${CONFIGURATION_URI}/vote-points/store`,
    method: 'post',
    data: formData,
    processData: false,
    contentType: false,
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
    success: (response) => {
      if(response.success) {
        $('#removeImageButton').addClass('d-none');
        $('#imageLabel').removeClass('d-none');
        $('#newAmount').val('');
        $('#newPoints').val('');
        $('#appVersionSelectedVotePoints').val('');
        $('#qrCodeImage').val("");
        getAllVotePoints();
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

const updateVotePoints = async (vpid, avid, voteAmount, votePoint, imageFile) => {
  const formData = new FormData();
  formData.append('vpid', vpid);
  formData.append('app_version_id', avid);
  formData.append('amount', voteAmount);
  formData.append('point', votePoint);
  formData.append('image', imageFile);

  $.ajax({
    url: `/api/${APP_VERSION}/${CONFIGURATION_URI}/vote-points/id/${vpid}/update`,
    method: 'post',
    data: formData,
    processData: false,
    contentType: false,
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': CSRF_TOKEN,
      'X-HTTP-Method-Override': 'PATCH'
    },
    success: (response) => {
      if(response.success) {
        getAllVotePoints();
        toastr.success(response.message);
        $('#versionFilterSelectedVP').val(APP_VERSION);
        $(`.editVoteAmount_${vpid}`).attr('contenteditable', 'false').removeClass('form-control');
        $(`.editVotePoint_${vpid}`).attr('contenteditable', 'false').removeClass('form-control');
        $(`.editVotePoint-icon_${vpid}`).removeClass('d-none');
        $(`.saveVotePoint-icon_${vpid}`).addClass('d-none');
        $(`.closeVotePoint-icon_${vpid}`).addClass('d-none');
        $(`.deleteVotePoint-icon_${vpid}`).removeClass('d-none');
         $(`.imageFileUpload_${vpid}`).val("");
         $('#removeImageButton').addClass('d-none');
        $('#imageLabel').removeClass('d-none');
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

const deleteVotePoints = async (vpid) => {
  $.ajax({
    url: `/api/${APP_VERSION}/${CONFIGURATION_URI}/vote-points/id/${vpid}/destroy`,
    method: 'delete',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
    success: (response) => {
       if(response.success) {
        $(`.votingPointsItem_${vpid}`).remove();
        $('#versionFilterSelectedVP').val(APP_VERSION);
        getAllVotePoints();
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

const displayVotePointsTable = (data) => {
  let tableData = ``;
  if(typeof data === 'object' && data !== null) {
    Object.keys(data).forEach(key => {
      tableData += `<tr class="votingPointsItem_${data[key].vpid}">
        <td>
          <small data-amount="${data[key].amount}" class="editVoteAmount_${data[key].vpid}">
            ${data[key].amount}
          </small>
        </td>
        <td>
          <small data-point="${data[key].point}" class="editVotePoint_${data[key].vpid}">
            ${data[key].point}
          </small>
        </td>
        <td class="text-end">
          <label data-id="${data[key].vpid}" class="editVotePointImage-icon_${data[key].vpid} d-none">
            <input type="file" class="form-control w-50 imageFileUpload_${data[key].vpid}" id="qrCodeImage" accept="image/png, image/jpg, image/jpeg" style="display: none;" />
            <button type="button" onclick="triggerFileUpload('${data[key].vpid}')" class="btn btn-sm border-0"><i class="fa-solid fa-upload fs-5 me-2 text-muted"></i></button>
          </label>
          <a href="javascript:void(0)" data-id="${data[key].vpid}" class="votePointButtonEdit editVotePoint-icon_${data[key].vpid}">
            <i class="fa-solid fa-pen-to-square fs-5 me-2 text-muted"></i>
          </a>
          <a href="javascript:void(0)" data-id="${data[key].vpid}" data-avid="${data[key].app_version_id}" class="votePointButtonSave saveVotePoint-icon_${data[key].vpid} d-none">
            <i class="fa-solid fa-floppy-disk fs-5 me-2 text-muted"></i>
          </a>
          <a href="javascript:void(0)" data-id="${data[key].vpid}" class="votePointButtonClose closeVotePoint-icon_${data[key].vpid} d-none">
            <i class="fa-solid fa-circle-xmark fs-5 me-2 text-muted"></i>
          </a>
          <a href="javascript:void(0)" data-id="${data[key].vpid}" class="votePointButtonDelete deleteVotePoint-icon_${data[key].vpid}">
            <i class="fa-solid fa-trash fs-5 me-2 text-muted"></i>
          </a>
        </td>
      </tr>`;
    });
  } else {
    tableData += `<tr class="text-center">
      <td></td>
      <td class="text-center"> Something went wrong <i class="fa-solid fa-face-sad-tear"></i></td>
      <td></td>
    </tr>`;
  }

  $('#equivalentVotePointsBody').html(tableData);
};

const displayVotePointsSelect = (data) => {
  let amountSelect = `<select class="form-select amountSelected"><option value="" id="selectedVotePoints" selected>-- SELECT --</option>`;

  if(typeof data === 'object' && data !== null) {
		Object.keys(data).forEach(key => {
      amountSelect += `<option data-amount="${data[key].amount}" class="optionDataVotePoints_${data[key].vpid}" value="${data[key].vpid}">${data[key].amount}</option>`;
    });
	}
  amountSelect += `</select><div class="invalid-feedback votePointIdError"></div>`;

  $('.voteAmountSelectDataBody').html(amountSelect);
};