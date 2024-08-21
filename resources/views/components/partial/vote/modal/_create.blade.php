<div class="modal fade" id="createNewVoteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
		    <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ __('(Admin) Create new votes') }}</h1>
		    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		  </div>
		  <div class="modal-body">
		    <form action="#" method="post" id="voteAdminForm">
		      <fieldset>
		        <legend>---</legend>
		       	<div class="row mt-2">
		        	<div class="col-sm-3">
		        		<label for="votersName" class="col-form-label fw-bold">{{ __('Email') }}</label>
		        	</div>
		        	<div class="col-sm-9">
		        		<small class="text-muted">
		        			{{ __('This field is filled up because. for admin purpose')}}
		        		</small>
		        		<input type="text" class="form-control w-100 readonly"  id="votersName"
		        			value="admin@voting.goldenmindsbulacan.com" readonly
		        		/>
		        	</div>
		        </div>

		        <div class="row mt-2">
		        	<div class="col-sm-3">
		        		<label for="votersContact" class="col-form-label fw-bold">{{ __('Contact no.') }}</label>
		        	</div>
		        	<div class="col-sm-9">
		        		<small class="text-muted">
		        			{{ __('This field is filled up because. for admin purpose')}}
		        		</small>
		        		<input type="text" class="form-control w-100 readonly"  id="votersContact" value="{{ App\Helpers\Generator::generatePhoneNumber() }}" readonly/>
		        	</div>
		        </div>

		        <div class="row mt-2">
		        	<div class="col-sm-3">
		        		<label for="candidates" class="col-form-label fw-bold">{{ __('Candidate') }}</label>
		        	</div>
		        	<div class="col-sm-9 candidateSelectDataBody">
		        		{{-- data fetch via ajax functions/candidates.js--}}
		        	</div>
		        </div>

		        <div class="row mt-2">
		        	<div class="col-sm-3">
		        		<label for="candidates" class="col-form-label fw-bold">{{ __('Amount') }}</label>
		        	</div>
		        	<div class="col-sm-9 voteAmountSelectDataBody">
		        		{{-- data fetch via ajax functions/configuration.js--}}
		        	</div>
		        </div>

		        <div class="row mt-2">
		        	<div class="col-sm-3">
		        		<label for="votersContact" class="col-form-label fw-bold">{{ __('Referrence no.') }}</label>
		        	</div>
		        	<div class="col-sm-9">
		        		<small class="text-muted">
		        			{{ __('This field is filled up because. for admin purpose')}}
		        		</small>
		        		<input type="text" class="form-control w-100 readonly" id="referrenceNo"
		        			value="{{ App\Helpers\Generator::generateReferrenceNumber() }}" readonly
		        		/>
		        	</div>
		        </div>
		        <hr class="text-muted" />
		        <button type="button" class="btn btn-primary w-100" id="submitVote">
		        	{{ __('Submit vote') }}
		        	<i class="fas fa-spinner fa-spin loading-spinner d-none"></i>
		        </button>
		      </fieldset>
		    </form>
		  </div>
		  <div class="modal-footer"></div>
		</div>
	</div>
</div>