<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <base href="{{env('APP_URL')}}">
    @include('front.layouts.meta')
    @include('front.layouts.styles')

</head>

<body style="background: url(assets/images/bg-3.jpg) no-repeat; background-size: cover; background-position: center; height: 100%;" ng-app="bbApp"  ng-cloak class="ng-cloak">

    @include('front.layouts.main_header')

    @include('front.layouts.header')

    @yield('content')

    @include('front.layouts.footer')

    @include('front.layouts.scripts')
    <style type="text/css">
        [ng:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
                        display: none !important;
                    }
    </style>
</body>
</html>