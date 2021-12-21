@extends('front.layouts.layout')

@section('title')
    About Us | Slate Sign
@endsection

@section('meta')
<meta name="description"  content="" />
@endsection

@section('styles')
@endsection

@section('content')
    <div id="main">
        <div id="container" class="about">
            <h1 class="entry-title">Get To Know More...</h1>
            <div id="content">
                <div id="post-11" class="post-11 page type-page status-publish hentry">
                    <div class="entry-content">
                        <div id="primary" class="widget-area desktop">
                            <ul class="xoxo">
                                <li id="nav_menu-3" class="widget-container widget_nav_menu">
                                    <div class="menu-faqs-container">
                                        @include('front.views.faqs.faq_sidebar')
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="full">
                            <h2>About Us</h2>
                            <p>House Signs is located in the beautiful valleys of South Wales. We specialise in the use of slate to create beautiful and durable slate signs which overflow with character and style. We only use the finest, traditional blue-black Welsh Slate (which we mine and collect from the quarries of North Wales) for all of our fabulous Slate Signs.</p>
                            <p>We have a large design department within the company which assists and advises our customers with their signs, plaques etc. The department also provides a Free Proof service where we can email, post or fax proofs prior to ordering. This service has proven to be an invaluable aid to our customers. Please contact us if you would like to receive a proof or discuss your ideas with us.</p>
                            <p>Each piece we make is hand-crafted on site, which allows us to provide a totally bespoke service. We can customise the size, font type, font colour, add motifs and more to suit your exact needs. Contact us with your thoughts and we will incorporate them into your item.</p>
                            <p>Today, House Signs retains a strong position as the recognised market leader in their field, putting the focus on quality, performance, reliability and customer service.</p>
                            <p>House Signs thank you for visiting our website.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
