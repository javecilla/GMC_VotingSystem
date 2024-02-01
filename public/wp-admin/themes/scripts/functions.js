/*
|--------------------------------------------------------------------------
| Configuration >>> Application Version
|--------------------------------------------------------------------------
*/

// Get ALl Application Version
const getAllApplicationVersions = (appVersion, csrfToken) => {
  $.ajax({
    url: `/${appVersion}/admin/configuration/app-versions/all`,
    method: 'get',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': csrfToken },
    success: (data) => {
      
      let tableData = ``;
      let selectData = `<select class="form-select" id="appVersionSelected">
        <option selected value="">-- SELECT --</option>`;
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
        });
        selectData += `</select>`;
        $('#versionDataBody').html(tableData);
        $('.selectDataBody').html(selectData);
      } else {
        toastr.error('Unexpected data format:', data);
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
| @TODO: Configuration >>> Category
|--------------------------------------------------------------------------
*/

// Get ALl Category Records base on Application Version
const getAllCategory = (appVersion, csrfToken) => {
  $.ajax({
    url: `/${appVersion}/admin/configuration/category/all`,
    method: 'get',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': csrfToken },
    success: (data) => {
      let tableData = ``;
      if(typeof data === 'object' && data !== null) {
        Object.keys(data).forEach(key => {
          tableData += `
            <div class="row mb-2 border-bottom">
              <div class="col-sm-10">
                <p class="mb-0" id="colFormLabel">
                  ${data[key].name}
                </p>
              </div>
              <label for="colFormLabel" class="col-sm-2 col-form-label">
                <a href="javascript:void(0)">
                  <i class="fa-solid fa-pen-to-square fs-5 me-2 text-muted"></i>
                </a>
                <a href="javascript:void(0)">
                  <i class="fa-solid fa-trash fs-5 me-2 text-muted"></i>
                </a>
              </label>
            </div>
          `; 
        });
        
      }

      $('#categoryBody').html(tableData);
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

/*
|--------------------------------------------------------------------------
| Logout the user
|--------------------------------------------------------------------------
*/
const logoutUser = (uid, csrfToken) => {
  $.ajax({
    url: `/logout/user`,
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