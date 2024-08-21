<x-layout.admin title="Ranking">
	<x-slot name="version">{{ request()->route('version') }}</x-slot>
	<x-section id="candidatesRankingContent" data-component="dashboard">
	  <x-container data-iurl="{{ route('candidates.ranking', request()->route('version')) }}">
	  	<div>
		    <div class="row">
		    	<div class="col-md-9">
		    		<div class="chart-card card mt-3">
							<div class="card-header">
								<i class="fa-solid fa-ranking-star fs-3"></i>&nbsp;
								<label>{{ __('Overall Ranking') }}</label>
							</div>
							<div class="card-body">
								<canvas id="overallRankingChart"></canvas>
								{{-- data fetch via ajax functions/candidates.js --}}
							</div>
						</div>
		    	</div>

		    	<div class="col-md-3">
		    		<div class="chart-card card mt-3">
							<div class="card-header">
								<i class="fa-solid fa-users fs-4"></i>&nbsp;
								<label>{{ __('Candidates') }}</label>
							</div>
							<div class="card-body">
								<div id="candidateRankingDataBody">
									<h4 class="text-center text-secondary mt-2">
										<i class="fa-solid fa-spinner fa-spin"></i> {{ __('Loading...') }}
									</h4>
								</div>
							</div>
						</div>
		    	</div>
		    </div>

		    <div id="categoryRankingData">
		    	{{-- data fetch via ajax functions/candidates.js --}}
				</div>
	    </div>
	  </x-container>
	</x-section>
</x-layout.admin>
<script src="{{ asset('/wp-plugins/chartjs/chart.js') }}"></script>
<script src="{{ asset('/wp-content/admin/themes/scripts/functions/candidate.js') }}"></script>
<script src="{{ asset('/wp-content/admin/themes/scripts/eventListener/candidate.ranking.js') }}"></script>