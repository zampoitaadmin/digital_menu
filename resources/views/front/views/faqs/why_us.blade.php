@extends('front.layouts.layout')

@section('title')
    Why Use Us? | Slate Sign
@endsection

@section('meta')
<meta name="description"  content="We specialise in all areas of Welsh Slate, the worlds best slate. Let the Industry experts produce your fabulous new slate sign. Fifteen fantastic reasons to" />
@endsection

@section('styles')
@endsection

@section('content')
    <div id="main">
        <div id="container" class="about">
            <h1 class="entry-title">WHY USE HOUSE SIGNS?...</h1>
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
							<h2>Why Use Us?</h2>
							<p class="intro">We specialise in all areas of Welsh Slate, the worlds best slate. Let the Industry experts produce your fabulous new slate sign. Fifteen fantastic reasons to order with us today…</p>
                            <ul>
                                <li>100% Welsh Blue-Black Slate.</li>
                                <li>Sourced and manufactured by hand in the UK.</li>
                                <li>Accurate on-line proof creator.</li>
                                <li>Delivery within 7-10 Working Days</li>
                                <li>Choice of edge types including Classic and Rustic.</li>
                                <li>All signs approx 20mm thick.</li>
                                <li>Doesn’t fade like other imported slate.</li>
                                <li>Motif’s and bespoke requests available.</li>
                                <li>We deeply engrave and enamel fill all of our signs. (Printed signs fade and wear)</li>
                                <li>Secret fixings.</li>
                                <li>Easy ordering system.</li>
                                <li>Range of sizes.</li>
                                <li>Choice of infill colours, including 24ct Gold.</li>
                                <li>Range of font types, or request your own.</li>
                                <li class="last">We produce our signs to last a lifetime and beyond.</li>
                            </ul>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
