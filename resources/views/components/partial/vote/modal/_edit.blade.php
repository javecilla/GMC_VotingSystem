<div class="modal fade" id="editInfoVoteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit votes information</h1>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      </div>
		      <div class="modal-body">
		      	<div id="editVotesRecordsBody">
		      		<fieldset>
		        		<legend>---</legend>
		        		<div class="row mt-2">
		        			<div class="col-sm-3">
		        				<label for="editVotersName" class="col-form-label fw-bold">Email</label>
		        			</div>
		        			<div class="col-sm-9">
		        				<input type="text" class="form-control w-100" id="editVotersName" placeholder="loading..."/>
		        			</div>
		        		</div>

		        		<div class="row mt-2">
		        			<div class="col-sm-3">
		        				<label for="votersContact" class="col-form-label fw-bold">Contact no.</label>
		        			</div>
		        			<div class="col-sm-9">
		        				<input type="text" class="form-control w-100"  id="editVotersContact"
		        					placeholder="loading..."
		        				/>
		        			</div>
		        		</div>

		        		<div class="row mt-2">
		        			<div class="col-sm-3">
		        				<label for="candidates" class="col-form-label fw-bold">Candidate</label>
		        			</div>
		        			<div class="col-sm-9">
		        				<div class="row">
		        					<div class="col-sm-9">
		        						<input type="text" class="form-control w-100 readonly"  id="activeCandidate"
		        							placeholder="loading..." readonly
		        						/>
		        					</div>
		        					<div class="col-sm-2 candidateSelectDataBody">
		        						<i class="fas fa-spinner fa-spin"></i>
		        						{{-- data fetch via ajax --}}
		        					</div>
		        				</div>
		        			</div>
		        		</div>

		        		<div class="row mt-2">
		        			<div class="col-sm-3">
		        				<label for="candidates" class="col-form-label fw-bold">Amount</label>
		        			</div>
		        			<div class="col-sm-9">
		        				<div class="row">
		        					<div class="col-sm-9">
		        						<input type="text" class="form-control w-100 readonly"  id="activeAmount"
		        							placeholder="loading..." readonly
		        						/>
		        					</div>
		        					<div class="col-sm-2 voteAmountSelectDataBody">
		        						<i class="fas fa-spinner fa-spin"></i>
		        						{{-- data fetch via ajax --}}
		        					</div>
		        				</div>
		        			</div>
		        		</div>

		        		<div class="row mt-2">
		        			<div class="col-sm-3">
		        				<label for="votersContact" class="col-form-label fw-bold">Referrence no.</label>
		        			</div>
		        			<div class="col-sm-9">
		        				<input type="text" class="form-control w-100" id="editReferrenceNo"
		        					placeholder="loading..."
		        				/>
		        			</div>
		        		</div>
		        		<hr class="text-muted" />
		        		<input type="hidden" value="" id="vid"/>
		        		<button type="button" class="btn btn-primary w-100" id="updateVote">Update vote
		        			<i class="fas fa-spinner fa-spin loading-spinner d-none"></i>
		        		</button>
		        	</fieldset>

		      	</div>
		      </div>
		      <div class="modal-footer"></div>
		    </div>
		  </div>
		</div>