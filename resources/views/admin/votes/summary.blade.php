<x-layout.admin title="Votes Summary">
	<x-slot name="version">{{ request()->route('version') }}</x-slot>
	<x-section id="votesSummaryContent" data-component="votesSummary">
		<x-container data-iurl="{{ route('votes.summary', request()->route('version')) }}">
			{{-- Hidden data inputs --}}
			<input type="hidden" value="{{ request()->route('version') }}" id="appVersionName"/>
			<div>
				<div class="votes-management-card card">
					<div class="card-header">
						<div class="float-start">
							<i class="fa-solid fa-list fs-4"></i>
							<label>{{ __("List of Candidates Summary of Votes") }}</label>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>Candidate No.</th>
										<th>Category</th>
										<th>Candidate Name</th>
										<th>Total Current Points</th>
									</tr>
								</thead>
								<tbody id="summaryOfVotesData">
									<tr>
							  		<td colspan="4">
											<h4 class="text-center text-secondary mt-2">{{ __('Loading') }} <i class="fas fa-spinner fa-spin"></i></h4>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</x-container>
	</x-section>
</x-layout.admin>
<script src="{{ asset('/wp-content/admin/themes/scripts/functions/votes.js') }}"></script>
<script src="{{ asset('/wp-content/admin/themes/scripts/eventListener/votes.js') }}"></script>