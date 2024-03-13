<div class="modal fade" id="candidateInfoEdit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #363b42!important;">
				<input type="hidden" class="candidateId"/>
				<div class="float-start text-white">
					<i class="fa-solid fa-eye fs-4"></i>&nbsp;
					<label><b>{{ __("Edit Candidate") }}</b></label>
				</div>
				<button type="button" class="closeModalBtn float-end"
					style="background: transparent!important; border: none;">
					<i class="fa-solid fa-xmark text-white fs-5"></i>
				</button>
			</div>
			<div class="modal-body">
				{{-- Hidden data inputs --}}
				{{-- active candidate id --}}
				<input type="hidden" id="editPrevPicture"/>
				<input type="hidden" id="editActiveCandidate"/>
				<div class="row">
					<div class="col-md-5">
						{{-- preview --}}
						<div class="card card-cover overflow-hidden text-bg-dark rounded-4 shadow-sm"
							id="editCardCandidateImage" style="background-image: url({{ asset('/wp-content/admin/uploads/noimg-yet.PNG') }});">
					    <div id="cardOverlay" class="d-flex flex-column h-100 p-4 pb-3 text-white text-shadow-1">
					      <h4 class="pt-5 mt-5 mb-5 display-6 lh-1"></h4>
					        <ul class="d-flex list-unstyled mt-auto">
					          <li class="me-auto" style="margin-top: 5px">
					            <a href="javascript:void(0)" data-bs-toggle="dropdown" aria-expanded="false"
					            class="button-links d-flex align-items-center text-decoration-none">
					             	<i class="fa-solid fa-ellipsis button-links-icon"></i>
					            </a>
										  <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
										    <a class="dropdown-item" href="javascript:void(0)"><li>
										      <i class="fa-solid fa-eye"></i>&nbsp; {{ __('View') }}</li>
										    </a>
										    <a class="dropdown-item" href="javascript:void(0)"><li>
										      <i class="fa-solid fa-pen-to-square"></i>&nbsp; {{ __('Edit') }}</li>
										    </a>
										    <a class="dropdown-item" href="javascript:void(0)"><li>
										      <i class="fa-solid fa-trash"></i>&nbsp; {{ __('Delete') }}</li>
										    </a>
										  </ul>
					          </li>
					          <li class="d-flex align-items-center">
					            <svg class="bi me-1" width="1em" height="1em"><use xlink:href="#geo-fill"/></svg>
					            <label class="fw-bold"  style="font-size: 20px;">
					              <span id="editCandidateNameText">{{ __('Candidate Name') }}</span>
					              <span>&nbsp;:&nbsp;</span>
					              <span id="editCandidateNoText">{{ __('00') }}</span>
					            </label>
					          </li>
					        </ul>
					      </div>
					    </div>
						</div>
						{{-- form --}}
						<div class="col-md-7">
						<form method="post" action="#" id="createCandidateForm" class="mt-3">
							<div class="row mb-3">
								<label for="candidateAppVersion" class="col-sm-2 col-form-label">
									<b>{{ __('Version') }}</b>
								</label>
								<div class="col-sm-10">
									<div class="row">
									  <div class="col-md-10">
									    <input type="text" id="editCandidateVersion" class="form-control mouse-default" readonly/>
									  </div>
									  <div class="col-md-2 selectDataBody">
									    {{-- data fetch via ajax functions/candidates.js --}}
									  </div>
									</div>
								</div>
							</div>

							<div class="row mb-3">
								<label for="selectCampus" class="col-sm-2 col-form-label">
									<b>{{ __('Campus') }}</b>
								</label>
								<div class="col-sm-10">
									<div class="row">
									  <div class="col-md-10">
									   	<input type="text" id="editCandidateCampus" class="form-control mouse-default"
									   	placeholder="---" readonly/>
									  </div>
									  <div class="col-md-2 selectCampusBody">
									   	{{-- data fetch via ajax functions/configuration.js --}}
									  </div>
									</div>
								</div>
							</div>

							<div class="row mb-3">
								<label for="candidateCategory" class="col-sm-2 col-form-label">
									<b>{{ __('Category') }}</b>
								</label>
								<div class="col-sm-10">
									<div class="row">
									 	<div class="col-md-10">
									   	<input type="text" id="editCandidateCategory" class="form-control mouse-default" readonly/>
									  </div>
									  <div class="col-md-2 selectCategoryBody">
									    {{-- data fetch via ajax functions/configuration.js --}}
									  </div>
									</div>
								</div>
							</div>

							<div class="row mb-3">
								<label for="candidateInfo" class="col-sm-2 col-form-label">
									<b>{{ __('Info') }}</b>
								</label>
								<div class="col-sm-10" id="candidateInfo">
									<div class="row">
									  <div class="col-8">
									   	<small class="text-muted">{{ __('Candidate name') }}</small>
									   	<input type="text" class="form-control" placeholder="Name" id="editCandidateName"/>
									  </div>
									  <div class="col-4">
									    <small class="text-muted">{{ __('Candidate no.') }}</small>
									    <input type="text" class="form-control" placeholder="Candidate no." id="editCandidateNo"/>
									  </div>
									</div>

									<div class="form-floating mt-3">
										<textarea class="form-control" placeholder="---" id="editCandidateMottoDescription"></textarea>
										<label for="editCandidateMottoDescription">
											<small class="text-muted">{{ __('---') }}</small>
										</label>
									</div>
								</div>
							</div>

							<div class="row mb-3">
								<label class="col-sm-2 col-form-label mouse-pointer">
									<span id="imageLabel"><b>{{ __('Image') }}</b></span>
									<small id="removeImageButton"class="d-none">
									 	<i class="fa-solid fa-trash"></i> {{ __('Remove') }}
									</small>
								</label>
								<div class="col-sm-10 ">
									<input type="file" class="form-control imageFile" id="editCandidateImage"
									  accept="image/png, image/jpg, image/jpeg" />
									<div class="invalid-feedback imageValidationFeedBack"></div>
								</div>
							</div>
							<button type="button" id="updateCandidate" class="btn btn-light w-100 btn-add">
								{{ __('Update') }} <i class="fas fa-spinner fa-spin loading-spinner d-none"></i>
							</button>
						</form>
					</div>
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-center align-items-center"></div>
		</div>
	</div>
</div>