<x-layout.app>
	<section id="heroSection" class="bg-white">
		<div class="text-center container">
			<div class="h-text-content">
				<div class="inner-text-content">
					<label class="h-label-text gradient-blue-text"><span id="countdown">GMCOVS v1.4</span></label>
			    <h1 class="main-header-title gradient-blue-text" id="title-vote">Buwan ng Wikang Pambansa: Lakan, Lakambini at Lakandyosa 2024</h1>
					<label class="h-sub-text" id="subtitle-vote">Your vote counts, your vote matters, make it heard!</label>
				</div>
			</div>
	  </div>
	  <div class="col-lg-6 mx-auto" >
	    <div class="h-button-content d-grid gap-2 d-sm-flex justify-content-sm-center" >
	      <a href="javascript:void(0)" class="h-button btn btn-light gap-3 text-muted border-0" style="cursor: no-drop!important;">
	        {{ __('Read More About This Event') }}
	      </a>
			  <a id="button-vote"
			  		@if(Route::has('index.page'))
			  			href="{{ route('index.page', Str::slug(env('APP_VOTING_NAME'))) }}"
						@else
							href="javascript:void(0)"
			   		@endif
			   		class="h-button btn btn-primary text-white">
			      {{ __('Cast Your Vote') }} <i class="fa-solid fa-arrow-right"></i>
			   </a>
	    </div>
	 	</div>
  </section>

  <section id="tracker">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="tracker-svg">
		  <path fill="#fff" fill-opacity="1" d="M0,192L60,186.7C120,181,240,171,360,149.3C480,128,600,96,720,106.7C840,117,960,171,1080,181.3C1200,192,1320,160,1380,144L1440,128L1440,0L1380,0C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0L0,0Z"></path>
		</svg>
		<div class="container px-3 py-5 tracker-container">
			<div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
	      <div class="feature col">
	      	<div class="card p-5 border-0 shadow rounded-4 wow fadeInUp">
		        <div class="bg-icon-gradient feature-icon d-inline-flex align-items-center justify-content-center fs-2 mb-3">
		        	<i class="fa-solid fa-eye bi"></i>
		        </div>
		        <h3 class="fs-2 h-sub-text">{{ __('Page Views:') }}
		        		<span id="totalPageViews"><i class="fas fa-spinner fa-spin fs-4"></i></span>
		        	</h3>
		        <p class="tracker-description">
		        	{{ __('Stay updated with the page views on the Golden Minds Colleges Voting System.') }}
		        </p>
	      	</div>
	      </div>
	      <div class="feature col">
	      	<div class="card p-5 border-0 shadow rounded-4 wow fadeInUp">
		        <div class="feature-icon d-inline-flex align-items-center justify-content-center bg-icon-gradient fs-2 mb-3">
		          <i class="fa-solid fa-users bi"></i>
		        </div>
		        <h3 class="fs-2 h-sub-text">{{ __('Total Voters:') }}
		        	<span id="totalVotes"><i class="fas fa-spinner fa-spin fs-4"></i></span>
		        </h3>
		        <p class="tracker-description">
		        	{{ __('Track the total number of voters participating in the Golden Minds Colleges - Voting System.') }}
		        </p>
	        </div>
	      </div>
	      <img src="{{ asset('/wp-content/guest/uploads/cp2.png') }}" alt="image"
	      	class="tracker-image d-none d-lg-inline"/>
    	</div>
  	</div>
  </section>

  <section id="howToVote" class="bg-white">
  	<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="htv-svg"><path fill="#f5fafe" fill-opacity="1" d="M0,160L48,165.3C96,171,192,181,288,160C384,139,480,85,576,85.3C672,85,768,139,864,138.7C960,139,1056,85,1152,69.3C1248,53,1344,75,1392,85.3L1440,96L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path></svg>
  	<div class="container px-4 py-5 htv-container">
  		<div class="row align-items-center g-5 py-5">
  			<div class="col-10 col-sm-8 col-lg-6">
	        <img src="{{ asset('/wp-content/guest/uploads/howtovote.png') }}" class="d-block mx-lg-auto img-fluid" alt="img" width="700" height="500" loading="lazy">
	      </div>
	      <div class="col-lg-6">
	      	<label class="gradient-blue-text h-sub-text fw-bold">{{ __('How to Vote?') }}</label>
	        <h1 class="sub-header-title lh-1 mb-3">{{ __('Navigating the Voting Process') }}</h1>
	        <p class="description-text-htv wow fadeInUp">
	        	<small class="text-justify">
					For a smooth and precise voting experience, kindly adhere to the following guidelines:
					<ol>
						<li><b>Choose Payment Amount</b>: Begin by selecting the desired payment amount.</li>
						<li><b>Scan QR Code</b>: Scan the provided QR code with your device's camera.</li>
						<li><b>Enter Refference Number</b>: Enter the reference number from GCash.</li>
						<li><b>Phone Number</b>: Enter your active phone number (This use by admin contact you incase of emergency regarding of your vote.)</li>
						<li><b>Submit Vote</b>: Click the "Submit Vote" button to confirm.</li>
					</ol>
					Your cooperation in following these steps ensures a seamless voting process.
				</small>
	        </p>
	      </div>
    	</div>
  	</div>
  </section><!-- /howToVote -->

  <section id="faq">
  	<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="faq-svg"><path fill="#ffffff" fill-opacity="1" d="M0,32L48,42.7C96,53,192,75,288,74.7C384,75,480,53,576,64C672,75,768,117,864,117.3C960,117,1056,75,1152,74.7C1248,75,1344,117,1392,138.7L1440,160L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path></svg>
  	<div class="container px-4 py-5 faq-container">
  		<label class="fyi-header-text">{{ __('Frequently Ask Questions') }}</label>
  		<h1 class="sub-header-title lh-1 mb-3 text-white">
  			{{ __("User's Most Common Questions Answered") }}
  		</h1>
  		<div class="row align-items-center g-5 py-5">
			 <div class="col-lg-4 mt-3">
	      	<div class="card h-100 p-5 border-0 shadow rounded-4 card-faq wow fadeInUp">
		        <h3 class="fs-2 sub-text-faq">{{ __('How Long Does It Take to Verify Votes?') }}</h3>
		        <p class="description-text-faq">
		        	{{ __('Voting commences promptly after meticulous review and validation by our administration team. Our thorough verification process ensures that every vote meets our stringent standards for accuracy and integrity. Once validated, your vote is promptly counted without delay.') }}
		      	</p>
	      	</div>
	      </div>
	      <div class="col-lg-4 mt-3">
	      	<div class="card h-100 p-5 border-0 shadow rounded-4 card-faq wow fadeInUp">
		        <h3 class="fs-2 sub-text-faq">{{ __('When is the Deadline for Online Voting?') }}</h3>
		        <p class="description-text-faq">
		        	 {{ __('Online voting for Lakan, Lakambini at Lakandyosa 2024 will conclude on September 03, 2024, at 12:59 PM. Please note that the system will no longer accept any further votes after this specified deadline.') }}
		      	</p>
	      	</div>
	      </div>
	      <div class="col-lg-4 mt-3">
	      	<div class="card h-100 p-5 border-0 shadow rounded-4 card-faq wow fadeInUp">
		        <h3 class="fs-2 sub-text-faq">{{ __('How Does the Voting Points System Operate?') }}</h3>
		        <p class="description-text-faq">
		        	{{ __('Our voting points system operates on a straightforward principle: each contribution made towards voting corresponds to designated vote points. The candidate with the highest accumulation of vote points emerges as the leader. Please note that the vote points of candidates will not be counted if they are not verified by our administration team.') }}
		        </p>
	      	</div>
	      </div>
  		</div>
  	</div>
  </section>

  <section id="about">
  	<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="about-svg">
		  <path fill="#03061e" fill-opacity="1" d="M0,128L48,133.3C96,139,192,149,288,138.7C384,128,480,96,576,101.3C672,107,768,149,864,154.7C960,160,1056,128,1152,122.7C1248,117,1344,139,1392,149.3L1440,160L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path>
		</svg>
		<div class="container text-center about-container">
			<div class="h-text-content">
    		<label class="gradient-blue-text h-sub-text fw-bold">{{ __('About this System') }}</label>
	      <h1 class="sub-header-title">
	      	{{ __("Discover Golden Minds Colleges' Online Voting System") }}
	      </h1>
	    </div>
	    <div class="col-lg-8 mx-auto about-description-content">
	      <p class="description-text-about wow fadeInUp">
					 {{ __('Welcome to the Golden Minds Colleges Online Voting System! Our journey began in 2023 when we launched our first online voting system for Santa Maria Teen Model 2023, followed by Lakan, Lakambini, and Lakandyosa 2023. Since then, we have been committed to providing a seamless and reliable platform for democratic participation.') }}
	      </p>
	    </div>
		</div>
  </section>

  <section id="contactUs" class="bg-white">
  	<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="contact-svg"><path fill="#f5fafe" fill-opacity="1" d="M0,192L48,160C96,128,192,64,288,64C384,64,480,128,576,149.3C672,171,768,149,864,128C960,107,1056,85,1152,74.7C1248,64,1344,64,1392,64L1440,64L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path></svg>
  	<div class="container">
  	 	<div class="contact-admins">
  			<div class="row">
      		<div class="col-lg-6 mt-4">
	      		<div class="card p-4 border-0 shadow rounded-4 wow fadeInUp">
	      			<center>
	      				<img src="{{ asset('/wp-content/uploads/derek.jpg') }}" class="bd-placeholder-img rounded-circle" width="140" height="140" alt="img" loading="lazy"/>
			      		<h2 class="contact-admin-name">{{ __('Derek Malibiran') }}</h2>
			      		<p class="contact-admin-description">
			      			 {{ __('Meet our esteemed School President at Golden Minds Colleges.') }}
			      		</p>
			      	</center>
	      		</div>
      		</div>

      		<div class="col-lg-6 mt-4">
	      		<div class="card p-4 border-0 shadow rounded-4 wow fadeInUp">
	      			<center>
	      				<img src="{{ asset('/wp-content/uploads/gian.jpg') }}" class="bd-placeholder-img rounded-circle" width="140" height="140" alt="img" loading="lazy"/>
			      		<h2 class="contact-admin-name">{{ __('Gian Carlos Castillo') }}</h2>
			      		<p class="contact-admin-description">
			      			{{ __('Meet organizer behind Golden Minds Colleges\' voting initiatives.') }}
			      		</p>
			      	</center>
	      		</div>
      		</div>
    		</div>
    	</div>
    	<br/><hr class="text-muted"/><br/>
    	<div class="report-concern">
	    	<div class="form-container" >
		    	<div class="row align-items-center g-lg-5 py-5">
			      <div class="col-lg-7 text-center text-lg-start">
			      	<label class="gradient-blue-text h-sub-text fw-bold">{{ __('Contact Us') }}</label>
			        <h1 class="sub-header-title">
			        	{{ __('Reporting Issues and Providing Feedback') }}
			        </h1>
			        <p class="col-lg-10 description-text-contact wow fadeInUp">
			        	{{ __('Your feedback is invaluable in enhancing our system. Whether you\'re sharing your user experience or reporting an error or issue, encountered a glitch or have ideas to make our platform even better, your input contributes to our continuous improvement efforts. Together, we can create a better voting experience for all users.') }}
			        </p>
			      </div>
			      <div class="col-md-10 mx-auto col-lg-5">
			        <form action="#" method="post" id="submitReportForm"
			        	class="p-4 p-md-5 border-1 shadow-4 rounded-4 bg-body-tertiary">
			        	<div class="form-floating mb-2">
			            <input type="text" class="form-control fullName" id="fullName" placeholder="Full Name">
			            <label for="fullName">{{ __('Full name') }}</label>
			            <div class="invalid-feedback nameError"></div>
			          </div>
			          <div class="form-floating mb-2">
			            <input type="text" class="form-control email" id="email" placeholder="name@example.com">
			            <label for="email">{{ __('Email address') }}</label>
			            <div class="invalid-feedback emailError"></div>
			          </div>
			          <div class="form-floating mb-2">
			          	<textarea name="message" class="form-control message" id="message" placeholder="Message" style="height: 15vh"></textarea>
			            <label for="message">{{ __('Message') }}</label>
			            <div class="invalid-feedback messageError"></div>
			          </div>
			          <div class="mb-2">
			          	<small class="text-muted">
			          		{{ __('Please insert the screenshoot of the error/issue as following format e.g., png, jpeg, jpg (Optional)')}}
			          	</small>
								  <input type="file" class="form-control" id="concernImage">

								</div>
								<div class="d-flex justify-content-center align-items-center mt-3 mb-2">
				          {{-- reCAPTCHA Widgets --}}
									<div class="g-recaptcha-widgets">
									  <div class="g-recaptcha" name="g-recaptcha-response"
									  	id="g-recaptcha-response"
									  data-sitekey="{{ env('RECAPTCHA_FRONTEND_KEY') }}"></div>
									</div>
								</div>
			          <hr class="text-muted">
			          <button type="submit" class="w-100 btn h-button btn-primary"
			          	id="submitReportBtn">
			          	{{ __('Send Message') }}
			          	<i class="fa-solid fa-paper-plane submit-icon"></i>
			          	<i class="fas fa-spinner fa-spin loading-spinner fw-bold d-none"></i>
			        	</button>
			        </form>
			      </div>
		    	</div>
	    	</div>
    	</div>
  	</div>
  	<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="f-svg"><path fill="#f9f9f9" fill-opacity="1" d="M0,128L48,112C96,96,192,64,288,74.7C384,85,480,139,576,144C672,149,768,107,864,122.7C960,139,1056,213,1152,213.3C1248,213,1344,139,1392,101.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>
  </section>
</x-layout.app>