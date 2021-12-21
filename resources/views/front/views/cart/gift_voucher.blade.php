@extends('front.layouts.layout')
@section('title')
    Cart | Slate Sign
@endsection
@section('meta')

@endsection
@section('styles')
@endsection
@section('content')
    <div id="main" class="cart" ng-controller="gitVoucherController" ng-init="init('')" ng-cloak >
        <div id="container">
            <div class="clearfix header_common gift">
                <div class="col-sm-9">
                    <h5>Make someones day with a lasting gift from housesigns.wales...</h5>
                    <ul>
                        <li>Looking for a high quality and original gift idea? Send an online voucher from Housesigns.Wales today!</li>
                        <li>It’s so simple, choose a value, pick a send-date and type a greeting message to accompany the e-voucher.</li>
                        <li>Recipients receive a voucher via email which is redeemable at checkout when shopping on this website.</li>
                        <li>The perfect gift for Christmas, Birthdays, New Home or Special Days</li>
                    </ul>
                </div>
            </div>
            <div id="content">
                <div id="post-6" class="post-6 page type-page status-publish hentry">
                    <div class="entry-content">
                        <!-- <div class="mid">
                            <div class="item proof">
                              <a href="https://www.housesigns.wales/order/"><span class="link"></span></a>
                            </div>
                            <div class="item gallery">
                              <a href="https://www.housesigns.wales/classic-edge-gallery/"><span class="link"></span></a>
                            </div>
                            <div class="item fixings">
                              <a href="https://www.housesigns.wales/secret-fixings-gallery/"><span class="link"></span></a>
                            </div>
                            </div> -->
                        <div class="main voucher">
                            <div class="left" style="padding: 0px!important;">
                                <form name="frm_order_gift_voucher" id="frm_order_gift_voucher" method="post" ng-submit="submitVoucherFun()">
                                    <div class="form">
                                        <div class="container">
                                            <div class="row">
                                                <div class="title">
                                                    <label class="main-heading">Order A Voucher ></label>
                                                </div>
                                                <div class="item half">
                                                    <label for="recipient_first_name">Recipients first name</label>
                                                    <input type="text" name="recipientFirstName" ng-model="requestFormData.recipientFirstName">
                                                    <span class="help-block" ng-if="requestFormDataError.recipientFirstName">
                                                            @{{ requestFormDataError.recipientFirstName}}
                                                    </span>
                                                </div>
                                                <div class="item half lastname">
                                                    <label for="recipient_last_name">Recipients second name</label>
                                                    <input type="text" name="recipientLastName" ng-model="requestFormData.recipientLastName">
                                                    <span class="help-block" ng-if="requestFormDataError.recipientLastName">
                                                                    @{{ requestFormDataError.recipientLastName}}
                                                    </span>
                                                </div>
                                                <div class="item">
                                                    <label for="recipient_email_address">Recipients Email Address</label>
                                                    <input type="text" name="recipientEmail" ng-model="requestFormData.recipientEmail">
                                                    <span class="help-block" ng-if="requestFormDataError.recipientEmail">
                                                                    @{{ requestFormDataError.recipientEmail}}
                                                    </span>
                                                </div>
                                                <div class="item">
                                                    <label for="voucher_from">Who is the Voucher From?</label>
                                                    <input type="text" name="voucherFrom" ng-model="requestFormData.voucherFrom">
                                                    <span class="help-block" ng-if="requestFormDataError.voucherFrom">
                                                                    @{{ requestFormDataError.voucherFrom}}
                                                    </span>
                                                </div>
                                                <div class="item message">
                                                    <label for="personal_message">Add A Personal Message</label>
                                                    <textarea name="personalMessage" ng-model="requestFormData.personalMessage"></textarea>
                                                    <span class="help-block" ng-if="requestFormDataError.personalMessage">
                                                                    @{{ requestFormDataError.personalMessage}}
                                                    </span>
                                                </div>

                                                <!-- <div class="item when_to_email_voucher_error help-block"></div> -->

                                                <div class="item title">
                                                    <label>Select When To Send Voucher</label>
                                                    <span class="help-block" ng-if="requestFormDataError.whenToEmailVoucher" style="top:15px;">
                                                                    @{{ requestFormDataError.whenToEmailVoucher}}
                                                </span>
                                                </div>
                                                <div class="item half tick">
                                                    <label for="whenToEmailVoucher">Email gift voucher today</label>
                                                    <input type="radio" name="whenToEmailVoucher" id="today" value="today" checked="checked" ng-model="requestFormData.whenToEmailVoucher" ng-change="changeSendVoucherFun()">
                                                    <span class="checkmark"></span>
                                                </div>
                                                <div class="item half tick last">
                                                    <label  for="whenToEmailVoucher" style="">Email gift voucher on</label>
                                                    <input type="radio" name="whenToEmailVoucher" id="date" value="on_specific_date" ng-model="requestFormData.whenToEmailVoucher" ng-change="changeSendVoucherFun()">
                                                    <span class="checkmark"></span>
                                                </div>

                                                <div class="item date-content " ng-class="{'disabled_div': requestFormData.whenToEmailVoucher=='today'}">
                                                    <div class="col-3">
                                                        <label for="date">Day</label>
                                                        <input type="text" name="day" placeholder="DD" ng-model="requestFormData.day"     maxlength="2" number>
                                                    </div>
                                                    <div class="col-3 col-3-month">
                                                        <label for="month">Month</label>
                                                        <input type="text" name="month" placeholder="MM" ng-model="requestFormData.month"  maxlength="2" number>
                                                    </div>
                                                    <div class="col-3">
                                                        <label for="year">Year</label>
                                                        <input type="text" name="year" placeholder="YYYY" ng-model="requestFormData.year"   maxlength="4" number>
                                                    </div>
                                                    <span class="help-block" ng-if="requestFormDataError.emailOnSpecific" ng-class="{'disabled_div1': requestFormData.whenToEmailVoucher=='today'}" >
                                                                    @{{ requestFormDataError.emailOnSpecific}}
                                                </span>
                                                </div>


                                                <!-- <div class="item voucher_value_error help-block"></div> -->

                                                <div class="item title none">
                                                    <label for="fname">Select A Voucher Value</label>
                                                    <span class="help-block" ng-if="requestFormDataError.voucherValue">
                                                                    @{{ requestFormDataError.voucherValue}}
                                                </span>
                                                </div>
                                                <?php
                                                $list = getVoucherType();
                                                foreach (getVoucherType() as $key=>$row){ ?>
                                                <div class="item col-3 for-box-set <?php if($key==80) {  echo 'last' ;}?>">
                                                    <label for="voucher_value">{{config('constants.currency')}}<?=$row['displayPrice']?> </label>
                                                    <input type="radio" name="voucherValue" value="<?=$row['displayPrice']?>" ng-model="requestFormData.voucherValue">
                                                    <span class="checkmark"></span>
                                                </div>
                                                <?php  }
                                                ?>


                                                {{--<div class="item col-3 for-box-set">
                                                    <label for="voucher_value">£30</label>
                                                    <input type="radio" name="voucher_value" value="30" ng-model="requestFormData.voucherValue">
                                                    <span class="checkmark"></span>
                                                </div>
                                                <div class="item col-3  for-box-set">
                                                    <label for="voucher_value">£50</label>
                                                    <input type="radio" name="voucher_value" value="50" ng-model="requestFormData.voucherValue">
                                                    <span class="checkmark"></span>
                                                </div>
                                                <div class="item col-3 for-box-set last">
                                                    <label for="voucher_value">£80</label>
                                                    <input type="radio" name="voucher_value" value="80" ng-model="requestFormData.voucherValue">
                                                    <span class="checkmark"></span>
                                                </div>--}}

                                            </div>
                                        </div>
                                    </div>
                                    <div class="for_buttons">
                                        <div class="buttons">
                                            <button type="button" class="btn-1 cls_frm_order_gift_voucher_submit" name="add_to_basket_and_order_another_voucher">Add & Order Another <span class="chev">></span></button>
                                            <button type="submit" class="btn-2 cls_frm_order_gift_voucher_submit" name="add_to_basket_and_checkout">Proceed to checkout <span class="chev">></span></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="right">
                                <div class="img-1"></div>
                                <div class="img-2"></div>
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
@endsection


@section('page_script')
    <script>
        @if(Session::has('message'))
        alert({{ Session::get('message') }});
        toastr.error('{{ Session::get('message') }}', 'Error');
        @endif
        /* ANGULAR ORDER */
        var urlCartAddVoucher = "{{ route('add-cart-voucher') }}";
        var urlReview = "{{ route('review') }}";
    </script>

@endsection
@section('script')
    {{--@include("front.views.stripe_example5_script")--}}
    {{-- @include("front.views.stripe_script") --}}
    <script type='text/javascript' src='{{ asset("front/js/custom/giftVoucher.js".'?t='.time()) }}'></script>
@endsection