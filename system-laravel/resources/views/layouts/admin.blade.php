<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard')</title>

    {{-- plugins:css --}}
    <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/typicons/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">

    @stack('styles')

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />

<style>
  /* 1. THE TOP NAVBAR BORDER */
  .navbar {
    border-bottom: 1px solid #e0e0e0 !important;
    background-color: #ffffff !important;
    left: 0 !important;
    width: 100% !important;
  }

  /* 2. THE LOGO BOX & SIDEBAR WIDTH (Expanded State) */
  /* Only apply 280px if NOT in icon-only mode */
  body:not(.sidebar-icon-only) .navbar .navbar-brand-wrapper, 
  body:not(.sidebar-icon-only) .sidebar {
    width: 280px !important;
    min-width: 280px !important;
    border-right: 1px solid #e0e0e0 !important;
  }

  /* 3. YOUR GREEN ACTIVE BOX */
  .sidebar .nav .nav-item.active > .nav-link {
    background: #2E7D32 !important;
    color: #ffffff !important;
    border-radius: 9px !important;
    margin: 5px 12px !important; 
    padding: 10px 15px !important; 
    display: flex !important;
    align-items: center !important;
  }

  /* 4. SIDEBAR CONTENT VISIBILITY */
  .sidebar .nav {
    overflow: visible !important;
  }

  .sidebar .nav .nav-item .menu-title {
    white-space: nowrap !important;
    color: #484848;
    margin-left: 10px;
  }

  .sidebar .nav .nav-item.active .menu-icon,
  .sidebar .nav .nav-item.active .menu-title {
    color: #ffffff !important;
  }

  /* 5. ADJUST THE CONTENT AREA & NAVBAR WRAPPER (Expanded State) */
  body:not(.sidebar-icon-only) .navbar-menu-wrapper,
  body:not(.sidebar-icon-only) .main-panel {
    width: calc(100% - 280px) !important;
  }

  /* ==========================================================
     FIX FOR TOGGLE (SIDEBAR-ICON-ONLY)
     ========================================================== */

  /* Force the sidebar to actually shrink to 70px when toggled */
  body.sidebar-icon-only .sidebar,
  body.sidebar-icon-only .navbar .navbar-brand-wrapper {
    width: 70px !important;
    min-width: 70px !important;
  }

  /* Force content to fill the extra space when sidebar is small */
  body.sidebar-icon-only .main-panel,
  body.sidebar-icon-only .navbar-menu-wrapper {
    width: calc(100% - 70px) !important;
  }

  /* Fix Icon Alignment: Center them in the small 70px space */
  body.sidebar-icon-only .sidebar .nav .nav-item .nav-link {
    display: flex !important;
    justify-content: center !important;
    padding-left: 0 !important;
    margin: 5px 0 !important;
  }

  /* Hide the Menu Titles and the "C" Logo entirely */
  body.sidebar-icon-only .menu-title,
  body.sidebar-icon-only .navbar-brand-wrapper .brand-logo-mini {
    display: none !important;
  }

  /* Fix for the green active box when collapsed */
  body.sidebar-icon-only .sidebar .nav .nav-item.active > .nav-link {
    margin: 5px 10px !important;
    padding: 10px 0 !important;
    justify-content: center !important;
  }
</style>
    </head>

  <body class="with-welcome-text">
    <div class="container-scroller">

      {{-- Navbar --}}
      @include('partials.navbar')

      <div class="container-fluid page-body-wrapper">

        {{-- Sidebar --}}
        @include('partials.sidebar_admin')

        <div class="main-panel">
          <div class="content-wrapper">
            {{-- Page Content --}}
            @yield('content')
          </div>
        </div>

      </div>
    </div>

    {{-- plugins:js --}}
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

    {{-- inject:js --}}
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <script src="{{ asset('assets/js/settings.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/js/todolist.js') }}"></script>

    @stack('scripts')
  </body>
</html>