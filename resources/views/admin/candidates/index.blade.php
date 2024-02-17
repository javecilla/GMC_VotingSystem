<x-layout.admin title="Candidates Management">
<x-slot name="version">{{ request()->route('version') }}</x-slot>
	<x-section id="candidatesManagementContent" data-component="candidatesManagement">
		<x-container>
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
						<div class="text-muted mt-3 d-flex align-items-center justify-content-center text-center">
							<i class="fas fa-spinner fa-spin loading-spinner fs-4"></i>
							<span class="fs-4">&nbsp;{{ __('Loading...') }}</span>
						</div>
						{{-- data fetch via ajax --}}
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
		</x-container>
	</x-section>
</x-layout.admin>
<script src="{{ asset('/wp-admin/themes/scripts/eventListener/candidate.js') }}" defer></script>