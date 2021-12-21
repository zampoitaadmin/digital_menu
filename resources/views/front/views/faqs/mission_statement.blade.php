@extends('front.layouts.layout')

@section('title')
    Mission Statement | Slate Sign
@endsection

@section('meta')
<meta name="description"  content="House Signs&#039; principle objective is to be the Number One Slate Products Maker in the UK. We aim to provide the highest quality service to clients by identifying" />
@endsection

@section('styles')
@endsection

@section('content')
    <div id="main">
        <div id="container" class="about">
            <h1 class="entry-title">OUR MISSION STATEMENT...</h1>
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
							<h2>Mission Statement</h2>
							<p>House Signs’ principle objective is to be the Number One Slate Products Maker in the UK. We aim to provide the highest quality service to clients by identifying their needs, then providing the most appropriate solutions.</p>
                            <p>In order to achieve this goal, we will strive to continually develop our most valuable asset – our staff within the Company. Training and development will therefore remain a high priority at House Signs. We shall also continue to invest in new technology. This will enable all staff to deliver the efficient service promised, thereby securing a prosperous future for the whole team.</p>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
