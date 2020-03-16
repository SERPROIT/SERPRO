<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Sistema Serpro</title>

	<!-- Global stylesheets -->
	<link href="{{asset('css/global_assets/css.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('css/global_assets/styles.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('css/assets/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('css/assets/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('css/assets/layout.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('css/assets/components.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('css/assets/colors.min.css')}}" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="{{asset('js/global_assets/main/jquery.min.js')}}"></script>
	<script src="{{asset('js/global_assets/main/bootstrap.bundle.min.js')}}"></script>
	<script src="{{asset('js/global_assets/plugins/loaders/blockui.min.js')}}"></script>
	<script src="{{asset('js/app.js')}}"></script>
	<!-- /core JS files -->

	@yield('scripts')

</head>

<body>

	
	
	<!-- Main navbar -->
	@include('partial.navbar')
	<!-- /main navbar -->
	<!-- Page content -->
	<div class="page-content">
		
		<!-- Main sidebar -->		
		@include('partial.sidebar')		
		<!-- /main sidebar -->
		

		<!-- Main content -->
		<div class="content-wrapper">

				
			<!-- Page header -->
			@include('partial.content_header')
			<!-- /page header -->
			
			@yield('content')				
				
			<!-- Footer -->
			@include('partial.content_footer')
			<!-- /footer -->
			

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

</body>
</html>
