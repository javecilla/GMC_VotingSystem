<x-layout.admin title="Dashboard">
	<x-slot name="version">{{ request()->route('version') }}</x-slot>
	<x-section data-component="dashboard" id="dashboardContent">
	  <x-container>
	  	<div id="indexUri" data-iurl="{{ route('dashboard.index', request()->route('version')) }}">
		    <div class="row">
		      <div class="col-md-6 col-xl-3">
		        <div class="dashboard-card-black card">
		          <div class="card-content">
		            <h4><b>{{ __('Pending Votes') }}</b></h4>
		            <h2 class="text-left"><i class="fas fa-user-clock fs-2"></i>
		              <span id="totalAllPending"><i class="fas fa-spinner fa-spin"></i></span>
		            </h2>
		          </div>
		        </div>
		      </div>

		      <div class="col-md-6 col-xl-3">
		        <div class="dashboard-card-black card">
		          <div class="card-content">
		            <h4><b>{{ __('Total Voters') }}</b></h4>
		            <h2 class="text-left"><i class="fas fa-users fs-2"></i>
		              <span id="totalVotersVerified"><i class="fas fa-spinner fa-spin"></i></span>
		            </h2>
		          </div>
		        </div>
		      </div>

		      <div class="col-md-6 col-xl-3">
		        <div class="dashboard-card-black card">
		          <div class="card-content">
		            <h4><b>{{ __('Total Amount') }}</b></h4>
		            <h2 class="text-left"><span class="fs-2">₱</span>
		              <span id="totalAmountVerified"><i class="fas fa-spinner fa-spin"></i></span>
		            </h2>
		          </div>
		        </div>
		      </div>

		      <div class="col-md-6 col-xl-3">
		        <div class="dashboard-card-black card">
		          <div class="card-content">
		            <h4><b>{{ __("Issue's Report") }}</b></h4>
		            <h2 class="text-left"><i class="fa-solid fa-bug fs-2"></i>
		              <span id="totalIssueReport"><i class="fas fa-spinner fa-spin"></i></span>
		            </h2>
		          </div>
		        </div>
		      </div>
		    </div>

		    <div class="row mt-2">
		    	<div class="col-md-6 mb-3">
		    		<div class="chart-card card">
						  <div class="card-header">
						    <i class="fa-solid fa-chart-simple fs-3"></i>&nbsp;
						    <label>{{ __('Candidates with Most Vote Points') }}</label>
						  </div>
						  <div class="card-body">
						  	<canvas id="mostVotesCandidatesChart"></canvas>
						  </div>
						</div>
		    	</div>
		    	<div class="col-md-6 mb-3">
		    		<div class="chart-card card">
						  <div class="card-header">
						    <i class="fa-solid fa-eye fs-4"></i>&nbsp;
						    <label>{{ __("Page's View") }}</label>
						  </div>
						  <div class="card-body">
						  	<canvas id="pageViewChart"></canvas>
						  </div>
						</div>
		    	</div>
		    </div>

		    <div class="row mt-2">
		    	<div class="col-md-6 mb-3">
		    		<div class="issue-report-card card">
						  <div class="card-header">
						  	<i class="fa-solid fa-clock fs-4"></i>
						    <label>{{ __("Recently Voter's") }}</label>
						  </div>
						  <div class="card-body">
						  	<div class="table-responsive" style="background: transparent;">
						  		<table class="table table-striped">
						  			<thead>
						  				<tr>
						  					<th>Status</th>
						  					<th>References no.</th>
						  					<th>Payment</th>
						  					<th>Email</th>
						  				</tr>
						  			</thead>
						  			<tbody id="recentlyDataTableBody">
						  				<tr>
						  					<td></td>
									  		<td rowspan="4">
													<h6 class="text-center text-secondary mt-2">{{ __('Loading') }} <i class="fas fa-spinner fa-spin"></i></h6>
												</td>
									  		<td></td>
									  		<td></td>
											</tr>
						  				{{-- data fetch via ajax functions/dashboard.js --}}
						  			</tbody>
						  		</table>
						  	</div>
						  </div>
						</div>
		    	</div>
		    	<div class="col-md-6 mb-3">
		    		<div class="issue-report-card card">
						  <div class="card-header">
						  	<i class="fa-solid fa-bug fs-4"></i>&nbsp;
						    <label>{{ __("Issue's Reports") }}</label>
						  </div>
						  <div class="card-body">
						  	<div id="dashboardReportDataBody">
						  		<a href="#" class="list-group-item list-group-item-action text-center" aria-current="true" style="background: transparent;">
										<h6 class="text-center text-secondary mt-2">{{ __('Loading') }} <i class="fas fa-spinner fa-spin"></i></h6>
									</a>
						  		{{-- data fecth via ajax functions/reports.js --}}
	  						</div>
						  </div>
						</div>
		    	</div>
		    </div>
	    </div>
	  </x-container>
	</x-section>
</x-layout.admin>
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
<script src="{{ asset('/wp-admin/plugins/chartjs/chart.js') }}"></script>
<script src="{{ asset('/wp-admin/themes/scripts/functions/dashboard.js') }}"></script>
<script src="{{ asset('/wp-admin/themes/scripts/functions/reports.js') }}"></script>
<script src="{{ asset('/wp-admin/themes/scripts/eventListener/dashboard.js') }}"></script>