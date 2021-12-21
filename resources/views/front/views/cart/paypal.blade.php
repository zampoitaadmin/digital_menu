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
									<?php $itemCtr = 0; $osvalue = 0; ?>
									@if($cartArray)
										@if(isset($cartArray->products) && !empty($cartArray->products))
											@foreach($cartArray->products as $key=>$row)
													<?php $itemCtr++; ?>
												@php
													#$productName = @$row->size_name.' ||'.$row->wall_name;
													$productName = @$row->size_name.' ||'.$row->edge_name.' ||'.($row->line1 ? $row->line1 : '-' ).'||'.($row->line2 ? $row->line2 : '-' ).'||'.($row->line3 ? $row->line3 : '-' ).' ||'.$row->font_name.' ||'.$row->color_name.' ||'.$row->fixing_type;
												@endphp
												{{--<br>{{$productName}}<br>--}}
												<input type="hidden" name="item_name_{{$itemCtr}}" value="{{$productName}}">
												<input type="hidden" name="amount_{{$itemCtr}}" value="{{$row->unit_price}}">
												@if(!$cartArray->isIslands)
    											<input type="hidden" name="tax_{{$itemCtr}}" value="{{$row->unit_vat}}">
                                                @endif
												
												<input type="hidden" name="quantity_{{$itemCtr}}" value="{{$row->quantity}}">
												<input type="hidden" name="item_number_{{$itemCtr}}" value="{{$itemCtr}}">
												
												

											@endforeach
										@endif
										@if(isset($cartArray->signatureCollection) && !empty($cartArray->signatureCollection))
											@foreach($cartArray->signatureCollection as $key=>$row)
													<?php $itemCtr++; ?>
												@php
												#_pre($row);
												       $previewData = (json_decode(@$row->preview_data)); #_pre($previewData);
													#$productName = @$previewData->size.' ||'.$previewData->finish.' ||'.$previewData->colour.'||'.(($row->line1!="") ? $row->line1 : '-' );
													$productName = @$previewData->product_slug.' ||'.$previewData->finish.' ||'.$previewData->colour.'||'.(($row->line1!="") ? $row->line1 : '-' );
												@endphp
												{{--<br>{{$productName}}<br>--}}
												<input type="hidden" name="item_name_{{$itemCtr}}" value="{{$productName}}">
												<input type="hidden" name="amount_{{$itemCtr}}" value="{{$row->unit_price}}">
												@if(!$cartArray->isIslands)
    											<input type="hidden" name="tax_{{$itemCtr}}" value="{{$row->unit_vat}}">
                                                @endif
												
												<input type="hidden" name="quantity_{{$itemCtr}}" value="{{$row->quantity}}">
												<input type="hidden" name="item_number_{{$itemCtr}}" value="{{$itemCtr}}">
												
												

											@endforeach
										@endif
										@if($cartArray->totalProductCount)
										<?php $itemCtr++; ?>
											<br>
											<input type="hidden" name="item_name_{{$itemCtr}}" value="Shipping Charge">
											<input type="hidden" name="amount_{{$itemCtr}}" value="{{$cartArray->shipping_charge}}">
											<input type="hidden" name="tax_{{$itemCtr}}" value="{{$cartArray->shipping_charge_vat}}">
                                            
											{{--<input type="text" name="shipping_1" value="{{$cartArray->total_shipping_charge}}">
											<input type="text" name="shipping2_1" value="{{$cartArray->shipping_charge_vat}}">--}}
										@endif

										@if(isset($cartArray->vouchers) && !empty($cartArray->vouchers))
											@foreach($cartArray->vouchers as $key=>$row)
													<?php $itemCtr++; ?>
												@php
													$productName = @$row->product_name;
												@endphp
												{{--<br>{{$productName}}<br>--}}
												<input type="hidden" name="item_name_{{$itemCtr}}" value="{{$productName}}">
												<input type="hidden" name="amount_{{$itemCtr}}" value="{{$row->total_price}}">
												{{--<input type="text" name="item_number_{{$itemCtr}}" value="{{$row->quantity}}">--}}
												<input type="hidden" name="tax_{{$itemCtr}}" value="{{$row->total_vat}}">

											@endforeach
										@endif
										<?php $itemCtr++; ?>
										{{-- #TODO Delivery Charges and Advance Order delivery --}}
										<br>
										@if($cartArray->total_discount>0)
											{{--<input type="text" name="discount_amount_1" value="Discount Amount: ">--}}
											<input type="hidden" name="discount_amount_1" value="{{$cartArray->discount_amount}}">
											<input type="hidden" name="discount_amount_2" value="{{$cartArray->discount_vat}}">
										@endif

										<br>
										@if($cartArray->is_urgent_order>0)
												<input type="hidden" name="item_name_{{$itemCtr}}" value="Advance Urgent Order">
												<input type="hidden" name="amount_{{$itemCtr}}" value="{{$cartArray->is_urgent_order_amount}}">
												<input type="hidden" name="tax_{{$itemCtr}}" value="{{$cartArray->is_urgent_order_vat}}">
										@endif
									@endif
									</span>
								<input type="hidden" name="currency_code" value="{{config('constants.PAYPAL_CURRENCY')}}">
								<!-- Specify URLs -->
								<input type="hidden" name="return" value="{{$constantsPaypal['PAYPAL_RETURN_URL']}}">
								<input type="hidden" name="cancel_return" value="{{$constantsPaypal['PAYPAL_CANCEL_URL']}}">
								<input type="hidden" name="notify_url" value="{{$constantsPaypal['PAYPAL_NOTIFY_URL']}}">
								<input type="hidden" name="rm" value="2">
								{{--<input type="hidden" name="custom" value='<?= json_encode($requestDataPaypal)?>'>--}}
								<input type="hidden" name="custom" value='{{$orderConfirmationId}}'>
								{{--<input type="text" name="address1" value='testAddress'>
								<input type="text" name="zip" value='zi121'>
								<input type="text" name="email" value='vix@test.com'>--}}

                                {{--<input type="hidden" name="first_name" value="Vix">
                                <input type="hidden" name="last_name" value="Smart">
                                <input type="hidden" name="address1" value="345 Lark Ave">
                                <input type="hidden" name="city" value="San Jose">
                                <input type="hidden" name="state" value="CA">
                                <input type="hidden" name="zip" value="95121">
                                <input type="hidden" name="country" value="US">--}}
								<!-- Display the payment button. -->
								{{-- #TODO Paypal GA --}}
								{{--<button id="id_btn_checkout" onclick="gtag('event', 'conversion', {'send_to': 'AW-975230974/hhaECK7vg-wBEP6vg9ED', 'value': 49.14,'currency': 'GBP','transaction_id': ''});" class="back-to-store2 checkout" type="submit">Checkout<span class="chev">&gt;</span></button>--}}
								<button id="id_btn_checkout"  class="back-to-store2 checkout" type="submit" style="display: none">Checkout<span class="chev">&gt;</span></button>
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

<script>
	window.onload = function(){
		document.forms['frm_paypal'].submit();
	}
</script>
