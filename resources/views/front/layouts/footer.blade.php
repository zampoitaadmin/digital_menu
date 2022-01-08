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
				<div class="row rowFooter">
					<div class="col-md-4 mb-md-0 mb-4 border-left">
						<h2 class="footer-heading">{{ __('message_lang.legal') }}</h2>
						<ul class="list-unstyled">
							<li><a href="#" class="py-1 d-block">{{ __('message_lang.termsandconditions') }}</a></li>
							<li><a href="#" class="py-1 d-block">{{ __('message_lang.com_ter_co') }}</a></li>
							<li><a href="#" class="py-1 d-block">{{ __('message_lang.privacy_policy') }}</a></li>
							<li><a href="#" class="py-1 d-block">{{ __('message_lang.cookies_info_text_f') }}</a></li>
						</ul>
					</div>
					<div class="col-md-2 mb-md-0 mb-4 border-left">
						<h2 class="footer-heading">{{ __('message_lang.company') }}</h2>
						<ul class="list-unstyled">
							<li><a href="#" class="py-1 d-block">{{ __('message_lang.About_Us') }}</a></li>
							<li><a href="#" class="py-1 d-block">{{ __('message_lang.why_zampoita') }}</a></li>
							<li><a href="#" class="py-1 d-block">{{ __('message_lang.pricing') }}</a></li>
							<li><a href="#" class="py-1 d-block">{{ __('message_lang.blog') }}</a></li>
						</ul>
					</div>
					<div class="col-md-4 mb-md-0 mb-4 border-left">
						<h2 class="footer-heading">{{ __('message_lang.services') }}</h2>
						<ul class="list-unstyled">
							<li><a href="#" class="py-1 d-block">{{ __('message_lang.prem_listing') }}</a></li>
							<li><a href="#" class="py-1 d-block">{{ __('message_lang.zam_design') }}</a></li>
							<li><a href="#" class="py-1 d-block">{{ __('message_lang.web_design') }}</a></li>
							<li><a href="#" class="py-1 d-block">{{ __('message_lang.tbl_reserver') }}</a></li>
							<li><a href="#" class="py-1 d-block">{{ __('message_lang.competitions_') }}</a></li>
						</ul>
					</div>
					<div class="col-md-2 mb-md-0 mb-4 border-left">
						<h2 class="footer-heading">{{ __('message_lang.contact') }}</h2>
						<ul class="list-unstyled">
							<li><a href="#" class="py-1 d-block">{{ __('message_lang.signup') }}</a></li>
							<li><a href="#" class="py-1 d-block">{{ __('message_lang.client_login') }}</a></li>
							<li><a href="#" class="py-1 d-block">{{ __('message_lang.contact') }}</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="row mt-5">
			<div class="col-md-6 col-lg-7">
				<p class="copyright" style="color: #bc874a;">
					{{ __('message_lang.copyright') }} &copy;<i class="ion-ios-heart" aria-hidden="true"></i> Zampoita.com <script>document.write(new Date().getFullYear());</script>
				</p>
			</div>
			<div class="col-md-6 col-lg-5 text-md-right d-flex justify-content-end">
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
								@if($appLanguage == "en") <button class="dropdown-item" type="button" onclick="changeLang('es');">Spanish</button>
								@elseif($appLanguage == "es") <button class="dropdown-item" type="button" onclick="changeLang('en');">English</button>
								@endif
							</div>
						</div>
					</a>
				</p>
			</div>
		</div>
	</div>
</footer>
<script type="text/javascript">
	function changeLang(langShortCode) {
		event.preventDefault();
		if(langShortCode=="es"){
			window.location.href = "{{ route('change-lang', ['lang' => 'es']) }}";
		}else if(langShortCode=="en"){
			window.location.href = "{{ route('change-lang', ['lang' => 'en']) }}";
		}
	}
</script>