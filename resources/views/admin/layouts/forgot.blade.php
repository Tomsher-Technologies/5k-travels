<!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<title>{{ env('APP_NAME') }} - @yield('title')</title>
	<!-- Bootstrap -->
    <link href="{{ asset('assets/plugins/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet" />
    <!-- Font Awesome -->
    <link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
    <!-- Custom Theme Style -->
    <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" />
	<!-- SweetAlert -->
	<link href="{{ asset('assets/css/sweetalert2.min.css') }}" rel="stylesheet" />
	@yield('header')
	<!-- jQuery -->
	<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
	

</head>

<body class="nav-md">
	<div class="container body">
		<div class="main_container">
			
			
			<!-- page content -->
			@yield('content')
			<!-- /page content -->

		</div>
	</div>

	<!-- Bootstrap -->
	<script src="{{ asset('assets/plugins/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

	<!-- Custom Theme Scripts -->
	<script src="{{ asset('assets/js/custom.min.js') }}"></script>
	<!-- SweetAlert -->
	<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
	@yield('footer')
</body></html>
