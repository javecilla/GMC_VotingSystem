<x-layout.admin title="Candidates Management">
<x-slot name="version">{{ request()->route('version') }}</x-slot>
	<x-section id="candidatesManagementContent" data-component="candidatesManagement">
		<x-container>
			<div id="indexUri" data-iurl="{{ route('candidates.index', request()->route('version')) }}" class="votes-management-card card">
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
				      <div id="filterCategoryDataBody">
				      	{{-- functions->configuration.js --}}
				      </div>
			    	</div>
					</div>
				</div>

				<div class="card-body">
					<form action="#" method="GET" class="search-form" id="searchForm">
						<div class="search-container">
							<button type="submit" id="searchBtn">
								<i class="fa-solid fa-magnifying-glass search-icon"></i>
							</button>
							<input type="search" class="search-input" name="search" id="searchCandidate"
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

					<div class="float-end mt-3">
					 	<button type="button" id="prevPaginateBtn" class="btn btn-dark btn-sm"
					 		title="reduce load data votes records" disabled>
					 		<i class="fa-solid fa-chevron-left reduce-icon"></i>
					 		<i class="fas fa-spinner fa-spin d-none"></i>
					 	</button>
					 	<button type="button" id="nextPaginateBtn" class="btn btn-dark btn-sm"
					 		 title="load more votes records">
					 		<i class="fa-solid fa-chevron-right load-icon"></i>
					 		<i class="fas fa-spinner fa-spin spinner-icon d-none"></i>
					 	</button>
					</div>
				</div>
			</div>
		</x-container>
	</x-section>
</x-layout.admin>
<script src="{{ asset('/wp-admin/themes/scripts/eventListener/candidate.js') }}"></script>
<script src="{{ asset('/wp-admin/themes/scripts/functions/candidate.js') }}"></script>
<script src="{{ asset('/wp-admin/themes/scripts/functions/configuration.js') }}"></script>