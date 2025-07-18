<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Dashboard | WMS Sinau</title>

    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $version = date('YmdHis');
    @endphp

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon"
        href="{{ asset('assets/img/favicon/fav_icon.jpg') }}?v={{ $version }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}?v={{ $version }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}?v={{ $version }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}?v={{ $version }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}?v={{ $version }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}?v={{ $version }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}?v={{ $version }}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}?v={{ $version }}"></script>

    <!-- Config -->
    <script src="{{ asset('assets/js/config.js') }}?v={{ $version }}"></script>

    {{-- Notiflix --}}
    {{-- <script src="{{ asset('assets/vendor/notiflix/src/notiflix.js') }}?v={{ $version }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/notiflix@3.2.5/dist/notiflix-aio-3.2.5.min.js"></script>

    {{-- Bootstrap Icons CDN --}}
    {{-- <link rel="stylesheet" href="{{ asset('npm/bootstrap/bootstrap-icons.min.css') }}?v={{ $version }}"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @yield('style')
</head>


<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo mb-3">
                    <a href="{{ url('/') }}" class="app-brand-link">
                        <img class="w-100" src="{{ asset('assets/img/logo/logo.jpg') }}?v={{ $version }}"
                            alt="">
                    </af>

                    <a href="javascript:void(0);"
                        class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Dashboard -->
                    <li class="menu-item {{ request()->is('/') ? 'active' : '' }}">
                        <a href="{{ url('/') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Analytics">Dashboard</div>
                        </a>
                    </li>

                    <!-- Sistem Gudang -->
                    <li class="menu-item {{ request()->is('warehouses*') || request()->is('materials*') || request()->is('units*') ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-package"></i>
                        <div data-i18n="Sistem Gudang">Sistem Gudang</div>
                    </a>
                    <ul class="menu-sub">
                        <!-- Master Gudang -->
                        <li class="menu-item {{ request()->is('warehouses*') ? 'active' : '' }}">
                        <a href="{{ route('warehouses.index') }}" class="menu-link">
                            <div data-i18n="Master Gudang">Master Gudang</div>
                        </a>
                        </li>

                        <!-- Master Bahan -->
                        <li class="menu-item">
                        <a href="{{ route('materials.index') }}" class="menu-link">
                            <div data-i18n="Master Bahan">Master Bahan</div>
                        </a>
                        </li>

                        <!-- Satuan Stok -->
                        <li class="menu-item {{ request()->is('units*') ? 'active' : '' }}">
                            <a href="{{ route('units.index') }}" class="menu-link">
                                <div data-i18n="Satuan Stok">Satuan Stok</div>
                            </a>
                        </li>

                        <!-- Satuan Stok Detail -->
                        <li class="menu-item">
                        <a href="#" class="menu-link">
                            <div data-i18n="Satuan Stok Detail">Satuan Stok Detail</div>
                        </a>
                        </li>

                        <!-- Belanja Bahan -->
                        <li class="menu-item">
                        <a href="#" class="menu-link">
                            <div data-i18n="Belanja Bahan">Belanja Bahan</div>
                        </a>
                        </li>

                        <!-- Daftar Stok -->
                        <li class="menu-item">
                        <a href="#" class="menu-link">
                            <div data-i18n="Daftar Stok">Daftar Stok</div>
                        </a>
                        </li>

                        <!-- Stok Minimal -->
                        <li class="menu-item">
                        <a href="#" class="menu-link">
                            <div data-i18n="Stok Minimal">Stok Minimal</div>
                        </a>
                        </li>

                        <!-- Transaksi Stok -->
                        <li class="menu-item">
                        <a href="#" class="menu-link">
                            <div data-i18n="Transaksi Stok">Transaksi Stok</div>
                        </a>
                        </li>
                    </ul>
                    </li>
                </ul>

            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar container-fluid navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

                        <ul class="navbar-nav flex-row align-items-center ms-auto">

                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="{{ asset('assets/img/avatars/avatar.jpg') }}?v={{ $version }}"
                                            alt class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="{{ asset('assets/img/avatars/avatar.jpg') }}?v={{ $version }}"
                                                            alt class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-semibold d-block">{{ Auth::user()->name }}</span>
                                                    <small class="text-muted">Admin</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle">Log Out</span>
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    @yield('content')
                    <!-- / Content -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Footer -->
                <footer class="content-footer footer bg-footer-theme">
                    <div class="container-fluid d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                        <div class="mb-2 mb-md-0">
                            Copyright ©
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                        </div>
                    </div>
                </footer>
                <!-- / Footer -->
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    @php
        $version = date('YmdHis');
    @endphp

    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}?v={{ $version }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}?v={{ $version }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}?v={{ $version }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}?v={{ $version }}"></script>

    <script src="{{ asset('assets/vendor/js/menu.js') }}?v={{ $version }}"></script>

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}?v={{ $version }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}?v={{ $version }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}?v={{ $version }}"></script>

    <!-- Github Buttons CDN (tidak perlu versioning) -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    {{-- Chart.js (lokal) --}}
    <script src="{{ asset('npm/chartjs/chart.js') }}?v={{ $version }}"></script>


    @yield('script')
    @stack('modals')
</body>

</html>
