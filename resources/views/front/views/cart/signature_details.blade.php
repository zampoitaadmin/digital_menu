@extends('front.layouts.layout')

@section('title')
    Signature Details | Slate Sign
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
    <div id="main" class="contact signature_single" ng-controller="signatureCollectionCtrl" ng-init="init('SCD')" >
        <div id="container">
            <div id="content">
                <div id="post-15" class="post-15 page type-page status-publish hentry">
                    <div class="entry-content" ng-if="signatureCollectionDetails  && !isProductLoader" >
                        <div class="left">
                            <a href="../signature-collection" style="text-transform: uppercase;padding: 2.5em 0 0em;float: left;width: 100%;">&lt; Back to signature menu</a>
                            <h2>Signature Collection </h2>
                            <h1>@{{ signatureCollectionDetails.name }}</h1>
                            <span class="price">{{config('constants.currency')}}@{{ signatureCollectionDetails.price }}</span>
                            <div class="info">
                                <!-- <span class="item" ng-bind-html="signatureCollectionDetails.description"></span> -->
                                <span class="item">Size: @{{ signatureCollectionDetails.size | setDash}}</span>
                                <span class="item">Finish: @{{ signatureCollectionDetails.finish | setDash }}</span>
                                <span class="item">Colour: @{{ signatureCollectionDetails.colour | setDash}}</span>
                            </div>
                            <div class="description">
                                <p ng-bind-html="signatureCollectionDetails.description"></p>
                            </div>
                            <div class="customise">
                                <p>Add Your House Number* &amp; Checkout below...</p>
                                <input type="text" id="t_line_custom" placeholder=""  ng-model="requestFormData.yourHouseNumber"  maxlength="10"  ng-keypress="getkeys($event);" autocomplete="off" stopccp>
                                <span class="index">*Numbers Only</span>
                                <span class="index help-block" ng-if="requestFormDataError.yourHouseNumber" >@{{ requestFormDataError.yourHouseNumber}}</span>
                                <span class="index help-block" ng-if="requestFormDataError.signatureCollection" >@{{ requestFormDataError.signatureCollection}}</span>
                            </div>

                            <div class="button checkout" ng-click="addToCartSignatureCollectionFun()"  ng-disabled="btnDisabled">
                                Add &amp; checkout <span class="chev">></span>
                            </div>
                        </div>
                        <div class="right">
                            <span class="label"></span>
                            <img src="@{{ signatureCollectionDetails.product_image }}" title="@{{ signatureCollectionDetails.name }}" />
                        </div>
                    </div>
                    <div class="entry-content" ng-if="!signatureCollectionDetails && !isProductLoader" >
                        <p> {{ __('order.order_product_sc_not_available')}} </p>
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
        var urlGetProductSignatureCollectionDetails = "{{ route('products-signature-details') }}/{{$slug}}";
        var urlCartAddSignatureCollection = "{{ route('add-cart-signature-collection') }}";
        var urlReview = "{{ route('review') }}";

        var isCheckoutPage = false;
        var varSlug = '{{$slug}}';
        var varPackage = '';
    </script>

@endsection
@section('script')
    <script type='text/javascript' src='{{ asset("front/js/custom/signatureCollection.js".'?t='.time()) }}'></script>
@endsection
