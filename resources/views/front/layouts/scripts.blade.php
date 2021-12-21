
<!-- ====== All Javascript Files ====== -->
<script src="{{ asset('assets/js/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('assets/js/js/wow.min.js')}}"></script>
<script src="{{ asset('assets/js/js/main.js')}}"></script>

<!-- ====== All Javascript Files ====== -->
<script src="{{ asset('assets/js/jquery.min.js')}}"></script>
{{--<script src="{{ asset('assets/js/popper.min.js')}}"></script>--}}
<script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

<script src="{{ asset('assets/js/fontawsome_5.js')}}" crossorigin="anonymous"></script>

<script type="text/javascript" src="{{ url('xPlugins/sweetalert2/sweetalert2.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ url('xPlugins/sweetalert2/sweetalert2.min.css') }}">


<script type="text/javascript">
    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                var htmlPreview =
                        '<img width="200" src="' + e.target.result + '" />' +
                        '<p>' + input.files[0].name + '</p>';
                var wrapperZone = $(input).parent();
                var previewZone = $(input).parent().parent().find('.preview-zone');
                var boxZone = $(input).parent().parent().find('.preview-zone').find('.box').find('.box-body');

                wrapperZone.removeClass('dragover');
                previewZone.removeClass('hidden');
                boxZone.empty();
                boxZone.append(htmlPreview);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    function reset(e) {
        e.wrap('<form>').closest('form').get(0).reset();
        e.unwrap();
    }

    $(".dropzone").change(function() {
        readFile(this);
    });

    $('.dropzone-wrapper').on('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).addClass('dragover');
    });

    $('.dropzone-wrapper').on('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('dragover');
    });

    $('.remove-preview').on('click', function() {
        var boxZone = $(this).parents('.preview-zone').find('.box-body');
        var previewZone = $(this).parents('.preview-zone');
        var dropzone = $(this).parents('.form-group').find('.dropzone');
        boxZone.empty();
        previewZone.addClass('hidden');
        reset(dropzone);
    });

</script>

<script type="text/javascript">
    $(document).ready(function() {
        $(".mob-menu span").click(function(){
            $(".main-menu").slideToggle();
        });
    });
</script>
{{--<script src="{{ asset("assets/ng/libs/angular-v1-6/angular.min.js") }}"></script>
<script src="{{ asset("assets/ng/libs/angular-v1-6/angular-route.min.js") }}"></script>
<script src="{{ asset("assets/ng/libs/angular-v1-6/angular-resource.min.js") }}"></script>
<script src="{{ asset("assets/ng/libs/angular-v1-6/angular-sanitize.js") }}"></script>
<script src="{{ asset("assets/ng/libs/angular-v1-6/moment.min.js") }}"></script>
<script src="{{ asset("assets/ng/libs/angular-v1-6/moment-range.min.js") }}"></script>
<script type='text/javascript' src='{{ asset("assets/ng/main.js".'?t='.time()) }}'></script>--}}

<script src="xPlugins/angular-libs/bower_components/angular/angular.min.js"></script>
{{--<script src="//code.angularjs.org/1.2.20/angular-sanitize.min.js"></script>--}}
<script src="xPlugins/angular-libs/bower_components/angular-sanitize/angular-sanitize-1.2.20.min.js"></script>
{{--<script src= "https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-sanitize.js" charset="utf-8">--}}
<script src="xPlugins/angular-libs/bower_components/lodash/dist/lodash.min.js"></script>
{{--<script src="xPlugins/angular-libs/bower_components/angular-route/angular-route.min.js"></script>--}}
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.1/underscore-min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/1.0.30/angular-ui-router.min.js"></script>
<script src="xPlugins/angular-libs/bower_components/angular-local-storage/dist/angular-local-storage.min.js"></script>
<script src="xPlugins/angular-libs/bower_components/restangular/dist/restangular.min.js"></script>
<script src="{{ url('xPlugins/angular-libs/bower_components/angular-ui-notification/angular-ui-notification.js') }}"></script>
<link rel="stylesheet" href="{{ url('xPlugins/angular-libs/bower_components/angular-ui-notification/angular-ui-notification.css') }}" />
<script src='{{ asset("js/ng/app.js".'?t='.time()) }}'></script>
<script src='{{ asset("js/ng/controllers.js".'?t='.time()) }}' ></script>
<script src='{{ asset("js/ng/services.js".'?t='.time()) }}' ></script>

@yield('page_script')

@yield('script')
