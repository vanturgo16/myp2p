<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta20
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">
  <head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
		<meta http-equiv="X-UA-Compatible" content="ie=edge"/>
		<title>P2P</title>

		<!-- CSS files -->
		<link href="{{ asset('dist/css/tabler.min.css') }}" rel="stylesheet"/>
		<link href="{{ asset('dist/css/tabler-flags.min.css') }}" rel="stylesheet"/>
		<link href="{{ asset('dist/css/tabler-payments.min.css') }}" rel="stylesheet"/>
		<link href="{{ asset('dist/css/tabler-vendors.min.css') }}" rel="stylesheet"/>
		<link href="{{ asset('dist/css/demo.min.css') }}" rel="stylesheet"/>
		
		<!--Data Tables-->
		<link rel="stylesheet" type="text/css" href="{{ asset('dist/css/jquery.dataTables.min.css') }}">
		<script src="{{ url('https://code.jquery.com/jquery-3.5.1.js') }}"></script>
		<script src="{{ url('https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js') }}"></script>

		<!--for Select2-->
		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
  </head>
  <body>
    <script src="{{ asset('/dist/js/demo-theme.min.js') }}"></script>
    <div class="page">
      <!-- Navbar -->
      <div class="sticky-top">
        <header class="navbar navbar-expand-md sticky-top d-print-none" >
          @include('layouts.includes._nav_head')
        </header>
        <header class="navbar-expand-md">
          @include('layouts.includes._nav_menu')
        </header>
      </div>
      <div class="page-wrapper">
        <!-- ini section content -->
        @yield('content')
        <footer class="footer footer-transparent d-print-none">
          <!-- ini adalah footer -->
          @include('layouts.includes._footer')
        </footer>
      </div>
    </div>

    <!-- Tabler Core -->
    <script src="{{ asset('/dist/js/tabler.min.js') }}"></script>
    <script src="{{ asset('./dist/js/demo.min.js') }}"></script>
  </body>
</html>