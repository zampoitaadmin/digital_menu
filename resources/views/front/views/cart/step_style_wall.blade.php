<div role="tabpanel" class="tab-panev" id="step2a" ng-show="currentStep=='step-style-wall'"  ng-cloak>
	<!--step2-->
	<div class="clearfix header_common">
		<div class="col-sm-9">
			<h5> <span class="text-black"> Step 2 : </span> SELECT A BACKGROUND WALL TYPE...</h5>
			<ul>
				<li>Click on the thumbnail images below to select a wall background visual. </li>
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
			<!--  <small> YOUR SELECTED: Sign style 1: 5X5</small>-->
			<div class="clearfix">
				<div class="edge_style edgelft_img" >
					<ul>
						<li class="bg_img" ng-if="styleWallList"  ng-repeat="row in styleWallList track by $index"   ng-click="selectStyleWallFun(row)">
							<img id="21" ng-src="@{{ row.imgUrl }}" ng-class="{'actives': row.id==requestFormData.cartStyleWall.id}">
						</li>
						{{--<li class="bg_img">
							<img id="21" src="{{ asset('front/images/step2a/color/21.jpg') }}">
						</li>
						<li class="bg_img">
							<img id="10" src="{{ asset('front/images/step2a/color/10.jpg') }}">
						</li>
						<li class="bg_img">
							<img id="18" src="{{ asset('front/images/step2a/color/18.jpg') }}">
						</li>
						<li class="bg_img">
							<img id="20" src="{{ asset('front/images/step2a/color/20.jpg') }}">
						</li>
						<li class="bg_img">
							<img id="6" src="{{ asset('front/images/step2a/color/6.jpg') }}">
						</li>
						<li class="bg_img">
							<img id="5" src="{{ asset('front/images/step2a/color/5.jpg') }}">
						</li>
						<li class="bg_img">
							<img id="16" src="{{ asset('front/images/step2a/color/16.jpg') }}">
						</li>
						<li class="bg_img">
							<img id="9" src="{{ asset('front/images/step2a/color/9.jpg') }}">
						</li>
						<li class="bg_img">
							<img id="12" src="{{ asset('front/images/step2a/color/12.jpg') }}">
						</li>
						<li class="bg_img">
							<img id="13" src="{{ asset('front/images/step2a/color/13.jpg') }}">
						</li>
						<li class="bg_img">
							<img id="15" src="{{ asset('front/images/step2a/color/15.jpg') }}">
						</li>
						<li class="bg_img">
							<img id="8" src="{{ asset('front/images/step2a/color/8.jpg') }}">
						</li>
						<li class="bg_img">
							<img id="4" src="{{ asset('front/images/step2a/color/4.jpg') }}">
						</li>
						<li class="bg_img">
							<img id="2" src="{{ asset('front/images/step2a/color/2.jpg') }}">
						</li>
						<li class="bg_img">
							<img id="14" src="{{ asset('front/images/step2a/color/14.jpg') }}">
						</li>
						<li class="bg_img">
							<img id="3" src="{{ asset('front/images/step2a/color/3.jpg') }}">
						</li>
						<li class="bg_img">
							<img id="7" src="{{ asset('front/images/step2a/color/7.jpg') }}">
						</li>
						<li class="bg_img">
							<img id="19" src="{{ asset('front/images/step2a/color/19.jpg') }}">
						</li>
						<li class="bg_img">
							<img id="11" src="{{ asset('front/images/step2a/color/11.jpg') }}">
						</li>
						<li class="bg_img">
							<img id="17" src="{{ asset('front/images/step2a/color/17.jpg') }}">
						</li>--}}
					</ul>
				</div>
			</div>
			<div class="clearfix hidden-xs">
				<div class="button edgergt_color">
					<button class="btn-block back-btn text-right" type="button" ng-click="changeStepFun('step-size')">
						<i class="pull-left"></i>
					</button>
				</div>
				<div class="button edgergt_color pull-left">
					{{--<a ng-href="javascript:void(0)" role="tab" data-toggle="tab">--}}
						<button class="btn-block continue-btn text-left" type="button" ng-click="changeStepFun('step-style-edge')">
							<i class="pull-right"></i>
						</button>
					{{--</a>--}}
				</div>
			</div>
		</div>
	</div>
</div>