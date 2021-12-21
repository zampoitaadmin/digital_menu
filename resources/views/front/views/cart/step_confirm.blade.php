<div role="tabpanel" class="tab-panev" id="step5a"  ng-show="currentStep=='step-confirm'" >
	<!--step5a-->
	<div class="clearfix header_common">
		<div class="col-sm-9">
			<h5> <span class="text-black"> Step 5 : </span> CONFIRM A FIXING TYPE FOR YOUR SIGN, SELECT FROM THE TWO OPTIONS BELOW...</h5>
			<ul>
				<li>Hidden fixings for securing to a wall or gate are fitted and supplied as standard. </li>
				<li>Upgrade to ground stake fixings* if you wish to locate your sign at landscape level.</li>
				<li>Slate stake or stakes will be matched to your sign during the production process.</li>
			</ul>
		</div>
	</div>
	<div class="clearfix tab_con">
		<div class="lft_step clearfix" style="width:100%">
			<div class="clearfix">
				<div class="edge_style edgelft_img">
					<ul>
						<li class="fixing_type"  ng-if="(row.code=='fixing_type_secret') || ( requestFormData.cartPreview.isSingleFixing == true && row.code == 'fixing_type_single_ground_stake') || ( requestFormData.cartPreview.isSingleFixing == false && row.code != 'fixing_type_single_ground_stake') " ng-repeat="row in fixingTypeList track by $index"   ng-click="selectFixingFun(row)">
							<img id="@{{ row.code }}" class="@{{ row.code }}" ng-class="{'activee': row.id == requestFormData.cartFixing.id}" ng-src="@{{ row.imgUrl }}" >
						</li>
						{{--<li class="fixing_type li_fixing_type_secret">
							<img id="fixing_type_secret" class="fixing_type_actives" src="{{ asset('front/images/step5a/Stakes-Page-Secret-Fixings.png') }}" ng-click="selectFixingFun()">
						</li>
						<li class="fixing_type li_fixing_type_single_ground_stake" ng-if="requestFormData.cartPreview.isSingleFixing">
							<img id="fixing_type_single_ground_stake" src="{{ asset('front/images/step5a/Stakes-Page-Single-Fixing.png') }}">
						</li>
						<li class="fixing_type li_fixing_type_double_ground_stake"  ng-if="!requestFormData.cartPreview.isSingleFixing">
							<img id="fixing_type_double_ground_stake" src="{{ asset('front/images/step5a/Stakes-Page-Double-Fixings.png') }}">
						</li>--}}
					</ul>
				</div>
			</div>
			<div class="clearfix hidden-xs buttons">
				<div class="button edgergt_color">
					<button class="btn-block back-btn text-right" type="button" ng-click="changeStepFun('step-color')"><i class="pull-left"></i></button>
				</div>
				<div class="spacer"></div>
				<div class="button edgergt_color pull-left">
					<a href="javascript:void(0)">
						<button class="btn-block text-left" style="cursor: pointer;" type="button" ng-click="addToCartFun()"></button>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>

<div role="tabpanel" class="tab-pane" id="step5">
	<!--step5-->
	<div class="clearfix header_common">
		<div class="col-sm-9">
			<h5> <span class="text-black"> Step 5 : </span>CONFIRM YOUR ORDER... </h5>
			<ul>
				<li>If you require a quantity greater than one, please type how many you require in the &lsquo;Qty&rsquo; box. </li>
				<li>Please Note : Delivery is charged &lsquo;per sign&rsquo; due to the weight and amount of packaging required.</li>
				<li>If you DO NOT receive a confirmation email from us, please check your spam, bulk or junk folders.</li>
			</ul>
		</div>
		<div class="col-sm-3 text-right">
			<img src="{{ asset('front/images/pimgpsh_fullsize_distr.jpg') }}">
		</div>
	</div>
	<div class="clearfix tab_con">
		<div class="clearfix ">
			<div class="col-sm-5 confirm4" id="checkout_left">
				<div class="table-responsive">
					<div class="left">
						<div class="title">
							<p>Description</p>
						</div>
						<div class="summary">
							<strong>YOU SELECTED:</strong>
							<div id="r_html"></div>
						</div>
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
							<!-- Identify your business so that you can collect the payments. -->
							<input type="hidden" name="business" value="paypal@slatesign.co.uk">
							<!-- Specify a Buy Now button. -->
							<input type="hidden" name="cmd" value="_xclick">
							<!-- Specify details about the item that buyers will purchase. -->
							<input type="hidden" name="item_name" value="">
							<input type="hidden" name="amount" value="5.95">
							<input type="hidden" name="quantity" value="1">
							<input type="hidden" name="currency_code" value="GBP">
							<input type="hidden" name="shipping" value="6.95">

							<!-- Display the payment button. -->
							{{--<button class="btn-block text-left" type="submit"
                                    style="cursor:pointer;"></button>--}}
							<a href="javascript:void()" class="continue_shopping" onclick="do_shop()" style="cursor:pointer;"> Add to cart & Do shop</a>
						</form>
					</div>

					<div class="right">
						<div class="title">
							<p>Quantity</p>
						</div>
						<td width="30"><input type="tel" pattern="\d+" name="p_quantity" value="1" min="1" step="1" oninput="validity.valid||(value='');">
						</td>
						<div class="title">
							<p>Delivery:</p>
						</div>
						<label>Yes<input type="radio" name="delivery" value="yes" checked="checked"></label>
						<label>No<input type="radio" name="delivery" value="no"></label>
						<div class="title">
							<p>Price:</p>
						</div>
						<div class="price">
							<p>
								<span>Fixing type price:</span> &pound;
								<span id="span_fixing_type_price_tot">0.00</span>
								<span id="span_fixing_type_price" style="display:none;">0.00</span>
							</p>
							<p>
								<span>Sign/s:</span> &pound;
								<span id="sign_price_tot">65.00</span>
								<span id="sign_price" style="display:none;">65.00</span>
							</p>
							<p>
								<span>Gold:</span> &pound;
								<span id="gold_price_tot">58.00</span>
								<span id="gold_price" style="display:none;">58.00</span>
							</p>
							<p>
								<span>Delivery:</span> &pound;
								<span id="del_price">6.95</span>
							</p>
						</div>
						<div class="total">Total : &pound;<span id="total_price">121</span></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>