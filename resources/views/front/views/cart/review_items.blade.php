<span ng-if="isLoaderCart" class="isLoaderCart" ng-bind-html="loaderView"></span>
<div class="left1" ng-if="!cartData && !isLoaderCart" ng-cloak>
    <div class="row  text-center" style="text-align: center;">
        <div class="column">
            <h3 class="last-paragraf1 " style=""><b> {{ __('order.cart_cart_empty')}} </b></h3>
        </div>
    </div>
</div>
<div class="left2" ng-if="cartData && !isLoaderCart" ng-cloak>
    <div class="cart_item_list">

        <div class="row mt-10" ng-class="{'voucher': row.is_product==2}"  ng-if="cartData.allItems"  ng-repeat="row in cartData.allItems track by $index" >
            {{-- For Product--}}
            <div class="left" ng-if="row.is_product==1">
                <h3>Item @{{ $index+1 }}: You selected </h3>
                <p>Size : @{{ row.size_name | setDash}}</p>
                <p>Edge : @{{ row.edge_name | setDash}}</p>
                <p>Line 1 : @{{ row.line1 | setDash}}</p>
                <p>Line 2 : @{{ row.line2 | setDash}}</p>
                <p>Line 3 : @{{ row.line3 | setDash}}</p>
                <p>Font : @{{ row.font_name | setDash}}</p>
                <p>Colour : @{{ row.color_name | setDash}} ({{config('constants.currency')}}@{{ row.color_per_digit}} Per Digit) </p>
                <p>Fixing Type : @{{ row.fixing_name }}</p>
            </div>
            <div class="right" ng-if="row.is_product==1">
                <h3>Quantity</h3>
                <div class="buttons">
                    <button data-product_type="slate" aria-controls="q_number_t" class="decrease_t minus"
                            aria-label="decrease quantity" ng-click="cartAddUpdateItemFun(row,'M',$index)"></button>
                    <input type="text" ng-value="row.quantity" data-cart_index="1" class="form-2_input q_number_t"
                           data-increase="increase_t" data-decrease="decrease_t" aria-live="assertive"
                           aria-relevant="additions" aria-atomic="true" aria-label="quantity" pattern="\d{2}" min=0
                           max="99" maxlength="2" placeholder="" onblur="if(this.value == ''){ this.value = '' }"
                           ng-keyup="cartAddUpdateItemManualFun(row,$event,$index,row.quantity)"
                           ng-model-options="{ debounce: 1000 }"> {{-- ng-blur="cartAddUpdateItemManualFun(row,$event,$index)"--}} {{-- oninput="validity.valid || (value='');"--}}
                    <button aria-controls="q_number_t" class="increase_t add" aria-label="increase quantity" ng-click="cartAddUpdateItemFun(row,'A',$index)"></button>
                </div>
                <p class="title">Price</p>
                <p>Sign : <span class="result">{{config('constants.currency')}}@{{ row.size_price }}</span></p>
                <p>24ct Gold : <span class="result">{{config('constants.currency')}}@{{ row.color_price }}</span></p>
                <p>Fixings : <span class="result">{{config('constants.currency')}}@{{ row.fixing_price }}</span></p>
                <p>VAT : <span class="result">{{config('constants.currency')}}@{{ row.total_vat }}</span></p>
                <p class="totals">Total : <span class="result">{{config('constants.currency')}}@{{ row.total_item_price }}</span></p>
            </div>

            {{-- For Vocuher --}}
            <div class="left" ng-if="row.is_product==2">
                <h3>Item @{{ $index+1 }}: You selected </h3>
                <p>Gift Voucher</p>
                <p>Value : {{config('constants.currency')}}@{{ row.total_item_price}}</p>
                <p>To : @{{ row.recipient_first_name}} @{{ row.recipient_last_name}}</p>
                <p>Email : @{{ row.recipient_email_address | setDash}}</p>
                <p>From : @{{ row.voucher_from | setDash}}</p>
                <p>Send Date : @{{ row.when_to_email_voucher | setDash}}</p>
                <p>Greeting Message : @{{ row.personal_message | setDash}}</p>
            </div>
            <div class="right" ng-if="row.is_product==2">
                <h3>Quantity</h3>
                <div class="buttons">
                    <button data-product_type="slate" aria-controls="q_number_t" class="decrease_t minus"
                            aria-label="decrease quantity" ng-click="cartAddUpdateItemFun(row,'M',$index)"></button>
                    <input disabled type="number" ng-value="row.quantity" data-cart_index="1" class="form-2_input q_number_t"
                           data-increase="increase_t" data-decrease="decrease_t" aria-live="assertive"
                           aria-relevant="additions" aria-atomic="true" aria-label="quantity" pattern="\d{2}"  min=0 max="99" maxlength="2" placeholder=""  >  {{-- ng-blur="cartAddUpdateItemManualFun(row,$event,$index)"--}}
                    <button disabled aria-controls="q_number_t" class="increase_t add" aria-label="increase quantity" ></button>
                </div>
                <p class="title">Price</p>
                <p>Voucher : <span class="result">{{config('constants.currency')}}@{{ row.total_price }}</span></p>
                <p>VAT : <span class="result">{{config('constants.currency')}}@{{ row.total_vat }}</span></p>
                <p class="totals">Total : <span class="result">{{config('constants.currency')}}@{{ row.total_item_price }}</span></p></div>

            {{-- For signatureCollection --}}
            <div class="left" ng-if="row.is_product==3">
                <h3>Item @{{ $index+1 }}: You selected </h3>
                <p>Signature Collection</p>
                <p>@{{ row.preview_data3.name | setDash}}</p>
                <p>{{config('constants.currency')}}@{{ row.total_item_price}}</p>
                <p>Size : @{{ row.preview_data3.size | setDash}}</p>
                <p>Finish : @{{ row.preview_data3.finish | setDash}}</p>
                <p>Colour : @{{ row.preview_data3.colour | setDash}}</p>
               <!--  <p ng-bind-html="row.preview_data3.description" setDash></p> -->
            </div>
            <div class="right" ng-if="row.is_product==3">
                <h3>Quantity</h3>
                <div class="buttons">
                    <button data-product_type="slate" aria-controls="q_number_t" class="decrease_t minus"
                            aria-label="decrease quantity" ng-click="cartAddUpdateItemFun(row,'M',$index)"></button>
                    <input disabled type="number" ng-value="row.quantity" data-cart_index="1" class="form-2_input q_number_t"
                           data-increase="increase_t" data-decrease="decrease_t" aria-live="assertive"
                           aria-relevant="additions" aria-atomic="true" aria-label="quantity" pattern="\d{2}"  min=0 max="99" maxlength="2" placeholder=""  >  {{-- ng-blur="cartAddUpdateItemManualFun(row,$event,$index)"--}}
                    <button disabled aria-controls="q_number_t" class="increase_t add" aria-label="increase quantity" ></button>
                </div>
                <p class="title">Price</p>
                <p>Voucher : <span class="result">{{config('constants.currency')}}@{{ row.total_price }}</span></p>
                <p>VAT : <span class="result">{{config('constants.currency')}}@{{ row.total_vat }}</span></p>
                <p class="totals">Total : <span class="result">{{config('constants.currency')}}@{{ row.total_item_price }}</span></p></div>
        </div>

        {{--<div class="row mt-10" ng-if="cartData.products"  ng-repeat="row in cartData.products track by $index" >
            <div class="left"><h3>Item @{{ $index+1 }}: You selected </h3>
                <p>Size : @{{ row.size_name | setDash}}</p>
                <p>Edge : @{{ row.edge_name | setDash}}</p>
                <p>Line 1 : @{{ row.line1 | setDash}}</p>
                <p>Line 2 : @{{ row.line2 | setDash}}</p>
                <p>Line 3 : @{{ row.line3 | setDash}}</p>
                <p>Font : @{{ row.font_name | setDash}}</p>
                <p>Colour : @{{ row.color_name | setDash}} ({{config('constants.currency')}}@{{ row.color_per_digit}} Per Digit) </p>
                <p>Fixing Type : Double Ground Stake Fixings</p></div>
            <div class="right"><h3>Quantity</h3>
                <div class="buttons">
                    <button data-product_type="slate" aria-controls="q_number_t" class="decrease_t minus"
                            aria-label="decrease quantity" ng-click="cartAddUpdateItemFun(row,'M',$index)"></button>
                    <input type="number" ng-value="row.quantity" data-cart_index="1" class="form-2_input q_number_t"
                           data-increase="increase_t" data-decrease="decrease_t" aria-live="assertive"
                           aria-relevant="additions" aria-atomic="true" aria-label="quantity" pattern="\d{2}"  min=0 max="99" maxlength="2" placeholder="" oninput="validity.valid || (value='');" onblur="if(this.value == ''){ this.value = '' }" ng-keyup="cartAddUpdateItemManualFun(row,$event,$index)" > --}}{{-- ng-blur="cartAddUpdateItemManualFun(row,$event,$index)"--}}{{--
                    <button aria-controls="q_number_t" class="increase_t add" aria-label="increase quantity" ng-click="cartAddUpdateItemFun(row,'A',$index)"></button>
                </div>
                <p class="title">Price</p>
                <p>Sign : <span class="result">{{config('constants.currency')}}@{{ row.size_price }}</span></p>
                <p>24ct Gold : <span class="result">{{config('constants.currency')}}@{{ row.color_price }}</span></p>
                <p>Fixings : <span class="result">{{config('constants.currency')}}@{{ row.fixing_price }}</span></p>
                <p>VAT : <span class="result">{{config('constants.currency')}}@{{ row.total_vat }}</span></p>
                <p class="totals">Total : <span class="result">{{config('constants.currency')}}@{{ row.total_item_price }}</span></p></div>
        </div>--}}

        {{--<div class="row mt-10 voucher" ng-if="cartData.vouchers"  ng-repeat="row in cartData.vouchers track by $index" >
            <div class="left"><h3>Item @{{ $index+1 }}: You selected </h3>
                <p>Gift Voucher</p>
                <p>Value : {{config('constants.currency')}}@{{ row.total_item_price}}</p>
                <p>To : @{{ row.recipient_first_name}} @{{ row.recipient_last_name}}</p>
                <p>Email : @{{ row.recipient_email_address | setDash}}</p>
                <p>From : @{{ row.voucher_from | setDash}}</p>
                <p>Send Date : @{{ row.when_to_email_voucher | setDash}}</p>
                <p>Greeting Message : @{{ row.personal_message | setDash}}</p></div>
            <div class="right"><h3>Quantity</h3>
                <div class="buttons">
                    <button data-product_type="slate" aria-controls="q_number_t" class="decrease_t minus"
                            aria-label="decrease quantity" ng-click="cartAddUpdateItemFun(row,'M',$index)"></button>
                    <input type="number" ng-value="row.quantity" data-cart_index="1" class="form-2_input q_number_t"
                           data-increase="increase_t" data-decrease="decrease_t" aria-live="assertive"
                           aria-relevant="additions" aria-atomic="true" aria-label="quantity" pattern="\d{2}"  min=0 max="99" maxlength="2" placeholder="" oninput="validity.valid || (value='');" onblur="if(this.value == ''){ this.value = '' }" ng-keyup="cartAddUpdateItemManualFun(row,$event,$index)" > --}}{{-- ng-blur="cartAddUpdateItemManualFun(row,$event,$index)"--}}{{--
                    <button aria-controls="q_number_t" class="increase_t add" aria-label="increase quantity" ng-click="cartAddUpdateItemFun(row,'A',$index)"></button>
                </div>
                <p class="title">Price</p>
                <p>Voucher : <span class="result">{{config('constants.currency')}}@{{ row.total_price }}</span></p>
                <p>VAT : <span class="result">{{config('constants.currency')}}@{{ row.total_vat }}</span></p>
                <p class="totals">Total : <span class="result">{{config('constants.currency')}}@{{ row.total_item_price }}</span></p></div>
        </div>--}}
    </div>
    {{--<div class="row  mt-25">
        <div class="proof">
            <p>Relax, this proofing tool is a visual aid for ordering and representation only.</p>
            <p>We will email you a 'production design proof' to make sure you're happy before manufacture.</p>
            <p>Please also check any spam / trash folders.</p>
            <p>Thank you for your order.</p>
        </div>
    </div>--}}
</div>
<div class="right2" ng-if="cartData && !isLoaderCart" ng-cloak>
    <div class="cart_item_image_section" ng-if="cartData.allItems" >
        <div class="img-1"  ng-repeat="row in cartData.allItems track by $index" ng-style="{'background': 'url(' + row.displayImageUrl + ')  0px 0px / 100% no-repeat transparent' }"></div>
        {{--<div class="img-1"  ng-repeat="row in cartData.allItems track by $index" style="background: url('@{{ row.displayImageUrl}}') 0px 0px / 100% no-repeat transparent;"></div>--}}
    </div>
</div>