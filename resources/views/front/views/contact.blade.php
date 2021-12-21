@extends('front.layouts.layout')

@section('title')
    Contact | Slate Sign
@endsection

@section('meta')
<meta name="description"  content="Do you have a question or just want to tell us how much you love your new Slate Sign? Whatever the reason, we love hearing from you. So call us now or fill in" />
@endsection

@section('styles')
@endsection

@section('content')
    <script src="{{ URL::to('/') }}/ex_plugins/jquery-validation-1.19.1/dist/jquery.validate.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ URL::to('/') }}/ex_plugins/toastr/css/toastr.min.css">
    <script src="{{ URL::to('/') }}/ex_plugins/toastr/js/toastr.min.js"></script>
    @if (session('success'))
        <script type="text/javascript">
            toastr.success("{{ session('success') }}", "Success");
        </script>
    @endif
    @if (session('error'))
        <script type="text/javascript">
            toastr.error("{{ session('error') }}", "Error");
        </script>
    @endif
    <div id="main" class="contact">
        <div id="container">
            <h1 class="entry-title">Contact Us, <span>It's Great To Meet You...</span></h1>
            <div id="content">
                <div id="post-15" class="post-15 page type-page status-publish hentry">
                    <div class="entry-content">
                        <div class="left">
                            <h2>Contact Details...</h2>
                            <p>Do you have a question or just want to tell us how much you love your new Slate Sign? Whatever the reason, we love hearing from you. So call us now or fill in the quick form opposite to get in touch.</p>
                            <p>We welcome your comments, thoughts, ideas, questions and feedback! Please use any of the methods displayed on this page to contact us.</p>
                            <h3>Live Chat Facility :</h3>
                            <p>Please click the top right chat facility where we will answer any queries you have.</p>
                            <h3>Email :</h3>
                            <p><a href="mailto:info@slatesign.co.uk">info@slatesign.co.uk</a></p>
                            <h3>Address :</h3>
                            <p class="last">House Signs<br>
                                Bluetts,<br>
                                Peterston Super Ely,<br>
                                Cardiff, CF5 6NE.
                            </p>
                        </div>
                        <div class="mid">
                            <div class="item fixings">
                                <a href="{{ route('secret-fixings-gallery') }}">
                                    <span class="link"></span>
                                </a>
                            </div>
                            <div class="item faq">
                                <a href="{{ route('sign-faqs') }}">
                                    <span class="link"></span>
                                </a>
                            </div>
                            <div class="item proof">
                                <a href="{{ route('order') }}">
                                    <span class="link"></span>
                                </a>
                            </div>
                        </div>
                        <div class="right">
                            <div role="form" class="wpcf7" id="wpcf7-f580-p15-o1" lang="en-US" dir="ltr">
                                <div class="screen-reader-response"></div>
                                <form action="{{ route('contact-us') }}" method="post" class="wpcf7-form" novalidate="novalidate">
                                    @csrf
                                    @honeypot
                                    <div class="contact-form-bg">
                                        <h2>Contact Form...</h2>
                                        <p>
                                            <span class="wpcf7-form-control-wrap your-name">
                                                <input type="text" name="your_name" value="{{ old('your_name') }}" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required @error('your_name') error @enderror" aria-required="true" aria-invalid="false" placeholder="Your Name">
                                            </span> 
                                        </p>
                                        <p>
                                            <span class="wpcf7-form-control-wrap your-email">
                                                <input type="email" name="your_email" value="{{ old('your_email') }}" size="40" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email @error('your_email') error @enderror" aria-required="true" aria-invalid="false" placeholder="Your Email">
                                            </span> 
                                        </p>
                                        <p>
                                            <span class="wpcf7-form-control-wrap your-tel">
                                                <input type="tel" name="your_number" value="{{ old('your_number') }}" size="40" class="wpcf7-form-control wpcf7-text wpcf7-tel wpcf7-validates-as-required wpcf7-validates-as-tel @error('your_number') error @enderror" aria-required="true" aria-invalid="false" placeholder="Your Contact Number">
                                            </span> 
                                        </p>
                                        <p>
                                            <span class="wpcf7-form-control-wrap your-message">
                                                <textarea name="your_message" cols="40" rows="10" class="wpcf7-form-control wpcf7-textarea wpcf7-validates-as-required @error('your_message') error @enderror" aria-required="true" aria-invalid="false" placeholder="Your Message">{{ old('your_message') }}</textarea>
                                            </span> 
                                        </p>
                                    </div>
                                    <div class="contact-button">
                                        <input type="submit" value="&nbsp;" class="wpcf7-form-control wpcf7-submit">
                                        <span class="ajax-loader"></span>
                                        <p>Submit Contact Form
                                            <span class="chev">&gt;</span>
                                        </p>
                                    </div>
                                    <div class="wpcf7-response-output wpcf7-display-none"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
