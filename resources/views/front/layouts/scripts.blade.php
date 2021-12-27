
<!-- ====== All Javascript Files ====== -->
<script src="{{ asset('assets/js/popper.min.js')}}"></script>
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

<link rel="stylesheet" type="text/css" href="{{ url('xPlugins/dropzone/css/dropzone.min.css') }}">
<script src="{{ url('xPlugins/dropzone/js/dropzone.min.js') }}"></script>

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

    $(document).ready(function() {
        $(".mob-menu span").click(function(){
            $(".main-menu").slideToggle();
        });
    });

    /*$(function () {
        $('.selectpicker').selectpicker();
        $('pick__lang').selectpicker();

    $(function () {
        if ($('.selectpicker').length) {
            $('.selectpicker').selectpicker();
        }
        if ($('pick__lang').length) {
            $('pick__lang').selectpicker();
        }
    });

    function go__bahasa() {
        location = document.pilih__bahasa.ipicked__bahasa.
        options[document.pilih__bahasa.ipicked__bahasa.selectedIndex].value
    }

    function Util() {};

    Util.addClass = function (el, className) {
        var classList = className.split(' ');
        if (el.classList) el.classList.add(classList[0]);
        else if (!Util.hasClass(el, classList[0])) el.className += " " + classList[0];
        if (classList.length > 1) Util.addClass(el, classList.slice(1).join(' '));
    };

    (function () {
        var LanguagePicker = function (element) {
            this.element = element;
            this.select = this.element.getElementsByTagName('select')[0];
            this.options = this.select.getElementsByTagName('option');
            this.selectedOption = getSelectedOptionText(this);
            this.pickerId = this.select.getAttribute('id');
            this.trigger = false;
            this.dropdown = false;
            this.firstLanguage = false;
            // dropdown arrow inside the button element
            this.svgPath = '<svg viewBox="0 0 16 16" fill="#fff"><polygon points="3,5 8,11 13,5 "></polygon></svg>';
            initLanguagePicker(this);
            initLanguagePickerEvents(this);
        };

        function initLanguagePicker(picker) {
            // create the HTML for the custom dropdown element
            picker.element.insertAdjacentHTML('beforeend', initButtonPicker(picker) + initListPicker(picker));

            // save picker elements
            picker.dropdown = picker.element.getElementsByClassName('language-picker__dropdown')[0];
            picker.firstLanguage = picker.dropdown.getElementsByClassName('language-picker__item')[0];
            picker.trigger = picker.element.getElementsByClassName('language-picker__button color_css')[0];
        };

        function initLanguagePickerEvents(picker) {
            // make sure to add the icon class to the arrow dropdown inside the button element
            Util.addClass(picker.trigger.getElementsByTagName('svg')[0], 'icon');
            initLanguageSelection(picker);

            // click events
            picker.trigger.addEventListener('click', function () {
                toggleLanguagePicker(picker, false);
            });
        };

        function toggleLanguagePicker(picker, bool) {
            var ariaExpanded;
            if (bool) {
                ariaExpanded = bool;
            } else {
                ariaExpanded = picker.trigger.getAttribute('aria-expanded') == 'true' ? 'false' : 'true';
            }
            picker.trigger.setAttribute('aria-expanded', ariaExpanded);
            if (ariaExpanded == 'true') {
                picker.firstLanguage.focus(); // fallback if transition is not supported
                picker.dropdown.addEventListener('transitionend', function cb() {
                    picker.firstLanguage.focus();
                    picker.dropdown.removeEventListener('transitionend', cb);
                });
            }
        };


        function initButtonPicker(picker) { // create the button element -> picker trigger
            // check if we need to add custom classes to the button trigger
            var customClasses = picker.element.getAttribute('data-trigger-class') ? ' ' + picker.element.getAttribute('data-trigger-class') : '';

            var button = '<button class="language-picker__button color_css' + customClasses + '" aria-label="' + picker.select.value + ' ' + picker.element.getElementsByTagName('label')[0].innerText + '" aria-expanded="false" aria-contols="' + picker.pickerId + '-dropdown">';
            button = button + '<span aria-hidden="true" class="language-picker__label language-picker__flag language-picker__flag--' + picker.select.value + '"><em>' + picker.selectedOption + '</em>';
            button = button + picker.svgPath + '</span>';
            return button + '</button>';
        };

        function initListPicker(picker) { // create language picker dropdown
            var list = '<div class="language-picker__dropdown" aria-describedby="' + picker.pickerId + '-description" id="' + picker.pickerId + '-dropdown">';
            list = list + '<p class="sr-only" id="' + picker.pickerId + '-description">' + picker.element.getElementsByTagName('label')[0].innerText + '</p>';
            list = list + '<ul class="language-picker__list" role="listbox">';
            for (var i = 0; i < picker.options.length; i++) {
                var selected = picker.options[i].hasAttribute('selected') ? ' aria-selected="true"' : '',
                    language = picker.options[i].getAttribute('lang');
                list = list + '<li><a lang="' + language + '" hreflang="' + language + '" href="' + getLanguageUrl(picker.options[i]) + '"' + selected + ' role="option" data-value="' + picker.options[i].value + '" class="language-picker__item language-picker__flag language-picker__flag--' + picker.options[i].value + '"><span>' + picker.options[i].text + '</span></a></li>';
            };
            return list;
        };

        function getSelectedOptionText(picker) { // used to initialize the label of the picker trigger button
            var label = '';
            if ('selectedIndex' in picker.select) {
                label = picker.options[picker.select.selectedIndex].text;
            } else {
                label = picker.select.querySelector('option[selected]').text;
            }
            return label;
        };

        function getLanguageUrl(option) {
            // ⚠️ Important: You should replace this return value with the real link to your website in the selected language
            // option.value gives you the value of the language that you can use to create your real url (e.g, 'english' or 'italiano')
            return '#';
        };

        function initLanguageSelection(picker) {
            picker.element.getElementsByClassName('language-picker__list')[0].addEventListener('click', function (event) {
                var language = event.target.closest('.language-picker__item');
                if (!language) return;

                if (language.hasAttribute('aria-selected') && language.getAttribute('aria-selected') == 'true') {
                    // selecting the same language
                    event.preventDefault();
                    picker.trigger.setAttribute('aria-expanded', 'false'); // hide dropdown
                } else {
                    // ⚠️ Important: this 'else' code needs to be removed in production. 
                    // The user has to be redirected to the new url -> nothing to do here
                    event.preventDefault();
                    picker.element.getElementsByClassName('language-picker__list')[0].querySelector('[aria-selected="true"]').removeAttribute('aria-selected');
                    language.setAttribute('aria-selected', 'true');
                    picker.trigger.getElementsByClassName('language-picker__label')[0].setAttribute('class', 'language-picker__label language-picker__flag language-picker__flag--' + language.getAttribute('data-value'));
                    picker.trigger.getElementsByClassName('language-picker__label')[0].getElementsByTagName('em')[0].innerText = language.innerText;
                    picker.trigger.setAttribute('aria-expanded', 'false');
                }
            });
        };

        //initialize the LanguagePicker objects
        var languagePicker = document.getElementsByClassName('js-language-picker');
        if (languagePicker.length > 0) {
            var pickerArray = [];
            for (var i = 0; i < languagePicker.length; i++) {
                (function (i) {
                    pickerArray.push(new LanguagePicker(languagePicker[i]));
                })(i);
            }

            // listen for key events
            window.addEventListener('keyup', function (event) {
                if (event.keyCode && event.keyCode == 27 || event.key && event.key.toLowerCase() == 'escape') {
                    // close language picker on 'Esc'
                    pickerArray.forEach(function (element) {
                        moveFocusToPickerTrigger(element); // if focus is within dropdown, move it to dropdown trigger
                        toggleLanguagePicker(element, 'false'); // close dropdown
                    });
                }
            });
            // close language picker when clicking outside it
            window.addEventListener('click', function (event) {
                pickerArray.forEach(function (element) {
                    checkLanguagePickerClick(element, event.target);
                });
            });
        }
    }());*/

    $(document).on('click', '[data-dismiss="modal"]', function(event){
        let bsModalId = $(event.currentTarget).parent().parent().parent().parent().attr("id");
        $(`#${bsModalId}`).modal('hide');
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
<script src='{{ asset("xPlugins/jquery-ui/jquery-ui.js") }}'></script>
<script src='{{ asset("xPlugins/angular-ui/sortable.js") }}'></script>
<script src='{{ asset("js/ng/app.js".'?t='.time()) }}'></script>
<script src='{{ asset("js/ng/controllers.js".'?t='.time()) }}' ></script>
<script src='{{ asset("js/ng/services.js".'?t='.time()) }}' ></script>

@yield('page_script')

@yield('script')
