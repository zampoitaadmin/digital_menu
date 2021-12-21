<div role="tabpanel" class="tab-panev" id="step3" ng-show="currentStep=='step-design'" >
	<!--step3-->
	<div class="clearfix header_common">
		<div class="col-sm-9">
			<h5> <span class="text-black"> Step 3 : </span> DESIGN THE CONTENTS OF YOUR SIGN...</h5>
			<ul>
				<li>Use the design console below to style your fabulous new slate sign.</li>
				<li> Once you are happy with your selection, Click the &lsquo;Continue&rsquo; button below. </li>
				<li>Need a logo, motif or bespoke design? Contact us or
					<a href="{{ route('motifs-bespoke-gallery') }}"> Click here > </a>
				</li>
			</ul>
		</div>
		<div class="col-sm-3 text-right">
			<img src="{{ asset('front/images/pimgpsh_fullsize_distr.jpg' )}}">
		</div>
	</div>
	<div class="clearfix tab_con">
		<div class="col-sm-5 lft_step clearfix">
			<div class="clearfix" id="h_line1">
				<div class="edge_style edgelft_img input-box">
                    <input type="text" id="t_line1" placeholder="Type Your Information Here..."  ng-model="requestFormData.cartPreview.line1"  ng-maxlength="requestFormData.cartPreview.maxLength.line1"  maxlength="@{{ requestFormData.cartPreview.maxLength.line1 }}" ng-change ="setFontPositionFun()"  ng-keyup ="setFontPositionFun()" ng-keypress="getkeys($event);setFontPositionFun()" autocomplete="off" stopccp>
				</div>
				<div class=" edge_style edgergt_color step3"> <strong> Line 1.</strong>
					<br>
					<br>
				</div>
			</div>
			<div class="clearfix" id="h_line2">
				<div class=" edge_style edgelft_img input-box">
					<input type="text" id="t_line2" placeholder="Type Your Information Here..."  ng-model="requestFormData.cartPreview.line2"  ng-maxlength="requestFormData.cartPreview.maxLength.line2"  maxlength="@{{ requestFormData.cartPreview.maxLength.line2 }}"  ng-keypress="getkeys($event);setFontPositionFun()" ng-keyup ="setFontPositionFun()"  autocomplete="off" ng-change ="setFontPositionFun()" stopccp>
				</div>
				<div class=" edge_style edgergt_color step3"> <strong> Line 2.</strong>
					<br>
					<br>
				</div>
			</div>
			<div class="clearfix" id="h_line3">
				<div class=" edge_style edgelft_img input-box">
					<input type="text" id="t_line3" placeholder="Type Your Information Here..."  ng-model="requestFormData.cartPreview.line3"  ng-maxlength="requestFormData.cartPreview.maxLength.line3"  maxlength="@{{ requestFormData.cartPreview.maxLength.line3 }}"  ng-keypress="getkeys($event);setFontPositionFun()" ng-keyup ="setFontPositionFun()" ng-change ="setFontPositionFun()"  autocomplete="off" stopccp>
				</div>
				<div class=" edge_style edgergt_color step3"> <strong> Line 3.</strong>
					<br>
					<br>
				</div>
			</div>
			<div class="clearfix">
				<div class="edge_style edgelft_img add_edit_font font-size">
					<span class="text_position"> Text Size </span>
					<a href="javascript:void(0);" id="incfont" ng-click="increaseFontSizeFun()">
						<span class="plus"> <i class="glyphicon glyphicon-plus"></i></span>
					</a>
					<a href="javascript:void(0);" id="decfont" ng-click="decreaseFontSizeFun()">
						<span class="minus"> <i class="glyphicon glyphicon-minus"></i></span>
					</a>
				</div>
				<div class="edge_style add_edit_font edgergt_color step3 font-position">
					<span class="text_position"> Position </span>
					<a href="javascript:void(0);" id="incpos" ng-click="increaseFontPositionFun()">
						<span class="up"> <i class="glyphicon glyphicon-triangle-top"></i> </span>
					</a>
					<a href="javascript:void(0);" id="decpos" ng-click="decreaseFontPositionFun()">
						<span class="down"> <i class="glyphicon glyphicon-triangle-bottom"></i> </span>
					</a>
				</div>
			</div>
			<div class="clearfix">
				<div class="edge_style edgelft_img edgeleft_color font-option">
					<ul>
						<li class="sign_font" ng-if="designFontList"   id="@{{ row.font }}" style="font-family:'@{{ row.font }}';" ng-repeat="row in designFontList track by $index"   ng-click="selectDesignFontFun(row)">A</li>
					</ul>
				</div>
				<div class=" edge_style edgergt_color step3 desired_font"> Select<br>
					Your<br>
					Font:<br>
					<span class="text-black" id="font-prev" style="word-wrap: break-word;">@{{ requestFormData.cartPreview.fontName }}</span>
				</div>
			</div>
			<div class="clearfix hidden-xs">
				<div class="button edgergt_color">
					<button class="btn-block back-btn text-right" type="button" ng-click="changeStepFun('step-style-edge')">
						<i class="pull-left"></i>
					</button>
				</div>
				<div class="button edgergt_color pull-left">
					<button class="btn-block continue-btn text-left" type="button" ng-click="changeStepFun('step-color')"><i class="pull-right"> </i>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>