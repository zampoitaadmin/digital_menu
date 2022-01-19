@extends('front.layouts.layout-menu')
@section('title')
    Zampoita
@endsection
@section('meta')
    <meta name="title" content="LV MAP">
    <meta name="description" content="LV MAP DESCRIPTION">
@endsection
@section('styles')
@endsection
@section('content')
@if($userInfo)
    <ui-view></ui-view>
    <script type="text/ng-template" id="menu.html">
        <section id="product_details" data-aos="fade-down" data-aos-delay="300">
            <div class="container">
                <div class="row" >
                    <div class="col-md-3">
                        <img class="img-responsive main-product_img" src="@{{ branding.brandLogoUrl }}">
                    </div>
                    <div class="col-md-6">
                        <h1 class="title text-white wack_waffle_pizza">@{{ userInfo.restaurant_name }}</h1>
                        <h5 class="text-white wack_waffle_pizza_h3">@{{ userInfo.short_description }}</h5>
                        <div id="accordion">
                            <div class="card  pb-3">
                                <div class="card-header p-0" id="headingTwo" >
                                    <button class="btn btn-link  p-0 collapsed text-white" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    @{{ userInfo.long_description }}
                                    <i class="fa fa-chevron-down down_arrow" aria-hidden="true"></i>
                                    </button>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="card-body pl-0">
                                        @{{ userInfo.long_description }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="listing listing-danger mt-4">
                            <div class="listing-content text-white">
                                <h3 class="text-center font-weight-bold">Offers</h3>
                                <div class="d-flex text-white" ng-if="userInfo.standard_delivery_charge!=''">
                                    <div class="pt-1 pb-1 mr-2">
                                        <img src="{{ _getHomeUrl('assets/frontend/images/delivery-bike-white.png') }}" height="25px" width="20px">
                                    </div>
                                    <div class="pt-1 pb-1  offer-p">Standard Delivery charge  € @{{ userInfo.standard_delivery_charge }}
                                    </div>
                                </div>
                                <div class="d-flex text-white" ng-if="userInfo.min_order_delivery_charge!=''">
                                    <div class="pt-1 pb-1 mr-2">
                                        <img src="{{ _getHomeUrl('assets/frontend/images/delivery-bike-white.png') }}" height="25px" width="20px">
                                    </div>
                                    <div class="pt-1 pb-1  offer-p">Min Order Delivery charge € @{{ userInfo.min_order_delivery_charge }}
                                    </div>
                                </div>
                                <div class="d-flex text-white" ng-if="userInfo.free_delivery_charge_order!=''">
                                    <div class="pt-1 pb-1 mr-2">
                                        <img src="{{ _getHomeUrl('assets/frontend/images/delivery-bike-white.png') }}" height="25px" width="20px">
                                    </div>
                                    <div class="pt-1 pb-1  offer-p">Free Delivery charge Max Order € @{{ userInfo.free_delivery_charge_order }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="search" class="sticky-top" data-aos="fade-down" data-aos-delay="350">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class=" has-search">
                            <input type="text" class="form-control" placeholder="Search" ng-model="searchText" ng-keyup="searchItem()">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6 class="title m-0 pt-3 pb-3 text-right"><a href="#" class="text-white allergy_text" type="button" class="btn btn-light border rounded-pill shadow-sm mb-1" data-toggle="modal" data-target="#fullscreen_modal">CLICK HERE FOR ALLERGY INFORMATION</a></h6>
                    </div>
                </div>
            </div>
        </section>
        <section style="background-image: url({{ asset('assets/front-menu/images/bg.png') }}); background-size: contain;" data-aos="fade-up" data-aos-delay="350">
            <div class="container" >
                <div class="row">
                    <span class="loaderMenu bb-loader" ng-bind-html="loaderMenu" ng-if="loaderMenu.length>0"></span>
                    <div class="col-md-3 mb-3 p-3 tab-panel sticky-top" style="top: 50px!important;">
                        <ul class="nav nav-pills flex-column" ng-repeat="category in userSelectedCategories">
                            <li class="nav-item">
                                <a ng-if="category.change_category_name" class="nav-link" ng-class="{'active': $first}" href="#@{{category.slug}}">@{{ category.change_category_name }}</a>
                                <a ng-if="!category.change_category_name" class="nav-link" ng-class="{'active': $first}" href="#@{{category.slug}}">
                                    @if( _getAppLang() == "en" )
                                        @{{ category.name }}
                                    @elseif( _getAppLang() == "es" )
                                        @{{ category.spanish }}
                                    @endif
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-9 p-3 tab-content" style="border-left: 1px solid #A1A1A1;" ng-repeat="category in userSelectedCategories">
                        <div id="@{{category.slug}}" data-toggle="pill"  role="tabpanel" aria-labelledby="home-tab">
                            <h2 ng-if="category.change_category_name">
                                @{{ category.change_category_name }}
                            </h2>
                            <h2 ng-if="!category.change_category_name">
                                @if( _getAppLang() == "en" )
                                    @{{ category.name }}
                                @elseif( _getAppLang() == "es" )
                                    @{{ category.spanish }}
                                @endif
                            </h2>
                            <div class="row product_bottom_border" ng-class="{'mt-4': !$first}" ng-repeat="product in category.responseProducts">
                                <div class="col-sm-4">
                                    <img data-toggle="modal" data-target="#regular_modal" src="" class="img-responsive mb-3">
                                </div>
                                <div class="col-sm-6">
                                    <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">@{{ product.product_name }}</h4>
                                    <p class="card-text">@{{ product.product_description }}</p>
                                </div>
                                <div class="col-sm-2 my-auto">
                                    <a href="#" class="btn btn-primary pull-right btn-md">$ 789</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </script>
@else
    <h1>Not Found</h1>
@endif
@endsection
@section('page_script')
    <script>
        @if(Session::has('message'))
        toastr.error('{{ Session::get('message') }}', 'Error');
        @endif
    </script>
@endsection
@section('script')
    @if($userInfo)
        <script src='{{ asset("assets/ng/menu/index.js?t=".time()) }}'></script>
        <script src='{{ asset("assets/ng/menu/menuCtrl.js?t=".time()) }}'></script>
        <script src='{{ asset("assets/ng/menu/servicesMenu.js?t=".time()) }}'></script>
    @endif
@endsection