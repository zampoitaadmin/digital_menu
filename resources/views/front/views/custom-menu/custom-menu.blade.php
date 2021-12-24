@extends('front.layouts.layout')
@section('title')
    custom-menu
@endsection

@section('meta')
    <meta name="title" content="LV MAP">
    <meta name="description" content="LV MAP DESCRIPTION">
@endsection
@section('styles')
@endsection

@section('content')
    <div id="main-content" class="blog-page">
        <div class="container">
            @include('front.views.custom-menu._custom-sub-menu')
        </div>
        <div class="tab-content">
            <ui-view></ui-view>
            <script type="text/ng-template" id="categories.html">
                @include('front.views.custom-menu._categories')
            </script>
            <script type="text/ng-template" id="products.html" >
                @include('front.views.custom-menu._products')
            </script>
            <script type="text/ng-template" id="branding.html" ng-cloak>
                @include('front.views.custom-menu._branding')
            </script>
            <script type="text/ng-template" id="setting.html" ng-cloak>
                @include('front.views.custom-menu._setting')
            </script>

        </div>
    </div>
    <!-- ====== Banner End ====== -->
    <div class="content-wrapper" ng-cloak>
        {{--<ui-view></ui-view>--}}
        {{--@include('front.views.custom-menu._custom-sub-menu')--}}
        {{--<div ng-view></div>--}}
        {{--<ui-view></ui-view>
        <script type="text/ng-template" id="categories.html">
            @include('front.views.custom-menu._categories')
        </script>
        <script type="text/ng-template" id="products.html" >
            @include('front.views.custom-menu._products')
        </script>--}}
        {{--<script type="text/ng-template" id="branding.html" ng-cloak>
            @include('front.views.custom-menu._branding')
        </script>
        <script type="text/ng-template" id="setting.html" ng-cloak>
            @include('front.views.custom-menu._setting')
        </script>--}}
        {{--@if(auth()->user()->is_superadmin == 1 || auth()->user()->can('Create Admin-User'))
            <script type="text/ng-template" id="add.html">
                @include(BACKEND_VIEW.'.demo-crud.add')
            </script>
        @endif
        @if(auth()->user()->is_superadmin == 1 || auth()->user()->can('Create Admin-User'))
            <script type="text/ng-template" id="update.html">
                @include(BACKEND_VIEW.'.demo-crud.update')
            </script>
        @endif--}}

    </div>
@endsection

@section('page_script')
    <script>
        @if(Session::has('message'))
        toastr.error('{{ Session::get('message') }}', 'Error');
        @endif
    </script>
@endsection

@section('script')

    <script src='{{ asset("assets/ng/custom-menu/index.js?t=".time()) }}'></script>
    <script src='{{ asset("assets/ng/custom-menu/categoriesCtrl.js?t=".time()) }}'></script>
    <script src='{{ asset("assets/ng/category/servicesCategory.js?t=".time()) }}'></script>

    <script src='{{ asset("assets/ng/custom-menu/productsCtrl.js?t=".time()) }}'></script>
    <script src='{{ asset("assets/ng/products/servicesProduct.js?t=".time()) }}'></script>

    <script src='{{ asset("assets/ng/custom-menu/brandingCtrl.js?t=".time()) }}'></script>
    <script src='{{ asset("assets/ng/custom-menu/servicesBranding.js?t=".time()) }}'></script>
@endsection

{{--<script type='text/javascript' src='{{ asset("assets/ng/sso/index.js".'?t='.time()) }}'></script>--}}
{{--<script type='text/javascript' src='{{ asset(
"assets/ng/sso/MainController.js".'?t='.time()) }}'></script>--}}
{{--    <script src='{{ asset("assets/ng/sso/services-sso.js".'?t='.time()) }}'></script>
    <script src='{{ asset("assets/ng/custom-menu/index".'?t='.time()) }}'></script>
    <script src='{{ asset("assets/ng/category/CustomMenuCategoryController.js".'?t='.time()) }}'></script>
    <script src='{{ asset("assets/ng/category/servicesCategory.js".'?t='.time()) }}'></script>--}}
