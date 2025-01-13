<!doctype html>
<html lang="en" dir="ltr" data-bs-theme="auto">
<head>

    <!-- Include JavaScript for color modes -->
    <script src="{{ asset('assets-2/js/color-modes.js') }}"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Update the 'content' attribute to reflect the actual content description -->
    <meta name="description" content="your_description_goes_here">

    <!-- Modify the 'content' attribute to include appropriate keywords -->
    <meta name="keywords" content="your_keywords_goes_here">

    <meta name="author" content="tigmatemplate">
    <meta name="generator" content="Bootstrap">

    <!-- Change the text within the <title> tag to match the webpage's content -->
    <title>@yield('title', 'WashUP Laundry')</title>

    <!-- 
        Set the website's favicon and Apple touch icon using the files in the assets/logo folder. You can change these files to your own icons by replacing them with the same names and sizes.

        Be careful if you change the site.webmanifest file, as you need to update the src attribute of the icons array to match the new path of your icon files. Otherwise, your icons may not display correctly on some devices. 
    -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets-2/logo/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo_laundry_bg.jpeg') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo_laundry_bg.jpeg') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo_laundry_bg.jpeg') }}">
    <link rel="manifest" href="{{ asset('assets-2/logo/site.webmanifest') }}">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets-2/libraries/glide/css/glide.core.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-2/libraries/aos/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-2/css/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-2/css/style.css') }}">

    <!-- Open Graph Meta Tags for Social Sharing -->
    <!-- Update the 'title' and 'description' content below to enhance social sharing -->
    <meta property="og:title" content="your_title_goes_here">
    <meta property="og:description" content="your_description_goes_here">
    <!-- Update with actual absolute image URL like: https://example.com/main.jpg -->
    <meta property="og:image" content="your_absolute_image_url_goes_here">
    <!-- Update with the absolute URL of the content like: https://example.com/index.html -->
    <meta property="og:url" content="your_absolute_content_url_goes_here">
    <!-- Update with the type of object you’re sharing. (e.g., article, website, etc.) -->
    <meta property="og:type" content="website">
    <!-- Defines the content language -->
    <meta property="og:locale" content="id_ID">

    
    <!-- X/Twitter Card Meta Tags for Social Sharing -->
    <meta name="twitter:card" content="summary_large_image">
    <!-- Update with your X/Twitter handle -->
    <meta name="twitter:site" content="@yourtwitterhandle"> 
    <!-- Update the 'title' and 'description' content below to enhance social sharing -->
    <meta name="twitter:title" content="your_title_goes_here"> 
    <meta name="twitter:description" content="your_description_goes_here">
    <!-- Update with actual absolute image URL like: https://example.com/main.jpg -->
    <meta name="twitter:image" content="your_absolute_image_url_goes_here"> 
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="your_canonical_url_goes_here">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.4.47/css/materialdesignicons.min.css">
</head>
<body>
    <!-- loader-wrapper -->
    <div class="loader-wrapper">
        <div class="spinner-border text-success p-5" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    @include('landing.layout.header')
    @include('landing.layout.content')
    @include('landing.layout.footer')

    @include('vendor.sweetalert')
    
    <!-- Back to top button -->
    <button type="button" class="btn btn-success btn-back-to-top rounded-circle justify-content-center align-items-center p-2 text-white">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16"> <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/> </svg>
    </button>
	<!-- Bootstrap JavaScript: Bundle with Popper -->
    <script src="{{ asset('assets-2/libraries/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets-2/libraries/glide/glide.min.js') }}"></script>
    <script src="{{ asset('assets-2/libraries/aos/aos.js') }}"></script>
    <script src="{{ asset('assets-2/js/scripts.js') }}"></script>
    <script src="{{ asset('assets-2/php/contact/script.js') }}"></script>
</body>
</html>