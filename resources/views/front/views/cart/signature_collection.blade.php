@extends('front.layouts.layout')

@section('title')
    Signature Collection | Slate Sign
@endsection

@section('meta')
<meta name="description"  content="Do you have a question or just want to tell us how much you love your new Slate Sign? Whatever the reason, we love hearing from you. So call us now or fill in" />
@endsection

@section('styles')
@endsection

@section('content')
    {{--<script src="{{ URL::to('/') }}/ex_plugins/jquery-validation-1.19.1/dist/jquery.validate.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ URL::to('/') }}/ex_plugins/toastr/css/toastr.min.css">
    <script src="{{ URL::to('/') }}/ex_plugins/toastr/js/toastr.min.js"></script>--}}
    @if (session('success'))
        <script type="text/javascript">
            toastr.success("{{ session('success') }}", "Success");
        </script>
    @endif
    @if (session('error'))
        <script type="text/javascript">
            toastr.error("{{ session('error') }}", "Error");
        </script>
    @endif
    <div id="main" class="contact signature" ng-controller="signatureCollectionCtrl" ng-init="init('SC')" >
        <div id="container">
            <div class="clearfix header_common gift">
                <div class="col-sm-9">
                    <span class="icon"></span>
                    <h1>Signature Collection</h1>
                    <p>Looking for something special? Welcome to the HouseSigns.Wales signature collection.<br>
                    Beautiful Welsh-Slate house signs, crafted with unique motif’s and your house number.<br>
                    Browse our bespoke designs below, select your sign and add your house number. Simple…</p>
                </div>
            </div>
            <div id="content" class="signature_collection">
                <div id="post-15" class="post-15 page type-page status-publish hentry">
                    <div class="entry-content">
                        {{--<span ng-if="isProductLoader" class="loaderProduct" ng-bind-html="loaderProduct"></span>--}}
                        <div class="item" ng-if="signatureCollectionList.length>0  && !isProductLoader" ng-show="signatureCollectionList" ng-repeat="row in signatureCollectionList track by $index" ng-cloak>
                            <a ng-href="{{ route('signature-details') }}/@{{row.product_slug}}" alt="@{{ row.name }}"><span class="link"></span></a>
                            <div class="image">
                                <span class="label"></span>
                                <img src="@{{ row.product_details_image }}" title="@{{ row.name }}" />
                            </div>
                            <div class="info">
                                <h3>@{{ row.name }}</h3>
                                <span class="price">{{config('constants.currency')}}@{{ row.price }}</span>
                                <span class="view">View ></span>
                            </div>
                        </div>
                        <div class="empty-product" ng-if="signatureCollectionList.length==0 && !isProductLoader" >
                            <p> {{ __('order.order_product_sc_not_available')}} </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_script')
    <script>
        @if(Session::has('message'))
        alert({{ Session::get('message') }});
        toastr.error('{{ Session::get('message') }}', 'Error');
        @endif
        /* ANGULAR ORDER */
        var urlGetProductSignatureCollectionList = "{{ route('products-signature-collection') }}";
        var isCheckoutPage = false;
        var varPackage = '';
    </script>

@endsection
@section('script')
    <script type='text/javascript' src='{{ asset("front/js/custom/signatureCollection.js".'?t='.time()) }}'></script>
@endsection
