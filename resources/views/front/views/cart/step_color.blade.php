<div role="tabpanel" class="tab-panev" id="step4" ng-show="currentStep=='step-color'" >
	<!--step4-->
	<div class="clearfix header_common">
		<div class="col-sm-9">
			<h5> <span class="text-black"> Step 4 : </span> SELECT THE COLOUR OF YOUR SIGN... </h5>
			<ul>
				<li>Select a colour or finish below for your fabulous new slate sign.</li>
				<li>Once you are happy with your selection, Click the &lsquo;Continue&rsquo; button below.</li>
				<li>Please Note : If you need a logo, motif or bespoke design? Contact us or
					<a href="{{ route('motifs-bespoke-gallery') }}"> Click here </a>
				</li>
			</ul>
		</div>
		<div class="col-sm-3 text-right">
			<img src="{{ asset('front/images/pimgpsh_fullsize_distr.jpg') }}">
		</div>
	</div>
	<div class="clearfix tab_con">
		<div class="col-sm-5 lft_step clearfix">
			<div class="clearfix">
				<div class=" edge_style edgelft_img">
					<img class="sign_color"  width="364"  id="@{{ row.name }}"   ng-src="@{{(requestFormData.cartPreview.edgeType != 'BORDERED') && row.imgUrl || (requestFormData.cartPreview.styleId == 'style1' ||requestFormData.cartPreview.styleId == 'style2' ||requestFormData.cartPreview.styleId == 'style3' ) && row.imgUrlA || row.imgUrlB}}" ng-class="{'activee': row.id==requestFormData.cartColor.id}" ng-repeat="row in colorList track by $index"   ng-click="selectColorFun(row)">
					{{--<img class="sign_color"  width="364"  id="@{{ row.name }}"   ng-src="@{{(requestFormData.cartPreview.edgeType != 'BORDERED') && row.imgUrl || row.imgUrlA}}" ng-class="{'activee': row.id==requestFormData.cartColor.id}" ng-repeat="row in colorList track by $index"   ng-click="selectColorFun(row)">--}}

				</div>
			</div>
			<div class="clearfix hidden-xs">
				<div class="button edgergt_color">
					<button class="btn-block back-btn text-right" type="button" ng-click="changeStepFun('step-design')">
						<i class="pull-left"></i>
					</button>
				</div>
				<div class="button edgergt_color pull-left">
					<button class="btn-block continue-btn text-left" type="button" ng-click="changeStepFun('step-confirm')">
						<i class="pull-right"> </i>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>