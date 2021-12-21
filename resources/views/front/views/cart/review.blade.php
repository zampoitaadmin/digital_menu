@extends('front.layouts.layout')
@section('title')
	Cart | Slate Sign
@endsection
@section('meta')

@endsection
@section('styles')
	<link rel="stylesheet" href="{{ asset('front/css/stripe-styles.css') }}">
@endsection
@section('content')
	<script src="https://js.stripe.com/v3/"></script>
{{--<script src="{{ URL::to('/') }}/ex_plugins/jquery-validation-1.19.1/dist/jquery.validate.js"></script>
<link rel="stylesheet" type="text/css" href="{{ URL::to('/') }}/ex_plugins/toastr/css/toastr.min.css">--}}
<link href="{{ asset('front/styles/ss_style.css') }}" rel="stylesheet">
{{--<script src="{{ URL::to('/') }}/ex_plugins/toastr/js/toastr.min.js"></script>--}}
<link rel="stylesheet" type="text/css" href="{{ URL::to('/') }}/stripe-css/base.css">
<link rel="stylesheet" type="text/css" href="{{ URL::to('/') }}/stripe-css/example5.css">
<style type="text/css">

</style>
{{--@include("front.views.stripe_index_script")--}}
{{-- @include("front.views.stripe_index_applepay_script") --}}
	<div id="main" class="cart" ng-controller="checkoutController" ng-init="init('')" ng-cloak>
		<div id="container">
			<div ng-class="{'overlayShow': btnDisabled}" class='overlay ' >
				<div class="overlay__inner">
					<div class="overlay__content">
						<div class="Box">Processing...<span></span></div>
					</div>
				</div>
			</div>
			<div id="channel"><span class="grey">Living in the channel isles?</span> We now ship to the channel isles, vat will be removed at checkout.</div>
			<h1 class="entry-title"   ng-cloak><span class="grey">Your Basket :</span> Confirm your order...</h1>
			<div id="content">
				<div id="post-6" class="post-6 page type-page status-publish hentry">
					<div class="entry-content">
						<div class="main2 @{{clickBusy}}">
							{{-- #TODO Shipping price --}}
							{{-- #TODO Voucher Listing Cart--}}
							@include('front.views.cart.review_items', array('step' => 'Review Item'))
							@include('front.views.cart.review_last', array('step' => 'Review Item'))
							<div id="buttons" ng-if="!isLoaderCart" ng-cloak>
								<div class="continue-button" >
									<a href="{{ route('order') }}"><span class="link"></span></a>
									<span class="chev"><</span>Continue Shopping
								</div>
								<div class="total_checkout_section" ng-if="cartData" >
									<div id="vat-breakdown">
										<p>Price : {{config('constants.currency')}}<span class="cls_total_slat_wo_vat">@{{ cartData.payable_amount }}</span> | VAT : {{config('constants.currency')}}<span class="cls_total_slate_vat">@{{ cartData.payable_vat }}</span></p>
									</div>
									<div class="total">Total : <span class="results">{{config('constants.currency')}}<span class="cls_total_lbl">@{{ cartData.total_payable }}</span></span></div>
									<input type="hidden" name="hdn_form_stripe_details">
									<input type="hidden" name="hdn_form_apple_pay_stripe_details">
									<div id="frm_paypal" style="float: right;margin-left: 5px;">
                                    {{--@if(WEBSITE_MODE==SITE_MODE)
									        <button id="id_btn_checkout" class="back-to-store2 checkout" type="button" ng-click="doCheckout()" @{{clickBusy}} ng-disabled="btnDisabled">@{{ btnSubmitText }}<span class="chev">></span></button>
                                    @else--}}
                                            <button id="id_btn_checkout" class="back-to-store2 checkout" type="button" ng-click="doCheckout()" @{{clickBusy}} ng-disabled="btnDisabled">@{{ btnSubmitText }}<span class="chev">></span></button>
                                    {{--@endif--}}

									{{--<button id="id_btn_checkout_stripe" class="back-to-store2 checkout" type="button" style="display: none;">Checkout<span class="chev">></span></button>--}}
										{{--<button id="id_btn_checkout" onclick="gtag('event', 'conversion', {'send_to': 'AW-975230974/hhaECK7vg-wBEP6vg9ED', 'value': 50.0,'currency': 'GBP','transaction_id': ''});" class="back-to-store2 checkout" type="submit">Checkout<span class="chev">></span></button>
										<button id="id_btn_checkout_stripe" onclick="gtag('event', 'conversion', {'send_to': 'AW-975230974/hhaECK7vg-wBEP6vg9ED', 'value': 50.0,'currency': 'GBP','transaction_id': ''});" class="back-to-store2 checkout" type="button" style="display: none;">Checkout<span class="chev">></span></button>--}}
									</div>
								</div>
							</div>
							<div class="products_preview">
							</div>

						</div>
					</div>
					<!-- .entry-content -->
				</div>
				<!-- #post-6 -->
			</div>
			<!-- #content -->
		</div>
	</div>

	<link href="{{ asset('front/css/style_vc.css') }}" rel="stylesheet">
	<style type="text/css">
		img.wp-smiley,
		img.emoji {
			display: inline !important;
			border: none !important;
			box-shadow: none !important;
			height: 1em !important;
			width: 1em !important;
			margin: 0 .07em !important;
			vertical-align: -0.1em !important;
			background: none !important;
			padding: 0 !important;
		}
		form.example input[type=text] {
			padding: 10px;
			font-size: 17px;
			border:none;
			float: left;
			width: 80%;
			color: #d1d1d1!important;
			background: none;
			box-sizing: border-box;
		}
		form.example button {
			float: left;
			width: 20%;
			height: 32px!important;
			padding: 0px;
			background: #2196F3;
			border-radius: 0px!important;
			color: #8cc63f!important;
			color: white;
			font-size: 17px;
			border: none;
			border-left: none;
			cursor: pointer;
		}
		form.example button:hover {
			background: #0b7dda;
			border:none!important;
			color: #000!important;
		}
		form.example::after {
			content: "";
			clear: both;
			display: table;
		}
	</style>

@endsection


@section('page_script')
	<script>
		@if(Session::has('message'))
		//alert({{ Session::get('message') }});
		toastr.error('{{ Session::get('message') }}', 'Error');
		@endif
		/* ANGULAR ORDER */
		var isCheckoutPage = true;
		var stripePublishableKey = "{{$stripePublishableKey}}";
		var urlCart = "{{ route('cart') }}";
		var urlUpdateItemQty = "{{ route('update-item-qty') }}";
		var urlDoCheckout = "{{ route('do-checkout') }}";
		var urlConfirmPayment = "{{ route('confirm-payment') }}";
		var urlUrgentOrderShipping = "{{ route('urgent-order-shipping') }}";
		var urlApplyDiscountCode = "{{ route('apply-discount-code') }}";
		var urlResetDiscountCode = "{{ route('reset-discount-code') }}";
		var urlSaveShippingDetails= "{{ route('save-shipping-details') }}";
		var urlConfirmPaymentAP= "{{ route('confirm-payment') }}";

		var varPackage = '';
		var pType = '';
		@if(isAdminLogged())
			pType = 'Manual';
		@else
			pType = 'Paypal';
		@endif
	</script>

@endsection
@section('script')
	{{--@include("front.views.stripe_example5_script")--}}
	{{-- @include("front.views.stripe_script") --}}
	<script type='text/javascript' src='{{ asset("front/js/custom/checkout.js".'?t='.time()) }}'></script>
@endsection