<x-layout.app>
	<section id="archieveCarousel" class="bg-white">
		<div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
	    <div class="carousel-indicators">
	      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
	      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
	      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
	    </div>
	    <div class="carousel-inner">
	    	<div class="carousel-item active">
	        <img class="bd-placeholder-img" src="{{ asset('/wp-content/uploads/dati2.jpg') }}" alt="img"
	        loading="lazy"/>
	        <div class="container p-0">
	          <div class="carousel-caption text-start">
	            <h4>{{ __('Lakan, Lakambini at Lakamdyosa 2023 Coronation') }}</h4>
	            <p class="opacity-60">
								{{ __('Experience the pinnacle of elegance and distinction as Golden Minds proudly presents the 2023 coronation, transcending beauty and grace with outstanding candidates showcasing poise and charisma.') }}
	            </p>
	          </div>
	        </div>
	      </div>
	      <div class="carousel-item">
	        <img class="bd-placeholder-img" src="{{ asset('/wp-content/uploads/dati1.jpg') }}" alt="img"
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
	      <div class="carousel-item">
	        <img class="bd-placeholder-img carousel-image" src="{{ asset('/wp-content/uploads/dati3.jpg') }}" alt="img" loading="lazy"/>
	        <div class="container p-0">
	          <div class="carousel-caption text-start">
	            <h4>{{ __('Lakan, Lakambini at Lakamdyosa 2022 Coronation') }}</h4>
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
			<div id="guideLine" class="py-5">
				<div class="alert alert-primary alert-dismissible fade show" role="alert">
				  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="bi flex-shrink-0 me-2"
				    aria-label="Info:" width="20"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z" fill="currentColor"/></svg>
				  </svg>
  	  		<h4 class="alert-heading"><strong>Important Notice:</strong></h4>
				  <p>
				  	The online voting for Golden Minds Colleges' Lakan, Lakambini at Lakandyosa 2023 will end on September 29 at 11:59 PM</strong><br/><br/>Following the deadline, the voting system will be locked and will no longer accept any votes. We encourage you to cast your votes in advance to prevent any inconvenience. If you have any concerns or require clarification regarding your votes, please reach out to the vote administrators before the online voting deadline
				  </p>
				  <hr>
				  <p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p>
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			</div>
			<div id="filterTools">
				<form action="{{ route('index.page') }}" method="GET" class="search_form" id="searchForm">
					<div class="search_container">
						<input type="search" class="search_input" name="search"
						  placeholder="Search candidate name and hit enter or click search button icon"
						  autocomplete="search"
						  value="{{ (isset($_GET['search'])) ? $_GET['search'] : ''}}"
						/>
						<button type="submit" id="searchBtn">
		  				<i class="fa-solid fa-magnifying-glass search_icon"></i>
		  			</button>
					</div>
				</form>
				<div class="d-flex justify-content-center align-items-center mb-4">
		      <div class="btn-group float-end">
		        <a href="{{ route('main.page') }}" class="filter-item btn btn-light back-button">
				      <i class="fa-solid fa-arrow-left"></i> {{ __('Back') }}
				    </a>
				    <a href="#" class="filter-item btn btn-light active">
				      {{ __('All Candidates') }}
				    </a>
		        <a href="#" class="filter-item btn btn-light">
				      {{ __('Category 1') }}
				    </a>
				    <a href="#" class="filter-item btn btn-light">
				      {{ __('Category 2') }}
				    </a>
		      </div>
	      </div>
			</div>

			<div id="dataList">
				<div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5">
		      <div class="col">
		        <div class="card card-cover h-100 overflow-hidden border-0 text-bg-dark rounded-4 shadow-lg" style="background-image: url({{ asset('/wp-content/uploads/testcandidates8.PNG') }});
		        	height: 65vh!important;">
		          <div class="d-flex flex-column h-100 p-4 pb-3 text-white text-shadow-1">
		            <h4 class="pt-5 mt-5 mb-5 display-6 lh-1"></h4>
		            <ul class="d-flex list-unstyled mt-auto">
		              <li class="me-auto" style="margin-top: 5px">
		              	<a href="#" class="button-links"
		              		data-bs-toggle="tooltip" data-bs-placement="bottom"
							        data-bs-custom-class="custom-tooltip"
							        data-bs-title="Copy link and share">
		              		<i class="fa-solid fa-share-nodes button-links-icon"></i>
		              	</a>
		              	<a href="#" class="button-links"
		              		data-bs-toggle="tooltip" data-bs-placement="bottom"
							        data-bs-custom-class="custom-tooltip"
							        data-bs-title="View more information">
		              		<i class="fa-solid fa-eye button-links-icon"></i>
		              	</a>
		              	<a href="#" class="button-links"
		              		data-bs-toggle="tooltip" data-bs-placement="bottom"
							        data-bs-custom-class="custom-tooltip"
							        data-bs-title="Cast vote for this candidate">
		              		<i class="fa-solid fa-heart button-links-icon"></i>
		              	</a>
		              </li>
		              <li class="d-flex align-items-center me-3">
		                <svg class="bi me-1" width="1em" height="1em"><use xlink:href="#geo-fill"/></svg>
		                <span class="fw-bold" style="font-size: 20px;">Candidate Name</span>
		              </li>
		            </ul>
		          </div>
		        </div>
		      </div>
		      <div class="col">
		        <div class="card card-cover h-100 overflow-hidden border-0 text-bg-dark rounded-4 shadow-lg" style="background-image: url({{ asset('/wp-content/uploads/testcandidates4.PNG') }});
		        	height: 65vh!important;">
		          <div class="d-flex flex-column h-100 p-4 pb-3 text-white text-shadow-1">
		            <h4 class="pt-5 mt-5 mb-5 display-6 lh-1"></h4>
		            <ul class="d-flex list-unstyled mt-auto">
		              <li class="me-auto" style="margin-top: 5px">
		              	<a href="#" class="button-links"
		              		data-bs-toggle="tooltip" data-bs-placement="bottom"
							        data-bs-custom-class="custom-tooltip"
							        data-bs-title="Copy link and share">
		              		<i class="fa-solid fa-share-nodes button-links-icon"></i>
		              	</a>
		              	<a href="#" class="button-links"
		              		data-bs-toggle="tooltip" data-bs-placement="bottom"
							        data-bs-custom-class="custom-tooltip"
							        data-bs-title="View more information">
		              		<i class="fa-solid fa-eye button-links-icon"></i>
		              	</a>
		              	<a href="#" class="button-links"
		              		data-bs-toggle="tooltip" data-bs-placement="bottom"
							        data-bs-custom-class="custom-tooltip"
							        data-bs-title="Cast vote for this candidate">
		              		<i class="fa-solid fa-heart button-links-icon"></i>
		              	</a>
		              </li>
		              <li class="d-flex align-items-center me-3">
		                <svg class="bi me-1" width="1em" height="1em"><use xlink:href="#geo-fill"/></svg>
		                <span class="fw-bold" style="font-size: 20px;">Candidate Name</span>
		              </li>
		            </ul>
		          </div>
		        </div>
		      </div>
		      <div class="col">
		        <div class="card card-cover h-100 overflow-hidden border-0 text-bg-dark rounded-4 shadow-lg" style="background-image: url({{ asset('/wp-content/uploads/testcandidates3.PNG') }});
		        	height: 65vh!important;">
		          <div class="d-flex flex-column h-100 p-4 pb-3 text-white text-shadow-1">
		            <h4 class="pt-5 mt-5 mb-5 display-6 lh-1"></h4>
		            <ul class="d-flex list-unstyled mt-auto">
		              <li class="me-auto" style="margin-top: 5px">
		              	<a href="#" class="button-links"
		              		data-bs-toggle="tooltip" data-bs-placement="bottom"
							        data-bs-custom-class="custom-tooltip"
							        data-bs-title="Copy link and share">
		              		<i class="fa-solid fa-share-nodes button-links-icon"></i>
		              	</a>
		              	<a href="#" class="button-links"
		              		data-bs-toggle="tooltip" data-bs-placement="bottom"
							        data-bs-custom-class="custom-tooltip"
							        data-bs-title="View more information">
		              		<i class="fa-solid fa-eye button-links-icon"></i>
		              	</a>
		              	<a href="#" class="button-links"
		              		data-bs-toggle="tooltip" data-bs-placement="bottom"
							        data-bs-custom-class="custom-tooltip"
							        data-bs-title="Cast vote for this candidate">
		              		<i class="fa-solid fa-heart button-links-icon"></i>
		              	</a>
		              </li>
		              <li class="d-flex align-items-center me-3">
		                <svg class="bi me-1" width="1em" height="1em"><use xlink:href="#geo-fill"/></svg>
		                <span class="fw-bold" style="font-size: 20px;">Candidate Name</span>
		              </li>
		            </ul>
		          </div>
		        </div>
		      </div>
		      <div class="col">
		        <div class="card card-cover h-100 overflow-hidden border-0 text-bg-dark rounded-4 shadow-lg" style="background-image: url({{ asset('/wp-content/uploads/testcandidates1.PNG') }});
		        	height: 65vh!important;">
		          <div class="d-flex flex-column h-100 p-4 pb-3 text-white text-shadow-1">
		            <h4 class="pt-5 mt-5 mb-5 display-6 lh-1"></h4>
		            <ul class="d-flex list-unstyled mt-auto">
		              <li class="me-auto" style="margin-top: 5px">
		              	<a href="#" class="button-links"
		              		data-bs-toggle="tooltip" data-bs-placement="bottom"
							        data-bs-custom-class="custom-tooltip"
							        data-bs-title="Copy link and share">
		              		<i class="fa-solid fa-share-nodes button-links-icon"></i>
		              	</a>
		              	<a href="#" class="button-links"
		              		data-bs-toggle="tooltip" data-bs-placement="bottom"
							        data-bs-custom-class="custom-tooltip"
							        data-bs-title="View more information">
		              		<i class="fa-solid fa-eye button-links-icon"></i>
		              	</a>
		              	<a href="#" class="button-links"
		              		data-bs-toggle="tooltip" data-bs-placement="bottom"
							        data-bs-custom-class="custom-tooltip"
							        data-bs-title="Cast vote for this candidate">
		              		<i class="fa-solid fa-heart button-links-icon"></i>
		              	</a>
		              </li>
		              <li class="d-flex align-items-center me-3">
		                <svg class="bi me-1" width="1em" height="1em"><use xlink:href="#geo-fill"/></svg>
		                <span class="fw-bold" style="font-size: 20px;">Candidate Name</span>
		              </li>
		            </ul>
		          </div>
		        </div>
		      </div>
		      <div class="col">
		        <div class="card card-cover h-100 overflow-hidden border-0 text-bg-dark rounded-4 shadow-lg" style="background-image: url({{ asset('/wp-content/uploads/testcandidates6.PNG') }});
		        	height: 65vh!important;">
		          <div class="d-flex flex-column h-100 p-4 pb-3 text-white text-shadow-1">
		            <h4 class="pt-5 mt-5 mb-5 display-6 lh-1"></h4>
		            <ul class="d-flex list-unstyled mt-auto">
		              <li class="me-auto" style="margin-top: 5px">
		              	<a href="#" class="button-links"
		              		data-bs-toggle="tooltip" data-bs-placement="bottom"
							        data-bs-custom-class="custom-tooltip"
							        data-bs-title="Copy link and share">
		              		<i class="fa-solid fa-share-nodes button-links-icon"></i>
		              	</a>
		              	<a href="#" class="button-links"
		              		data-bs-toggle="tooltip" data-bs-placement="bottom"
							        data-bs-custom-class="custom-tooltip"
							        data-bs-title="View more information">
		              		<i class="fa-solid fa-eye button-links-icon"></i>
		              	</a>
		              	<a href="#" class="button-links"
		              		data-bs-toggle="tooltip" data-bs-placement="bottom"
							        data-bs-custom-class="custom-tooltip"
							        data-bs-title="Cast vote for this candidate">
		              		<i class="fa-solid fa-heart button-links-icon"></i>
		              	</a>
		              </li>
		              <li class="d-flex align-items-center me-3">
		                <svg class="bi me-1" width="1em" height="1em"><use xlink:href="#geo-fill"/></svg>
		                <span class="fw-bold" style="font-size: 20px;">Candidate Name</span>
		              </li>
		            </ul>
		          </div>
		        </div>
		      </div>
		      <div class="col">
		        <div class="card card-cover h-100 overflow-hidden border-0 text-bg-dark rounded-4 shadow-lg" style="background-image: url({{ asset('/wp-content/uploads/testcandidates7.PNG') }});
		        	height: 65vh!important;">
		          <div class="d-flex flex-column h-100 p-4 pb-3 text-white text-shadow-1">
		            <h4 class="pt-5 mt-5 mb-5 display-6 lh-1"></h4>
		            <ul class="d-flex list-unstyled mt-auto">
		              <li class="me-auto" style="margin-top: 5px">
		              	<a href="#" class="button-links"
		              		data-bs-toggle="tooltip" data-bs-placement="bottom"
							        data-bs-custom-class="custom-tooltip"
							        data-bs-title="Copy link and share">
		              		<i class="fa-solid fa-share-nodes button-links-icon"></i>
		              	</a>
		              	<a href="#" class="button-links"
		              		data-bs-toggle="tooltip" data-bs-placement="bottom"
							        data-bs-custom-class="custom-tooltip"
							        data-bs-title="View more information">
		              		<i class="fa-solid fa-eye button-links-icon"></i>
		              	</a>
		              	<a href="#" class="button-links"
		              		data-bs-toggle="tooltip" data-bs-placement="bottom"
							        data-bs-custom-class="custom-tooltip"
							        data-bs-title="Cast vote for this candidate">
		              		<i class="fa-solid fa-heart button-links-icon"></i>
		              	</a>
		              </li>
		              <li class="d-flex align-items-center me-3">
		                <svg class="bi me-1" width="1em" height="1em"><use xlink:href="#geo-fill"/></svg>
		                <span class="fw-bold" style="font-size: 20px;">Candidate Name</span>
		              </li>
		            </ul>
		          </div>
		        </div>
		      </div>
	    	</div>
    	</div>
		</div>
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="f-svg"><path fill="#f9f9f9" fill-opacity="1" d="M0,128L48,112C96,96,192,64,288,74.7C384,85,480,139,576,144C672,149,768,107,864,122.7C960,139,1056,213,1152,213.3C1248,213,1344,139,1392,101.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>
	</section>
</x-layout.app>