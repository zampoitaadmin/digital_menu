<script src="{{-- asset('assets/front-menu/js/aos.js') --}}"></script>
<script type="text/javascript" src="{{ asset('assets/front-menu/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/front-menu/js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/front-menu/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/front-menu/js/4077c6ef6a.js') }}"></script>
<script src="xPlugins/angular-libs/bower_components/angular/angular.min.js"></script>
<script src="xPlugins/angular-libs/bower_components/angular-sanitize/angular-sanitize-1.2.20.min.js"></script>
<script src="xPlugins/angular-libs/bower_components/lodash/dist/lodash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.1/underscore-min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/1.0.30/angular-ui-router.min.js"></script>
<script src="xPlugins/angular-libs/bower_components/angular-local-storage/dist/angular-local-storage.min.js"></script>
<script src="xPlugins/angular-libs/bower_components/restangular/dist/restangular.min.js"></script>
<script src="{{ url('xPlugins/angular-libs/bower_components/angular-ui-notification/angular-ui-notification.js') }}"></script>
<link rel="stylesheet" href="{{ url('xPlugins/angular-libs/bower_components/angular-ui-notification/angular-ui-notification.css') }}" />
<script src='{{ asset("xPlugins/jquery-ui/jquery-ui.js") }}'></script>
<script src='{{ asset("xPlugins/angular-ui/sortable.js") }}'></script>
<script src='{{ asset("js/ng/app.js".'?t='.time()) }}'></script>
<script src='{{ asset("js/ng/controllers.js".'?t='.time()) }}' ></script>
<script src='{{ asset("js/ng/services.js".'?t='.time()) }}' ></script>
<script src="{{ url('xPlugins/angular-ui/select/select.js') }}"></script>
<script src="{{ url('xPlugins/angular-ui/select/select-patch.js') }}"></script>
@yield('page_script')
@yield('script')