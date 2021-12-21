@extends('front.layouts.layout')
@section('title')
Map Site
@endsection

@section('meta')
    <meta name="title" content="LV MAP">
    <meta name="description" content="LV MAP DESCRIPTION">
@endsection
@section('styles')
@endsection

@section('content')

    <!-- ====== Hero Start ====== -->
    <section class="ud-hero" id="home">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ud-hero-content wow fadeInUp" data-wow-delay=".2s">
                        <h1 class="ud-hero-title">
                            Open-Source Web Template for SaaS, Startup, Apps, and More
                        </h1>
                        <p class="ud-hero-desc">
                            Multidisciplinary Web Template Built with Your Favourite
                            Technology - HTML Bootstrap, Tailwind and React NextJS.
                        </p>
                        <ul class="ud-hero-buttons">
                            <li>
                                <a href="https://links.uideck.com/play-bootstrap-download" rel="nofollow noopener" target="_blank" class="ud-main-btn ud-white-btn">
                                    Download Now
                                </a>
                            </li>
                            <li>
                                <a href="https://github.com/uideck/play-bootstrap" rel="nofollow noopener" target="_blank" class="ud-main-btn ud-link-btn">
                                    Learn More <i class="lni lni-arrow-right"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div
                            class="ud-hero-brands-wrapper wow fadeInUp"
                            data-wow-delay=".3s"
                            >
                        <img src="assets/images/hero/brand.svg" alt="brand" />
                    </div>
                    {{--<div class="ud-hero-image wow fadeInUp" data-wow-delay=".25s">
                        <img src="assets/images/hero/hero-image.svg" alt="hero-image" />
                        <img
                                src="assets/images/hero/dotted-shape.svg"
                                alt="shape"
                                class="shape shape-1"
                                />
                        <img
                                src="assets/images/hero/dotted-shape.svg"
                                alt="shape"
                                class="shape shape-2"
                                />
                    </div>--}}
                </div>
            </div>
        </div>
    </section>
    <!-- ====== Hero End ====== -->
    <!-- ====== Features Start ====== -->
    <section id="features" class="ud-features">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ud-section-title">
                        <span>Features</span>
                        <h2>Main Features of Play</h2>
                        <p>
                            There are many variations of passages of Lorem Ipsum available
                            but the majority have suffered alteration in some form.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-sm-6">
                    <div class="ud-single-feature wow fadeInUp" data-wow-delay=".1s">
                        <div class="ud-feature-icon">
                            <i class="lni lni-gift"></i>
                        </div>
                        <div class="ud-feature-content">
                            <h3 class="ud-feature-title">Free and Open-Source</h3>
                            <p class="ud-feature-desc">
                                Lorem Ipsum is simply dummy text of the printing and industry.
                            </p>
                            <a href="javascript:void(0)" class="ud-feature-link">
                                Learn More
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-sm-6">
                    <div class="ud-single-feature wow fadeInUp" data-wow-delay=".15s">
                        <div class="ud-feature-icon">
                            <i class="lni lni-move"></i>
                        </div>
                        <div class="ud-feature-content">
                            <h3 class="ud-feature-title">Multipurpose Template</h3>
                            <p class="ud-feature-desc">
                                Lorem Ipsum is simply dummy text of the printing and industry.
                            </p>
                            <a href="javascript:void(0)" class="ud-feature-link">
                                Learn More
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-sm-6">
                    <div class="ud-single-feature wow fadeInUp" data-wow-delay=".2s">
                        <div class="ud-feature-icon">
                            <i class="lni lni-layout"></i>
                        </div>
                        <div class="ud-feature-content">
                            <h3 class="ud-feature-title">High-quality Design</h3>
                            <p class="ud-feature-desc">
                                Lorem Ipsum is simply dummy text of the printing and industry.
                            </p>
                            <a href="javascript:void(0)" class="ud-feature-link">
                                Learn More
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-sm-6">
                    <div class="ud-single-feature wow fadeInUp" data-wow-delay=".25s">
                        <div class="ud-feature-icon">
                            <i class="lni lni-layers"></i>
                        </div>
                        <div class="ud-feature-content">
                            <h3 class="ud-feature-title">All Essential Elements</h3>
                            <p class="ud-feature-desc">
                                Lorem Ipsum is simply dummy text of the printing and industry.
                            </p>
                            <a href="javascript:void(0)" class="ud-feature-link">
                                Learn More
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ====== Features End ====== -->
    <!-- ====== About Start ====== -->
    <section id="about" class="ud-about">
        <div class="container">
            <div class="ud-about-wrapper wow fadeInUp" data-wow-delay=".2s">
                <div class="ud-about-content-wrapper">
                    <div class="ud-about-content">
                        <span class="tag">About Us</span>
                        <h2>Brilliant Toolkit to Build Nextgen Website Faster.</h2>
                        <p>
                            The main ‘thrust’ is to focus on educating attendees on how to
                            best protect highly vulnerable business applications with
                            interactive panel discussions and roundtables led by subject
                            matter experts.
                        </p>

                        <p>
                            The main ‘thrust’ is to focus on educating attendees on how to
                            best protect highly vulnerable business applications with
                            interactive panel.
                        </p>
                        <a href="javascript:void(0)" class="ud-main-btn">Learn More</a>
                    </div>
                </div>
                <div class="ud-about-image">
                    <img src="assets/images/about/about-image.svg" alt="about-image" />
                </div>
            </div>
        </div>
    </section>
    <!-- ====== About End ====== -->
@endsection



@section('scripts')

@endsection

