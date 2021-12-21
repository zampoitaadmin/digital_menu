@extends('front.layouts.layout')

@section('title')
	Order | Slate Sign
@endsection

@section('meta')

@endsection

@section('styles')
@endsection

@section('content')
	<div id="main"  ng-controller="cartCtrl" ng-init="init('')" ng-cloak>
		<div id="container" class="order">
			<div id="content">
				<div id="post-9" class="post-9 page type-page status-publish hentry">
					<div class="entry-content">
						<div class="tab-content">
							{{--
							Step#1 : Size  step_size
							Step#2 : Style step_style_wall
							Step#2 : Style Edge  step_style_edge
							Step#3 : Design and Content step_design
							Step#4 : COlour step_color
							Step#4 : Confirm step_confirm

							--}}
							{{--<input type="text" id="t_line1" placeholder="Type Your Information Here..."  ng-model="requestFormData.cartPreview.line1" ng-keydown="setTextFun(1,$event)" ng-maxlength="requestFormData.cartPreview.maxLength.line1"  maxlength="@{{ requestFormData.cartPreview.maxLength.line1 }}" ng-change ="setFontPositionFun()" ng-keypress="getkeys($event)">--}}
							@include('front.views.cart.step_size', array('step' => 'size 1'))
							@include('front.views.cart.step_style_wall', array('step' => 'style-wall 2'))
							@include('front.views.cart.step_style_edge', array('step' => 'style-edge 2'))
							@include('front.views.cart.step_design', array('step' => 'design 3'))
							@include('front.views.cart.step_color', array('step' => 'color 4'))
							@include('front.views.cart.step_confirm', array('step' => 'Confirm 5'))

						</div>

						@include('front.views.cart._preview', array('step' => 'Confirm 5'))
						{{--<div class="col-sm-7 col-xs-12 rgt_step no_pad clearfix" id="c_preview">
			                <span class="rgt_step_content">
			                    <div class="line1" id="line1"></div>
			                    <div class="line2" id="line2"></div>
			                    <div class="line3" id="line3"></div>
			                    <img id="slate_preview" src="{{ asset('front/images/step2a/5X5CLASSIC.png') }}" width="130" height="130" class="style1" ng-show="false">
			                </span>
						</div>

						<input type="hidden" name="sign_size" id="sign_size" />
						<input type="hidden" name="sign_size_price" id="sign_size_price" />
						<input type="hidden" name="sign_bg_image" id="sign_bg_image" />
						<input type="hidden" name="sign_edge_style" id="sign_edge_style" value="CLASSIC" />
						<input type="hidden" name="sign_line_1" id="sign_line_1" />
						<input type="hidden" name="sign_line_2" id="sign_line_2" />
						<input type="hidden" name="sign_line_3" id="sign_line_3" />
						<input type="hidden" name="sign_gold_price" id="sign_gold_price" />
						<input type="hidden" name="sign_font_color" id="sign_font_color" value="White" />
						<input type="hidden" name="sign_font_size" id="sign_font_size" />
						<input type="hidden" name="sign_font_margin" id="sign_font_margin" />
						<input type="hidden" name="sign_font_style" id="sign_font_style" value="Albertus" />
						<input type="hidden" name="hdn_fixing_type" id="hdn_fixing_type" value="Secret Fixing" />--}}
					</div>
				</div>

			</div>
		</div>


		<script src="{{ asset('front/js/flat-ui.min.js') }}"></script>
		<link href="{{ asset('front/styles/ss_style.css') }}" rel="stylesheet">
	</div>
	<style>
		.continue_shopping{
			cursor: pointer;
			background-color: #77787c;
			color: white;
			padding: 1em 1.5em;
			position: relative;
			text-decoration: none;
			text-transform: uppercase;
		}
	</style>
@endsection

@section('page_script')
	<script>
		@if(Session::has('message'))
		alert({{ Session::get('message') }});
		toastr.error('{{ Session::get('message') }}', 'Error');
		@endif
		/* ANGULAR ORDER */
		var urlGetProductList = "{{ route('products') }}";
		var urlCartAddProduct = "{{ route('add-cart-product') }}";
		var urlReview = "{{ route('review') }}";

		var isCheckoutPage = false;
		var varPackage = '';
	</script>

@endsection

@section('script')
	{{--<script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.9/angular.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.8/angular-route.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.8/angular-resource.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-sanitize.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.16.0/moment.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/moment-range/2.2.0/moment-range.min.js"></script>--}}
	<script type='text/javascript' src='{{ asset("front/js/custom/cart.js".'?t='.time()) }}'></script>
@endsection