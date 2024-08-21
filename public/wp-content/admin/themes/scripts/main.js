const APP_VERSION = $('.app-content').data('app');
const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

	updateTime('#time'); // Update time on page load

  // Update time every second at @Top Navigation Bar
  setInterval(function() {
    updateTime('#time');
  }, 1000);

  setInterval(function() {
    checkUserSession();
  }, 20000);

  setTimeout(function() {
    getTotalNotFixedTicketReportsSidebar();
  }, 1500);

  setTimeout(function() {
  	getAllApplicationVersionsSidebar();
  }, 2000);


const getTotalNotFixedTicketReportsSidebar = () => {
	$.ajax({
    url: `/api/${APP_VERSION}/admin/manage/ticket/reports/count/not/fix`,
    method: 'get',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
    success: (data) => {
      $('.report-badge').text(data.totalReports);
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      console.log(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

const getAllApplicationVersionsSidebar = () => {
  $.ajax({
    url: `/api/${APP_VERSION}/admin/configuration/app-versions/all/records`,
    method: 'get',
    dataType: 'json',
    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
    success: (data) => {
     	let switchVersions = `<ul class="dropdown-menu dropdown-menu-dark text-small shadow">`;

		  if(typeof data === 'object' && data !== null) {
   			Object.keys(data).forEach(key => {
          let currentURL = window.location.href;
          let redirectURL = currentURL.replace(/\/v\d\.\d\//, `/${data[key].name}/`);
   				switchVersions += `<a class="dropdown-item"
            href="/${APP_VERSION}/admin/switching/version?request_version=${data[key].name}&redirect_to=${redirectURL}">
       		 	<li>${data[key].name}</li>
      		</a>
      	`;
   			});
   		}

   		switchVersions += `</ul>`;

   		$('#switchVersionsBody').html(switchVersions);
    },
    error: (xhr, status, error) => {
      const response = JSON.parse(xhr.responseText);
      toastr.error(response.message);
    }
  });
};

// toastr config style
toastr.options = {
	"debug": false,
	"rtl": false,
	"newestOnTop": false,
	"preventDuplicates": false,
	"progressBar": true,
	"showDuration": "500",
  "hideDuration": "2500",
	"timeOut": 5000,
	"extendedTimeOut": 0,
	"closeButton": true,
	"closeMethod": 'fadeOut',
	"closeEasing": 'swing',
	"hideEasing": "linear",
	"showMethod": "fadeIn",
  "hideMethod": "fadeOut",
	"positionClass": 'toast-bottom-right',
};