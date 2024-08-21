<div class="modal fade" id="showInfoVoteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
		    <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ __('View votes information') }}</h1>
		    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		  </div>
			<div class="modal-body">
			  <div id="showVotesRecordsBody">
			    				<div class="row mt-2">
		      <div class="col-sm-3"><label for="votersInfo" class="col-form-label fw-bold">Voters Info</label></div>
		      <div class="col-sm-9">
		      	<div class="row">
		      		<div class="col-md-6">
		      			<small class="text-muted">Email</small>
		      			<input type="text" class="form-control w-100 votersName" value="loading..." readonly/>
		      		</div>
		      		<div class="col-md-6">
		      			<small class="text-muted">Contact no.</small>
		      			<input type="text" class="form-control w-100 votersContact" value="loading..." readonly/>
		      		</div>
		      	</div>
		      </div>
		    </div>
		    <hr class="text-muted"/>
		    <div class="row mt-2">
		     	<div class="col-sm-3">
		        <label for="candidates" class="col-form-label fw-bold">Candidate Info</label>
		      </div>
		     	<div class="col-sm-9" id="candidateSelectDataBody">
		     		<div class="row">
		      		<div class="col-md-6">
		      			<small class="text-muted">Name</small>
		      			<input type="text" class="form-control w-100 candidateName" value="loading..." readonly/>
		      		</div>
		      		<div class="col-md-6">
		      			<small class="text-muted">Number</small>
		      			<input type="text" class="form-control w-100 candidateNo" value="loading..." readonly/>
		      		</div>
		      	</div>
		      </div>
		    </div>

		    <div class="row mt-2">
		      <div class="col-sm-3">
		       	<label for="candidates" class="col-form-label fw-bold">Amount & Points</label>
		      </div>
		      <div class="col-sm-9" id="voteAmountSelectDataBody">
		      	<div class="row">
		      		<div class="col-md-6">
		      			<small class="text-muted">Amount</small>
		      			<input type="text" class="form-control w-100 voteAmount" value="loading..." readonly/>
		      		</div>
		      		<div class="col-md-6">
		      			<small class="text-muted">Points</small>
		      			<input type="text" class="form-control w-100 votePoint" value="loading..." readonly/>
		      		</div>
		      	</div>
		      </div>
		   	</div>

		   	<div class="row mt-2">
		      <div class="col-sm-3">
		       	<label for="votersContact" class="col-form-label fw-bold">Referrence no.</label>
		      </div>
		      <div class="col-sm-9">
		        <input type="text" class="form-control w-100 referrenceNo" value="loading..." readonly/>
		      </div>
		    </div>
		    <hr class="text-muted"/>

		    <div class="row mt-2">
		      <div class="col-sm-3">
		       	<label for="candidates" class="col-form-label fw-bold">Timestamps</label>
		      </div>
		      <div class="col-sm-9" id="voteAmountSelectDataBody">
		      	<div class="row">
		      		<div class="col-md-6">
		      			<small class="text-muted">Voted at</small>
		      			<input type="text" class="form-control w-100 createdAt" value="loading..." readonly/>
		      		</div>
		      		<div class="col-md-6">
		      			<small class="text-muted">Update at</small>
		      			<input type="text" class="form-control w-100 updatedAt" value="loading..." readonly/>
		      		</div>
		      	</div>
		      </div>
		   	</div>
			  </div>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>