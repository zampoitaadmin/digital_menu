<aside id="ms-side-nav" class="side-nav fixed ms-aside-scrollable ms-aside-left">
	<!-- Logo -->
		<div class="logo-sn ms-d-block-lg" style="padding:20px;">
			<a class="pl-0 ml-0 text-center" href="{{ route('admin-dashboard') }}">
				<img src="{{ _get_site_logo() }}" alt="logo" style="width: 135px;">
			</a>
		</div>
	<!-- Logo -->

	<!-- Navigation -->
		<ul class="accordion ms-main-aside fs-14" id="side-nav-accordion">
			<li class="menu-item">
				<a href="{{ route('admin-dashboard') }}" class="{{ (request()->is('admin/dashboard*')) ? 'active' : '' }}"> 
					<span><i class="fas fa-home"></i>Dashboard</span>
				</a>
			</li>
			<li class="menu-item">
				<a href="{{ route('admin-orders-list') }}" class="{{ (request()->is('admin/orders/*')) ? 'active' : '' }}">
				    <span><i class="fas fa-shopping-cart"></i>Orders</span>
				</a>
			</li>
			<?php $adminRoleId= Session::get('role_id'); ?>
			@if($adminRoleId != "2")
			<li class="menu-item">
				<a href="{{ route('admin-voucher-orders-list') }}" class="{{ (request()->is('admin/voucher/voucher-order/*')) ? 'active' : '' }}">
					<span><i class="fas fa-gift"></i>Voucher Orders</span>
				</a>
			</li>
			
			<li class="menu-item">
				<a href="{{ route('admin-coupon-list') }}" class="{{ (request()->is('admin/coupon/*')) ? 'active' : '' }}">
				    <span><i class="fas fa-tag"></i>Coupon</span>
				</a>
			</li>
			<!-- <li class="menu-item">
				<a href="{{ route('admin-category-list') }}" class="{{ (request()->is('admin/category/*')) ? 'active' : '' }}">
				    <span><i class="fa fa-list"></i>Category</span>
				</a>
			</li> -->

			<li class="menu-item">
				<a href="{{ route('admin-product-list') }}" class="{{ (request()->is('admin/product/*')) ? 'active' : '' }}">
				    <span><i class="fa fa-tasks"></i>Product</span>
				</a>
			</li>

			<!--<li class="menu-item">
				<a href="{{ route('setting-list') }}" class="{{ (request()->is('admin/settings*')) ? 'active' : '' }}"> 
					<span><i class="fa fa-cog"></i>Settings</span>
				</a>
			</li>-->
			<li class="menu-item">
				<a href="{{ route('admin-coupon-report-list') }}" class="{{ (request()->is('admin/report-coupon*')) ? 'active' : '' }}">
				    <span><i class="fas fa-address-card"></i>Coupon Report</span>
				</a>
			</li>
			@endif
			<!-- <li class="menu-item">
				<a href="{{ route('email-list') }}" class="{{ (request()->is('admin/email*')) ? 'active' : '' }}"> 
					<span><i class="fa fa-envelope"></i>Email Templates</span>
				</a>
			</li> -->
			<!-- <li class="menu-item ">
				<a href="#" class="has-chevron {{ (request()->is('admin/report-order*') || request()->is('admin/report-voucher*')) ? 'active' : '' }}"  data-toggle="collapse" data-target="#report" aria-expanded="false" aria-controls="order"> 
					<span><i class="fas fa-file-alt fs-16"></i>Reports </span>
				</a>
				<ul id="report" class="collapse" aria-labelledby="report" data-parent="#side-nav-accordion">
					<li class="menu-item">
						<a href="{{ route('admin-report-order-list') }}" class="{{ (request()->is('admin/report-order*')) ? 'active' : '' }}"> 
							<span><i class="fas fa-shopping-cart fs-16"></i>Report Orders</span>
						</a>
					</li>
					<li class="menu-item">
						<a href="{{route('admin-report-voucher-list')}}" class="{{ (request()->is('admin/report-voucher*')) ? 'active' : '' }}"> 
							<span><i class="fas fa-gift fs-16"></i>Report Vouchers</span>
						</a>
					</li>
				</ul>
			</li> -->
		</ul>
	<!-- Navigation -->
</aside>