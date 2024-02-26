<div class="modal fade" id="createNewVoteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h1 class="modal-title fs-5" id="staticBackdropLabel">(Admin) Create new votes</h1>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      </div>
		      <div class="modal-body">
		        <form action="#" method="post" id="voteAdminForm">
		        	<fieldset>
		        		<legend>---</legend>
		        		<div class="row mt-2">
		        			<div class="col-sm-3">
		        				<label for="votersName" class="col-form-label fw-bold">Email</label>
		        			</div>
		        			<div class="col-sm-9">
		        				<small class="text-muted">This field is filled up because.</small>
		        				<input type="text" class="form-control w-100 readonly"  id="votersName"
		        					value="admin@voting.goldenmindsbulacan.com" readonly
		        				/>

		        			</div>
		        		</div>

		        		<div class="row mt-2">
		        			<div class="col-sm-3">
		        				<label for="votersContact" class="col-form-label fw-bold">Contact no.</label>
		        			</div>
		        			<div class="col-sm-9">
		        				<small class="text-muted">This field is filled up because.</small>
		        				<input type="text" class="form-control w-100 readonly"  id="votersContact"
		        					value="{{ App\Dto\HelperDto::generatePhoneNumber() }}" readonly
		        				/>
		        			</div>
		        		</div>

		        		<div class="row mt-2">
		        			<div class="col-sm-3">
		        				<label for="candidates" class="col-form-label fw-bold">Candidate</label>
		        			</div>
		        			<div class="col-sm-9 candidateSelectDataBody">
		        				{{-- data fetch via ajax --}}
		        			</div>
		        		</div>

		        		<div class="row mt-2">
		        			<div class="col-sm-3">
		        				<label for="candidates" class="col-form-label fw-bold">Amount</label>
		        			</div>
		        			<div class="col-sm-9 voteAmountSelectDataBody">
		        				{{-- data fetch via ajax --}}
		        			</div>
		        		</div>

		        		<div class="row mt-2">
		        			<div class="col-sm-3">
		        				<label for="votersContact" class="col-form-label fw-bold">Referrence no.</label>
		        			</div>
		        			<div class="col-sm-9">
		        				<small class="text-muted">This field is filled up because.</small>
		        				<input type="text" class="form-control w-100 readonly" id="referrenceNo"
		        					value="{{ App\Dto\HelperDto::generateReferrenceNumber() }}" readonly
		        				/>
		        			</div>
		        		</div>
		        		<hr class="text-muted" />
		        		<button type="button" class="btn btn-primary w-100" id="submitVote">Submit vote
		        			<i class="fas fa-spinner fa-spin loading-spinner d-none"></i>
		        		</button>
		        	</fieldset>
		        </form>
		      </div>
		      <div class="modal-footer"></div>
		    </div>
		  </div>
		</div>