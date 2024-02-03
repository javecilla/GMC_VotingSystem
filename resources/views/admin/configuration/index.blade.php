<x-layout.admin title="Configuration">
	<x-slot name="version">{{ request()->route('version') }}</x-slot>
	<section class="app-content"
		id="configurationContent"
		data-component="configuration"
		data-app="{{ request()->route('version') }}">
		<div class="container" data-aos="fade-in">
			{{-- Application Versioning --}}
			<div id="applicationVersionConfig" class="configuration-card card">
				<div class="card-header">
					<i class="fa-solid fa-list-check fs-4"></i>&nbsp;
					 <label>{{ __("Application") }}</label>
					<small>{{ __("(Use this module to create and set up new version of voting)") }}</small>
				</div>
				<div class="card-body">
					<div class="container">
						<div class="row">
							<div class="col-md-6">
								<fieldset>
									<legend class="fs-5 fw-bold">{{ __('Create New Version') }}</legend>
									<hr class="text-muted"/>
									<div class="row">
										<div class="col-md-6">
											<small class="text-muted">{{ __('Enter a new version of voting (v0)') }}</small>
											<div class="form-floating mb-2">
												<input type="text" class="form-control" id="newVotingVersion" placeholder="version"/>
												<label for="newVotingVersion">{{ __('Enter version') }}</label>
											</div>
										</div>
										<div class="col-md-6">
											<small class="text-muted">{{ __('Enter a new theme title of voting') }}</small>
											<div class="form-floating mb-2">
												<input type="text" class="form-control" id="newVotingTitle" placeholder="title"/>
												<label for="newVotingTitle">{{ __('Enter title') }}</label>
											</div>
										</div>
									</div>
									<button type="button" id="createNewVersionButton"
										class="btn btn-light w-100 btn-add">
										{{ __('Add') }}
				  					<i class="fas fa-spinner fa-spin loading-spinner d-none"></i>
									</button>
								</fieldset>
							</div>
							<div class="col-md-6">
								<fieldset>
									<legend class="fs-5 fw-bold">{{ __('List of Application Version') }}
									</legend><hr class="text-muted"/>
									<div id="equivalentVotePointsItem" class="table-responsive">
										<table class="table">
											<thead>
												<tr>
													<th>{{ __('Version') }}</th>
													<th>{{ __('Title') }}</th>
													<th class="text-end">{{ __('Actions') }}</th>
												</tr>
											</thead>
											<tbody id="versionDataBody">
												<tr class="text-center">
													<td></td>
													<td class="text-center">
														{{ __('Loading') }} <i class="fas fa-spinner fa-spin"></i>
													</td>
													<td></td>
												</tr>
											</tbody>
										</table>
									</div>
								</fieldset>
							</div>
						</div>
					</div>
				</div>
			</div>
			<hr class="text-muted"/>

			{{--  Category --}}
			<div id="categoryConfig" class="configuration-card card mt-3">
				<div class="card-header">
					<i class="fa-solid fa-list-check fs-4"></i>&nbsp;
					 <label>{{ __("Category") }}</label>
					<small>{{ __('(Use this module to create and set up category for voting)') }}</small>
				</div>
				<div class="card-body">
					<div class="container">
						<div class="row">
							<div class="col-md-6">
								<fieldset>
									<legend class="fs-5 fw-bold">{{ __('Add New Category') }}</legend>
									<hr class="text-muted"/>
									<div class="mb-2">
										<small class="text-muted">
											{{ __('Select the version of voting you want to add this category') }}
										</small>
										<div class="selectDataBody">
											<label class="text-center">
												{{ __('Loading') }} <i class="fas fa-spinner fa-spin"></i>
											</label>
									  </div>
									</div>
									<div class="form-floating mb-2">
										<input type="text" class="form-control" id="newCategory" placeholder="category"/>
										<label for="newCategory">{{ __('Enter category name') }}</label>
									</div>
									<button type="button" id="createCategoryButton" class="btn btn-light w-100 btn-add">
										{{ __('Add') }}
				  					<i class="fas fa-spinner fa-spin loading-spinner d-none"></i>
									</button>
								</fieldset>
							</div>
							<div class="col-md-6">
								<fieldset>
									<legend class="fs-5 fw-bold">
										<span class="float-start">{{ __('List of Registered Category') }}</span>
										<span class="float-end selectFilterBody">
											{{-- data being fetch via ajax--}}
										</span>
									</legend>
									<hr class="text-muted"/>
									<div id="listOfCategoryItem" class="table-responsive">
										<table class="table">
											<thead>
												<tr>
													<th>{{ __('Name') }}</th>
													<th class="text-end">{{ __('Actions') }}</th>
												</tr>
											</thead>
											<tbody id="categoryBody">
												<tr class="text-center">
													<td class="text-center">
														{{ __('Loading') }} <i class="fas fa-spinner fa-spin"></i>
													</td>
													<td></td>
												</tr>
											</tbody>
										</table>
									</div>
								</fieldset>
							</div>
						</div>
					</div>
				</div>
			</div>
			<hr class="text-muted"/>

			{{-- @TODO: VotePoints --}}
			<div id="VotePointsConfig" class="configuration-card card mt-3">
				<div class="card-header">
					<i class="fa-solid fa-list-check fs-4"></i>&nbsp;
					 <label>{{ __("Vote Points") }}</label>
					<small>{{ __('(Use this module to create and set up vote points for voting)') }}</small>
				</div>
				<div class="card-body">
					<div class="container">
						<div class="row">
							<div class="col-md-6">
								<fieldset>
									<legend class="fs-5 fw-bold">{{ __('Create Voting Points') }}</legend>
									<hr class="text-muted"/>
									<div class="mb-2">
										<small class="text-muted">
											{{ __('Select the version of voting you want to add this category') }}
										</small>
										<div class="selectDataBodyVP">
											<label class="text-center">
												{{ __('Loading') }} <i class="fas fa-spinner fa-spin"></i>
											</label>
									  </div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<small class="text-muted">{{ __('Enter amount (payment) value') }}</small>
											<div class="form-floating mb-2">
												<input type="text" class="form-control newAmount" id="newAmount" placeholder="category"/>
												<label for="newAmount">{{ __('Enter amount') }}</label>
											</div>
										</div>
										<div class="col-md-6">
											<small class="text-muted">{{  __('Enter equivalent vote points') }}</small>
											<div class="form-floating mb-2">
												<input type="text" class="form-control newPoints" id="newPoints" placeholder="category"/>
												<label for="newPoints">{{ __('Enter points') }}</label>
											</div>
										</div>
									</div>
									<button type="button" id="createVotingPointsButton" class="btn btn-light w-100 btn-add">
										{{ __('Add') }}
				  					<i class="fas fa-spinner fa-spin loading-spinner d-none"></i>
									</button>
								</fieldset>
							</div>
							<div class="col-md-6">
								<fieldset>
									<legend class="fs-5 fw-bold">
										<span class="float-start">{{ __('Equivalent Vote Points for each Amount') }}</span>
										<span class="float-end selectFilterBodyVP">
											{{-- data being fetch via ajax--}}
										</span>
									</legend>
									<hr class="text-muted"/>
									<div id="equivalentVotePointsItem" class="table-responsive">
										<table class="table">
											<thead>
												<tr>
													<th>Amount (₱)</th>
													<th>Points</th>
													<th class="text-end">Actions</th>
												</tr>
											</thead>
											<tbody id="equivalentVotePointsBody">
												{{-- Data fetch via ajax request --}}
											</tbody>
										</table>
									</div>
								</fieldset>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</x-layout.admin>
<script src="{{ asset('/wp-admin/themes/scripts/configuration/eventListener.js') }}"></script>