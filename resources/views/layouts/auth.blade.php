<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@yield('title_page')</title>

    <meta name="description" content="" />

    @php
        $version = date('YmdHis');
    @endphp

    <!-- Favicon (with versioning) -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/fav_icon.jpg') }}?v={{ $version }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}?v={{ $version }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}?v={{ $version }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}?v={{ $version }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?v={{ $version }}" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}?v={{ $version }}" />

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}?v={{ $version }}"></script>
</head>


<body>
    <!-- Content -->

    <div class="container-fluid">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Form -->
                    @yield('content')
                <!-- /Form -->
            </div>
        </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}?v={{ $version }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}?v={{ $version }}"></script>
    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}?v={{ $version }}"></script>

    <!-- Page JS -->
</body>

</html>
