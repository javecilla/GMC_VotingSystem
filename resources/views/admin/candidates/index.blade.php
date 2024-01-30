<x-layout.admin title="Candidates Management">
<x-slot name="version">{{ request()->route('version') }}</x-slot>
	<section data-component="candidatesManagement" id="candidatesManagementContent">
		<div class="container" data-aos="fade-in">
			<div class="votes-management-card card">
				<div class="card-header">
					<div class="float-start">
						<i class="fa-solid fa-list fs-4"></i>
						<label>{{ __("List of All Candidates") }}</label>
					</div>
					<div class="float-end">
					  <div class="dropdown rounded-5">
				      <a href="javascript:void(0)" class="browse-listing d-flex align-items-center dropdown-toggle text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
				        <strong>Filter Category</strong>
				      </a>
				      <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
				      	<a class="dropdown-item active" href="javascript:void(0)"><li>
				        	<i class="fa-solid fa-server"></i>&nbsp; {{ __('All Candidates') }}</li>
				        </a>
				        <li><hr class="dropdown-divider"></li>
				        <a class="dropdown-item" href="javascript:void(0)"><li>
				        	<i class="fa-solid fa-clock"></i>&nbsp; {{ __('Category 1') }}</li>
				        </a>
				        <a class="dropdown-item" href="javascript:void(0)"><li>
				        	<i class="fa-solid fa-circle-check"></i>&nbsp; {{ __('Category 2') }}</li>
				        </a>
				      </ul>
			    	</div>
					</div>
				</div>
				<div class="card-body">
					<form action="#" method="GET" class="search-form" id="searchForm">
						<div class="search-container">
							<button type="submit" id="searchBtn">
								<i class="fa-solid fa-magnifying-glass search-icon"></i>
							</button>
							<input type="search" class="search-input" name="search"
								placeholder="Search candidate name and hit enter or click search button icon"
								autocomplete="search"
								value="{{ (isset($_GET['search'])) ? $_GET['search'] : ''}}"
							/>
							<a href="{{ route('candidates.create', ['version' => request()->route('version')]) }}" id="createBtn">
								<i class="fa-solid fa-user-plus create-icon"></i>
							</a>
						</div>
					</form>
					<div class="candidatesDataRecords">
						<div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5">
				      <div class="col">
				        <div class="card card-cover h-100 overflow-hidden border-0 text-bg-dark rounded-4 shadow-lg" style="background-image: url({{ asset('/wp-content/uploads/testcandidates8.PNG') }});
				        	height: 65vh!important;">
				          <div class="d-flex flex-column h-100 p-4 pb-3 text-white text-shadow-1">
				            <h4 class="pt-5 mt-5 mb-5 display-6 lh-1"></h4>
				            <ul class="d-flex list-unstyled mt-auto">
				              <li class="me-auto" style="margin-top: 5px">
				              	<a href="javascript:void(0)" class="button-links d-flex align-items-center dropdown-toggle text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
				              		<i class="fa-solid fa-ellipsis button-links-icon"></i>
				              	</a>
									      <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
									      	<a class="dropdown-item" href="javascript:void(0)"><li>
									        	<i class="fa-solid fa-eye"></i>&nbsp; {{ __('View') }}</li>
									        </a>
									      	<a class="dropdown-item" href="javascript:void(0)"><li>
									        	<i class="fa-solid fa-pen-to-square"></i>&nbsp; {{ __('Edit') }}</li>
									        </a>
									        <a class="dropdown-item" href="javascript:void(0)"><li>
									        	<i class="fa-solid fa-trash"></i>&nbsp; {{ __('Delete') }}</li>
									        </a>
									      </ul>
				              </li>
				              <li class="d-flex align-items-center">
				                <svg class="bi me-1" width="1em" height="1em"><use xlink:href="#geo-fill"/></svg>
				                <span class="fw-bold" style="font-size: 20px;">Candidate Name</span>
				              </li>
				            </ul>
				          </div>
				        </div>
				      </div>

				      <div class="col">
				        <div class="card card-cover h-100 overflow-hidden border-0 text-bg-dark rounded-4 shadow-lg" style="background-image: url({{ asset('/wp-content/uploads/testcandidates4.PNG') }});
				        	height: 65vh!important;">
				          <div class="d-flex flex-column h-100 p-4 pb-3 text-white text-shadow-1">
				            <h4 class="pt-5 mt-5 mb-5 display-6 lh-1"></h4>
				            <ul class="d-flex list-unstyled mt-auto">
				              <li class="me-auto" style="margin-top: 5px">
				              	<a href="javascript:void(0)" class="button-links d-flex align-items-center dropdown-toggle text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
				              		<i class="fa-solid fa-ellipsis button-links-icon"></i>
				              	</a>
									      <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
									      	<a class="dropdown-item" href="javascript:void(0)"><li>
									        	<i class="fa-solid fa-eye"></i>&nbsp; {{ __('View') }}</li>
									        </a>
									      	<a class="dropdown-item" href="javascript:void(0)"><li>
									        	<i class="fa-solid fa-pen-to-square"></i>&nbsp; {{ __('Edit') }}</li>
									        </a>
									        <a class="dropdown-item" href="javascript:void(0)"><li>
									        	<i class="fa-solid fa-trash"></i>&nbsp; {{ __('Delete') }}</li>
									        </a>
									      </ul>
				              </li>
				              <li class="d-flex align-items-center">
				                <svg class="bi me-1" width="1em" height="1em"><use xlink:href="#geo-fill"/></svg>
				                <span class="fw-bold" style="font-size: 20px;">Candidate Name</span>
				              </li>
				            </ul>
				          </div>
				        </div>
				      </div>

				      <div class="col">
				        <div class="card card-cover h-100 overflow-hidden border-0 text-bg-dark rounded-4 shadow-lg" style="background-image: url({{ asset('/wp-content/uploads/testcandidates3.PNG') }});
				        	height: 65vh!important;">
				          <div class="d-flex flex-column h-100 p-4 pb-3 text-white text-shadow-1">
				            <h4 class="pt-5 mt-5 mb-5 display-6 lh-1"></h4>
				            <ul class="d-flex list-unstyled mt-auto">
				              <li class="me-auto" style="margin-top: 5px">
				              	<a href="javascript:void(0)" class="button-links d-flex align-items-center dropdown-toggle text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
				              		<i class="fa-solid fa-ellipsis button-links-icon"></i>
				              	</a>
									      <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
									      	<a class="dropdown-item" href="javascript:void(0)"><li>
									        	<i class="fa-solid fa-eye"></i>&nbsp; {{ __('View') }}</li>
									        </a>
									      	<a class="dropdown-item" href="javascript:void(0)"><li>
									        	<i class="fa-solid fa-pen-to-square"></i>&nbsp; {{ __('Edit') }}</li>
									        </a>
									        <a class="dropdown-item" href="javascript:void(0)"><li>
									        	<i class="fa-solid fa-trash"></i>&nbsp; {{ __('Delete') }}</li>
									        </a>
									      </ul>
				              </li>
				              <li class="d-flex align-items-center">
				                <svg class="bi me-1" width="1em" height="1em"><use xlink:href="#geo-fill"/></svg>
				                <span class="fw-bold" style="font-size: 20px;">Candidate Name</span>
				              </li>
				            </ul>
				          </div>
				        </div>
				      </div>

				      <div class="col">
				        <div class="card card-cover h-100 overflow-hidden border-0 text-bg-dark rounded-4 shadow-lg" style="background-image: url({{ asset('/wp-content/uploads/testcandidates1.PNG') }});
				        	height: 65vh!important;">
				          <div class="d-flex flex-column h-100 p-4 pb-3 text-white text-shadow-1">
				            <h4 class="pt-5 mt-5 mb-5 display-6 lh-1"></h4>
				            <ul class="d-flex list-unstyled mt-auto">
				              <li class="me-auto" style="margin-top: 5px">
				              	<a href="javascript:void(0)" class="button-links d-flex align-items-center dropdown-toggle text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
				              		<i class="fa-solid fa-ellipsis button-links-icon"></i>
				              	</a>
									      <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
									      	<a class="dropdown-item" href="javascript:void(0)"><li>
									        	<i class="fa-solid fa-eye"></i>&nbsp; {{ __('View') }}</li>
									        </a>
									      	<a class="dropdown-item" href="javascript:void(0)"><li>
									        	<i class="fa-solid fa-pen-to-square"></i>&nbsp; {{ __('Edit') }}</li>
									        </a>
									        <a class="dropdown-item" href="javascript:void(0)"><li>
									        	<i class="fa-solid fa-trash"></i>&nbsp; {{ __('Delete') }}</li>
									        </a>
									      </ul>
				              </li>
				              <li class="d-flex align-items-center">
				                <svg class="bi me-1" width="1em" height="1em"><use xlink:href="#geo-fill"/></svg>
				                <span class="fw-bold" style="font-size: 20px;">Candidate Name</span>
				              </li>
				            </ul>
				          </div>
				        </div>
				      </div>

				      <div class="col">
				        <div class="card card-cover h-100 overflow-hidden border-0 text-bg-dark rounded-4 shadow-lg" style="background-image: url({{ asset('/wp-content/uploads/testcandidates6.PNG') }});
				        	height: 65vh!important;">
				          <div class="d-flex flex-column h-100 p-4 pb-3 text-white text-shadow-1">
				            <h4 class="pt-5 mt-5 mb-5 display-6 lh-1"></h4>
				            <ul class="d-flex list-unstyled mt-auto">
				              <li class="me-auto" style="margin-top: 5px">
				              	<a href="javascript:void(0)" class="button-links d-flex align-items-center dropdown-toggle text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
				              		<i class="fa-solid fa-ellipsis button-links-icon"></i>
				              	</a>
									      <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
									      	<a class="dropdown-item" href="javascript:void(0)"><li>
									        	<i class="fa-solid fa-eye"></i>&nbsp; {{ __('View') }}</li>
									        </a>
									      	<a class="dropdown-item" href="javascript:void(0)"><li>
									        	<i class="fa-solid fa-pen-to-square"></i>&nbsp; {{ __('Edit') }}</li>
									        </a>
									        <a class="dropdown-item" href="javascript:void(0)"><li>
									        	<i class="fa-solid fa-trash"></i>&nbsp; {{ __('Delete') }}</li>
									        </a>
									      </ul>
				              </li>
				              <li class="d-flex align-items-center">
				                <svg class="bi me-1" width="1em" height="1em"><use xlink:href="#geo-fill"/></svg>
				                <span class="fw-bold" style="font-size: 20px;">Candidate Name</span>
				              </li>
				            </ul>
				          </div>
				        </div>
				      </div>

				      <div class="col">
				        <div class="card card-cover h-100 overflow-hidden border-0 text-bg-dark rounded-4 shadow-lg" style="background-image: url({{ asset('/wp-content/uploads/testcandidates7.PNG') }});
				        	height: 65vh!important;">
				          <div class="d-flex flex-column h-100 p-4 pb-3 text-white text-shadow-1">
				            <h4 class="pt-5 mt-5 mb-5 display-6 lh-1"></h4>
				            <ul class="d-flex list-unstyled mt-auto">
				              <li class="me-auto" style="margin-top: 5px">
				              	<a href="javascript:void(0)" class="button-links d-flex align-items-center dropdown-toggle text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
				              		<i class="fa-solid fa-ellipsis button-links-icon"></i>
				              	</a>
									      <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
									      	<a class="dropdown-item" href="javascript:void(0)"><li>
									        	<i class="fa-solid fa-eye"></i>&nbsp; {{ __('View') }}</li>
									        </a>
									      	<a class="dropdown-item" href="javascript:void(0)"><li>
									        	<i class="fa-solid fa-pen-to-square"></i>&nbsp; {{ __('Edit') }}</li>
									        </a>
									        <a class="dropdown-item" href="javascript:void(0)"><li>
									        	<i class="fa-solid fa-trash"></i>&nbsp; {{ __('Delete') }}</li>
									        </a>
									      </ul>
				              </li>
				              <li class="d-flex align-items-center">
				                <svg class="bi me-1" width="1em" height="1em"><use xlink:href="#geo-fill"/></svg>
				                <span class="fw-bold" style="font-size: 20px;">Candidate Name</span>
				              </li>
				            </ul>
				          </div>
				        </div>
				      </div>
			    	</div>
					</div>


					<nav aria-label="Page navigation example" class="float-end">
					  <ul class="pagination">
					    <li class="page-item">
					      <a class="page-link" href="#" aria-label="Previous">
					        <span aria-hidden="true">&laquo;</span>
					      </a>
					    </li>
					    <li class="page-item active"><a class="page-link" href="#">1</a></li>
					    <li class="page-item"><a class="page-link" href="#">2</a></li>
					    <li class="page-item"><a class="page-link" href="#">3</a></li>
					    <li class="page-item">
					      <a class="page-link" href="#" aria-label="Next">
					        <span aria-hidden="true">&raquo;</span>
					      </a>
					    </li>
					  </ul>
					</nav>
				</div>
			</div>
		</div>
	</section>
</x-layout.admin>