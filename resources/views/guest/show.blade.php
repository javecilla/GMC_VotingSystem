<x-layout.app title="test">
	<section id="activeCandidate" class="bg-white">
		<div class="container">
			<div id="candidateInfo" class="py-5" data-id="{{ request()->route('candidate')}}">
				<div id="dataOneCandidatesBody">
					<div class="text-muted mt-3 d-flex align-items-center justify-content-center text-center">
						<i class="fas fa-spinner fa-spin loading-spinner fs-4"></i>
						<span class="fs-4">&nbsp;{{ __('Loading...') }}</span>
					</div>
					{{-- data fetch via ajax --}}
				</div>
			</div>
		</div>
	</section>
</x-layout.app>