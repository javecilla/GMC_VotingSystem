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
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet"/>

	<link rel="stylesheet" href="{{ asset('/wp-content/plugins/bootstrap/bootstrap@5.3.2/css/bootstrap.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('/wp-content/plugins/fontawesome/css/all.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('/wp-content/plugins/toastr/toastr.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('/wp-admin/plugins/aos/aos.css') }}"/>
	<link rel="stylesheet" href="{{ asset('/wp-admin/plugins/bootstrap-icons/bootstrap-icons.css') }}"/>
	<link rel="stylesheet" href="{{ asset('/wp-admin/plugins/boxicons/css/boxicons.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('/wp-admin/plugins/glightbox/css/glightbox.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('/wp-admin/plugins/swiper/swiper-bundle.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('/wp-admin/themes/stylesheets/main.css') }}"/>
	<link rel="stylesheet" href="{{ asset('/wp-admin/themes/stylesheets/sidebar.css') }}" defer/>
	<script src="{{ asset('/wp-content/plugins/jquery/jquery@3.7.1/jquery.min.js')}}"></script>
</head>
<body>
	<!-- ======= Mobile nav toggle button ======= -->
	<i class="bi bi-list mobile-nav-toggle d-xl-none admin_mobile_nav"></i>

	<!-- ======= Header ======= -->
	<aside id="sidebar">
	  <div class="d-flex flex-column">
	   	<div class="profile">
	      <img src="{{ asset('/wp-admin/uploads/profile.jpg') }}" alt="profile"
	      	class="img-fluid rounded-circle" loading="lazy"/>
	      <h1 class="text-light"><span><a href="{{ url()->current() }}">
	      	<small class="text-center">
	      		{{ env('APP_NAME') }}  {{ env('APP_VERSION') }}
	      	</small></a></span>
	      </h1>
	    </div>
	   	<nav id="navbar" class="nav-menu">
	      <ul>
	        <a href="{{ route('dashboard.index') }}"
	        	class="nav-link {{ Str::contains(request()->getRequestUri(), '/dashboard') ? 'active' : ''}}"><li>
	        	<i class="fas fa-igloo"></i>&nbsp; <span>{{ __('Dashboard') }}</span>
	        </li></a>

	        <a href="#" class="nav-link"><li>
	        	<i class="fas fa-database"></i>&nbsp; <span>Votes Management</span>
	        </li></a>

	        <a href="#" class="nav-link"><li>
	        	<i class="fas fa-users"></i>&nbsp; <span>Candidate Management</span>
	        </li></a>

	        <a href="#" class="nav-link"><li>
	        	<i class="fas fa-sort-amount-up"></i>&nbsp; <span>Candidates Ranking</span>
	        </li></a>

	        <a href="#" class="nav-link"><li>
	        	<i class="fa-solid fa-gear"></i>&nbsp; <span>Configuration</span>
	        </li></a>

	        <a href="javascript:void(0)"
	        	class="nav-link"
	        	id="logoutButton"
	        	data-uid="{{ auth()->user()->uid }}"><li>
	        	<i class="fas fa-sign-out-alt"></i>&nbsp; <span>{{ __('Logout') }}</span>
	        </li></a>
	      </ul>
	    </nav>
	  </div>
	</aside>
	<!-- ======= Main ======= -->
 	<main>
 		{{ $slot }}
 	</main>
 	<script src="{{ asset('/wp-content/plugins/bootstrap/bootstrap@5.3.2/js/bootstrap.bundle.min.js') }}"></script>
 	<script src="{{ asset('/wp-content/plugins/fontawesome/js/all.min.js') }}"></script>
	<script src="{{ asset('/wp-content/plugins/toastr/toastr.min.js') }}"></script>
	<script src="{{ asset('/wp-admin/plugins/purecounter/purecounter_vanilla.js') }}"></script>
 	<script src="{{ asset('/wp-admin/plugins/aos/aos.js') }}"></script>
 	<script src="{{ asset('/wp-admin/plugins/glightbox/js/glightbox.min.js') }}"></script>
 	<script src="{{ asset('/wp-admin/plugins/isotope-layout/isotope.pkgd.min.js') }}"></script>
 	<script src="{{ asset('/wp-admin/plugins/swiper/swiper-bundle.min.js') }}"></script>
 	<script src="{{ asset('/wp-admin/plugins/typed.js/typed.min.js') }}"></script>
 	<script src="{{ asset('/wp-admin/plugins/waypoints/noframework.waypoints.js') }}"></script>
 	<script src="{{ asset('/wp-admin/themes/scripts/app.js') }}"></script>
 	<script src="{{ asset('/wp-admin/themes/scripts/main.js') }}"></script>
</body>
</html>