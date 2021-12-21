	<!--====== Favicon Icon ======-->
	<link rel="icon" type="image/png" sizes="100x100" href="{{ _get_favicon() }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}" />
    {{--<link rel="canonical" href="URL" />--}}

	<!-- ===== All CSS files ===== -->
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/css/custom.css?t='.time())  }}" />
	{{--<link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/css/lineicons.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/css/ud-styles.css') }}" />--}}

	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
	<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">

    @yield('styles')