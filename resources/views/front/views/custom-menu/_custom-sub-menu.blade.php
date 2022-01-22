<div class="row">
    <div class="col-md-12">
        <ul  class="nav nav-pills nav-justified">
            <li class="active nav-item m-2">
                <a class="nav-link text-white btn_custom_for_only_border forFontFamilyOnly active1" href="custom-menu#categories" data-toggle="tab">{{ __('message_lang.category_text_1') }}</a>
            </li>
            <li class="nav-item m-2">
                <a class="nav-link text-white btn_custom_for_only_border forFontFamilyOnly" href="custom-menu#products" data-toggle="tab">{{ __('message_lang.product_text_1') }}</a>
            </li>
            <li class="nav-item m-2">
                <a class="nav-link btn_custom_for_only_border forFontFamilyOnly text-white" href="custom-menu#branding" data-toggle="tab">{{ __('message_lang.branding_text_1') }}</a>
            </li>
            <li class="nav-item m-2">
                <a class="nav-link btn_custom_for_only_border forFontFamilyOnly text-white"  ng-class="{active: currentTab == 'setting'}" href="custom-menu#setting" data-toggle="tab">{{ __('message_lang.setting_text_1') }} @{{ currentTab }}</a>
            </li>
            <li class="nav-item m-2">
                <a class="nav-link btn_custom_for_only_border forFontFamilyOnly text-white" href="{{ _getMerchantDashboardUrl() }}">{{ __('message_lang.dashboard_text_1') }}</a>
            </li>
            <li class="nav-item m-2">
                <a class="nav-link btn_custom_for_only_border forFontFamilyOnly text-white" href="{{ route('menu', ['slug' => session('login_details')->slug]) }}" target="_blank">{{ __('message_lang.preview_text_1') }}</a>
            </li>
        </ul>
    </div>
</div>
