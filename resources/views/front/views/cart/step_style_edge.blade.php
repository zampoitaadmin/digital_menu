<div role="tabpanel" class="tab-panev" id="step2" ng-show="currentStep=='step-style-edge'" >
	<!--step2-->
	<div class="clearfix header_common">
		<div class="col-sm-9">
			<h5> <span class="text-black"> Step 2 : </span> SELECT AN EDGE STYLE...</h5>
			<ul>
				<li>Click on the thumbnail images below to choose your sign edge style.</li>
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
				<div class="edge_style edgelft_img">
					{{--<img width="183" ng-if="styleEdgeList"  class="edge_img" id="@{{ row.name }}" src="@{{ row.imgUrl }}" ng-class="{'activee': row.id==requestFormData.cartStyleEdge.id}"   ng-repeat="row in styleEdgeList track by $index"   ng-click="selectStyleEdgeFun(row)">--}}
					<img width="183" ng-if="styleEdgeList"  class="edge_img" id="@{{ row.name }}"  ng-src="@{{(requestFormData.cartPreview.styleId == 'style1' ||requestFormData.cartPreview.styleId == 'style2' ||requestFormData.cartPreview.styleId == 'style3' ) && row.imgUrl || row.imgUrlA}}" ng-class="{'activee': row.id==requestFormData.cartStyleEdge.id}"   ng-repeat="row in styleEdgeList track by $index"   ng-click="selectStyleEdgeFun(row)">
				</div>
			</div>
			<div class="clearfix hidden-xs">
				<div class="button edgergt_color">
					<button class="btn-block back-btn text-right" type="button" ng-click="changeStepFun('step-style-wall')">
						<i class="pull-left"></i>
					</button>
				</div>
				<div class="button edgergt_color pull-left">
					<button class="btn-block continue-btn text-left" type="button" ng-click="changeStepFun('step-design')">
						<i class="pull-right"></i>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>