<div class="modal fade" id="candidateInfoShow" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #363b42!important;">
				<input type="hidden" class="candidateId"/>
				<div class="float-start">
					<ul class="nav nav-tabs">
						<li class="nav-item">
						  <a class="nav-link active" id="tabInformation" data-bs-toggle="tab" href="javascript:void(0)">{{ __('Information') }}</a>
						  </li>
						<li class="nav-item">
						  <a class="nav-link text-white" id="tabRecords" data-bs-toggle="tab" href="javascript:void(0)">{{ __('Vote Records') }}</a>
						</li>
					</ul>
				</div>
				<button type="button" class="closeModalBtn float-end"
					style="background: transparent!important; border: none;">
					<i class="fa-solid fa-xmark text-white fs-5"></i>
				</button>
			</div>
			<div class="modal-body">
				<div class="card-body">
					<div class="container" id="showDataBody">
						<div class="tab-content" id="myTabContent">
						  <div class="tab-pane fade show active" id="tabPaneInformation" role="tabpanel">
						    <div class="row">
						        <div class="col">
						          <div class="dashboard-card-black card">
						            <div class="card-content">
							            <h4><b>{{ __('Current Points') }}</b></h4>
							            <h2 class="text-left"><i class="fa-solid fa-check-to-slot fs-2t"></i>
							              <span id="totalCurrentVotePoints">
							                <i class="fas fa-spinner fa-spin"></i>
							              </span>
						              </h2>
						            </div>
						          </div>
						        </div>
						        <div class="col">
						          <div class="dashboard-card-black card">
						            <div class="card-content">
						              <h4><b>{{ __('Total Verified Votes') }}</b></h4>
						              <h2 class="text-left"><i class="fa-solid fa-circle-check fs-2"></i></i>
						                <span id="totalVoters"><i class="fas fa-spinner fa-spin"></i></span>
						              </h2>
						            </div>
						          </div>
						        </div>
						        <div class="col">
						          <div class="dashboard-card-black card">
						            <div class="card-content">
						              <h4><b>{{ __('Total Amount') }}</b></h4>
						              <h2 class="text-left"><span class="fs-2"></span>
						                <span id="totalAmount"><i class="fas fa-spinner fa-spin"></i></span>
						              </h2>
						            </div>
						          </div>
						        </div>
						    </div>
								<div class="row">
						      <div class="col-md-5">
						          <div class="card card-cover overflow-hidden text-bg-dark rounded-4 shadow-sm"
						          	id="showCardCandidateImage">
						            <div id="cardOverlay" class="d-flex flex-column h-100 p-4 pb-3 text-white text-shadow-1">
						              <h4 class="pt-5 mt-5 mb-5 display-6 lh-1"></h4>
						            </div>
						          </div>
						        </div>
						        <div class="col-md-7">
							        <br/>
							        <div>
							          <div class="row mb-3">
							            <label for="candidateAppVersion" class="col-sm-2 col-form-label">
							            	<b>{{ __('Voting')}}</b>
							            </label>
							            <div class="col-sm-10">
							              <input type="text" id="votingVersion" class="form-control mouse-default" value="loading..." readonly/>
							            </div>
							          </div>
							          <div class="row mb-3">
							            <label for="selectCampus" class="col-sm-2 col-form-label">
							            	<b>{{ __('Campus') }}</b>
							            </label>
							            <div class="col-sm-10">
							              <input type="text" id="campusCandidate" class="form-control mouse-default" value="loading..." readonly/>
							            </div>
							          </div>
							          <div class="row mb-3">
							            <label for="candidateCategory" class="col-sm-2 col-form-label">
							            	<b>{{ __('Category') }}</b>
							            </label>
							              <div class="col-sm-10">
							                <input type="text" id="categoryCandidate" class="form-control mouse-default" value="loading..." readonly/>
							              </div>
							            </div>
							            <div class="row mb-3">
							              <label for="candidateInfo" class="col-sm-2 col-form-label">
							              	<b>{{ __('Info') }}</b>
							              </label>
							                <div class="col-sm-10" id="candidateInfo">
							                	<div class="row">
							                		<div class="col-md-6">
							                			<small class="text-muted">{{ __('Candidate name') }}</small>
							                			<input type="text" id="nameCandidate" class="form-control mouse-default" value="loading..." readonly/>
							                		</div>
							                		<div class="col-md-6">
							                			<small class="text-muted">{{ __('Candidate no.') }}</small>
							                			<input type="text" id="noCandidate" class="form-control mouse-default" value="loading..." readonly/>
							                		</div>
							                	</div>
							                  <div class="form-floating mt-3">
							                    <textarea class="form-control mouse-default" placeholder="Leave a comment here" id="candidateMottoDescription">{{ __('loading...') }}</textarea>
							                    <label for="candidateMottoDescription"><small class="text-muted"></small></label>
							                  </div>
							                </div>
							              </div>
							            </div>
							            <hr class="text-muted"/>
							            <div class="row mb-3">
							              <label for="candidateInfo" class="col-sm-2 col-form-label">
							              	<b>{{ __('Timestamps') }}</b>
							              </label>
							                <div class="col-sm-10" id="candidateInfo">
							                	<div class="row">
							                		<div class="col-md-6">
							                			<small class="text-muted">{{ __('Created at') }}</small>
							                			<input type="text" id="dateCreated" class="form-control mouse-default" value="loading..." readonly/>
							                		</div>
							                		<div class="col-md-6">
							                			<small class="text-muted">{{ __('Updated at') }}</small>
							                			<input type="text" id="dateUpdated" class="form-control mouse-default" value="loading..." readonly/>
							                		</div>
							                	</div>
							                </div>
							              </div>
							            </div>
							          </div>
							        </div>
						        </div>
						    </div>
						  </div>
						  <div class="tab-pane fade" id="tabPaneRecords" role="tabpanel">
						  	<div class="row">
									<div class="col-md-4">
						        <div class="dashboard-card-black card">
						          <div class="card-content">
						            <h4><b>{{ __('Pending Votes') }}</b></h4>
						            <h2 class="text-left"><i class="fas fa-user-clock fs-2"></i>
						              <span id="totalPendingVotes"><i class="fas fa-spinner fa-spin"></i></span>
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
					      	<div class="col-md-4">
						        <div class="dashboard-card-black card">
						          <div class="card-content">
						            <h4><b>{{ __('Total of All Votes') }}</b></h4>
						            <h2 class="text-left"><i class="fas fa-users fs-2"></i>
						              <span id="totalOfAllVotes"><i class="fas fa-spinner fa-spin"></i></span>
						            </h2>
						          </div>
						        </div>
					      	</div>
								</div>
								<div id="votesDataRecords" class="table-responsive">
									<table class="table table-striped">
									  <thead>
									  	<tr>
									  		<th>{{ __('VID') }}</th>
									  		<th>{{ __('Candidate Name') }}</th>
									  		<th>{{ __('Payment') }}</th>
									  		<th>{{ __('Points') }}</th>
									  		<th>{{ __('Referrence no.') }}</th>
									  		<th>{{ __('Status') }}</th>
									  		<th>{{ __('Datetime') }}</th>
									  	</tr>
									  </thead>
									  <tbody id="candidatesVotesRecordsBody">
									  	<tr>
									  		<td></td>
									  		<td></td>
									  		<td></td>
									  		<td rowspan="7">
													<h4 class="text-center mt-2">{{ __('Loading') }} <i class="fas fa-spinner fa-spin"></i></h4>
												</td>
									  		<td></td>
									  		<td></td>
									  		<td></td>
											</tr>
									  </tbody>
									</table>
								</div>
						  </div>
						</div>
					</div>
				</div>
			</div>
		 	<div class="modal-footer d-flex justify-content-center align-items-center"></div>
		</div>
	</div>
</div>