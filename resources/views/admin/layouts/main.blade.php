<!doctype html>
<html
  lang="en"
  class="light-style layout-navbar-fixed layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ url('assets') }}/"
  data-template="vertical-menu-template-starter"
>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  @livewireStyles

  <!-- Core head -->
  @include('admin.partials.head', ['vendor' => isset($vendor)?$vendor:[]])

  <!-- head stack -->
  @stack('head')

  <title>{{ config('app.name', 'Hypercode') }} - @yield('title')</title>

  <style type="text/css">
    .sorticon{ visibility: hidden; color: darkgray; }
    .sort:hover .sorticon{ visibility: visible; }
    .sort:hover{ cursor: pointer; }
  </style>
</head>
<body>

  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

      @include('admin.partials.menu')

      <!-- Layout container -->
      <div class="layout-page">

        @include('admin.partials.navbar')

        <!-- Content wrapper -->
        <div class="content-wrapper">

          <!-- Content -->
          <div class="container-xxl flex-grow-1 container-p-y">

            @yield('content')

          </div><!-- /Content -->

          <div class="content-backdrop fade"></div>

        </div><!-- /Content wrapper -->

      </div><!-- /Layout page -->

    </div><!-- /Layout container -->

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>

  </div><!-- /Layout wrapper -->

<!-- Core script -->
@include('admin.partials.script', ['vendor' => isset($vendor)?$vendor:[]])

<!-- Stackscript-->
@stack('scripts')

@livewireScripts
</body>
</html>
