<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="UTF-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}"/>
  <meta name="robots" content="index, follow"/>
  <meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1"/>
  <meta name="bingbot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1"/>
  <meta name="description" content="@isset($description) {{ $description }} | @endisset {{ env('APP_NAME') }} {{ env('APP_VERSION') }}" />
  <meta name="abstract" content="Official Voting System of Golden Minds Bulacan"  />
  <meta name="copyright" content="Golden Minds Bulacan"  />
  <meta name='Classification' content='Website'/>
  <meta name='identifier-URL' content='{{ url()->current() }}'/>
  <meta name="msapplication-TileImage" content="{{ asset('/wp-content/uploads/favicon.png') }}" />
  <!--<meta name='developer' content='https://javecilla.vercel.app'/>-->
  <!--The SEO Framework by Jerome Avecilla -->
  <meta property="og:image" content="{{ asset('/wp-content/uploads/app_ogimage.png') }}" />
  <meta property="og:image:width" content="608">
  <meta property="og:image:height" content="260">
  <meta property="og:image:alt" content="{{ env('APP_NAME') }}" />
  <meta property="og:image:secure_url" content="{{ asset('/wp-content/uploads/favicon.png') }}"/>
  <meta property="og:locale" content="en_US">
  <meta property="og:type" content="website">
  <meta property="og:title" content="{{ env('APP_NAME') }}" />
  <meta property="og:description" content="Golden Minds Colleges Online Voting System! Our journey began in 2023 when we launched our first online voting system for Santa Maria Teen Model 2023, followed by Lakan, Lakambini, and Lakandyosa 2023. Since then, we have been committed to providing a seamless and reliable platform for democratic participation." />
  <meta property="og:url" content="{{ url()->current() }}" />
  <meta property="og:site_name" content="@isset($title) {{ $title }} | @endisset {{ env('APP_NAME') }} {{ env('APP_VERSION') }} - Golden Minds Colleges"/>
  <meta property="article:author" content="https://www.facebook.com/gmcstamaria2015"/>
  <meta property="article:publisher" content="https://www.facebook.com/gmcstamaria2015"/>
  <meta property="fb:pages" content="100924508936440"/>
  <meta property="fb:app_id" content="100924508936440"/>
  <meta name="twitter:card" content="summary"/>
  <meta name="twitter:site" content="https://twitter.com/goldenminds"/>
  <meta name="twitter:creator" content="https://twitter.com/goldenminds"/>
  <meta name="twitter:title" content="@isset($title) {{ $title }} | @endisset {{ env('APP_NAME') }} {{ env('APP_VERSION') }}"/>
  <meta name="twitter:description" content="Golden Minds Colleges Online Voting System! Our journey began in 2023 when we launched our first online voting system for Santa Maria Teen Model 2023, followed by Lakan, Lakambini, and Lakandyosa 2023. Since then, we have been committed to providing a seamless and reliable platform for democratic participation."/>
	<title>@isset($title) {{ $title }} | @endisset {{ env('APP_NAME') }} {{ env('APP_VERSION') }}</title>

	<link rel="shortcut icon" type="image/png" sizes="16x16" href="{{ asset('/wp-content/uploads/favicon.png') }}" />
  <link rel="apple-touch-icon" type="image/png" sizes="16x16" href="{{ asset('/wp-content/uploads/favicon.png') }}" />
  <link rel="canonical" href="https://admission.goldenmindsbulacan.com/" />
  <link rel='shortlink' href="https://www.goldenmindsbulacan.com/" />
  <link rel="alternate" type="text/xml+oembed" href="https://www.goldenmindsbulacan.com/sitemap.xml?url=https://www.goldenmindsbulacan.com/&format=xml" />
  <link rel="alternate" type="application/rss+xml" title="Golden Minds Bulacan | News - Golden Minds Colleges is the private school that offers free education, produce graduates that are competitive in the current global trends." href="https://www.goldenmindsbulacan.com/news" />
  <link rel="alternate" type="application/rss+xml" title="Golden Minds Bulacan Online Application | Enrollment - GMC Senior High School effectively equips students with above level skills. Seize your future! Enroll now at GMC Senior High. Dream big, aim higher. New students and transferees are welcome at all levels. Your journey starts here!" href="https://admission.goldenmindsbulacan.com/" />
  <link rel='dns-prefetch' href='https://fonts.googleapis.com' />
  <link rel='dns-prefetch' href='https://fonts.gstatic.com' />
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@700;800&family=Roboto+Flex:opsz,wght@8..144,300&display=swap" />

	<link rel="stylesheet" href="{{ asset('/wp-plugins/bootstrap/bootstrap@5.3.2/css/bootstrap.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('/wp-plugins/fontawesome/css/all.min.css') }}"/>
  <link rel="stylesheet" href="{{ asset('/wp-plugins/wow/wow.min.css') }}"/>
  <link rel="stylesheet" href="{{ asset('/wp-plugins/toastr/toastr.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('/wp-content/guest/themes/stylesheets/app.css?v=1.4') }}" defer/>

  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
	<header id="header" class="header-content">
		<div class="h-nav-container">
			<div class="container p-0">
        <div class="row">
        	{{-- Admission Promotion --}}
  	      <div class="col-md-6 d-none d-lg-inline ">
  	        <img src="{{ asset('/wp-content/guest/uploads/icon-new.svg') }}" alt="svg"
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
	     <!--  <img src="{{ asset('/wp-content/guest/uploads/logo.png') }}"
	      	alt="VotingSystem" width="160"> -->
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
        &copy; {{ now()->year }} {{ __('Golden Minds Colleges - OVS') }} {{ env('APP_VERSION') }}</a></p>
      <ul class="nav col-md-6 justify-content-end">
        <li class="nav-item"><span class="nav-link text-body-secondary">
          {{ __('Maintain and Manage by Information System') }}</span>
        </li>
      </ul>
    </div>
  </footer><!-- /footer -->

  <aside class="social-media-icons">
    <ul>
      <li><a href="https://voting.goldenmindsbulacan.com/auth/login"
        target="_blank"
        data-bs-toggle="tooltip"
        data-bs-placement="right"
        data-bs-title="GMCVS Portal v1.4"><i class="fas fa-globe"></i><span></span></a></li>
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

  <script src="{{ asset('/wp-plugins/jquery/jquery@3.7.1/jquery.min.js')}}"></script>
 	<script src="{{ asset('/wp-plugins/bootstrap/bootstrap@5.3.2/js/bootstrap.bundle.min.js') }}"></script>
 	<script src="{{ asset('/wp-plugins/fontawesome/js/all.min.js') }}"></script>
  <script src="{{ asset('/wp-plugins/toastr/toastr.min.js') }}"></script>
  <script src="{{ asset('/wp-plugins/wow/wow.min.js') }}"></script>
 	<script src="{{ asset('/wp-content/guest/themes/scripts/app.js?v=1.4.1') }}" defer></script>
  <script src="{{ asset('/wp-content/global/scripts/common.js?v=1.4.1') }}"></script>
  <script src="{{ asset('/wp-content/global/scripts/helpers.js?v=1.4.1') }}"></script>
  <script src="{{ asset('/wp-content/guest/themes/scripts/functions.js?v=1.4.1') }}" defer></script>
 </body>
</html>