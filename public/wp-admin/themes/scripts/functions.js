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
      let selectFilter = `<select class="form-select" id="versionFilterSelected">
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
      $('#versionDataBody').html(tableData);
      $('.selectDataBody').html(selectData);
      $('.selectFilterBody').html(selectFilter);
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
    url: `/${appVersion}/admin/configuration/category/by-version`,
    method: 'get',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': csrfToken },
    success: (data) => {
      let tableData = ``;
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

      $('#categoryBody').html(tableData);
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

// Update Category Name
const updateCategory = (appVersion, csrfToken, ctid, name) => {
  $.ajax({
    url: `/${appVersion}/admin/configuration/category/${ctid}/update`,
    method: 'patch',
    data: { 
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
      } else {
        if(response.type === 'warning') {
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
  })
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
| @TODO: Configuration >>> Vote Points
|--------------------------------------------------------------------------
*/
const getAllVotePointsByVersion = (appVersion, csrfToken) => {
  $.ajax({
    url: `/${appVersion}/admin/configuration/vote-points/by-version`,
    method: 'get',
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': csrfToken
    },
    success: (data) => {
      console.log(data);
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      console.log(response.message);
    },
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