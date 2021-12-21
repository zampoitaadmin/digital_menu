<div role="tabpanel" class="tab-pane active" id="step1"  ng-show="currentStep=='step-size'" ng-cloak>
	<!--step1-->
	<div class="clearfix header_common">
		<div class="col-sm-9">
			<h5> <span class="text-black"> Step 1 : </span> SELECT YOUR DESIRED SIGN SIZE...</h5>
			<ul>
				<li> Need a logo, motif or bespoke design?
					<a href="{{ route('motifs-bespoke-gallery') }}"> Click here > </a>
				</li>
				<li>All of our signs are produced in 100% welsh slate, approx 20mm thick. </li>
				<li>Please Note : 24ct Gold leaf finish attracts a premium of &pound;4.50 per digit, displayed at checkout. </li>
				<li>All prices exclude VAT which will be added at checkout. </li>
			</ul>
		</div>
		<div class="col-sm-3 text-right">
			<img src="{{ asset('front/images/pimgpsh_fullsize_distr.jpg') }}">
		</div>
	</div>


	<div class="clearfix tab_con" >
		{{--<div ng-if="isProductLoader" class="loaderProduct" ng-bind-html="loaderProduct"></div>--}}
		<div ng-if="sizeList  && !isProductLoader"  class="style_1 @{{ row.series }}" id="@{{ row.id }}"  ng-repeat="row in sizeList track by $index"   ng-click="selectSizeFun(row)" ng-cloak></div>
		<div ng-if="!sizeList && !isProductLoader" ng-cloak> Please refresh the page</div>
		{{--<div class="style_1 one" id="style1"></div>
		<div class="style_1 two" id="style2"></div>
		<div class="style_1 three" id="style3"></div>
		<div class="style_1 four" id="style4"></div>
		<div class="style_1 five" id="style5"></div>
		<div class="style_1 six" id="style6"></div>
		<div class="style_1 seven" id="style7"></div>
		<div class="style_1 eight" id="style8"></div>
		<div class="style_1 nine" id="style9"></div>
		<div class="style_1 ten" id="style10"></div>--}}
	</div>
</div>