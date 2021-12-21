@extends('front.layouts.layout')
@section('title')
Map Site
@endsection

@section('meta')
    <meta name="title" content="LV MAP">
    <meta name="description" content="LV MAP DESCRIPTION">
@endsection
@section('styles')
@endsection

@section('content')
    <!-- ====== Banner Start ====== -->
    <section class="ud-page-banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ud-banner-content">
                        <h1>Map</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ====== Banner End ====== -->

    <!-- ====== Pricing Start ====== -->
    <section id="pricing" class="ud-pricing" ng-controller="mapController" ng-init="init('')" ng-cloak >
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ud-section-title mx-auto text-center">
                        <span>Pricing</span>
                        <h2>Our Pricing Plans</h2>
                        <p>
                            There are many variations of passages of Lorem Ipsum available
                            but the majority have suffered alteration in some form.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row g-0 align-items-center justify-content-center">
                <div class="col-lg-4 col-md-6 col-sm-10">
                    <div
                            class="ud-single-pricing first-item wow fadeInUp"
                            data-wow-delay=".15s"
                            >
                        <div class="ud-pricing-header">
                            <h3>STARTING FROM</h3>
                            <h4>$ 19.99/mo</h4>
                        </div>
                        <div class="ud-pricing-body">
                            <ul>
                                <li>5 User</li>
                                <li>All UI components</li>
                                <li>Lifetime access</li>
                                <li>Free updates</li>
                                <li>Use on 1 (one) project</li>
                                <li>4 Months support</li>
                            </ul>
                        </div>
                        <div class="ud-pricing-footer">
                            <a href="javascript:void(0)" class="ud-main-btn ud-border-btn">
                                Purchase Now
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-10">
                    <div
                            class="ud-single-pricing active wow fadeInUp"
                            data-wow-delay=".1s"
                            >
                        <span class="ud-popular-tag">POPULAR</span>
                        <div class="ud-pricing-header">
                            <h3>STARTING FROM</h3>
                            <h4>$ 30.99/mo</h4>
                        </div>
                        <div class="ud-pricing-body">
                            <ul>
                                <li>5 User</li>
                                <li>All UI components</li>
                                <li>Lifetime access</li>
                                <li>Free updates</li>
                                <li>Use on 1 (one) project</li>
                                <li>4 Months support</li>
                            </ul>
                        </div>
                        <div class="ud-pricing-footer">
                            <a href="javascript:void(0)" class="ud-main-btn ud-white-btn">
                                Purchase Now
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-10">
                    <div
                            class="ud-single-pricing last-item wow fadeInUp"
                            data-wow-delay=".15s"
                            >
                        <div class="ud-pricing-header">
                            <h3>STARTING FROM</h3>
                            <h4>$ 70.99/mo</h4>
                        </div>
                        <div class="ud-pricing-body">
                            <ul>
                                <li>5 User</li>
                                <li>All UI components</li>
                                <li>Lifetime access</li>
                                <li>Free updates</li>
                                <li>Use on 1 (one) project</li>
                                <li>4 Months support</li>
                            </ul>
                        </div>
                        <div class="ud-pricing-footer">
                            <a href="javascript:void(0)" class="ud-main-btn ud-border-btn">
                                Purchase Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ====== Pricing End ====== -->
@endsection

@section('page_script')
    <script>
        @if(Session::has('message'))
        alert({{ Session::get('message') }});
        toastr.error('{{ Session::get('message') }}', 'Error');
        @endif

        var urlReview = "{{ route('review') }}";
    </script>

@endsection
@section('script')
    <script type='text/javascript' src='{{ asset("assets/ng/map.js".'?t='.time()) }}'></script>
@endsection
