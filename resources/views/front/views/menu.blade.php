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
        <style type="text/css">
            .item-list{
                color: #fff;
            }
            #product_details{
                background: @{{brandColor}};
            }
            .custom-btn{
                background: @{{brandColor}};
            }
            .tab-panel .nav .nav-item .active{
                background-color: @{{brandColor}} !important;
            }
            .pro-dec-title-bg{
                background-color: @{{brandColor}} !important;
                color: @{{thirdColor}} !important;
            }
            .item-list{
                background-color: @{{brandColor}} !important;
            }
            .product_bottom_border{
                border-bottom: 2px solid @{{brandColor}};
            }
            .btn-primary{
                border-color: @{{brandColor}} !important;
            }
            .listing-danger{
                border-color: @{{secondaryColor}};
            }
            #search{
                background-color: @{{secondaryColor}};
            }
            .tab-panel .nav .nav-item .nav-link{
                color: @{{secondaryColor}} !important;
            }
            .card-title{
                color: @{{secondaryColor}};
            }
            .card-text{
                color: @{{secondaryColor}};
            }
            .wack_waffle_pizza{
                color: @{{thirdColor}} !important;
            }
            .wack_waffle_pizza_h3{
                color: @{{thirdColor}} !important;
            }
            .lead{
                color: @{{thirdColor}} !important;
            }
            .offer-p{
                color: @{{thirdColor}} !important;
            }
            .allergy_text{
                color: @{{thirdColor}} !important;
            }
        </style>
        <section id="product_details" data-aos="fade-down" data-aos-delay="300">
            <div class="container">
                <div class="row" >
                    <div class="col-md-3">
                        <img class="img-fluid main-product_img" src="@{{ branding.brandLogoUrl }}" onerror="this.onerror=null;this.src='{{ _getHomeUrl('assets/default/100_no_img.jpg') }}';">
                    </div>
                    <div class="col-md-6">
                        <h1 class="title text-white wack_waffle_pizza text-black">@{{ userInfo.restaurant_name }}</h1>
                        <p class="text-white wack_waffle_pizza_h3 text-black">
                            @{{ userInfo.short_description }}
                        </p>
                        <!-- <p></p> -->
                    </div>
                    <div class="col-md-3">
                        <div class="listing listing-danger mt-4">
                            <!-- <div class="shape">
                                <div class="shape-text">hot</div>
                                </div> -->
                            <div class="listing-content text-white">
                                <h3 class="lead text-center text-black font-weight-bold">Offers</h3>
                                <div class="d-flex text-white" ng-if="userInfo.standard_delivery_charge!=''">
                                    <div class="pt-1 pb-1 mr-2">
                                        <img src="{{ _getHomeUrl('assets/frontend/images/delivery-bike-white.png') }}" height="25px" width="20px">
                                    </div>
                                    <div class="pt-1 pb-1  offer-p text-black">Standard Delivery charge {{ config('constants.currency') }}@{{ userInfo.standard_delivery_charge }}</div>
                                </div>
                                <div class="d-flex text-white" ng-if="userInfo.min_order_delivery_charge!=''">
                                    <div class="pt-1 pb-1 mr-2">
                                        <img src="{{ _getHomeUrl('assets/frontend/images/delivery-bike-white.png') }}" height="25px" width="20px">
                                    </div>
                                    <div class="pt-1 pb-1  offer-p text-black">Min Order Delivery charge {{ config('constants.currency') }}@{{ userInfo.min_order_delivery_charge }}</div>
                                </div>
                                <div class="d-flex text-white" ng-if="userInfo.free_delivery_charge_order!=''">
                                    <div class="pt-1 pb-1 mr-2">
                                        <img src="{{ _getHomeUrl('assets/frontend/images/delivery-bike-white.png') }}" height="25px" width="20px">
                                    </div>
                                    <div class="pt-1 pb-1  offer-p text-black">Min Order Delivery charge {{ config('constants.currency') }}@{{ userInfo.free_delivery_charge_order }}</div>
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
                        <!-- Actual search box -->
                        <div class=" has-search pb-3">
                            <span class="fa fa-search form-control-feedback"></span>
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
                    <div class="col-md-3 mb-3 p-3 tab-panel">
                        <ul class="nav nav-pills flex-column for_tab_panel_fix">
                            <li class="nav-item" ng-repeat="category in userSelectedCategories">
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
                    <div class="clearfix"></div>
                    <!-- /.col-md-4 -->
                    <div class="col-md-9 p-3 tab-content">
                        <div ng-repeat="category in userSelectedCategories">
                            <div ng-if="category.category_type=='Normal'">
                                <div id="@{{category.slug}}" data-toggle="pill"  role="tabpanel" aria-labelledby="home-tab">
                                    <h2 class="pro-dec-title-bg" ng-class="{'mt-3': !$first}" ng-if="category.change_category_name">
                                        @{{ category.change_category_name }}
                                    </h2>
                                    <h2 class="pro-dec-title-bg" ng-class="{'mt-3': !$first}" ng-if="!category.change_category_name">
                                        @if( _getAppLang() == "en" )
                                            @{{ category.name }}
                                        @elseif( _getAppLang() == "es" )
                                            @{{ category.spanish }}
                                        @endif
                                    </h2>
                                    <!-- <h6 class="item-list mt-md-3 mb-md-0 text-black">Test appetizer 2</h6> -->
                                    <div class="row product_bottom_border py-md-3" ng-repeat="product in category.responseProducts">
                                        <div class="col-sm-2">
                                            <img src="@{{ product.productMainImageUrl }}" class="img-fluid  product-img" onerror="this.onerror=null;this.src='{{ _getHomeUrl('assets/default/100_no_img.jpg') }}';" ng-click="showRecordFun(product)">
                                        </div>
                                        <div class="col-sm-6">
                                            <h4 class="card-title" ng-click="showRecordFun(product)">@{{ product.product_name }}</h4>
                                            <p class="card-text">@{{ product.product_description }}</p>
                                            <div class="productAllergiesDiv">
                                                <img ng-repeat="allergy in product.responseAllergies" src="{{ _getHomeUrl('assets/allergy/') }}@{{allergy.image}}" class="for-svg_height mr-1" onerror="this.onerror=null;this.src='{{ _getHomeUrl('assets/default/100_no_img.jpg') }}';">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 d-flex align-items-md-end justify-content-md-end align-items-sm-center justify-content-sm-center align-items-xs-center justify-content-xs-center">
                                            <div class="text-center mx-1" ng-if="product.product_price > 0">
                                                <span class="badge bg-dark text-white">Fixed</span>
                                                <div class="clearfix"></div>
                                                <a href="#" class="btn btn-sm btn-primary" id="tooldemo" type="button" data-toggle="tooltip" data-placement="top" title="Tooltip on top"> {{ config('constants.currency') }}@{{product.product_price}}</a>
                                            </div>
                                            <div class="text-center mx-1" ng-if="product.product_1r > 0">
                                                <span class="badge bg-dark text-white">1R</span>
                                                <div class="clearfix"></div>
                                                <a href="#" class="btn btn-sm btn-primary" id="tooldemo" type="button" data-toggle="tooltip" data-placement="top" title="Tooltip on top">{{ config('constants.currency') }}@{{product.product_1r}}</a>
                                            </div>
                                            <div class="text-center mx-1" ng-if="product.product_12r > 0">
                                                <span class="badge bg-dark text-white">12R</span>
                                                <div class="clearfix"></div>
                                                <a href="#" class="btn btn-sm btn-primary" id="tooldemo" type="button" data-toggle="tooltip" data-placement="top" title="Tooltip on top">{{ config('constants.currency') }}@{{product.product_12r}}</a>
                                            </div>
                                            <div class="text-center mx-1" ng-if="product.product_topa > 0">
                                                <span class="badge bg-dark text-white">Tapa</span>
                                                <div class="clearfix"></div>
                                                <a href="#" class="btn btn-sm btn-primary" id="tooldemo" type="button" data-toggle="tooltip" data-placement="top" title="Tooltip on top">{{ config('constants.currency') }}@{{product.product_topa}}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div ng-if="category.category_type=='Fixed'">
                                <div id="@{{category.slug}}" data-toggle="pill"  role="tabpanel" aria-labelledby="profile-tab">
                                    <h2 class="pro-dec-title-bg text-white" ng-class="{'mt-3': !$first}" ng-if="category.change_category_name">
                                        @{{ category.change_category_name }}
                                        <label class="pull-right">{{ config('constants.currency') }}@{{category.price}}</label>
                                    </h2>
                                    <h2 class="pro-dec-title-bg text-white" ng-class="{'mt-3': !$first}" ng-if="!category.change_category_name">
                                        @if( _getAppLang() == "en" )
                                            @{{ category.name }}
                                        @elseif( _getAppLang() == "es" )
                                            @{{ category.spanish }}
                                        @endif
                                        <label class="pull-right">{{ config('constants.currency') }}@{{category.price}}</label>
                                    </h2>
                                    <div class="d-flex justify-content-center">
                                        <p class="item-list mt-md-3 mb-md-0 btn bg-dark">Starter</p>
                                    </div>
                                    <div class="row product_bottom_border py-md-3 text-center">
                                        <div class="col-sm-3" ng-repeat="product in category.responseProducts" ng-if="product.product_type=='starter'">
                                            <img ng-click="showRecordFun(product)" src="@{{ product.productMainImageUrl }}" class="img-fluid rounded" onerror="this.onerror=null;this.src='{{ _getHomeUrl('assets/default/100_no_img.jpg') }}';">
                                            <h6 class="mt-3 mb-1" ng-click="showRecordFun(product)">@{{ product.product_name }}</h6>
                                            <p class="mb-0 p-list-p-tag">@{{ product.product_description }}</p>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <p class="item-list mt-md-3 mb-md-0 btn bg-dark">Main Course</p>
                                    </div>
                                    <div class="row product_bottom_border py-md-3 text-center">
                                        <div class="col-sm-3" ng-repeat="product in category.responseProducts" ng-if="product.product_type=='course'">
                                            <img ng-click="showRecordFun(product)" src="@{{ product.productMainImageUrl }}" class="img-fluid rounded" onerror="this.onerror=null;this.src='{{ _getHomeUrl('assets/default/100_no_img.jpg') }}';">
                                            <h6 class="mt-3 mb-1" ng-click="showRecordFun(product)">@{{ product.product_name }}</h6>
                                            <p class="mb-0 p-list-p-tag">@{{ product.product_description }}</p>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <p class="item-list mt-md-3 mb-md-0 btn bg-dark">Desert</p>
                                    </div>
                                    <div class="row product_bottom_border py-md-3 text-center">
                                        <div class="col-sm-3" ng-repeat="product in category.responseProducts" ng-if="product.product_type=='desert'">
                                            <img ng-click="showRecordFun(product)" src="@{{ product.productMainImageUrl }}" class="img-fluid rounded" onerror="this.onerror=null;this.src='{{ _getHomeUrl('assets/default/100_no_img.jpg') }}';">
                                            <h6 class="mt-3 mb-1" ng-click="showRecordFun(product)">@{{ product.product_name }}</h6>
                                            <p class="mb-0 p-list-p-tag">@{{ product.product_description }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-md-8 -->
                </div>
            </div>
        </section>
        <!-- <===================================Modal-1===============================================> -->
        <div class="modal full fade" id="fullscreen_modal" tabindex="-1" role="dialog" aria-labelledby="fullscreen_modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body d-flex align-items-center justify-content-center flex-column modal_bg" style="background-image: url(images/bg-white.png); background-size: contain;">
                        <div class="container my-5">
                            <div class="text-center mb-4 text-uppercase">
                                <h1 class="text-capitalize font-weight-bold">Zampoita<span style="color: #fff"> Allergy Guide</span></h1>
                                <p class="text-white mb-0">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                    tempor incididunt ut labore et dolore magna aliqua.
                                </p>
                            </div>
                            <div class="row">
                                <div class="col-md-2 col-sm-2 col-xs-1 p-2 text-center">
                                    <div class="bg-light px-3 py-3">
                                        <img src="{{ url('assets/front-menu/images/9.svg') }}" class="for-svg-size">
                                        <div class="mt-3">
                                            <h5 class="mb-2" style="font-weight: 600;">pizza</h5>
                                            <p class="text-secondary d-none">Lorem ipsum</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-1 p-2 text-center">
                                    <div class="bg-light px-3 py-3">
                                        <img src="{{ url('assets/front-menu/images/10.svg') }}" class="for-svg-size">
                                        <div class="mt-3">
                                            <h5 class="mb-2" style="font-weight: 600;">tier cake</h5>
                                            <p class="text-secondary d-none">Lorem ipsum</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-1 p-2 text-center">
                                    <div class="bg-light px-3 py-3">
                                        <img src="{{ url('assets/front-menu/images/11.svg') }}" class="for-svg-size">
                                        <div class="mt-3">
                                            <h5 class="mb-2" style="font-weight: 600;">gluten</h5>
                                            <p class="text-secondary d-none">Lorem ipsum</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-1 p-2 text-center">
                                    <div class="bg-light px-3 py-3">
                                        <img src="{{ url('assets/front-menu/images/12.svg') }}" class="for-svg-size">
                                        <div class="mt-3">
                                            <h5 class="mb-2" style="font-weight: 600;">fruit</h5>
                                            <p class="text-secondary d-none">Lorem ipsum</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-1 p-2 text-center">
                                    <div class="bg-light px-3 py-3">
                                        <img src="{{ url('assets/front-menu/images/4.svg') }}" class="for-svg-size">
                                        <div class="mt-3">
                                            <h5 class="mb-2" style="font-weight: 600;">dinner</h5>
                                            <p class="text-secondary d-none">Lorem ipsum</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-1 p-2 text-center">
                                    <div class="bg-light px-3 py-3">
                                        <img src="{{ url('assets/front-menu/images/12.svg') }}" class="for-svg-size">
                                        <div class="mt-3">
                                            <h5 class="mb-2" style="font-weight: 600;">fruit</h5>
                                            <p class="text-secondary d-none">Lorem ipsum</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 col-sm-2 col-xs-1 p-2 text-center">
                                    <div class="bg-light px-3 py-3">
                                        <img src="{{ url('assets/front-menu/images/5.svg') }}" class="for-svg-size">
                                        <div class="mt-3">
                                            <h5 class="mb-2" style="font-weight: 600;">silverware</h5>
                                            <p class="text-secondary d-none">Lorem ipsum</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-1 p-2 text-center">
                                    <div class="bg-light px-3 py-3">
                                        <img src="{{ url('assets/front-menu/images/6.svg') }}" class="for-svg-size">
                                        <div class="mt-3">
                                            <h5 class="mb-2" style="font-weight: 600;">martini</h5>
                                            <p class="text-secondary d-none">Lorem ipsum</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-1 p-2 text-center">
                                    <div class="bg-light px-3 py-3">
                                        <img src="{{ url('assets/front-menu/images/7.svg') }}" class="for-svg-size">
                                        <div class="mt-3">
                                            <h5 class="mb-2" style="font-weight: 600;">seafood</h5>
                                            <p class="text-secondary d-none">Lorem ipsum</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-1 p-2 text-center">
                                    <div class="bg-light px-3 py-3">
                                        <img src="{{ url('assets/front-menu/images/8.svg') }}" class="for-svg-size">
                                        <div class="mt-3">
                                            <h5 class="mb-2" style="font-weight: 600;">donut</h5>
                                            <p class="text-secondary d-none">Lorem ipsum</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-1 p-2 text-center">
                                    <div class="bg-light px-3 py-3">
                                        <img src="{{ url('assets/front-menu/images/1.svg') }}" class="for-svg-size">
                                        <div class="mt-3">
                                            <h5 class="mb-2" style="font-weight: 600;">Grape</h5>
                                            <p class="text-secondary d-none">Lorem ipsum</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-1 p-2 text-center">
                                    <div class="bg-light px-3 py-3">
                                        <img src="{{ url('assets/front-menu/images/2.svg') }}" class="for-svg-size">
                                        <div class="mt-3">
                                            <h5 class="mb-2" style="font-weight: 600;">Ice Cream</h5>
                                            <p class="text-secondary d-none">Lorem ipsum</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 col-sm-2 col-xs-1 p-2 text-center">
                                    <div class="bg-light px-3 py-3">
                                        <img src="{{ url('assets/front-menu/images/3.svg') }}" class="for-svg-size">
                                        <div class="mt-3">
                                            <h5 class="mb-2" style="font-weight: 600;">beverage</h5>
                                            <p class="text-secondary d-none">Lorem ipsum</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-1 p-2 text-center">
                                    <div class="bg-light px-3 py-3">
                                        <img src="{{ url('assets/front-menu/images/4.svg') }}" class="for-svg-size">
                                        <div class="mt-3">
                                            <h5 class="mb-2" style="font-weight: 600;">dinner</h5>
                                            <p class="text-secondary d-none">Lorem ipsum</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-white mt-3 px-2">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </p>
                        </div>
                        <h2 class="close-modal display-2"><a class="text-white text-decoration-none" href="#0" data-dismiss="modal">&times;</a></h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- <===================================Modal-1===============================================> -->
        <!-- <===================================Modal-2===============================================> -->
        <div class="modal fade" id="regular_modal" tabindex="-1" role="dialog" aria-labelledby="regular_modal">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content" style="background-color: #fff0!important; border: none;">
                    <div class="modal-header d-none">
                        <h5 class="modal-title">Regular Modal Title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="font-size: 40px;">&times;</span>
                    </button>
                    <div class="modal-body p-0">
                        <div class="container-fluid">
                            <div class="cart">
                                <div class="row">
                                    <div class="col-md-4 p-0">
                                        <div class="img-box">
                                            <img src="@{{formCrudRequestData.productMainImageUrl}}" width="100%" class="img-fluid" id="ProductImg">              
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h1 class="product-title">@{{formCrudRequestData.productName}}</h1>
                                        <div class="productAllergiesDiv">
                                            <img ng-repeat="allergy in formCrudRequestData.responseAllergies" src="{{ _getHomeUrl('assets/allergy/') }}@{{allergy.image}}" class="for-svg_height mr-1" onerror="this.onerror=null;this.src='{{ _getHomeUrl('assets/default/100_no_img.jpg') }}';">
                                        </div>
                                        <div id="product" class="product-inf">
                                            <div class="tabs-content">
                                                <div id="Description">
                                                    <p>@{{formCrudRequestData.productDescription}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="buttons">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <a href="#" class="custom-btn">{{ config('constants.currency') }}@{{ formCrudRequestData.productPrice }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <===================================Modal-2===============================================> -->
        <!-- <===================================Mobile_menu===============================================> -->
        <div class="container">
            <div class="menu click_menu">
                <nav class="menu__nav ">
                    <ul class="menu__list r-list ">
                        <div class="text-center">
                            <a class="navbar-brand" href="#" target="_blank"><img src="{{ url('assets/front-menu/images/white-logo.png') }}" alt=""></a> 
                        </div>
                        <li class="menu__group" ng-repeat="category in userSelectedCategories">
                            <a ng-if="category.change_category_name" href="#@{{category.slug}}" class="menu__link r-link">@{{ category.change_category_name }}</a>
                            <a ng-if="!category.change_category_name" href="#@{{category.slug}}" class="menu__link r-link">
                                @if( _getAppLang() == "en" )
                                    @{{ category.name }}
                                @elseif( _getAppLang() == "es" )
                                    @{{ category.spanish }}
                                @endif
                            </a>
                        </li>
                    </ul>
                </nav>
                <button class="menu__toggle r-button" type="button">
                <span class="menu__hamburger m-hamburger">
                <span class="m-hamburger__label">
                <span class="menu__screen-reader screen-reader">Open menu</span>
                </span>
                </span>
                </button>
            </div>
        </div>
        <!-- <===================================Mobile_menu===============================================> -->
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