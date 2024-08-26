<x-layout.app>
	<section id="archieveCarousel" class="bg-white">
		<div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
	    <div class="carousel-indicators">
	      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
	      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
	      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
	    </div>
	    <div class="carousel-inner">
	    	<div class="carousel-item active slider-image-overlay">
	        <img class="bd-placeholder-img" src="{{ asset('/wp-content/guest/uploads/dati2.jpg') }}" alt="img"
	        loading="lazy"/>
	        <div class="container p-0">
	          <div class="carousel-caption text-start">
	            <h4>{{ __('Lakan, Lakambini at Lakandyosa 2023 Coronation') }}</h4>
	            <p class="opacity-60">
								{{ __('Experience the pinnacle of elegance and distinction as Golden Minds proudly presents the 2023 coronation, transcending beauty and grace with outstanding candidates showcasing poise and charisma.') }}
	            </p>
	          </div>
	        </div>
	      </div>
	      <div class="carousel-item slider-image-overlay">
	        <img class="bd-placeholder-img" src="{{ asset('/wp-content/guest/uploads/dati1.jpg') }}" alt="img"
	        loading="lazy"/>
	        <div class="container p-0">
	          <div class="carousel-caption text-start">
	            <h4>{{ __('Crowining Royalty and Fairy of 2023: A Night of Presitage and Promise') }}</h4>
	            <p class="opacity-60">
							  {{ __('An enchanting night of elegance and promise as students adorned in regal attire stepped into the spotlight to claim their titles.') }}
	            </p>
	          </div>
	        </div>
	      </div>
	      <div class="carousel-item slider-image-overlay">
	        <img class="bd-placeholder-img carousel-image" src="{{ asset('/wp-content/guest/uploads/dati3.jpg') }}" alt="img" loading="lazy"/>
	        <div class="container p-0">
	          <div class="carousel-caption text-start">
	            <h4>{{ __('Lakan, Lakambini at Lakandyosa 2022 Coronation') }}</h4>
	            <p class="opacity-60">
							  {{ __("Evening of talent, grace, and intellect as students vie for esteemed titles that honor their individual accomplishments and embodiment of the school's values.") }}
	            </p>
	          </div>
	        </div>
	      </div>
	    </div>
	    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
	      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
	      <span class="visually-hidden">{{__('Previous')}}</span>
	    </button>
	    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
	      <span class="carousel-control-next-icon" aria-hidden="true"></span>
	      <span class="visually-hidden">{{__('Next')}}</span>
	    </button>
  	</div>
	</section>

	<section class="bg-white" style="margin-top: -100px;">
		<div class="container">
			<div id="filterTools" class="py-5">
	      <form action="{{ route('index.page', Str::slug(env('APP_VOTING_NAME'))) }}" method="GET" class="search_form" id="searchForm">
					<div class="search_container">
						<a href="{{ route('main.page') }}" class="btn btn-light rounded-3">
							<i class="fa-solid fa-arrow-left back_icon"></i>
		  			</a>
						<input type="search" class="search_input" name="search"
						  placeholder="Search candidate name and click search button icon"
						  autocomplete="search"
						/>
						<button type="submit" id="searchBtn" class="btn btn-light rounded-3">
							<i class="fa-solid fa-magnifying-glass filter_icon"></i>
		  			</button>&nbsp;
						<button type="button" class="dropdown-toggle btn btn-light rounded-3"
							data-bs-toggle="dropdown" aria-expanded="false">
		  				<i class="fa-solid fa-filter filter_icon"></i>
		  			</button>
		  			<div id="dataListOfCategoriesBody">

		  			</div>

					</div>
				</form>
			</div>

			<div class="instruction alert alert-primary alert-dismissible fade show instructionModal" role="alert">
				<small class="text-justify">
					<b>For a smooth and precise voting experience, kindly adhere to the following guidelines:</b><br/><br/>
					<ol>
						<li><b>Choose Payment Amount</b>: Begin by selecting the desired payment amount.</li>
						<li><b>Scan QR Code</b>: Scan the provided QR code with your device's camera.</li>
						<li><b>Enter Refference Number</b>: Enter the reference number from GCash.</li>
						<li><b>Phone Number</b>: Enter your active phone number (This use by admin contact you incase of emergency regarding of your vote.)</li>
						<li><b>Submit Vote</b>: Click the "Submit Vote" button to confirm.</li>
					</ol>
					Your cooperation in following these steps ensures a seamless voting process.
				</small>
  			<button type="button" class="btn-close" id="alertClose"></button>
			</div>

			<div id="dataListOfCandidatesBody">
				<div class="text-muted mt-3 d-flex align-items-center justify-content-center text-center">
					<div class="spinner-border" role="status"
						style="width: 2rem!important; height: 2rem!important;">
		  			<span class="visually-hidden">Loading...</span>
					</div>&nbsp;
					<h3 style="margin-top: 10px;">Loading...</h3>
				</div>
				{{-- data fetch via ajax --}}
    	</div>
		</div>

		<input type="hidden" value="{{ route('index.page', Str::slug(env('APP_VOTING_NAME'))) }}" id="indexURI">
		<div class="modal fade" id="castVoteModal" data-bs-backdrop="static" aria-hidden="true" aria-labelledby="castVoteModalLabel" tabindex="-1" >
		  <div class="modal-dialog modal-fullscreen-xxl-down">
		    <div class="modal-content container">
		      <div class="modal-header">
		        <h1 class="modal-title fs-5" id="castVoteModalLabel"><span id="candidateInfo"></span></h1>
		        <button type="button" class="btn-close" id="castVoteCloseModal" aria-label="Close"></button>
		      </div>
		      <div class="modal-body">
		      	<form id="castVoteForm">
							<ul id="progressbar" class="d-flex justify-content-center align-items-center">
					      <li class="active" id="fillUpForm"><strong>{{ __('Fill up & Scan QR') }}</strong></li>
					      <li id="referrenceNo"><strong>{{ __('Refference No') }}</strong></li>
					      <li id="finish"><strong>{{ __('Finish') }}</strong></li>
					   	</ul>
					    <div class="form-step" id="stepOne" data-step="1" data-mode="fill-up" >
								<div class="row mb-2">
									<label for="email" class="col-sm-3 col-form-label fw-bold">Contact Number</label>
									<div class="col-sm-9">
									  <div class="row">
											<div class="col-12 visually-hidden">
												<input type="text" id="email" class="form-control email" value="automated@gmail.com" placeholder="your@gmail.com" aria-label="email">
												<div class="invalid-feedback emailError"></div>
											</div>
											<div class="col-12">
												<input type="number" id="contactno" class="contactno form-control" placeholder="09*******00" aria-label="contactno">
												<div class="invalid-feedback contactnoError"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="row mb-2">
									<label for="amountOfPayment" class="col-sm-3 col-form-label fw-bold">Amount of Payment</label>
									<div class="col-sm-9">
									  <div class="row">
											<div class="col-md-6" id="dataListOfAmountPaymentBody">
												{{-- data fetch via ajax --}}
											</div>
											<div class="col-md-6">
											<div class="p-2 noEvents mb-2">
												<div class="form-control mb-2">
													<small id="guideTextLabel">QR Code Image Preview</small>
												</div>
												<input type="hidden" value="" id="amountPaymentSelected"/>
												<input type="hidden" value="" id="candidateSelected"/>
												<input type="hidden" value="{{ env('APP_VERSION') }}" id="appVersionName"/>
												<div id="dataQRCodePreviewBody">
													{{-- data fetch  via ajax --}}
												</div>
											</div>
										</div>
									</div>
									</div>
								</div>
								<center>
						  		<hr class="text-muted"/>
							  	<button type="button" class="btn btn-primary" id="nextStepButton" disabled>proceed to next step
							  		<i class="fa-solid fa-arrow-right"></i>
							  	</button>
					  		</center>
					  	</div>
						  <div class="form-step" id="stepTwo" data-step="2" data-mode="reference-no" style="display: none;">
						  	<center class="container">
						  		<label for="referenceNo" class="fw-bold text-muted">Please enter the reference number send by Gcash</label>
						  		<input type="number" class="form-control w-100 referenceNo" id="referenceNo"
						  		placeholder="200*******123"
						  		/>
						  		<div class="invalid-feedback referenceNoError"></div>
						  		<div class="mb-2 mt-2 d-flex justify-content-center align-items-center ">
										<div class="g-recaptcha-widgets">
											<div class="g-recaptcha"
												id="g-recaptcha-response"
												data-sitekey="{{ env('RECAPTCHA_FRONTEND_KEY') }}">
											</div>
										</div>
									</div>
									<hr class="text-muted"/>
									<button type="button" class="btn btn-primary" id="submitMyVote">
										Submit my vote
							  		<i class="fas fa-spinner fa-spin loading-spinner d-none"></i>
							  	</button>
						  	</center>
						  </div>
						  <div class="form-step" id="stepThree" data-step="3" data-mode="finish" style="display: none;">
						  	<center class="container">
						  		<div class="card mb-3" style="border: 1px solid #f3f3f3">
									  <img src="{{ asset('/wp-content/guest/uploads/vote-success.PNG') }}" class="card-img-top" alt="vote success">
									  <div class="card-body">
									  	<div class="row">
									  		<div class="col-md-6 mt-2">
									  			<button type="button" id="voteAgainButton" class="btn btn-primary w-100">Vote again this candidate</button>
									  		</div>
									  		<div class="col-md-6 mt-2">
									  			<button type="button" id="doneAndExitButton" class="btn btn-light w-100">Done and exit</button>
									  		</div>
									  	</div>
									  </div>
									</div>
						  	</center>
						  </div>
						</form>
		    	</div>
			   	<div class="modal-footer d-flex text-center align-items-center justify-content-center">
			   		<center>
			   			<small class="text-muted">&copy; {{ now()->year }} Golden Minds Colleges <br/>Maintain and Manage by IT Department</small>
			   		</center>
			    </div>
		  	</div>
			</div>
		</div>

		<div class="modal fade" id="showCandidateInfoModal" data-bs-backdrop="static" aria-hidden="true" aria-labelledby="showCandidateInfoModal" tabindex="-1" >
		  <div class="modal-dialog modal-fullscreen-xxl-down">
		    <div class="modal-content container">
		      <div class="modal-header">
		        <h1 class="modal-title fs-5 mt-2 fw-bold">
		        </h1>
		        <button type="button" class="btn-close" id="showCandidateInfoModalClose" aria-label="Close"></button>
		      </div>
		      <div class="modal-body">
		      	<div class="row">
		      		<div class="col-md-5 mb-3">
		      			<div class="card card-cover h-100 overflow-hidden border-0 text-bg-dark rounded-4 shadow-lg" id="showCardCandidateImage" style="height: 80vh!important;">
				      <div id="cardOverlay" class="d-flex flex-column h-100 p-4 pb-3 text-white text-shadow-1">
				        <h4 class="pt-5 mt-5 mb-5 display-6 lh-1"></h4>
				        </ul>
				      </div>
				    </div>
		      		</div>
		      		<div class="col-md-7">
		      			<div class="row">
				      		<div class="col">
						        <div class="card mb-4 rounded-3 shadow-sm"
						        	style="border: 1px solid #00084d!important">
						          <div class="card-header py-3"
						          	style="background: #00084d!important;
						          		border: 1px solid #00084d!important;
						          		color: #ffffff">
						            <h4 class="my-0 fw-normal">
						            	<i class="fa-solid fa-check-to-slot fs-3"></i> Current Points</h4>
						          </div>
						          <div class="card-body">
						            <h1 class="card-title pricing-card-title fw-bold" style="opacity: .8;"
						            	id="totalCurrentVotePoints">
						            	<i class="fas fa-spinner fa-spin fs-4"></i>
						           	</h1>
						            <span class="mt-3 mb-4">
						             	Vote points will count if votes is verified.
						            </span>
						          </div>
						        </div>
						      </div>
						      <div class="col">
						        <div class="card mb-4 rounded-3 shadow-sm"
						        	style="border: 1px solid #00084d!important">
						          <div class="card-header py-3"
						          	style="background: #00084d!important;
						          		border: 1px solid #00084d!important;
						          		color: #ffffff">
						            <h4 class="my-0 fw-normal">
						            	<i class="fas fa-users fs-3"></i> Total Votes
						            </h4>
						          </div>
						          <div class="card-body">
						            <h1 class="card-title pricing-card-title fw-bold" style="opacity: .8;"
						            	id="totalVerifiedVoters">
						            	<i class="fas fa-spinner fa-spin fs-4"></i></h1>
						            <span class="mt-3 mb-4">
						             	Total number of votes this count if vote is verified
						            </span>
						          </div>
						        </div>
						      </div>
				      	</div>
				      	<div class="card mb-4 rounded-3 shadow-sm">
          				<div class="card-body">
									  <div class="row mb-2">
									    <label class="col-sm-2 col-form-label fw-bold">Name</label>
									    <div class="col-sm-10">
									      <input type="text" class="form-control border-0" readonly
									      	id="candidateNameShow"
									      	value="Katarina Zae" />
									    </div>
									  </div>
									  <div class="row mb-2">
									    <label class="col-sm-2 col-form-label fw-bold">Campus</label>
									    <div class="col-sm-10">
									      <input type="text" class="form-control border-0" readonly
									      	id="candidateCampusShow"
									      	value="Golden Minds Colleges of Sta.Maria Campus"/>
									    </div>
									  </div>
									  <div class="row mb-2">
									    <label class="col-sm-2 col-form-label fw-bold">Category</label>
									    <div class="col-sm-10">
									      <input type="text" class="form-control border-0" readonly
									      	id="candidateCategoryShow"
									      	value="Pride"/>
									    </div>
									  </div>
				          </div>
				        </div>
		      		</div>
		      	</div>


		    	</div>
			   	<div class="modal-footer d-flex text-center align-items-center justify-content-center">
			   		<center>
			   			<small class="text-muted">&copy; {{ now()->year }} Golden Minds Colleges <br/>Maintain and Manage by Information System</small>
			   		</center>
			    </div>
		  	</div>
			</div>
		</div>

		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="f-svg"><path fill="#f9f9f9" fill-opacity="1" d="M0,128L48,112C96,96,192,64,288,74.7C384,85,480,139,576,144C672,149,768,107,864,122.7C960,139,1056,213,1152,213.3C1248,213,1344,139,1392,101.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>
	</section>
</x-layout.app>