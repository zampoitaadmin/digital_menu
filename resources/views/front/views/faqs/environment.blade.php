@extends('front.layouts.layout')

@section('title')
    Environment | Slate Sign
@endsection

@section('meta')
<meta name="description"  content="By nature, slate is an eco friendly material and a further reduction in our carbon footprint is enhanced by using local raw materials. We only use the finest" />
@endsection

@section('styles')
@endsection

@section('content')
    <div id="main">
        <div id="container" class="about">
            <h1 class="entry-title">WE TAKE OUR ENVIRONMENTAL FOOTPRINT VERY SERIOUSLY...</h1>
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
							<h2>Environment</h2>
							<p>By nature, slate is an eco friendly material and a further reduction in our carbon footprint is enhanced by using local raw materials. We only use the finest Welsh Slate, which means no import logistics. Not mention that your Slate Sign can last you a lifetime! </p>
                            <p>House Signs Environment Policy is:</p>
                            <p>To demonstrate our aim to implement environmentally responsible policies and practices throughout our operations.</p>
                            <p>To adopt safe operating and storage practices, and have procedures in place to deal with emergencies which safeguard our health and the environment.</p>
                            <p>To monitor legislation and regulations and aim to improve upon any relevant requirements.</p>
                            <p>To improve continuously in the efficient use of resources and energy, and in the minimisation of waste, in every aspect of our business.</p>
                            <p>To ensure that waste is disposed of in the most environmentally responsible manner available, and that only fully authorised waste disposal contractors are used.</p>
                            <p>To periodically review our environmental performance and seek to extend and develop the range of environmental issues on which we can take positive action.</p>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
