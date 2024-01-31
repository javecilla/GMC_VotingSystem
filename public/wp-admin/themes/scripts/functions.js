/*
|--------------------------------------------------------------------------
| Get ALl Application Version
|--------------------------------------------------------------------------
 */
 const getAllApplicationVersions = (appVersion, csrfToken) => {
  $.get({
    url: `/${appVersion}/admin/app-versions`,
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': csrfToken },
    success: (data) => {
      //check if the return data in an object format and not null
      let listItem = ``;
      if(typeof data === 'object' && data !== null) {
        Object.keys(data).forEach(key => {
          listItem += `
            <tr class="appVersionItem_${data[key].avid}">
              <td>
                <small class="editNameVersion">${data[key].name}</small>
              </td>
              <td>
                <small class="editTitleVersion">${data[key].title}</small>
              </td>
              <td class="text-end">
                <a href="#edit" data-id="${data[key].avid}" class="appVersionButton">
                  <i class="fa-solid fa-pen-to-square edit-icon fs-5 me-2 text-muted"></i>
                  
                  <i class="fa-solid fa-floppy-disk save-icon d-none fs-5 me-2 text-muted"></i>
                </a>
                <a href="#close" class="appVersionButtonClose d-none">
                  <i class="fa-solid fa-circle-xmark fs-5 me-2 text-muted"></i>
                </a>
                <a href="#delete" data-id="${data[key].avid}" class="appVersionButtonDelete">
                  <i class="fa-solid fa-trash fs-5 me-2 text-muted"></i>
                </a>
              </td>
            </tr>
          `;
        });
        $('#versionDataBody').html(listItem);
      } else {
        console.error('Unexpected data format:', data);
      }
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      console.error(response.message);
    }
  });
};

/*
|--------------------------------------------------------------------------
| Update Application Version
|--------------------------------------------------------------------------
 */
 const updateApplicationVersion = (appVersion, csrfToken, avid, name, title) => {
  $.ajax({
    url: `/${appVersion}/admin/app-versions/${avid}/update`,
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
| @TODO: ADD FUNCTIONALITY AND DELETE
|--------------------------------------------------------------------------
 */

/*
|--------------------------------------------------------------------------
| Get ALl Category Records base on Application Version
|--------------------------------------------------------------------------
 */

const getAllCategory = (appVersion, csrfToken) => {
  $.get({
    url: `/${appVersion}/admin/category`,
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': csrfToken },
    success: (data) => {
      console.log(data);
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      console.log(response.message);
    }
  });
};

/*
|--------------------------------------------------------------------------
| Logout the user
|--------------------------------------------------------------------------
 */
const logoutUser = (uid, csrfToken) => {
  $.post({
    url: `/logout/user`,
    data: { 'uid': uid },
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': csrfToken },
    success: (response) => {
      window.location.href=response.redirect;
    },
    error: (xhr, status, error) => {
      console.log(xhr.responseText);
    }
  });
};