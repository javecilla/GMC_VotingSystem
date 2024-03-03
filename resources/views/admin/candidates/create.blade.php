<x-layout.admin title="Create Candidate">
	<x-slot name="version">{{ request()->route('version') }}</x-slot>
	<x-section id="candidatesManagementContent" data-component="candidatesManagement">
		<x-container data-iurl="{{ route('candidates.index', request()->route('version')) }}">
			{{-- Hidden data inputs --}}
			<input type="hidden" value="3" id="candidateId"/>
			<div class="votes-management-card card bg-white">
				<div class="card-header">
					<i class="fa-solid fa-user-plus fs-4"></i>&nbsp;
					<label>{{ __("Create New Candidate") }}</label>
					<div class="float-end">
						<a href="{{ route('candidates.index', ['version' => request()->route('version')]) }}"
							class="btn btn-light border-0 ">
							<i class="fa-solid fa-arrow-left"></i> {{ __('Back') }}
						</a>
					</div>
				</div>
				<div class="card-body">
					<div class="container">
						<div class="row">
							{{-- preview --}}
							<div class="col-md-5">
								<div class="card card-cover overflow-hidden text-bg-dark rounded-4 shadow-sm"
									id="cardCandidateImage"
									style="background-image: url({{ asset('/wp-content/admin/uploads/noimg-yet.PNG') }});">
				          <div id="cardOverlay" class="d-flex flex-column h-100 p-4 pb-3 text-white text-shadow-1">
				            <h4 class="pt-5 mt-5 mb-5 display-6 lh-1"></h4>
				            <ul class="d-flex list-unstyled mt-auto">
				              <li class="me-auto" style="margin-top: 5px">
				              	<a href="javascript:void(0)" class="button-links d-flex align-items-center text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
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
				                	<span id="candidateNameText">{{ __('Candidate Name') }}</span>
				                	<span>&nbsp;:&nbsp;</span>
				                	<span id="candidateNoText">{{ __('00') }}</span>
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
								    	{{ __('Version') }}
								    </label>
								    <div class="col-sm-10">
								    	<small class="text-muted">
								    		{{ __('Select the version of voting you want to add this candidate') }}
								    	</small>
								    	<div class="selectDataBody">
								    		{{-- data fetch via ajax  functions/configurations.js --}}
								    	</div>
								    </div>
								  </div>

								  <div class="row mb-3">
								    <label for="selectCampus" class="col-sm-2 col-form-label">
								    	{{ __('Campus') }}
								    </label>
								    <div class="col-sm-10">
								    	<small id="campusLabel" class="text-muted">
								    		{{ __('Select the campus candidate. Leave it blank if not applicable.') }}
								    	</small>
								    	<div class="selectCampusBody">
									      {{-- data fetch via ajax  functions/configurations.js --}}
									  	</div>
								    </div>
								  </div>

								  <div class="row mb-3">
								    <label for="candidateCategory" class="col-sm-2 col-form-label">
								    	{{ __('Category') }}
								    </label>
								    <div class="col-sm-10">
								    	<div class="selectCategoryBody">
								    		{{-- data fetch via ajax functions/configurations.js--}}
									    </div>
								    </div>
								  </div>

								  <div class="row mb-3">
								    <label for="candidateInfo" class="col-sm-2 col-form-label">Info</label>
								    <div class="col-sm-10" id="candidateInfo">
								    	<div class="row">
								    		<div class="col-8">
								    			<input type="text" class="form-control" placeholder="Name"
								    			id="candidateName"/>
								    		</div>
								    		<div class="col-4">
								    			<input type="text" class="form-control" placeholder="Candidate no."
								    			id="candidateNo"/>
								    		</div>
								    	</div>

								    	<div class="form-floating mt-3">
											  <textarea class="form-control" placeholder="Leave a comment here" id="candidateMottoDescription"></textarea>
											  <label for="candidateMottoDescription"><small class="text-muted">
											  	{{ __('Candidate motto or description. Leave it blank if not applicable.') }}
											  </small></label>
											</div>
								    </div>
								  </div>

								  <div class="row mb-3">
								  	<label class="col-sm-2 col-form-label"
								  	style="cursor: pointer;">
								  		<span id="imageLabel">{{ __('Image') }}</span>
								  		<small id="removeImageButton"class="d-none">
								  			<i class="fa-solid fa-trash"></i> {{ __('Remove') }}
								  		</small>
								  	</label>
								    <div class="col-sm-10 ">
								    	<input type="file" class="form-control imageFile" id="candidateImage"
								    	accept="image/png, image/jpg, image/jpeg" />
								    	<div class="invalid-feedback imageValidationFeedBack"></div>
								    </div>
								  </div>
								  <button type="submit" id="createNewCandidate"
										class="btn btn-light w-100 btn-add">
										{{ __('Create') }}
				  					<i class="fas fa-spinner fa-spin loading-spinner d-none"></i>
									</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</x-container>
	</x-section>
</x-layout.admin>
<script src="{{ asset('/wp-content/admin/themes/scripts/eventListener/candidate.js') }}"></script>
<script src="{{ asset('/wp-content/admin/themes/scripts/functions/candidate.js') }}"></script>
<script src="{{ asset('/wp-content/admin/themes/scripts/functions/configuration.js') }}"></script>