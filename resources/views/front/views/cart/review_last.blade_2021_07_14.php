
<div class="left2" ng-if="cartData && !isLoaderCart" ng-cloak>
    <div class="row  mt-25">
        <div class="proof">
            <p>Relax, this proofing tool is a visual aid for ordering and representation only.</p>
            <p>We will email you a 'production design proof' to make sure you're happy before manufacture.</p>
            <p>Please also check any spam / trash folders.</p>
            <p>Thank you for your order.</p>
            <div id="urgent-graphic"></div>
        </div>
    </div>
</div>
<div class="right2" ng-show="cartData && !isLoaderCart" ng-cloak>
    <div class="img-100">
        {{--<div class="delivery_section" style="" ng-if="cartData.totalProductCount > 0">
            <p>Delivery Required?</p>
            <div class="inp">
                <div class="item">
                    <label>Yes</label>
                    <input type="radio" name="is_delivery" value="yes" checked=""><span class="checkmark"></span>
                </div>
                <label data-delivery_price="0.00" class="display_delivery_price">{{config('constants.currency')}}@{{cartData.shipping_charge}} +VAT {{config('constants.currency')}}@{{cartData.shipping_charge_vat}} : &nbsp;&nbsp; <b>{{config('constants.currency')}}@{{cartData.total_shipping_charge}}</b></label>
            </div>
        </div>--}}
        {{--<div class="delivery_section" style="" ng-if="cartData.totalProductCount > 0">
            <p>Advance Urgent Order?</p> <switch name="yesNo" ng-model="yesNo" on="Yes" off="No" class="wide"></switch>
        </div>--}}
        {{-- <div class="delivery_section advanced" style="" ng-if="cartData.totalProductCount > 0">
             <p>Advance Urgent Order?</p>
             <div class="inp" style="border: inherit;">
                 <div class="item">
                     <switch name="isUrgentOrder" ng-model="checkoutRequestData.isUrgentOrder" on="Yes" off="No" class="wide "  ng-change="selectAdvanceOrderFun()"></switch>
                 </div>
                 <label  class="display_delivery_price" ng-if="checkoutRequestData.isUrgentOrder">{{config('constants.currency')}}@{{cartData.is_urgent_order_amount}} +VAT {{config('constants.currency')}}@{{cartData.is_urgent_order_vat}} : &nbsp;&nbsp; <b>{{config('constants.currency')}}@{{cartData.is_urgent_order_total_amount}}</b></label>
             </div>
         </div>--}}
        <div class="voucher_code_section" style="">
            {{--<p>Do You have a Promocode or Voucher Code?</p>
            <div class="inp">
                <form  method="post" id="frm_voucher_code" name="frm_voucher_code" class="example"
                       novalidate="novalidate" ng-submit="applyDiscountCodeFun(promoCodeData)">
                    <input type="text" name="voucher_code" placeholder="Enter Code Here" ng-model="promoCodeData.discountCode">
                    <button type="submit" value="Apply" name="btn_submit_voucher"><i class="fa fa-search"></i>Apply +
                    </button>
                </form>

            </div>
            <br>
            <p class="voucher_amount_section" ng-if="cartData.discount_code_id == 0 && cartData.discount_code !=''  && cartData.discount_code !=null">Voucher:
                <span class="voucher_product_price">{{config('constants.currency')}}@{{cartData.discountAmountTotal}}</span>
                <span class="voucher_product_price_remaining">({{config('constants.currency')}}@{{cartData.voucherRemainingAmount}} Remaining)</span>
                <span class="remove remove_voucher_code" style="cursor: pointer;" ng-click="resetDiscountCodeFun()">Remove</span>
            </p>
            <p class="voucher_applied_text" ng-if="cartData.discount_code_id == 0 && cartData.discount_code !=''  && cartData.discount_code !=null">Thank you for activating your gift voucher. If applicable we will store the remaining balance of your voucher on record for you to use in the future, simply apply the same code.</p>


            <p class="coupon_amount_section" ng-if="cartData.discount_code_id">Coupon: {{config('constants.currency')}}<span class="coupon_price">@{{cartData.discountAmountTotal}}</span>
                <span class="coupon_price_remaining"></span>
                <span class="remove remove_coupon_code" style="cursor: pointer;"  ng-click="resetDiscountCodeFun()">Remove</span>
            </p>--}}

            <div id="email" class="cls_receipt_email" >
                <p class="bold">Please provide delivery details below &amp; then CHECKOUT.</p>
                <p>Please enter your name</p>
                <input type="text" name="shippingName" ng-model="checkoutRequestData.shippingName"  ng-blur="saveShippingDetailsFun()"
                       autocomplete="no-fill"> {{-- ng-model-options="{ debounce: 1000 }" ng-blur="saveShippingDetailsFun()" --}}
                <span class="help-block" ng-if="checkoutRequestDataError.shippingName">
                    @{{ checkoutRequestDataError.shippingName}}
                </span>
                <br><br><br>
                <p>Your email address</p>
                <input type="text" name="shippingEmail" ng-model="checkoutRequestData.shippingEmail" ng-blur="saveShippingDetailsFun()" autocomplete="no-fill">
                <span class="help-block" ng-if="checkoutRequestDataError.shippingEmail">
                    @{{ checkoutRequestDataError.shippingEmail}}
                </span>
                <br><br><br>
                <p>Your phone</p>
                <input type="text" name="shippingPhone" ng-model="checkoutRequestData.shippingPhone" ng-blur="saveShippingDetailsFun()"
                       autocomplete="no-fill">
                <span class="help-block" ng-if="checkoutRequestDataError.shippingPhone">
                    @{{ checkoutRequestDataError.shippingPhone}}
                </span>
                <br><br><br>
                <p>Your delivery address</p>
                <textarea name="shippingAddress" cols="5" rows="3" ng-model="checkoutRequestData.shippingAddress"  ng-blur="saveShippingDetailsFun()"
                          style="resize: none"  autocomplete="no-fill"></textarea>
                <span class="help-block" ng-if="checkoutRequestDataError.shippingAddress">
                    @{{ checkoutRequestDataError.shippingAddress}}
                </span>
                <br><br><br>
                <p>Your delivery Postcode</p>
                <input type="text" name="shippingPostCode"  ng-model="checkoutRequestData.shippingPostCode"
                       ng-model-options="{ debounce: 1500 }" ng-change="saveShippingDetailsFun()" autocomplete="no-fill">
                <span class="help-block" ng-if="checkoutRequestDataError.shippingPostCode">
                    @{{ checkoutRequestDataError.shippingPostCode}}
                </span>
            </div>

        </div>
        <div class="delivery_section" style="" ng-if="cartData.totalProductCount > 0 && cartData.isShippingAllow">
            <p>Delivery Required?</p>
            <div class="inp">
                <div class="item">
                    <label>Yes</label>
                    <input type="radio" name="is_delivery" value="yes" checked=""><span class="checkmark"></span>
                </div>
                <label data-delivery_price="0.00" class="display_delivery_price">{{config('constants.currency')}}@{{cartData.shipping_charge}} +VAT {{config('constants.currency')}}@{{cartData.shipping_charge_vat}} : &nbsp;&nbsp; <b>{{config('constants.currency')}}@{{cartData.total_shipping_charge}}</b></label>
            </div>
        </div>
        <div class="delivery_section advanced" style="" ng-if="cartData.totalProductCount > 0  && cartData.isShippingAllow">
            <p>Advance Urgent Order?</p>
            <p>{{config('constants.currency')}}{{_number_format(config('constants.shippingChargeForUrgent'))}}+VAT : Skip the queue and get your order faster.</p>
            <div class="inp" style="border: inherit;">
                <div class="item">
                    <switch name="isUrgentOrder" ng-model="checkoutRequestData.isUrgentOrder" on="Yes" off="No" class="wide "  ng-change="selectAdvanceOrderFun()"></switch>
                </div>
                <label  class="display_delivery_price" ng-if="checkoutRequestData.isUrgentOrder">{{config('constants.currency')}}@{{cartData.is_urgent_order_amount}} +VAT {{config('constants.currency')}}@{{cartData.is_urgent_order_vat}} : &nbsp;&nbsp; <b>{{config('constants.currency')}}@{{cartData.is_urgent_order_total_amount}}</b></label>
            </div>
        </div>

        <div class="voucher_code_section" style="">
            <p>Do You have a Promocode or Voucher Code?</p>
            <div class="inp">
                <form  method="post" id="frm_voucher_code" name="frm_voucher_code" class="example"
                       novalidate="novalidate" ng-submit="applyDiscountCodeFun(promoCodeData)">
                    <input type="text" name="voucher_code" placeholder="Enter Code Here" ng-model="promoCodeData.discountCode">
                    <button type="submit" value="Apply" name="btn_submit_voucher"><i class="fa fa-search"></i>Apply +
                    </button>
                </form>

            </div>
            <br>
            <p class="voucher_amount_section" ng-if="cartData.discount_code_id == 0 && cartData.discount_code !=''  && cartData.discount_code !=null">Voucher:
                <span class="voucher_product_price">{{config('constants.currency')}}@{{cartData.discountAmountTotal}}</span>
                <span class="voucher_product_price_remaining">({{config('constants.currency')}}@{{cartData.voucherRemainingAmount}} Remaining)</span>
                <span class="remove remove_voucher_code" style="cursor: pointer;" ng-click="resetDiscountCodeFun()">Remove</span>
            </p>
            <p class="voucher_applied_text" ng-if="cartData.discount_code_id == 0 && cartData.discount_code !=''  && cartData.discount_code !=null">Thank you for activating your gift voucher. If applicable we will store the remaining balance of your voucher on record for you to use in the future, simply apply the same code.</p>


            <p class="coupon_amount_section" ng-if="cartData.discount_code_id > 0 && cartData.discount_code !=''  && cartData.discount_code !=null">Coupon: {{config('constants.currency')}}<span class="coupon_price">@{{cartData.discountAmountTotal}}</span>
                <span class="coupon_price_remaining"></span>
                <span class="remove remove_coupon_code" style="cursor: pointer;"  ng-click="resetDiscountCodeFun()">Remove</span>
            </p>

        </div>
        <div class="payment_method_section" style="" ng-if="cartData.total_payable>0">
            <p>Payment Method </p>
            <div class="inp">
                <div class="item">
                    <label>Paypal</label>
                    <input type="radio" name="rd_payment_method" value="Paypal" checked="checked"  ng-checked="paymentMethodType =='Paypal'"  ng-model="paymentMethodType" ng-change="changePaymentMethodTypeFun('Paypal')"><span
                            class="checkmark"></span>
                </div>
                <div class="item">
                    <label>Debit/Credit Card or Apple Pay</label>
                    <!--<label>Debit/Credit Card</label>-->
                    <input type="radio" name="rd_payment_method" value="Stripe" ng-model="paymentMethodType" ng-checked="paymentMethodType =='Stripe'"  ng-change="changePaymentMethodTypeFun('Stripe')"><span class="checkmark"></span>
                </div>
            </div>
            <br>
            <p class="voucher_amount_section" ng-if="paymentMethodType =='Paypal'">
                Please click on 'Return to merchant' on paypal after payment success if not automatically return back to site from paypal.
            </p>
        </div>
        {{-- ng-show="paymentMethodType =='Stripe'"--}}
        <div class="cell example example5 payment_method_section cls_stripe_card_section" id="example-5"  style="width: 100%;" ng-show="paymentMethodType =='Stripe' || paymentMethodType =='Stripe-Apple-Pay'">
            <form id="frm_stripe_form">
                <div id="example5-paymentRequest">
                    <!--Stripe paymentRequestButton Element inserted here-->
                </div>
                <fieldset>
                    <legend class="card-only" data-tid="elements_examples.form.pay_with_card">Pay with card </legend>
                    <legend class="payment-request-available" data-tid="elements_examples.form.enter_card_manually">Or
                        enter card details
                    </legend>
                    {{--<div class="row">
                        <div class="field">
                            <label for="example5-name" data-tid="elements_examples.form.name_label">Name</label>
                            <input id="example5-name" data-tid="elements_examples.form.name_placeholder" class="input"
                                   type="text" placeholder="" required="" autocomplete="name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="field">
                            <label for="example5-email" data-tid="elements_examples.form.email_label">Email</label>
                            <input id="example5-email" data-tid="elements_examples.form.email_placeholder" class="input"
                                   type="text" placeholder="" required="" autocomplete="email">
                        </div>
                        <div class="field">
                            <label for="example5-phone" data-tid="elements_examples.form.phone_label">Phone</label>
                            <input id="example5-phone" data-tid="elements_examples.form.phone_placeholder" class="input"
                                   type="text" placeholder="" required="" autocomplete="tel">
                        </div>
                    </div>
                    <div data-locale-reversible="">
                        <div class="row">
                            <div class="field">
                                <label for="example5-address"
                                       data-tid="elements_examples.form.address_label">Address</label>
                                <input id="example5-address" data-tid="elements_examples.form.address_placeholder"
                                       class="input" type="text" placeholder="" required=""
                                       autocomplete="address-line1">
                            </div>
                        </div>
                    </div>--}}
                    <div class="row">
                        <div class="field">
                            <label for="example5-card" data-tid="elements_examples.form.card_label">Card</label>
                            <div id="example5-card" class="input"></div>
                        </div>
                    </div>
                    <!--<button type="submit" data-tid="elements_examples.form.pay_button">Pay $25</button>-->
                </fieldset>
                <div class="error" role="alert">
                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17">
                  <path class="base" fill="#000" d="M8.5,17 C3.80557963,17 0,13.1944204 0,8.5 C0,3.80557963 3.80557963,0 8.5,0 C13.1944204,0 17,3.80557963 17,8.5 C17,13.1944204 13.1944204,17 8.5,17 Z"></path>
                  <path class="glyph" fill="#FFF" d="M8.5,7.29791847 L6.12604076,4.92395924 C5.79409512,4.59201359 5.25590488,4.59201359 4.92395924,4.92395924 C4.59201359,5.25590488 4.59201359,5.79409512 4.92395924,6.12604076 L7.29791847,8.5 L4.92395924,10.8739592 C4.59201359,11.2059049 4.59201359,11.7440951 4.92395924,12.0760408 C5.25590488,12.4079864 5.79409512,12.4079864 6.12604076,12.0760408 L8.5,9.70208153 L10.8739592,12.0760408 C11.2059049,12.4079864 11.7440951,12.4079864 12.0760408,12.0760408 C12.4079864,11.7440951 12.4079864,11.2059049 12.0760408,10.8739592 L9.70208153,8.5 L12.0760408,6.12604076 C12.4079864,5.79409512 12.4079864,5.25590488 12.0760408,4.92395924 C11.7440951,4.59201359 11.2059049,4.59201359 10.8739592,4.92395924 L8.5,7.29791847 L8.5,7.29791847 Z"></path>
                </svg> -->
                    {{--<span class="message text-red" id="stripeError">@{{stripeErrorMsg}}</span>--}}
                </div>
            </form>
        </div>
        <span class="invalid-feedback" style="display: block;" ng-show="stripeTextMsg">
                                                        <strong>@{{ stripeTextMsg }}</strong>
        </span>
        <div>
            <div class="stripe-source-errors" role="alert"></div>
            {{--<div id="paymentResponse" class="element-hide message text-red" ng-show="true" ng-bind-html="stripeErrorMsg"></div>--}}
            {{--<div id="paymentResponse" class="element-hide message1 text-red" ng-show="true" >@{{stripeErrorMsg}}</div>--}}
            <div class="message text-red" ng-bind-html="stripeErrorMsg"></div>
        </div>
        <span class="help-block " ng-if="checkoutRequestDataError.paymentMethodType">
                    @{{ checkoutRequestDataError.paymentMethodType}}
        </span>

    </div>
</div>