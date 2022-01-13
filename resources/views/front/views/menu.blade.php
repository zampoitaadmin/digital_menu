@extends('front.layouts.layout-menu')
@section('title')
    Zampoita
@endsection
@section('meta')
    <meta name="title" content="LV MAP">
    <meta name="description" content="LV MAP DESCRIPTION">
@endsection
@section('styles')
@endsection
@section('content')
<section id="product_details" data-aos="fade-down" data-aos-delay="300">
    <div class="container">
        <ui-view></ui-view>
        <script type="text/ng-template" id="menu.html">
            <div class="row" >
                <div class="col-md-3">
                    <img class="img-responsive main-product_img" src="https://images.pexels.com/photos/1279330/pexels-photo-1279330.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260">
                </div>
                <div class="col-md-6">
                    <h1 class="title text-white wack_waffle_pizza">Wack Waffle Pizza</h1>
                    <h5 class="text-white wack_waffle_pizza_h3">Lorem Lipsunm Ipsum</h5>
                    <div id="accordion">
                        <div class="card  pb-3">
                            <div class="card-header p-0" id="headingTwo" >
                                <button class="btn btn-link  p-0 collapsed text-white" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Lorem ipsum dolor sit amet, consectetur adipisicing...
                                <i class="fa fa-chevron-down down_arrow" aria-hidden="true"></i>
                                </button>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                <div class="card-body pl-0">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex text-white">
                        <div class="pt-1 pb-1 pr-3 text-center rating_box" >
                            <svg id="Capa_1" fill="#fff" enable-background="new 0 0 512 512" height="25" viewBox="0 0 512 512" width="25">
                                <g>
                                    <path d="m408.132 256 69.571-120.5c1.34-2.32 1.34-5.18 0-7.5s-3.815-3.75-6.495-3.75h-139.142l-69.571-120.5c-1.34-2.32-3.815-3.75-6.495-3.75s-5.155 1.43-6.495 3.75l-69.571 120.5h-139.142c-2.68 0-5.155 1.43-6.495 3.75s-1.34 5.18 0 7.5l69.571 120.5-69.571 120.5c-1.34 2.32-1.34 5.18 0 7.5s3.815 3.75 6.495 3.75h113.472c4.142 0 7.5-3.358 7.5-7.5s-3.358-7.5-7.5-7.5h-100.481l58.745-101.75 17.321 30-17.609 30.5c-1.34 2.32-1.34 5.18 0 7.5s3.815 3.75 6.495 3.75h170.03l-17.321 30h-87.18c-2.68 0-5.155 1.43-6.495 3.75s-1.34 5.18 0 7.5l71.736 124.25c1.34 2.32 3.815 3.75 6.495 3.75s5.155-1.43 6.495-3.75l69.571-120.5h139.142c2.68 0 5.155-1.43 6.495-3.75s1.34-5.18 0-7.5zm-8.66-15-17.321-30 17.609-30.5c1.34-2.32 1.34-5.18 0-7.5s-3.815-3.75-6.495-3.75h-170.03l17.321-30h217.661zm-25.981-45-6.784-11.75h13.568zm-124.275-71.75 6.784-11.75 6.784 11.75zm6.784-101.75 58.746 101.75h-34.641l-17.609-30.5c-1.341-2.32-3.816-3.75-6.496-3.75s-5.155 1.43-6.495 3.75l-85.015 147.25-17.32-30zm-124.275 161.75h13.568l-6.784 11.75zm39.549-45-17.321 30h-35.219c-2.68 0-5.155 1.43-6.495 3.75s-1.34 5.18 0 7.5l85.015 147.25h-34.641l-108.83-188.5zm-32.765 176.75 6.784 11.75h-13.568zm76.066 11.75-41.425-71.75 41.425-71.75h82.85l41.425 71.75-41.425 71.75zm48.209 60-6.784 11.75-6.784-11.75zm-6.784 101.75-58.746-101.75h34.641l17.609 30.5c1.34 2.32 3.815 3.75 6.495 3.75s5.155-1.43 6.495-3.75l85.016-147.25 17.32 30zm124.275-161.75h-13.568l6.784-11.75zm-39.549 45 17.321-30h35.219c2.68 0 5.155-1.43 6.495-3.75s1.34-5.18 0-7.5l-85.015-147.25h34.642l108.831 188.5z"/>
                                </g>
                            </svg>
                            <br>Too Few Ratings
                        </div>
                        <div class="pt-1 pb-1 pl-3 pr-3 text-center delivery-time-box"><strong>29 mins</strong><br>Delivery Time</div>
                        <div class="pt-1 pb-1 pl-3 pr-3 text-center " ><strong>$150</strong><br>Cost for two</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="listing listing-danger mt-4">
                        <!-- <div class="shape">
                            <div class="shape-text">hot</div>
                            </div> -->
                        <div class="listing-content text-white">
                            <h3 class="text-center font-weight-bold">Offers</h3>
                            <div class="d-flex text-white">
                                <div class="pt-1 pb-1 mr-2">
                                    <svg id="Capa_1" enable-background="new 0 0 512 512" fill="#fff" height="15" viewBox="0 0 512 512" width="15" xmlns="http://www.w3.org/2000/svg">
                                        <g>
                                            <path d="m509 186-26.852-35.802-14.93 104.512c-1.367 9.574-5.888 18.614-12.729 25.454l-183.847 183.848c-16.036 16.038-37.382 24.871-60.104 24.871-6.791 0-13.454-.806-19.894-2.34 9.78 15.29 26.897 25.457 46.356 25.457h220c30.327 0 55-24.673 55-55v-262c0-3.245-1.053-6.403-3-9z"/>
                                            <circle cx="309.533" cy="234.203" r="15"/>
                                            <circle cx="139.827" cy="234.203" r="15"/>
                                            <path d="m249.429 442.799 183.848-183.848c2.295-2.295 3.784-5.272 4.243-8.485l21.214-148.493c.667-4.674-.904-9.39-4.243-12.728l-31.82-31.82-42.426 42.427 10.607 10.607c5.858 5.857 5.858 15.355 0 21.213-2.929 2.929-6.768 4.394-10.606 4.394s-7.678-1.465-10.606-4.394l-42.427-42.427c-5.858-5.857-5.858-15.355 0-21.213 5.857-5.857 15.355-5.857 21.213 0l10.607 10.607 42.426-42.427-31.82-31.82c-3.338-3.339-8.054-4.905-12.728-4.243l-148.494 21.214c-3.213.459-6.19 1.948-8.485 4.243l-183.848 183.848c-21.445 21.444-21.445 56.338 0 77.782l155.563 155.563c10.722 10.723 24.807 16.083 38.891 16.083s28.169-5.36 38.891-16.083zm60.104-253.596c24.813 0 45 20.187 45 45s-20.187 45-45 45-45-20.187-45-45 20.187-45 45-45zm-169.706 90c-24.813 0-45-20.187-45-45s20.187-45 45-45 45 20.187 45 45-20.186 45-45 45zm49.5 76.07c-1.572 0-3.172-.249-4.745-.773-7.859-2.62-12.106-11.114-9.487-18.974l70.71-212.133c2.62-7.859 11.115-12.106 18.974-9.487 7.859 2.62 12.106 11.114 9.487 18.974l-70.71 212.133c-2.096 6.284-7.949 10.26-14.229 10.26z"/>
                                            <path d="m454.489 25.606c5.858-5.857 5.858-15.355 0-21.213-5.857-5.857-15.355-5.857-21.213 0l-31.819 31.82 21.213 21.213z"/>
                                        </g>
                                    </svg>
                                </div>
                                <div class="pt-1 pb-1  offer-p">60% off up to ₹120 | Use code
                                    DEAL60
                                </div>
                            </div>
                            <div class="d-flex text-white">
                                <div class="pt-1 pb-1 mr-2">
                                    <svg id="Layer_1" enable-background="new 0 0 512.654 512.654" fill="#fff" height="15" viewBox="0 0 512.654 512.654" width="15" xmlns="http://www.w3.org/2000/svg">
                                        <g>
                                            <path d="m511.647 358.613-.303-.524c-22.892-39.644-73.111-53.724-114.326-32.058l-63.677 33.063c.266 2.751.517 5.776.517 7.202 0 23.259-13.015 45.802-33.158 57.432-9.099 5.253-19.018 7.874-29.109 7.874-10.84 0-21.879-3.022-32.325-9.054-.184-.106-.365-.216-.544-.33l-54.686-34.743c-6.992-4.442-9.06-13.712-4.617-20.705 4.443-6.992 13.713-9.059 20.705-4.617l54.4 34.562c13.712 7.804 24.515 4.878 31.177 1.032 8.327-4.807 14.544-13.362 16.999-22.742l-.02.011c2.476-13.363-2.199-27.889-17.863-36.932l-61.896-35.735c-6.02-4.378-13.413-6.969-21.382-6.969h-82.516v141.722h9.573l118.794 68.726c7.442 4.305 15.159 6.463 22.605 6.463 6.992 0 13.747-1.902 19.813-5.715l219.337-137.859c3.415-2.148 4.521-6.611 2.502-10.104z"/>
                                            <path d="m74.021 249.207h-59.021c-8.284 0-15 6.716-15 15v208.873c0 8.284 6.716 15 15 15h59.021c8.284 0 15-6.716 15-15v-208.873c0-8.284-6.715-15-15-15z"/>
                                            <path d="m227.848 167.504c1.668 1.58 4.164 3.945 4.772 5.059.452 2.089-.451 6.401-1.25 10.217-1.719 8.202-4.071 19.434 1.784 30.236 5.918 10.92 17.085 13.592 24.474 15.36 2.235.535 5.58 1.335 6.664 1.995 1.436 1.584 2.81 5.769 4.024 9.474 2.613 7.961 6.191 18.865 16.664 25.292 10.585 6.497 21.591 3.228 28.875 1.065 2.202-.654 5.53-1.636 6.768-1.604 2.035.653 5.317 3.591 8.223 6.191 6.244 5.589 14.795 13.243 27.078 13.573.242.006.482.01.722.01 12.001 0 19.693-8.118 24.816-13.525 1.581-1.668 3.946-4.165 5.06-4.773 2.09-.451 6.4.451 10.218 1.251 8.2 1.717 19.434 4.07 30.235-1.785 10.92-5.919 13.592-17.085 15.36-24.474.535-2.235 1.335-5.579 1.995-6.663 1.584-1.436 5.77-2.81 9.474-4.025 7.961-2.613 18.864-6.191 25.293-16.664 6.497-10.585 3.228-21.592 1.064-28.875-.654-2.203-1.634-5.5-1.604-6.769.653-2.035 3.591-5.317 6.191-8.223 5.589-6.244 13.242-14.795 13.572-27.078.334-12.416-8-20.313-13.515-25.539-1.668-1.581-4.164-3.946-4.772-5.06-.452-2.089.45-6.402 1.25-10.218 1.718-8.201 4.07-19.433-1.785-30.236-5.918-10.916-17.083-13.587-24.472-15.356-2.235-.535-5.579-1.335-6.663-1.996-1.437-1.583-2.81-5.769-4.025-9.473-2.613-7.961-6.192-18.865-16.664-25.292-10.585-6.498-21.593-3.229-28.875-1.065-2.202.654-5.503 1.658-6.769 1.604-2.035-.654-5.317-3.591-8.223-6.191-6.243-5.589-14.794-13.243-27.077-13.573 0 0 0 0-.001 0-12.418-.329-20.312 8-25.538 13.515-1.58 1.668-3.946 4.165-5.06 4.773-2.09.45-6.403-.452-10.217-1.251-8.203-1.718-19.434-4.07-30.236 1.785-10.92 5.919-13.592 17.085-15.359 24.474-.535 2.235-1.336 5.58-1.996 6.664-1.583 1.436-5.769 2.81-9.474 4.025-7.961 2.613-18.865 6.192-25.292 16.664-6.497 10.585-3.229 21.592-1.064 28.875.653 2.203 1.633 5.5 1.604 6.769-.654 2.035-3.592 5.317-6.191 8.221-5.589 6.244-13.243 14.795-13.573 27.078-.335 12.415 7.999 20.312 13.515 25.538zm175.11-6.124c7.175 4.142 9.633 13.316 5.49 20.49-4.142 7.175-13.316 9.632-20.49 5.49-7.175-4.142-9.633-13.316-5.49-20.49 4.142-7.174 13.316-9.632 20.49-5.49zm-36.621-66.349c4.143-7.175 13.315-9.634 20.49-5.49 7.174 4.142 9.633 13.316 5.49 20.49l-46 79.674c-2.778 4.812-7.82 7.502-13.004 7.502-2.545 0-5.124-.648-7.486-2.012-7.174-4.142-9.633-13.316-5.49-20.49zm-59.132 2.334c4.142-7.174 13.316-9.632 20.49-5.49 7.175 4.142 9.633 13.316 5.49 20.49-4.142 7.174-13.316 9.632-20.49 5.491-7.174-4.142-9.632-13.316-5.49-20.491z"/>
                                        </g>
                                    </svg>
                                </div>
                                <div class="pt-1 pb-1  offer-p">30% off up to ₹150 on orders
                                    above ₹400 | Use code JUMBO
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </script>
    </div>
