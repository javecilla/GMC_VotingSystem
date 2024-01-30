<x-layout.admin title="Dashboard">
	<x-slot name="version">{{ request()->route('version') }}</x-slot>
	<section data-component="dashboard" id="dashboardContent">
	  <div class="container" data-aos="fade-in">
	    <div class="row">
	      <div class="col-md-6 col-xl-3">
	        <div class="dashboard-card-black card">
	          <div class="card-content">
	            <h4><b>{{ __('Pending Votes') }}</b></h4>
	            <h2 class="text-left"><i class="fas fa-user-clock fs-2"></i>
	              <span id="totalAllPending">0</span>
	            </h2>
	          </div>
	        </div>
	      </div>

	      <div class="col-md-6 col-xl-3">
	        <div class="dashboard-card-black card">
	          <div class="card-content">
	            <h4><b>{{ __('Total Voters') }}</b></h4>
	            <h2 class="text-left"><i class="fas fa-users fs-2"></i>
	              <span  id="totalVotersAll">0</span>
	            </h2>
	          </div>
	        </div>
	      </div>

	      <div class="col-md-6 col-xl-3">
	        <div class="dashboard-card-black card">
	          <div class="card-content">
	            <h4><b>{{ __('Total Amount') }}</b></h4>
	            <h2 class="text-left"><span class="fs-2">₱</span>
	              <span id="totalAmountAll">0</span>
	            </h2>
	          </div>
	        </div>
	      </div>

	      <div class="col-md-6 col-xl-3">
	        <div class="dashboard-card-black card">
	          <div class="card-content">
	            <h4><b>{{ __("Issue's Report") }}</b></h4>
	            <h2 class="text-left"><i class="fa-solid fa-bug fs-2"></i>
	              <span id="totalIssueReport">0</span>
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
					    <label>{{ __('Candidates with Most Votes') }}</label>
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
					  					<th>Email</th>
					  					<th>References no.</th>
					  					<th>Payment</th>
					  				</tr>
					  			</thead>
					  			<tbody>
					  				<tr title="Pending">
					  					<td><span class="badge text-bg-warning opacity-4 rounded-5" style="color: transparent!important; font-size: 10px;">0</span></td>
					  					<td>test1@gmail.com</td>
					  					<td>182475820582</td>
					  					<td>₱ 200.00</td>
					  				</tr>
					  				<tr title="Pending">
					  					<td><span class="badge text-bg-warning opacity-4 rounded-5" style="color: transparent!important; font-size: 10px;">0</span></td>
					  					<td>test2@gmail.com</td>
					  					<td>522375820981</td>
					  					<td>₱ 500.00</td>
					  				</tr>
					  				<tr title="Spam">
					  					<td><span class="badge text-bg-danger opacity-4 rounded-5" style="color: transparent!important; font-size: 10px;">0</span></td>
					  					<td>test3@gmail.com</td>
					  					<td>282375829092</td>
					  					<td>₱ 500.00</td>
					  				</tr>
					  				<tr title="Verified">
					  					<td><span class="badge text-bg-success opacity-4 rounded-5" style="color: transparent!important; font-size: 10px;">0</span></td>
					  					<td>test4@gmail.com</td>
					  					<td>922975822981</td>
					  					<td>₱ 100.00</td>
					  				</tr>
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
					  	<div class="list-group" >
						    <a href="#" class="list-group-item list-group-item-action d-flex gap-2 py-2 border-0" aria-current="true">
						      <img src="{{ asset('/wp-admin/uploads/profile.jpg') }}" alt="twbs" width="32" height="32" class="rounded-circle flex-shrink-0">
						      <div class="d-flex gap-2 w-100 justify-content-between">
						        <div>
						          <h6 class="mb-0">From: testing@gmail.com</h6>
						          <p class="mb-0 opacity-75">Lorem ipsum dolor sit amet, consectetur adipisicing elit...Read More</p>
						        </div>
						        <small class="opacity-50 text-nowrap">Feb 1, 2024</small>
						      </div>
						    </a>
						    <hr class="text-muted"/>
						    <a href="#" class="list-group-item list-group-item-action d-flex gap-2 py-2 border-0" aria-current="true">
						      <img src="{{ asset('/wp-admin/uploads/profile.jpg') }}" alt="twbs" width="32" height="32" class="rounded-circle flex-shrink-0">
						      <div class="d-flex gap-2 w-100 justify-content-between">
						        <div>
						          <h6 class="mb-0">From: testing@gmail.com</h6>
						          <p class="mb-0 opacity-75">Lorem ipsum dolor sit amet, consectetur adipisicing elit...Read More</p>
						        </div>
						        <small class="opacity-50 text-nowrap">Jan 29, 2024</small>
						      </div>
						    </a>
  						</div>
					  </div>
					</div>
	    	</div>
	    </div>
	  </div>
	</section>
</x-layout.admin>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('/wp-admin/themes/scripts/dashboard.js') }}"></script>