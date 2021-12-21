{{--@extends('front.layouts.layout')
@section('title')
	Paypal Parocessing | Slate Sign
@endsection
@section('meta')

@endsection
@section('styles')
@endsection
@section('content')--}}
<div id="main" class="cart" >
	<div id="container">
		{{--<h1 class="entry-title"   ><span class="grey">Your Basket :</span> Confirm your order...</h1>--}}
		<div id="content">
			<div id="post-6" class="post-6 page type-page status-publish hentry">
				<div class="entry-content">
					<div class="main2 ">
						<div class="left1" >
							<div class="row  text-center" style="text-align: center;">
								<div class="column">
									<h3 class="last-paragraf1 " style=""><b> <?= __('order.order_transaction_processing_msg')?> </b></h3>
								</div>
							</div>
						</div>
						<div class="products_preview">
							<form action="{{$constantsPaypalUrl}}" id="frm_paypal" method="post" >
								<!-- Identify your business so that you can collect the payments. -->
								<input type="hidden" name="hdn_payment_method" value="PayPal">
								<input type="hidden" name="business" value="{{$constantsPaypal['PAYPAL_ID']}}">

								<!-- Specify a Buy Now button. -->
								<input type="hidden" name="upload" value="1">
								<input type="hidden" name="cmd" value="_cart">
								<input type="hidden" name="amount_all" value="{{$cartArray->total_payable}}">
								<!-- Specify details about the item that buyers will purchase. -->
								<span class="paypal_items">
										@php $itemCtr = 1; $osvalue = 0;@endphp
									@if($cartArray)
										@if(isset($cartArray->products) && !empty($cartArray->products))
											@foreach($cartArray->products as $key=>$row)
												@php
													#$productName = @$row->size_name.'||'.$row->edge_name;
													#$osvalue
													$productName = @$row->size_name.'||'.$row->wall_name.'||'.$row->edge_name.'||'.($row->line1 ? $row->line1 : '-' ).'||'.($row->line2 ? $row->line2 : '-' ).'||'.($row->line3 ? $row->line3 : '-' ).'||'.$row->font_name.'||'.$row->color_name.'||'.$row->fixing_type;
												@endphp
												<br>{{$productName}}<br>
												<input type="text" name="item_name_{{$itemCtr}}" value="{{$productName}}">
												<input type="text" name="amount_{{$itemCtr}}" value="{{$row->total_price}}">
												<input type="text" name="item_number_{{$itemCtr}}" value="{{$row->quantity}}">
												<input type="text" name="tax_{{$itemCtr}}" value="{{$row->total_vat}}">
												{{--<input type="text" name="option_select0" value="Wall">
												<input type="text" name="option_select0" value="{{$row->wall_name}}">--}}
												{{--<input type="text" name="on1" value="Line1||Line2||Line3">
												<input type="text" name="os1" value="{{($row->line1 ? $row->line1 : '-' ).'||'.($row->line2 ? $row->line2 : '-' ).'||'.($row->line3 ? $row->line3 : '-' )}}">
												<input type="text" name="on2" value="Font Name">
												<input type="text" name="os2" value="{{$row->font_name}}">
												<input type="text" name="on3" value="Color Name">
												<input type="text" name="os3" value="{{$row->color_name}}">
												<input type="text" name="on4" value="Fixing Type">
												<input type="text" name="os4" value="{{$row->fixing_type}}">--}}
												{{$itemCtr = $itemCtr+1 }}
											@endforeach

											{{-- Delivery Charges and Advance Order delivery --}}
											<br>
											@if($cartArray->totalProductCount)
												<input type="text" name="item_name_{{$itemCtr}}" value="Shipping Charge">
												<input type="text" name="amount_{{$itemCtr}}" value="{{$cartArray->shipping_charge}}">
												{{--<input type="text" name="item_number_{{$itemCtr}}" value="1">--}}
												<input type="text" name="tax_{{$itemCtr}}" value="{{$cartArray->shipping_charge_vat}}">
											@endif
											@if($cartArray->total_discount>0)
												{{--<input type="text" name="discount_amount_1" value="Discount Amount: ">--}}
												<input type="text" name="discount_amount_1" value="{{$cartArray->discount_amount}}">
												{{--<input type="text" name="item_number_{{$itemCtr}}" value="1">--}}
												<input type="text" name="discount_amount_2" value="{{$cartArray->discount_vat}}">
											@endif
										@endif
									@endif

									{{--<input type="hidden" name="item_name_1" value="Style 1 5X5 / 130X130mm || BORDERED || 55 || - || - || Celtic || White || Secret Fixing">
                                    <input type="hidden" name="amount_1" value="17.00">
                                    <input type="hidden" name="item_number_1" value="1">
                                    <input type="hidden" name="quantity_1" value="1">
                                    <input type="hidden" name="tax_1" value="3.40">
                                    <input type="hidden" name="item_name_2" value="Style 1 5X5 / 130X130mm || BORDERED || 99 || - || - || Albertus || White || Secret Fixing">
                                    <input type="hidden" name="amount_2" value="17.00">
                                    <input type="hidden" name="item_number_2" value="2">
                                    <input type="hidden" name="quantity_2" value="1">
                                    <input type="hidden" name="tax_2" value="3.40">
                                    <input type="hidden" name="item_name_3" value="Shipping Charge">
                                    <input type="hidden" name="amount_3" value="6.95">
                                    <input type="hidden" name="tax_3" value="1.39">
                                    <input type="hidden" name="item_name_4" value="Gift Voucher">
                                    <input type="hidden" name="amount_4" value="25.00">
                                    <input type="hidden" name="tax_4" value="5.00">
                                    <input type="hidden" name="discount_amount_1" value="30.00">--}}
									</span>
								<input type="hidden" name="currency_code" value="{{config('constants.PAYPAL_CURRENCY')}}">
								<!-- Specify URLs -->
								<input type="hidden" name="return" value="{{$constantsPaypal['PAYPAL_RETURN_URL']}}https://www.housesigns.wales/checkout/order-success">
								<input type="hidden" name="cancel_return" value="{{$constantsPaypal['PAYPAL_CANCEL_URL']}}https://www.housesigns.wales/review">
								<input type="hidden" name="notify_url" value="{{$constantsPaypal['PAYPAL_NOTIFY_URL']}}https://www.housesigns.wales/checkout/paypal-notify">
								<input type="hidden" name="rm" value="2">
								<input type="hidden" name="custom">

								<!-- Display the payment button. -->
								{{-- #TODO Paypal GA --}}
								<button id="id_btn_checkout" onclick="gtag('event', 'conversion', {'send_to': 'AW-975230974/hhaECK7vg-wBEP6vg9ED', 'value': 49.14,'currency': 'GBP','transaction_id': ''});" class="back-to-store2 checkout" type="submit">Checkout<span class="chev">&gt;</span></button>

							</form>
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
{{--
@endsection


@section('page_script')
	<script>
		@if(Session::has('message'))
		alert({{ Session::get('message') }});
		toastr.error('{{ Session::get('message') }}', 'Error');
		@endif
		/* ANGULAR ORDER */
		var isCheckoutPage = true;
		var varPackage = '';
	</script>

@endsection
@section('script')
	--}}
{{--@include("front.views.stripe_example5_script")--}}{{--

	--}}
{{-- @include("front.views.stripe_script") --}}{{--

	<script type='text/javascript' src='{{ asset("front/js/custom/checkout.js".'?t='.time()) }}'></script>
@endsection--}}
<script>
	window.onload = function(){
		//document.forms['frm_paypal'].submit();
	}
</script>
