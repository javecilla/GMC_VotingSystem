"use-strict";

/*
	|--------------------------------------------------------------------------
	| Configuration >>> Application Version
	|--------------------------------------------------------------------------
*/

const CONFIGURATION_URI = 'admin/configuration';
// APP_VERSION & CSRF_TOKEN (variable)-> wp-admin/themes/scripts/main.js

const getAllApplicationVersions = async () => {
  $.ajax({
    url: `/${APP_VERSION}/${CONFIGURATION_URI}/app-versions`,
    method: 'get',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
    success: (data) => {
     	displayAppVersions(data);
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

const createNewApplicationVersion = async (name, title) => {
  $.ajax({
    url: `/${APP_VERSION}/${CONFIGURATION_URI}/app-versions/store`,
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
    url: `/${APP_VERSION}/${CONFIGURATION_URI}/app-versions/${avid}/update`,
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
    url: `/${APP_VERSION}/${CONFIGURATION_URI}/app-versions/${avid}/destroy`,
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

const displayAppVersions = (data) => {
 	let tableData = ``;

  let selectData = `<select class="form-select" id="appVersionSelected"><option selected value="">-- SELECT --</option>`;
  let selectFilter = `<select class="form-select" id="versionFilterSelected"><option selected value="${APP_VERSION}">${APP_VERSION}</option>`;
  
  let selectDataVP = `<select class="form-select" id="appVersionSelectedVP"><option selected value="">-- SELECT --</option>`;
  let selectFilterVP = `<select class="form-select" id="versionFilterSelectedVP"><option selected value="${APP_VERSION}">${APP_VERSION}</option>`;

  if(typeof data === 'object' && data !== null) {
   	Object.keys(data).forEach(key => {
     	tableData += `<tr class="appVersionItem_${data[key].avid}">
      	<td>
          <small data-name="${data[key].name}" class="editNameVersion_${data[key].avid}">
            ${data[key].name}
          </small>
        </td>
       	<td>
          <small data-title="${data[key].title}" class="editTitleVersion_${data[key].avid}">
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

      selectData += `<option value="${data[key].avid}">${data[key].name}</option>`;
      selectFilter += `<option value="${data[key].name}">${data[key].name}</option>`;
      selectDataVP += `<option value="${data[key].avid}">${data[key].name}</option>`;
      selectFilterVP += `<option value="${data[key].name}">${data[key].name}</option>`;
    });
  } else {
    tableData += `<tr class="text-center">
      <td></td>
      <td class="text-center"> Something went wrong <i class="fa-solid fa-face-sad-tear"></i></td>
      <td></td>
    </tr>`;
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
};

/*
	|--------------------------------------------------------------------------
	| Configuration >>> Category
	|--------------------------------------------------------------------------
*/

const getAllCategories = async () => {
  $.ajax({
    url: `/${APP_VERSION}/${CONFIGURATION_URI}/category`,
    method: 'get',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
    success: (data) => {
      displayCategories(data)
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

const createNewCategory = async (avid, name) => {
  $.ajax({
    url: `/${APP_VERSION}/${CONFIGURATION_URI}/category/store`,
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
        $('#appVersionSelected').val('');
        $('#versionFilterSelected').val(APP_VERSION);
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
    url: `/${APP_VERSION}/${CONFIGURATION_URI}/category/${ctid}/update`,
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
    url: `/${APP_VERSION}/${CONFIGURATION_URI}/category/${ctid}/destroy`,
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

const displayCategories = (data) => {
	let tableData = ``;
  let selectCategoryData = `<select id="categorySelected" class="form-select"><option selected value="">-- SELECT --</option>`;
  let filterCategoryData = `<ul class="dropdown-menu dropdown-menu-dark text-small shadow">
		<a style="cursor: pointer;" class="dropdown-item active" onclick="loadMoreCandidatesRecord(9, 0)"><li>
    <i class="fa-solid fa-server"></i>&nbsp; All Candidates</li></a><li><hr class="dropdown-divider"></li>`;

  let rankingCandidateDataBody = `<div class="row">`;

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

      selectCategoryData += `<option value="${data[key].ctid}">${data[key].name}</option>`;

      filterCategoryData += `<a style="cursor: pointer;" class="dropdown-item" onclick="filterCandidatesByCategory('${data[key].ctid}')">
        <li><i class="fa-solid fa-clock"></i>&nbsp; ${data[key].name}</li>
      </a>`;

      rankingCandidateDataBody += `

      `;
    });
  } else {
    tableData += `<tr class="text-center">
      <td></td>
      <td class="text-center"> Something went wrong <i class="fa-solid fa-face-sad-tear"></i></td>
      <td></td>
    </tr>`;
 	}
  selectCategoryData += `</select>`;
  filterCategoryData += `</ul>`;
   	
  $('#categoryBody').html(tableData);
  $('.selectCategoryBody').html(selectCategoryData);
  $('#filterCategoryDataBody').html(filterCategoryData);
};

/*
	|--------------------------------------------------------------------------
	| Configuration >>> Vote Points
	|--------------------------------------------------------------------------
*/

const getAllVotePoints = async () => {
  $.ajax({
    url: `/${APP_VERSION}/${CONFIGURATION_URI}/vote-points`,
    method: 'get',
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': CSRF_TOKEN
    },
    success: (data) => {
     displayVotePoints(data);
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
    url: `/${APP_VERSION}/${CONFIGURATION_URI}/vote-points/store`,
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
        $('#appVersionSelectedVP').val('');
        $('#qrCodeImage').val("");
        $('#versionFilterSelectedVP').val(APP_VERSION);
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
    url: `/${APP_VERSION}/${CONFIGURATION_URI}/vote-points/${vpid}/update`,
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
    url: `/${APP_VERSION}/${CONFIGURATION_URI}/vote-points/${vpid}/destroy`,
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

const displayVotePoints = (data) => {
	let tableData = ``;
  let amountSelect = `<select class="form-select amountSelected"><option value="" id="selectedVotePoints" selected>-- SELECT --</option>`;
	
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
	         	<button onclick="uploadButtonIcon(${data[key].vpid})" class="btn btn-sm border-0"><i class="fa-solid fa-upload fs-5 me-2 text-muted"></i></button>
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

      amountSelect += `<option data-amount="${data[key].amount}" class="optionDataVotePoints_${data[key].vpid}" value="${data[key].vpid}">${data[key].amount}</option>`;
    });
	} else {
		tableData += `<tr class="text-center">
      <td></td>
      <td class="text-center"> Something went wrong <i class="fa-solid fa-face-sad-tear"></i></td>
      <td></td>
    </tr>`;
	} 

  amountSelect += `</select><div class="invalid-feedback votePointIdError"></div>`;

  $('#equivalentVotePointsBody').html(tableData);
  $('.voteAmountSelectDataBody').html(amountSelect);
};

/*
	|--------------------------------------------------------------------------
	| Configuration >>> Campus
	|--------------------------------------------------------------------------
*/

const getAllCampus = () => {
  $.ajax({
    url: `/${APP_VERSION}/${CONFIGURATION_URI}/campus`,
    method: 'get',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
    success: (data) => {
      displayCampus(data);
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

const displayCampus = (data) => {
	let selectCampusData = `<select id="campusSelected" class="form-select"><option selected value="">-- SELECT --</option>`;
 	
 	if(typeof data === 'object' && data !== null) {
    Object.keys(data).forEach(key => {
      selectCampusData += `<option value="${data[key].scid}">${data[key].name}</option>`;
    });
  } 
 	selectCampusData += `</select>`;

  $('.selectCampusBody').html(selectCampusData);
};