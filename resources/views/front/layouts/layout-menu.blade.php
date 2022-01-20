<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <base href="{{env('APP_URL')}}">
    @include('front.layouts.meta')
    @include('front.layouts.styles-menu')
</head>
<body ng-app="bbApp"  ng-cloak class="ng-cloak" data-spy="scroll" data-target=".tab-panel" data-offset="50">
    @yield('content')
    @include('front.layouts.scripts-menu')
    <style type="text/css">
        [ng:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
                        display: none !important;
                    }
    </style>
</body>
</html>