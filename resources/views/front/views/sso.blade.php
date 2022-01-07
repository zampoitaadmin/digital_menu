@extends('front.layouts.layout')
@section('title')
    {{ __('message_lang.connecting_text_1') }}
@endsection

@section('meta')
    <meta name="title" content="LV MAP">
    <meta name="description" content="LV MAP DESCRIPTION">
@endsection
@section('styles')
@endsection

@section('content')
    <div id="main-content" class="blog-page">
        <div class="container">
            <ui-view></ui-view>
            <script type="text/ng-template" id="sso.html">
                <div class="row">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 ng-bind-html="message"></h3>
                        </div>
                    </div>
                </div>
            </script>
        </div>
    </div>
@endsection

@section('page_script')
    <script>
        @if(Session::has('message'))
        toastr.error('{{ Session::get('message') }}', 'Error');
        @endif
    </script>
@endsection
@section('script')
    <script type="text/javascript">
        let connectingText2 = "{{ __('message_lang.connecting_text_2') }}";
    </script>
    <script src='{{ asset("assets/ng/sso/index.js?t=".time()) }}'></script>
    <script src='{{ asset("assets/ng/sso/SsoController.js?t=".time()) }}'></script>
@endsection
