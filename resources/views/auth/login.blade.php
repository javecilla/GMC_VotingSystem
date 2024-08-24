<x-layout.auth title="Portal">
	<x-slot name="description">{{ __('Admin Portal - Online Voting System of Golden Minds Colleges') }}</x-slot>
	<x-slot name="ogimage">{{ asset('/wp-content/guest/uploads/vsogimage.PNG') }}</x-slot>
	<section id="loginAuthSection">
		<form id="authForm">
			<div class="d-flex justify-content-center align-items-center">
				<div class="form-signin w-100 card rounded-4 shadow border-0">
	   			<img class="mb-2" src="{{ asset('/wp-content/guest/uploads/logo3.png') }}"
	   				alt="vslogo" width="280" height="90" loading="lazy"/><br/>
	   			<fieldset id="inputField">
					  <div class="form-floating">
					    <input class="form-control uid-input"
					      type="text" id="uid"
					      placeholder="uid@example.com"
					      autocomplete="username"
							  onpaste="false"
								autofocus
							/>
					    <label for="uid">{{ __('UID') }}</label>
					  </div>

					  <div class="form-floating">
					    <input class="form-control pwd-input"
					     	type="password" id="password"
					      placeholder="Password"
					      autocomplete="password"
					      onpaste="false"
					    />
					    <label for="password">{{ __('Password') }}</label>
					  </div>
				  </fieldset>

	    		<span id="notice" class="text-muted mb-2">
	    			{{ __('Note: This system is for authorized user only, if you do not have an account please contact the system administrator to request access.') }}
	    		</span>

	    		<div class="mb-2 d-flex justify-content-center align-items-center ">
						<div class="g-recaptcha-widgets">
							<div class="g-recaptcha"
								id="g-recaptcha-response"
								data-sitekey="{{ env('RECAPTCHA_FRONTEND_KEY') }}">
							</div>
						</div>
					</div>
					<button type="submit" name="submit" id="loginButton" class="btn btn-lg btn-primary mb-1 login-button" style="font-size: 16px;" disabled>
						<span id="loginButtonContent">
							<i class="fas fa-spinner fa-spin"></i> Loading recaptcha...
						</span>
					</button>
					<a href="{{ route('main.page') }}" class="btn btn-lg btn-light mb-1" style="font-size: 16px;">
						<span>{{ __('Back') }}</span>
					</a>
					<small class="text-muted text-center mt-3">
						&copy; {{ now()->year }}
						<a href="https://goldenmindsbulacan.com" target="_blank"
							class="text-muted text-decoration-none">
							{{ __('Golden Minds Bulacan') }}
						</a><br/>
						{{ __('Maintain and Manage by Information System') }}
					</small>
				</div>
			</div>
		</form>
	</section>
</x-layout.auth>