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
  <meta name="msapplication-TileImage" content="{{ asset('/wp-content/uploads/favicon.PNG') }}" />
  <!--<meta author='Jerome Avecilla' content='Developer: https://javecilla.vercel.app'/>-->
  <!--The SEO Framework by Jerome Avecilla -->
  <meta property="article:author" content="https://www.facebook.com/gmcstamaria2015"/>
  <meta property="article:publisher" content="https://www.facebook.com/gmcstamaria2015"/>
  <meta property="og:image"
    content="{{ isset($ogimage) ? $ogimage : asset('/wp-content/uploads/mainogimage.PNG') }}" />
  <meta property="og:image:width" content="608"/>
  <meta property="og:image:height" content="260"/>
  <meta property="og:image:alt" content="{{ env('APP_NAME') }}" />
  <meta property="og:image:secure_url" content="{{ asset('/wp-content/uploads/favicon.PNG') }}"/>
  <meta property="og:locale" content="en_US">
  <meta property="og:type" content="website"/>
  <meta property="og:title"
  content="@isset($title) {{ $title }} | @endisset {{ env('APP_NAME') }} {{ env('APP_VERSION') }}" />
  <meta property="og:description" content="{{ $description }}" />
  <meta property="og:url" content="{{ url()->current() }}" />
  <meta property="og:site_name" content="{{ env('APP_NAME') }}"/>
  <meta property="fb:pages" content="100924508936440"/>
  <meta property="fb:app_id" content="100924508936440"/>
  <meta name="twitter:card" content="summary"/>
  <meta name="twitter:site" content="https://twitter.com/goldenminds"/>
  <meta name="twitter:creator" content="https://twitter.com/goldenminds"/>
  <meta name="twitter:title" content="@isset($ogtitle) {{ $ogtitle }} | @endisset Online Voting System"/>
  <meta name="twitter:description" content="{{ $description }}"/>
  <meta name="twitter:image"
    content="{{ isset($ogimage) ? $ogimage : asset('/wp-content/uploads/mainogimage.PNG') }}"/>
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
	<link rel="stylesheet" href="{{ asset('/wp-content/themes/stylesheets/app.css?v=1.3') }}" async defer/>
	<link rel="stylesheet" href="{{ asset('/wp-content/themes/stylesheets/auth.css?v=1.3') }}" async defer/>
	<script src="{{ asset('/wp-content/plugins/jquery/jquery@3.7.1/jquery.min.js')}}"></script>
	<script src="{{ asset('/wp-content/themes/scripts/auth.js?v=1.3') }}" defer></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body class="auth-body" oncontextmenu="return false">
 	<main class="p-2">
 		{{ $slot }}
 	</main> <!-- /main -->

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

 	<script src="{{ asset('/wp-content/plugins/bootstrap/bootstrap@5.3.2/js/bootstrap.bundle.min.js') }}"></script>
 	<script src="{{ asset('/wp-content/plugins/fontawesome/js/all.min.js') }}"></script>
  <script src="{{ asset('/wp-content/plugins/wow/wow.min.js') }}"></script>
  <script src="{{ asset('/wp-content/plugins/toastr/toastr.min.js') }}"></script>
  <script src="{{ asset('/wp-content/themes/scripts/general.js?v=1.3') }}"></script>
</body>
</html>