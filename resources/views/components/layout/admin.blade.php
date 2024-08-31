<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="UTF-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}"/>
  <meta name="app-version" content="{{ env('APP_VERSION') }}"/>
  <meta name="robots" content="noindex, nofollow"/>
  <meta name="googlebot" content="noindex, nofollow, max-snippet:-1, max-image-preview:large, max-video-preview:-1"/>
  <meta name="bingbot" content="noindex, nofollow, max-snippet:-1, max-image-preview:large, max-video-preview:-1"/>
  <meta name="description" content="@isset($description) {{ $description }} | @endisset {{ env('APP_NAME') }} {{ env('APP_VERSION') }}" />
  <meta name="abstract" content="Official Voting System of Golden Minds Bulacan"  />
  <meta name="copyright" content="Golden Minds Bulacan"  />
  <meta name='Classification' content='Website'/>
  <meta name='identifier-URL' content='{{ url()->current() }}'/>
  <meta name="msapplication-TileImage" content="{{ asset('/wp-content/uploads/favicon.png') }}" />
	<title>
		@isset($title) {{ $title }} | @endisset {{ env('APP_NAME') }}
		@if(isset($version)) {{ $version }} @else {{ env('APP_VERSION') }} @endif
	</title>

	<link rel="shortcut icon" type="image/png" sizes="16x16"
		href="{{ asset('/wp-content/uploads/favicon.png') }}" />
  <link rel="apple-touch-icon" type="image/png" sizes="16x16"
  	href="{{ asset('/wp-content/uploads/favicon.png') }}" />

  <link rel='dns-prefetch' href='https://fonts.googleapis.com' />
  <link rel='dns-prefetch' href='https://fonts.gstatic.com' />
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet"/>

	<link rel="stylesheet" href="{{ asset('/wp-plugins/bootstrap/bootstrap@5.3.2/css/bootstrap.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('/wp-plugins/fontawesome/css/all.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('/wp-plugins/toastr/toastr.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('/wp-plugins/sweetalert/sweetalert2@11/dist/sweetalert2.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('/wp-plugins/aos/aos.css') }}"/>
	<link rel="stylesheet" href="{{ asset('/wp-plugins/bootstrap-icons/bootstrap-icons.css') }}"/>
	<link rel="stylesheet" href="{{ asset('/wp-plugins/boxicons/css/boxicons.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('/wp-plugins/glightbox/css/glightbox.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('/wp-plugins/swiper/swiper-bundle.min.css') }}"/>

	<link rel="stylesheet" href="{{ asset('/wp-content/admin/themes/stylesheets/sidebar.css') }}" defer/>
	<link rel="stylesheet" href="{{ asset('/wp-content/admin/themes/stylesheets/main.css') }}" defer/>
	<script src="{{ asset('/wp-plugins/jquery/jquery@3.7.1/jquery.min.js')}}"></script>
