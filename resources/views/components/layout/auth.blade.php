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
  <meta name='identifier-URL' content='{{ env('APP_URL') }}'/>
  <meta name="msapplication-TileImage" content="{{ asset('/wp-content/uploads/favicon.png') }}" />
  <meta name='author' content='https://javecilla.vercel.app'/>
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

  <link rel='dns-prefetch' href='https://fonts.googleapis.com' />
  <link rel='dns-prefetch' href='https://fonts.gstatic.com' />
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@700;800&family=Roboto+Flex:opsz,wght@8..144,300&display=swap" defer/>

  <link rel="stylesheet" href="{{ asset('/wp-plugins/bootstrap/bootstrap@5.3.2/css/bootstrap.min.css') }}"/>
  <link rel="stylesheet" href="{{ asset('/wp-plugins/fontawesome/css/all.min.css') }}"/>
  <link rel="stylesheet" href="{{ asset('/wp-plugins/wow/wow.min.css') }}"/>
  <link rel="stylesheet" href="{{ asset('/wp-plugins/toastr/toastr.min.css') }}"/>
  <link rel="stylesheet" href="{{ asset('/wp-content/guest/themes/stylesheets/app.css?v=1.4.1') }}" defer/>
  <link rel="stylesheet" href="{{ asset('/wp-content/guest/themes/stylesheets/auth.css?v=1.4.1') }}" defer/>
  <link rel="stylesheet" href="{{ asset('/wp-content/guest/themes/stylesheets/auth.css?v=1.4.1') }}" defer/>


  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  @production
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-CH1S28LJ16"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-CH1S28LJ16');
    </script>
  @endproduction
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

	<script src="{{ asset('/wp-plugins/jquery/jquery@3.7.1/jquery.min.js')}}"></script>
  <script src="{{ asset('/wp-plugins/bootstrap/bootstrap@5.3.2/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('/wp-plugins/fontawesome/js/all.min.js') }}"></script>
  <script src="{{ asset('/wp-plugins/wow/wow.min.js') }}"></script>
  <script src="{{ asset('/wp-plugins/toastr/toastr.min.js') }}"></script>
  <script src="{{ asset('/wp-content/global/scripts/common.js?v=1.4.1') }}"></script>
  <script src="{{ asset('/wp-content/global/scripts/helpers.js?v=1.4.1') }}"></script>
  <script src="{{ asset('/wp-content/guest/themes/scripts/auth.js?v=1.4.2') }}"></script>
</body>
</html>
<!-- GMCVS v1.4.1 -->
<!-- Last Updated at: August 18, 2024 -->
<!-- https://github.com/javecilla/readme -->