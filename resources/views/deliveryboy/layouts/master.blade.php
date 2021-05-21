<!DOCTYPE html>
<html lang="zxx">
<head>
	@include('deliveryboy.layouts.head')
</head>
<body class="js">

	<!-- Preloader -->
    {{--
	<div class="preloader">
		<div class="preloader-inner">
			<div class="preloader-icon">
				<span></span>
				<span></span>
			</div>
		</div>
	</div>
	--}}
	<!-- End Preloader -->

	@include('deliveryboy.layouts.notification')
	<!-- Header -->
	@include('deliveryboy.layouts.header')
	<!--/ End Header -->
	@yield('main-content')

	@include('deliveryboy.layouts.footer')

</body>
</html>