</section>
<section id="search" class="sticky-top" data-aos="fade-down" data-aos-delay="350">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <!-- Actual search box -->
                <div class=" has-search">
                    <!-- <span class="fa fa-search form-control-feedback" aria-hidden="true"></span> -->
                    <input type="text" class="form-control" placeholder="Search">
                </div>
            </div>
            <div class="col-md-8">
                <h6 class="title m-0 pt-3 pb-3 text-right"><a href="#" class="text-white allergy_text" type="button" class="btn btn-light border rounded-pill shadow-sm mb-1" data-toggle="modal" data-target="#fullscreen_modal">CLICK HERE FOR ALLERGY INFORMATION</a></h6>
            </div>
        </div>
    </div>
</section>
<section style="background-image: url({{ asset('assets/front-menu/images/bg.png') }}); background-size: contain;" data-aos="fade-up" data-aos-delay="350">
    <div class="container" >
        <div class="row">
            <div class="col-md-3 mb-3 p-3 tab-panel sticky-top" style="top: 50px!important;">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a class="nav-link active"  href="#recommended">Recommended</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#exotic_pocket">Exotic Pocket Waffles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#waffle_pizza">Waffle Pizza</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#brownies">Brownies</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#mini_pancakes">Mini Pancakes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#beverages_milkshakes">Beverages & Milkshakes (250 ML)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#combos">Combos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#special_price">Special Price Dessert From Wack</a>
                    </li>
                </ul>
            </div>
            <!-- <div class="clearfix"></div> -->
            <!-- /.col-md-4 -->
            <div class="col-md-9 p-3 tab-content" style="border-left: 1px solid #A1A1A1;">
                <div id="recommended" data-toggle="pill"  role="tabpanel" aria-labelledby="home-tab">
                    <h2 >Recommended</h2>
                    <p class="item-list">ITEM 5</p>
                    <div class="row product_bottom_border">
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/406152/pexels-photo-406152.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <!-- Add icon library -->
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 789</a>
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border" >
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/406152/pexels-photo-406152.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 432</a>
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border" >
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/406152/pexels-photo-406152.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 234</a>
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border" >
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/406152/pexels-photo-406152.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 321</a>
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border" >
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/406152/pexels-photo-406152.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 123</a>
                        </div>
                    </div>
                </div>
                <div id="exotic_pocket" data-toggle="pill"  role="tabpanel" aria-labelledby="profile-tab">
                    <h2 class="mt-3">Exotic Pocket Waffles</h2>
                    <p class="item-list">ITEM 5</p>
                    <div class="row product_bottom_border" >
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/3186654/pexels-photo-3186654.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 155</a>
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border" >
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/3186654/pexels-photo-3186654.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 476</a>
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border">
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/3186654/pexels-photo-3186654.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 567</a>
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border">
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/3186654/pexels-photo-3186654.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 134</a>
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border">
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/3186654/pexels-photo-3186654.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 477</a>
                        </div>
                    </div>
                </div>
                <div id="waffle_pizza" role="tabpanel" aria-labelledby="contact-tab">
                    <h2 class="mt-3">Waffle Pizza</h2>
                    <p class="item-list">ITEM 5</p>
                    <div class="row product_bottom_border">
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 344</a>
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border" >
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 259</a>
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border">
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 344</a>
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border">
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 244</a>
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border">
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 255</a>
                        </div>
                    </div>
                </div>
                <div id="brownies"  role="tabpanel" aria-labelledby="home-tab">
                    <h2 class="mt-3">Brownies</h2>
                    <p class="item-list">ITEM 5</p>
                    <div class="row product_bottom_border">
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 344</a>
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border" >
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 259</a>
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border">
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 344</a>
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border">
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 244</a>
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border">
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 255</a>
                        </div>
                    </div>
                </div>
                <div id="mini_pancakes" role="tabpanel" aria-labelledby="home-tab">
                    <h2 class="mt-3">Mini Pancakes</h2>
                    <p class="item-list">ITEM 5</p>
                    <div class="row product_bottom_border">
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 344</a>
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border" >
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 259</a>
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border">
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 344</a>
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border">
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 244</a>
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border">
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 255</a>   
                        </div>
                    </div>
                </div>
                <div id="beverages_milkshakes"  role="tabpanel" aria-labelledby="home-tab">
                    <h2 class="mt-3">Beverages & Milkshakes (250 ML)</h2>
                    <p class="item-list">ITEM 5</p>
                    <div class="row product_bottom_border">
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 344</a> 
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border" >
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 259</a>
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border">
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 344</a>   
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border">
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 244</a> 
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border">
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 255</a>   
                        </div>
                    </div>
                </div>
                <div id="combos"  role="tabpanel" aria-labelledby="home-tab">
                    <h2 class="mt-3">Combos</h2>
                    <p class="item-list">ITEM 5</p>
                    <div class="row product_bottom_border">
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 344</a> 
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border" >
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 259</a> 
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border">
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 344</a>
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border">
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 244</a> 
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border">
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 255</a>
                        </div>
                    </div>
                </div>
                <div id="special_price"  role="tabpanel" aria-labelledby="home-tab">
                    <h2 class="mt-3">Special Price Dessert From Wack Waffles</h2>
                    <p class="item-list">ITEM 5</p>
                    <div class="row product_bottom_border">
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 344</a>
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border" >
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 259</a>
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border">
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 344</a>
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border">
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal"src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 244</a>
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border">
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 255</a>
                        </div>
                    </div>
                </div>
                <div id="price_combos" role="tabpanel" aria-labelledby="home-tab">
                    <h2 class="mt-3">Special Price Combos From Wack</h2>
                    <p class="item-list">ITEM 5</p>
                    <div class="row product_bottom_border">
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 344</a>
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border" >
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 259</a>
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border">
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 344</a>
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border">
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal"src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 244</a>
                        </div>
                    </div>
                    <div class="row mt-4 product_bottom_border">
                        <div class="col-sm-4">
                            <img data-toggle="modal" data-target="#regular_modal" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive mb-3">
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title" data-toggle="modal" data-target="#regular_modal">Lorem ipsum dolor sit amet</h4>
                            <img src="{{ asset('assets/front-menu/images/1.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/2.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/3.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/4.svg') }}" class="for-svg_height" >
                            <img src="{{ asset('assets/front-menu/images/5.svg') }}" class="for-svg_height" >
                            <p class="card-text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <a href="#" class="btn btn-primary pull-right btn-md">$ 255</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-md-8 -->
        </div>
    </div>
</section>
@endsection
@section('page_script')
    <script>
        @if(Session::has('message'))
        toastr.error('{{ Session::get('message') }}', 'Error');
        @endif
    </script>
@endsection
@section('script')
    <script src='{{ asset("assets/ng/menu/index.js?t=".time()) }}'></script>
    <script src='{{ asset("assets/ng/menu/menuCtrl.js?t=".time()) }}'></script>
    <script src='{{ asset("assets/ng/menu/servicesMenu.js?t=".time()) }}'></script>
@endsection