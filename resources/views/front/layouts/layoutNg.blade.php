<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    <base href="{{env('APP_URL')}}">
    @include('front.layouts.meta')
    @include('front.layouts.styles')

</head>

<body ng-app="bbApp"  ng-cloak class="ng-cloak">
    <div ng-view>
    </div>
</body>
</html>