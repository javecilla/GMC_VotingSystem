<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="UTF-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}"/>
  <meta name="robots" content="noindex, nofollow"/>
  <meta name="googlebot" content="noindex, nofollow, max-snippet:-1, max-image-preview:large, max-video-preview:-1"/>
  <meta name="bingbot" content="noindex, nofollow, max-snippet:-1, max-image-preview:large, max-video-preview:-1"/>
  <meta name="description" content="@isset($description) {{ $description }} | @endisset {{ env('APP_NAME') }} {{ env('APP_VERSION') }}" />
  <meta name="abstract" content="Official Voting System of Golden Minds Bulacan"  />
  <meta name="copyright" content="Golden Minds Bulacan"  />
  <meta name='Classification' content='Website'/>
  <meta name='identifier-URL' content='{{ url()->current() }}'/>
  <meta name="msapplication-TileImage" content="{{ asset('/wp-content/uploads/favicon.PNG') }}" />
	<title>@isset($title) {{ $title }} | @endisset {{ env('APP_NAME') }} {{ env('APP_VERSION') }}</title>

	<link rel="shortcut icon" type="image/png" sizes="16x16"
		href="{{ asset('/wp-content/uploads/favicon.PNG') }}" />
  <link rel="apple-touch-icon" type="image/png" sizes="16x16"
  	href="{{ asset('/wp-content/uploads/favicon.PNG') }}" />

  <link rel='dns-prefetch' href='https://fonts.googleapis.com' />
  <link rel='dns-prefetch' href='https://fonts.gstatic.com' />
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@700;800&family=Roboto+Flex:opsz,wght@8..144,300&display=swap"
		defer/>

	<link rel="stylesheet" href="{{ asset('/wp-content/plugins/bootstrap/bootstrap@5.3.2/css/bootstrap.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('/wp-content/plugins/fontawesome/css/all.min.css') }}"/>
  <link rel="stylesheet" href="{{ asset('/wp-content/plugins/wow/wow.min.css') }}"/>
  <link rel="stylesheet" href="{{ asset('/wp-content/plugins/toastr/toastr.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('/wp-content/themes/stylesheets/app.css?v=1.3') }}" defer/>
	<script src="{{ asset('/wp-content/plugins/jquery/jquery@3.7.1/jquery.min.js')}}"></script>

  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
	<header id="header" class="header-content">
		<div class="h-nav-container">
			<div class="container p-0">
        <div class="row">
        	{{-- Admission Promotion --}}
  	      <div class="col-md-6 d-none d-lg-inline ">
  	        <img src="{{ asset('/wp-content/uploads/icon-new.svg') }}" alt="svg"
  	        	class="h-admission-image" />
  	        <a href="#" target="_blank" class="h-nav-link">
  	        	<span class="h-admission-text">
  	        		{{ __('Golden Minds Colleges: Senior High School Admission') }}
  	        	</span>
  	        	<i class="fa-solid fa-arrow-right"></i>
  	        </a>
  	      </div>
  	      {{-- Social --}}
  	      <div class="col-md-6 d-flex justify-content-center justify-content-md-end align-items-center">
  	        <div class="d-flex">
  	          <a href="https://www.facebook.com/gmcstamaria2015" target="_blank"
  	            class="h-nav-link">
  	            <small><i class="fa-brands fa-facebook-f"></i></small>
  	          </a>
  	          <a href="https://www.youtube.com/@goldenmindscolleges7588" target="_blank"
  	           	class="ml-10 h-nav-link">
  	            <small><i class="fa-brands fa-youtube"></i></small>
  	          </a>
  	          <span class="ml-10">
  	            <small class="h-nav-link"><i class="fa-brands fa-linkedin-in"></i></small>
  	          </span>
  	          <a href="mailto:info@goldenmindsbulacan.com" class="ml-10 h-nav-link">
  	            <small><i class="fa-solid fa-envelope"></i></small>
  	          </a>
  	          <a href="tel:+639394499844" class="ml-10 h-nav-link">
  	            <small><i class="fa-solid fa-phone"></i></small>
  	          </a>
  	        </div>
  	      </div>
       </div>
			</div>
   	</div>
	</header><!-- /header -->

	<nav class="navbar bg-white border-bottom">
	  <div class="container p-0">
	    <a class="navbar-brand" href="#">
	      {{-- <img src="{{ asset('/wp-content/uploads/logo.png') }}"
	      	alt="VotingSystem" width="160"> --}}
	    </a>
	  </div>
	</nav><!-- /nav -->

 	<main class="main-content"
    data-app="{{ env('APP_VERSION') }}"
    data-vtitle="{{ Str::slug(env('APP_VOTING_NAME')) }}">
 		{{ $slot }}
 	</main> <!-- /main -->

  <footer id="footer">
    <div class="d-flex flex-wrap container f-container">
      <p class="col-md-6 mb-0"><a href="#" target="_blank" class="nav-link px-2 text-body-secondary">
        &copy; {{ now()->year }} {{ __('Golden Minds Colleges - OVS v1.3') }}</a></p>
      <ul class="nav col-md-6 justify-content-end">
        <li class="nav-item"><span class="nav-link text-body-secondary">
          {{ __('Maintain and Manage by Information System') }}</span>
        </li>
      </ul>
    </div>
  </footer><!-- /footer -->

  <aside class="social-media-icons">
    <ul>
      <li><a href="https://www.goldenmindsbulacan.com/"
        target="_blank"
        data-bs-toggle="tooltip"
        data-bs-placement="right"
        data-bs-title="Golden Minds Website"><i class="fas fa-globe"></i><span></span></a></li>
      <li><a href="https://www.facebook.com/gmcstamaria2015"
        target="_blank"
        data-bs-toggle="tooltip"
        data-bs-placement="right"
        data-bs-title="Facebook"><i class="fab fa-facebook-f"></i><span></span></a></li>
      <li><a href="mailto:info@goldenmindsbulacan.com"
        target="_blank"
        data-bs-toggle="tooltip"
        data-bs-placement="right"
        data-bs-title="Mail"><i class="fa-solid fa-envelope"></i><span></span></a></li>
      <li><a href="https://www.youtube.com/@goldenmindscolleges7588"
        target="_blank"
        data-bs-toggle="tooltip"
        data-bs-placement="right"
        data-bs-title="Youtube"><i class="fab fa-youtube"></i><span></span></a>
      </li>
    </ul>
  </aside>

  <div id="backToTop">
    <a class="p-0 btn btt-btn" id="top" href="#top">
      <i class="fa-solid fa-arrow-up btt-icon"></i>
    </a>
  </div>

 	<script src="{{ asset('/wp-content/plugins/bootstrap/bootstrap@5.3.2/js/bootstrap.bundle.min.js') }}"></script>
 	<script src="{{ asset('/wp-content/plugins/fontawesome/js/all.min.js') }}"></script>
  <script src="{{ asset('/wp-content/plugins/toastr/toastr.min.js') }}"></script>
  <script src="{{ asset('/wp-content/plugins/wow/wow.min.js') }}"></script>
  <script src="{{ asset('/wp-content/themes/scripts/functions.js?v=1.3') }}" defer></script>
  <script src="{{ asset('/wp-content/themes/scripts/helper.js?v=1.3') }}" defer></script>
 	<script src="{{ asset('/wp-content/themes/scripts/app.js?v=1.3') }}" defer></script>
  <script src="{{ asset('/wp-content/themes/scripts/general.js?v=1.3') }}" defer></script>

 </body>
</html>