</head>
<body class="app-body" id="body">
	<!-- ======= Mobile nav toggle button ======= -->
	<i class="bi bi-list mobile-nav-toggle d-xl-none admin_mobile_nav"></i>

	<!-- ======= Sidebar ======= -->
	<x-sidebar>
	  <div class="d-flex flex-column">
	   	<div class="mt-3">
	      <img src="{{ asset('/wp-content/admin/uploads/vslogo-white.png') }}" alt="logo"
	      	class="img-fluid" loading="lazy"/>
	    </div>
	    <hr class="text-white"/>
	    {{-- date today --}}
      <div class="current-date">
        <h5 id="date">{{ now()->format('F d, Y') }}</h5>
        <label class="days_time">{{ now()->format('(l)') }}
          <span id="time"></span>
        </label>
      </div>
	   	<nav id="navbar" class="nav-menu">
	   		<hr class="mb-3">
	      <ul>
	        <a href="{{ route('dashboard.index', ['version' => request()->route('version')]) }}"
	        	class="nav-link {{ Str::contains(request()->getRequestUri(), '/dashboard') ? 'active' : ''}}">
	        	<li><i class="fas fa-igloo"></i>&nbsp; <span>{{ __('Dashboard') }}</span></li>
	        </a>

	        <a href="{{ route('candidates.ranking', ['version' => request()->route('version')]) }}" class="nav-link {{ Str::contains(request()->getRequestUri(), '/ranking') ? 'active' : ''}}"><li>
	        	<i class="fas fa-sort-amount-up"></i>&nbsp; <span>{{ __('Candidates Ranking') }}</span>
	        </li></a>

	        <a href="{{ route('votes.summary', ['version' => request()->route('version')]) }}"
	        	class="nav-link {{ Str::contains(request()->getRequestUri(), '/votes/summary') ? 'active' : ''}}">
	        	<li><i class="fa-solid fa-file"></i>&nbsp; <span>{{ __('Summary') }}</span></li>
	        </a>

	        <a href="{{ route('votes.index', ['version' => request()->route('version')]) }}"
	        	class="nav-link {{ Str::contains(request()->getRequestUri(), '/manage/votes') ? 'active' : ''}}">
	        	<li><i class="fas fa-database"></i>&nbsp; <span>{{ __('Votes Management') }}</span></li>
	        </a>

	        <a
	        href="{{ route('candidates.index', ['version' => request()->route('version')]) }}"
	        	class="nav-link {{ Str::contains(request()->getRequestUri(), '/manage/candidates') ? 'active' : ''}}">
	        	<li><i class="fas fa-users"></i>&nbsp; <span>{{ __('Candidate Management') }}</span></li>
	        </a>
	        <hr class="mb-3">

	        <a href="{{ route('reports.index', request()->route('version')) }}"
	         class="nav-link {{ Str::contains(request()->getRequestUri(), '/manage/ticket/reports') ? 'active' : ''}}"><li>
	        	<i class="fa-solid fa-bug"></i>&nbsp; <span>{{ __("Ticket Report's") }}</span>
	        	<span class="report-badge {{ Str::contains(request()->getRequestUri(), '/manage/ticket/reports') ? 'active' : ''}}">
	        		<i class="fas fa-spinner fa-spin" style="font-size: 10px;"></i>
	        	</span>
	        </li></a>

	        <a
	        href="{{ route('configuration.index', ['version' => request()->route('version')]) }}"
	        	class="nav-link {{ Str::contains(request()->getRequestUri(), '/configuration') ? 'active' : ''}}"><li>
	        	<i class="fa-solid fa-gear"></i>&nbsp; <span>{{ __('Configuration') }}</span>
	        </li></a>
	      </ul>
	      <hr>
	      <div class="sidebar-profile-dropdown mt-auto">
			    <div class="nav-link dropdown rounded-5">
			      <a href="javascript:void(0)" class="d-flex align-items-center dropdown-toggle text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
			        <i class="fa-solid fa-code-compare"></i>
			        <span>&nbsp; {{ __('System Versioning') }}</span>
			      </a>
			      <div id="switchVersionsBody">
			      	<ul class="dropdown-menu dropdown-menu-dark text-small shadow">
				      	<a class="dropdown-item active" href="javascript:void(0)">
	        				<li><i class="fas fa-spinner fa-spin" style="font-size: 10px;"></i></li>
	      				</a>
      				</ul>
			      	{{-- data fetch via ajax functions/configuration.js --}}
			      </div>
			    </div>
		    </div>
	    </nav>
	  </div>
	</x-sidebar>

	<!-- ======= Header ======= -->
	<x-header>
		<div class="header-content">
    <div id="headerProfile" class="dropdown rounded-5 ml-auto">
        <a href="javascript:void(0)" class="d-flex align-items-center dropdown-toggle text-decoration-none text-white" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ asset('/wp-content/admin/uploads/profile.jpg') }}" alt="" width="32" height="32" class="rounded-circle me-2">
            <strong>{{ auth()->user()->name }}</strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
            <a class="dropdown-item" href="javascript:void(0)">
                <li><i class="fa-solid fa-user"></i>&nbsp; {{ __('My Profile') }}</li>
            </a>
            <a class="dropdown-item" href="javascript:void(0)">
                <li><i class="fa-solid fa-list"></i>&nbsp; {{ __('Activity Log') }}</li>
            </a>
            <li><hr class="dropdown-divider"></li>
            <a class="dropdown-item" href="javascript:void(0)"
                id="logoutButton"
                data-uid="{{ auth()->user()->uid }}"
                data-version="{{ request()->route('version') }}"
                data-csrf="{{ csrf_token() }}">
                <li><i class="fas fa-sign-out-alt"></i>&nbsp; {{ __('Log out') }}</li>
            </a>
        </ul>
    </div>
		</div>
	</x-header>

	<!-- ======= Main ======= -->
 	<x-main>
 		{{ $slot }}
 	</x-main>

 	<!-- ======= Footer ======= -->
 	<footer>
 	</footer>

 	<script src="{{ asset('/wp-plugins/bootstrap/bootstrap@5.3.2/js/bootstrap.bundle.min.js') }}"></script>
 	<script src="{{ asset('/wp-plugins/fontawesome/js/all.min.js') }}"></script>
	<script src="{{ asset('/wp-plugins/toastr/toastr.min.js') }}"></script>
	<script src="{{ asset('/wp-plugins/sweetalert/sweetalert2@11/dist/sweetalert2.all.min.js') }}"></script>
	<script src="{{ asset('/wp-plugins/purecounter/purecounter_vanilla.js') }}"></script>
 	<script src="{{ asset('/wp-plugins/aos/aos.js') }}"></script>
 	<script src="{{ asset('/wp-plugins/glightbox/js/glightbox.min.js') }}"></script>
 	<script src="{{ asset('/wp-plugins/isotope-layout/isotope.pkgd.min.js') }}"></script>
 	<script src="{{ asset('/wp-plugins/swiper/swiper-bundle.min.js') }}"></script>
 	<script src="{{ asset('/wp-plugins/typed.js/typed.min.js') }}"></script>
 	<script src="{{ asset('/wp-plugins/waypoints/noframework.waypoints.js') }}"></script>

 	<script src="{{ asset('/wp-content/admin/themes/scripts/helper.js') }}" defer></script>
 	<script src="{{ asset('/wp-content/admin/themes/scripts/functions/auth.js') }}" defer></script>
 	<script src="{{ asset('/wp-content/admin/themes/scripts/eventListener/auth.js') }}" defer></script>
 	<script src="{{ asset('/wp-content/admin/themes/scripts/validations.js') }}" defer></script>
 	<script src="{{ asset('/wp-content/admin/themes/scripts/app.js') }}" defer></script>
 	<script src="{{ asset('/wp-content/admin/themes/scripts/main.js') }}" defer></script>
</body>
</html>