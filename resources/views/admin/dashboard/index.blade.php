<x-layout.admin title="Dashboard">
	<x-slot name="version">{{ request()->route('version') }}</x-slot>
	<x-section id="dashboardContent" data-component="dashboard">
	  <x-container data-iurl="{{ route('dashboard.index', request()->route('version')) }}">
	  	<div>
		    <div class="row">
		      <div class="col-md-6 col-xl-3">
		        <div class="dashboard-card-black card">
		          <div class="card-content">
		            <h4><b>Pending Votes</b></h4>
		            <h2 class="text-left"><i class="fas fa-user-clock fs-2"></i>
		              <span id="totalAllPending"><i class="fas fa-spinner fa-spin"></i></span>
		            </h2>
		          </div>
		        </div>
		      </div>

		      <div class="col-md-6 col-xl-3">
		        <div class="dashboard-card-black card">
		          <div class="card-content">
		            <h4><b>Total Voters</b></h4>
		            <h2 class="text-left"><i class="fas fa-users fs-2"></i>
		              <span id="totalVotersVerified"><i class="fas fa-spinner fa-spin"></i></span>
		            </h2>
		          </div>
		        </div>
		      </div>

		      <div class="col-md-6 col-xl-3">
		        <div class="dashboard-card-black card">
		          <div class="card-content">
		            <h4><b>Total Amount</b></h4>
		            <h2 class="text-left"><span class="fs-2">{{ __('₱') }}</span>
		              <span id="totalAmountVerified"><i class="fas fa-spinner fa-spin"></i></span>
		            </h2>
		          </div>
		        </div>
		      </div>

		      <div class="col-md-6 col-xl-3">
		        <div class="dashboard-card-black card">
		          <div class="card-content">
		            <h4><b>Ticket Report's</b></h4>
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
						    <label>Candidates with Most Vote Points</label>
						  </div>
						  <div class="card-body">
						  	<canvas id="mostVotesCandidatesChart">
						  		<i class="fas fa-spinner fa-spin fs-2"></i>
						  	</canvas>
						  </div>
						</div>
		    	</div>
		    	<div class="col-md-6 mb-3">
		    		<div class="chart-card card">
						  <div class="card-header">
						    <i class="fa-solid fa-eye fs-4"></i>&nbsp;
						    <label>Page View's by Day</label>
						  </div>
						  <div class="card-body">
						  	<canvas id="pageViewChart">
						  		<i class="fas fa-spinner fa-spin fs-2"></i>
						  	</canvas>
						  </div>
						</div>
		    	</div>
		    </div>

		    <div class="row mt-2">
		    	<div class="col-md-12 mb-3">
		    		<div class="issue-report-card card">
						  <div class="card-header">
						  	<i class="fa-solid fa-clock fs-4"></i>
						    <label>Recently Voter's</label>
						  </div>
						  <div class="card-body">
						  	<div class="table-responsive" style="background: transparent;">
						  		<table class="table">
						  			<thead>
						  				<tr>
						  					<th>Status</th>
						  					<th>References no.</th>
						  					<th>Payment</th>
						  					<th>Email</th>
						  					<th>Date and Time</th>
						  				</tr>
						  			</thead>
						  			<tbody id="recentlyDataTableBody">
						  				<tr>
						  					<td colspan="5" class="text-center">
													<h6 class=" text-secondary mt-2">Loading <i class="fas fa-spinner fa-spin"></i></h6>
												</td>
											</tr>
						  			</tbody>
						  		</table>
						  	</div>
						  </div>
						</div>
		    	</div>
		    	<div class="col-md-12 mb-3">
		    		<div class="issue-report-card card">
						  <div class="card-header">
						  	<i class="fa-solid fa-bug fs-4"></i>&nbsp;
						    <label>Ticket Report's</label>
						  </div>
						  <div class="card-body">
						  	<div id="dashboardReportDataBody">
						  		<a href="#" class="list-group-item list-group-item-action text-center" aria-current="true" style="background: transparent;">
										<h6 class="text-center text-secondary mt-2">Loading <i class="fas fa-spinner fa-spin"></i></h6>
									</a>
	  						</div>
						  </div>
						</div>
		    	</div>
		    </div>
	    </div>
	  </x-container>
	</x-section>
</x-layout.admin>
<script src="{{ asset('/wp-plugins/chartjs/chart.js') }}"></script>
<script src="{{ asset('/wp-content/admin/themes/scripts/functions/dashboard.js') }}"></script>
<script src="{{ asset('/wp-content/admin/themes/scripts/functions/reports.js') }}"></script>
<script src="{{ asset('/wp-content/admin/themes/scripts/eventListener/dashboard.js') }}"></script>