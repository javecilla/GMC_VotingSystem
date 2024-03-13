<x-layout.admin title="Ticket Reports">
	<x-slot name="version">{{ request()->route('version') }}</x-slot>
	<x-section data-component="ticketReport" id="ticketReportContent">
	  <x-container data-iurl="{{ route('reports.index', request()->route('version')) }}">
	  	<div>
	  		<div class="mt-2">
	  			<div class="votes-management-card card">
						  <div class="card-header">
						  	<div class="float-start">
						  		<i class="fa-solid fa-bug fs-4"></i>&nbsp;
						    	<label id="cardLabelTxt">{{ __("List of All Issue's Reports") }}</label>
						  	</div>
						  	<div class="float-end">
						  		<div class="dropdown rounded-5">
							      <a href="javascript:void(0)" class="text-white d-flex align-items-center dropdown-toggle text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
							        <strong>{{ __('Filter by: Status') }}</strong>
							      </a>
							      <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
							      	<a class="dropdown-item all active allReportsBtn" href="javascript:void(0)"><li>
							        	<i class="fa-solid fa-server"></i>&nbsp; {{ __('All Tickets') }}</li>
							        </a>
							        <li><hr class="dropdown-divider"></li>
							        <a class="dropdown-item fixed filterReportBtn"
							        data-status="0" href="javascript:void(0)"><li>
							        	<i class="fa-solid fa-circle-check"></i>&nbsp; {{ __('Fixed') }}</li>
							        </a>
							        <a class="dropdown-item pending filterReportBtn"
							        data-status="1" href="javascript:void(0)"><li>
							        	<i class="fa-solid fa-clock"></i>&nbsp; {{ __('Pending') }}</li>
							        </a>
							      </ul>
						    	</div>
						  	</div>
						  </div>
						  <div class="card-body">
						  	<form action="#" method="GET" class="search-form" id="searchForm">
									<div class="search-container">
										<button type="submit" id="searchBtn" class="searchBtn" title="search">
											<i class="fa-solid fa-magnifying-glass search-icon"></i>
										</button>
										<input type="search" class="search-input" id="search"
											placeholder="Search ticket reports e.g., name, email or message and hit enter or click the icon search button"
											autocomplete="search"
										/>
									</div>
								</form>
								<div id="reportDataBody" class="table-responsive">
									<table class="table table-hover table-striped">
										<tr>
								  		<td></td>
								  		<td></td>
								  		<td rowspan="5">
												<h4 class="text-center text-secondary mt-2">{{ __('Loading') }}
													<i class="fas fa-spinner fa-spin"></i></h4>
											</td>
								  		<td></td>
								  		<td></td>
										</tr>
									</table>
									{{-- data fetch via ajax functions/reports.js --}}
								</div>
	  						@include('components.partial._pagination')
						  </div>
						</div>
	  		</div>
	    </div>
	  </x-container>
	</x-section>
	@include('components.partial.report.modal._show')
	@include('components.partial.report.modal._create')
</x-layout.admin>
<script src="{{ asset('/wp-content/admin/themes/scripts/eventListener/reports.js') }}"></script>
<script src="{{ asset('/wp-content/admin/themes/scripts/functions/reports.js') }}"></script>