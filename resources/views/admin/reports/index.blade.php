<x-layout.admin title="Ticket Reports">
	<x-slot name="version">{{ request()->route('version') }}</x-slot>
	<x-section data-component="ticketReport" id="ticketReportContent">
	  <x-container data-iurl="{{ route('reports.index', request()->route('version')) }}">
	  	<div>
	  		<div class="mt-2">
	  			<div class="chart-card card">
						  <div class="card-header">
						  	<i class="fa-solid fa-bug fs-4"></i>&nbsp;
						    <label>{{ __("Issue's Reports") }}</label>
						  </div>
						  <div class="card-body">
						  	<div id="reportDataBody">
						  		{{-- data fetch via ajax functions/reports.js --}}
	  						</div>
	  						<div class="float-end">
								 	<button type="button" id="prevPaginateBtn" class="btn btn-dark btn-sm"
								 		title="reduce load data votes records" disabled>
								 		<i class="fa-solid fa-chevron-left reduce-icon"></i>
								 		<i class="fas fa-spinner fa-spin d-none"></i>
								 	</button>
								 	<button type="button" id="nextPaginateBtn" class="btn btn-dark btn-sm"
								 		 title="load more votes records">
								 		<i class="fa-solid fa-chevron-right load-icon"></i>
								 		<i class="fas fa-spinner fa-spin spinner-icon d-none"></i>
								 	</button>
								</div>
						  </div>
						</div>
	  		</div>
	    </div>
	  </x-container>
	</x-section>
</x-layout.admin>
<script src="{{ asset('/wp-content/admin/themes/scripts/eventListener/reports.js') }}"></script>
<script src="{{ asset('/wp-content/admin/themes/scripts/functions/reports.js') }}"></script>