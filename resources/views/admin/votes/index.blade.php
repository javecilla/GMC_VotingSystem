<x-layout.admin title="Votes Management">
	<x-slot name="version">{{ request()->route('version') }}</x-slot>
	<x-section id="votesManagementContent" data-component="votesManagement">
		<x-container>
			<div id="indexUri" data-iurl="{{ route('votes.index', request()->route('version')) }}">
				<input type="hidden" value="{{ request()->route('version') }}" id="appVersionName"/>
				<div class="row">
					<div class="col-md-4">
		        <div class="dashboard-card-black card">
		          <div class="card-content">
		            <h4><b>{{ __('Pending Votes') }}</b></h4>
		            <h2 class="text-left"><i class="fas fa-user-clock fs-2"></i>
		              <span id="totalAllPending"><i class="fas fa-spinner fa-spin"></i></span>
		            </h2>
		          </div>
		        </div>
	      	</div>
	      	<div class="col-md-4">
		        <div class="dashboard-card-black card">
		          <div class="card-content">
		            <h4><b>{{ __('Verified Votes') }}</b></h4>
		            <h2 class="text-left"><i class="fas fa-circle-check fs-2"></i>
		              <span id="totalVerifiedVotes"><i class="fas fa-spinner fa-spin"></i></span>
		            </h2>
		          </div>
		        </div>
	      	</div>
	      	<div class="col-md-4">
		        <div class="dashboard-card-black card">
		          <div class="card-content">
		            <h4><b>{{ __('Spam Votes') }}</b></h4>
		            <h2 class="text-left"><i class="fas fa-delete-left fs-2"></i>
		              <span id="totalSpamVotes"><i class="fas fa-spinner fa-spin"></i></span>
		            </h2>
		          </div>
		        </div>
	      	</div>
				</div>
			</div>
			<div class="votes-management-card card">
				<div class="card-header">
					<div class="float-start">
						<i class="fa-solid fa-list fs-4"></i>
						<label id="cardLabelTxt">{{ __("List of All Votes") }}</label>
					</div>
					<div class="float-end">
					  <div class="dropdown rounded-5">
				      <a href="javascript:void(0)" class="browse-listing d-flex align-items-center dropdown-toggle text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
				        <strong>Filter by: Status</strong>
				      </a>
				      <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
				      	<a class="dropdown-item all active allVotesBtn" href="javascript:void(0)"><li>
				        	<i class="fa-solid fa-server"></i>&nbsp; {{ __('All Votes') }}</li>
				        </a>
				        <li><hr class="dropdown-divider"></li>
				        <a class="dropdown-item pending filterVoteBtn" data-status="1" href="javascript:void(0)"><li>
				        	<i class="fa-solid fa-clock"></i>&nbsp; {{ __('Pending') }}</li>
				        </a>
				        <a class="dropdown-item verified filterVoteBtn" data-status="0" href="javascript:void(0)"><li>
				        	<i class="fa-solid fa-circle-check"></i>&nbsp; {{ __('Verified') }}</li>
				        </a>
				        <li><hr class="dropdown-divider"></li>
				        <a class="dropdown-item spam filterVoteBtn" data-status="2" href="javascript:void(0)"><li>
				        	<i class="fa-solid fa-circle-minus"></i>&nbsp; {{ __('Spam') }}</li></a>
				      </ul>
			    	</div>
					</div>
				</div>
				<div class="card-body">
					<form action="#" method="GET" class="search-form" id="searchForm">
						<div class="search-container">
							<button type="submit" id="searchBtn" class="searchBtn">
								<i class="fa-solid fa-magnifying-glass search-icon"></i>
							</button>
							<input type="search" class="search-input" id="search"
								placeholder="Search referrences number and click search button icon"
								autocomplete="search"
							/>
							<button type="button" id="addNewVoteBtn">
								<i class="fa-solid fa-plus create-icon"></i>
							</button>
						</div>
					</form>
					<div id="votesDataRecords" class="table-responsive">
						<table class="table table-striped">
						  <thead>
						  	<tr>
						  		<th>VID</th>
						  		<th>CID</th>
						  		<th>Payment</th>
						  		<th>Points</th>
						  		<th>Referrence no.</th>
						  		<th>Status</th>
						  		<th>Phone no.</th>
						  		<th>Datetime</th>
						  		<th class="text-end">Action</th>
						  	</tr>
						  </thead>
						  <tbody id="votesRecordsBody">
						  	<tr>
						  		<td></td>
						  		<td></td>
						  		<td></td>
						  		<td></td>
						  		<td rowspan="9">
										<h4 class="text-center text-secondary mt-2">{{ __('Loading') }} <i class="fas fa-spinner fa-spin"></i></h4>
									</td>
						  		<td></td>
						  		<td></td>
						  		<td></td>
						  		<td></td>
								</tr>
								{{-- data fetch via ajax [votes.js - getAllVotes()] --}}
						  </tbody>
						</table>
					</div>

					<div class="float-end">
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

		@include('components.partial.vote.modal._create')
		@include('components.partial.vote.modal._show')
		@include('components.partial.vote.modal._edit')
	</x-section>
</x-layout.admin>
<script src="{{ asset('/wp-admin/themes/scripts/functions/votes.js') }}"></script>
<script src="{{ asset('/wp-admin/themes/scripts/functions/candidate.js') }}"></script>
<script src="{{ asset('/wp-admin/themes/scripts/functions/configuration.js') }}"></script>
<script src="{{ asset('/wp-admin/themes/scripts/eventListener/votes.js') }}"></script>