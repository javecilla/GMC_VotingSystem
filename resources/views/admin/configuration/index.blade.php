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
									<legend class="fs-5 fw-bold">{{ __('List of Applicaiton Version') }}
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

			{{-- @TODO: Category --}}
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
									<div class="form-floating mb-2">
										<input type="text" class="form-control" id="newCategory" placeholder="category"/>
										<label for="newCategory">{{ __('Enter category name') }}</label>
									</div>
									<div class="mb-2">
										<small class="text-muted">
											{{ __('Please select the version of voting you want to add this category') }}
										</small>
										<div class="selectDataBody">
											<label class="text-center">
												{{ __('Loading') }} <i class="fas fa-spinner fa-spin"></i>
											</label>
									  </div>
									</div>
									<button type="button" class="btn btn-light w-100 btn-add">
										{{ __('Add') }}
				  					<i class="fas fa-spinner fa-spin loading-spinner d-none"></i>
									</button>
								</fieldset>
							</div>
							<div class="col-md-6">
								<fieldset>
									<legend class="fs-5 fw-bold">List of Registered Category</legend><hr class="text-muted"/>
									<div id="categoryBody">

										<div class="text-center">
											{{ __('Loading') }} <i class="fas fa-spinner fa-spin"></i>
										</div>

									</div>
								</fieldset>
							</div>
						</div>
					</div>
				</div>
			</div>
			<hr class="text-muted"/>

			{{-- VotePoints --}}
			<div id="VotePointsConfig" class="configuration-card card mt-3">
				<div class="card-header">
					<i class="fa-solid fa-list-check fs-4"></i>&nbsp;
					 <label>{{ __("Vote Points") }}</label>
					<small>(Use this module to create and set up vote points for voting)</small>
				</div>
				<div class="card-body">
					<div class="container">
						<div class="row">
							<div class="col-md-6">
								<fieldset>
									<legend class="fs-5 fw-bold">Create Voting Points</legend><hr class="text-muted"/>
									<div class="row">
										<div class="col-md-6">
											<small class="text-muted">Enter amount (payment) value</small>
											<div class="form-floating mb-2">
												<input type="text" class="form-control" id="newAmount" placeholder="category"/>
												<label for="newAmount">Enter amount</label>
											</div>
										</div>
										<div class="col-md-6">
											<small class="text-muted">Enter equivalent vote points</small>
											<div class="form-floating mb-2">
												<input type="text" class="form-control" id="newAmount" placeholder="category"/>
												<label for="newAmount">Enter points</label>
											</div>
										</div>
									</div>
									<div class="mb-2">
										<small class="text-muted">Please select the version of voting you want to add this category</small>
									  <select class="form-select" id="specificSizeSelect">
									    <option selected value="">{{ env('APP_VERSION') }} (latest)</option>
									    <option value="">v2</option>
									    <option value="">v1</option>
									  </select>
									</div>
									<button type="button" class="btn btn-light w-100 btn-add">
										Add
									</button>
								</fieldset>
							</div>
							<div class="col-md-6">
								<fieldset>
									<legend class="fs-5 fw-bold">Equivalent Vote Points for each Payment</legend><hr class="text-muted"/>
									<div id="equivalentVotePointsItem" class="table-responsive">
										<table class="table">
											<thead>
												<tr>
													<th>#</th>
													<th>Amount (₱)</th>
													<th>Points</th>
													<th class="text-end">Actions</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>1</td>
													<td><small contenteditable="true" class="form-control">
															100
														</small>
													</td>
													<td><small contenteditable="true" class="form-control">
															50
														</small>
													</td>
													<td class="text-end">
														<a href="#edit">
															<i class="fa-solid fa-pen-to-square fs-5 me-2 text-muted"></i></a>
										  			<a href="#delete">
										  				<i class="fa-solid fa-trash fs-5 me-2 text-muted"></i></a>
													</td>
												</tr>
												<tr>
													<td>2</td>
													<td>200</td>
													<td>150</td>
													<td class="text-end">
														<a href="#edit">
															<i class="fa-solid fa-pen-to-square fs-5 me-2 text-muted"></i></a>
										  			<a href="#delete">
										  				<i class="fa-solid fa-trash fs-5 me-2 text-muted"></i></a>
													</td>
												</tr>
												<tr>
													<td>3</td>
													<td>500</td>
													<td>500</td>
													<td class="text-end">
														<a href="#edit">
															<i class="fa-solid fa-pen-to-square fs-5 me-2 text-muted"></i></a>
										  			<a href="#delete">
										  				<i class="fa-solid fa-trash fs-5 me-2 text-muted"></i></a>
													</td>
												</tr>
												<tr>
													<td>4</td>
													<td>1000</td>
													<td>700</td>
													<td class="text-end">
														<a href="#edit">
															<i class="fa-solid fa-pen-to-square fs-5 me-2 text-muted"></i></a>
										  			<a href="#delete">
										  				<i class="fa-solid fa-trash fs-5 me-2 text-muted"></i></a>
													</td>
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
		</div>
	</section>
</x-layout.admin>
<script src="{{ asset('/wp-admin/themes/scripts/configuration/eventListener.js') }}"></script>