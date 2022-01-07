<footer class="footer_bg">
	<div class="container">
		<div class="row">
			<div class="col-md-2 col-lg-3">
				<div class="row">
					<div class="col-md-12 col-lg-8 mb-md-0 mb-4">
						<h2 class="footer-heading"><a href="#" class="logo"><img src="https://betagit.zampoita.com/assets/landing/img/logo_zampoita_new.png?ver=1" width="160"></a></h2>
					</div>
				</div>
			</div>
			<div class="col-md-10 col-lg-9">
				<div class="row">
					<div class="col-md-4 mb-md-0 mb-4 border-left">
						<h2 class="footer-heading">Legal</h2>
						<ul class="list-unstyled">
							<li><a href="#" class="py-1 d-block">Term & Conditions</a></li>
							<li><a href="#" class="py-1 d-block">Term & Conditions - Competitions</a></li>
							<li><a href="#" class="py-1 d-block">Privacy Policy</a></li>
							<li><a href="#" class="py-1 d-block">Cookie Info</a></li>
						</ul>
					</div>
					<div class="col-md-2 mb-md-0 mb-4 border-left">
						<h2 class="footer-heading">Company</h2>
						<ul class="list-unstyled">
							<li><a href="#" class="py-1 d-block">About Us</a></li>
							<li><a href="#" class="py-1 d-block">Why Zampoita</a></li>
							<li><a href="#" class="py-1 d-block">Pricing</a></li>
							<li><a href="#" class="py-1 d-block">Blog</a></li>
						</ul>
					</div>
					<div class="col-md-4 mb-md-0 mb-4 border-left">
						<h2 class="footer-heading">Services</h2>
						<ul class="list-unstyled">
							<li><a href="#" class="py-1 d-block">Premium Listing</a></li>
							<li><a href="#" class="py-1 d-block">Zampoita Design</a></li>
							<li><a href="#" class="py-1 d-block">Website Design</a></li>
							<li><a href="#" class="py-1 d-block">Table Reserving & Foor ordering</a></li>
						</ul>
					</div>
					<div class="col-md-2 mb-md-0 mb-4 border-left">
						<h2 class="footer-heading">Support</h2>
						<ul class="list-unstyled">
							<li><a href="#" class="py-1 d-block">Signup</a></li>
							<li><a href="#" class="py-1 d-block">Client Login</a></li>
							<li><a href="#" class="py-1 d-block">Instagram</a></li>
							<li><a href="#" class="py-1 d-block">Support</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="row mt-5">
			<div class="col-md-6 col-lg-8">
				<p class="copyright" style="color: #bc874a;">
					Copyright &copy;<i class="ion-ios-heart" aria-hidden="true"></i> Zampoita.com <script>document.write(new Date().getFullYear());</script>
				</p>
			</div>
			<div class="col-md-6 col-lg-4 text-md-right d-flex justify-content-end">
				<p class="mb-0 list-unstyled">
					<a class="mr-md-3" href="https://www.facebook.com/zampoita"><i class="fab fa-facebook-f for_style"></i></a>
					<a class="mr-md-3" href="https://www.linkedin.com/company/zampoita/"><i class="fab fa-linkedin-in for_style"></i></a>
					<a class="mr-md-3" href="{{ _getHomeUrl().'blogs/' }}"><i class="fas fa-comment-dots for_style"></i></a>
					<a href="#" class="mr-md-3">
						<div class="dropdown">
							@php $appLanguage = ""; @endphp
                            @if(Session::has('locale'))
                                @php $appLanguage = Session('locale'); @endphp
                            @else
                                @php $appLanguage = Config::get('app.locale'); @endphp
                            @endif
							<button class="btn dropdown-toggle text-white" style="background: #202020;" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fas fa-globe px-1"></i>
								@if($appLanguage == "en") English
								@elseif($appLanguage == "es") Spanish
								@endif
							</button>
							<div class="dropdown-menu" aria-labelledby="dropdownMenu2">
								@if($appLanguage == "en") <button class="dropdown-item" type="button">Spanish</button>
								@elseif($appLanguage == "es") <button class="dropdown-item" type="button">English</button>
								@endif
							</div>
						</div>
					</a>
				</p>
			</div>
		</div>
	</div>
</footer>