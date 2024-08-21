<x-layout.admin title="AccountModernization">
	<x-slot name="version">{{ request()->route('version') }}</x-slot>
	<x-section id="configurationContent" data-component="configuration">
		<x-container data-iurl="{{ route('configuration.index', request()->route('version')) }}">
			<center style="margin-top: 19%;">
				<input type="hidden" id="redirectTo"
					value="{{ (isset($_GET['redirect_to']))
						? $_GET['redirect_to']
						: ''
					}}">
					<div class="spinner-border" role="status"
						style="width: 4rem!important; height: 4rem!important;">
		  			<span class="visually-hidden">Loading...</span>
					</div>
					<h1 style="font-family: poppins" id="label">Loading...</h1>
					<script>
            setTimeout(function() {
            	$('#label').text('Authenticating...');
            }, 1500);

            setTimeout(function() {
            	$('#label').text('Switching...');
            	window.location.href=`${$('#redirectTo').val()}`;
            }, 2500);
					</script>
				</center>
		</x-container>
	</x-section>
</x-layout.admin>