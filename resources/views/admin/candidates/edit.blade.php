<x-layout.admin title="Edit Candidate">
	<x-slot name="version">{{ request()->route('version') }}</x-slot>
	<x-section id="candidatesManagementContent" data-component="candidatesManagement">
		<x-container>
			<div class="votes-management-card card bg-white">
				<div class="card-header">
					<i class="fa-solid fa-eye fs-4"></i>&nbsp;
					<label>{{ __("Edit Candidate") }}</label>
					<a href="{{ route('candidates.index', ['version' => env('APP_VERSION')]) }}"
						class="btn btn-light border-0 float-end">
						<i class="fa-solid fa-arrow-left"></i> {{ __('Back') }}
					</a>
				</div>
				{{-- active candidate id --}}
				<input type="hidden" value="{{ request()->route('candidate') }}" id="candidateId"/>
				<div class="card-body" id="editDataBody">
					{{-- data being fetch via ajax --}}
				</div>
			</div>
		</x-container>
	</x-section>
</x-layout.admin>
<script src="{{ asset('/wp-admin/themes/scripts/eventListener/candidate.js') }}" defer></script>