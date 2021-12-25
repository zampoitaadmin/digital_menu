<header>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xl-3">
                <div class="logo">
                    <a href="/" title="logo">
                        <img src="assets/images/logo.png" width="160">
                    </a>
                </div>
                <div class="mob-menu">
                     <span>
                        <i class="fa fa-bars"></i>
                     </span>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-lg-12 col-xl-9">
                <div class="main-menu">
                    <ul>
                        <li style="margin: 0px;">
                            <!-- <div class="js">
                                <div class="language-picker js-language-picker" data-trigger-class="btn btn--subtle">
                                    <form action="" class="language-picker__form">
                                        <label for="language-picker-select"></label>
                                        <select name="language-picker-select" id="language-picker-select">
                                            <option lang="en" value="english" selected>English</option>
                                            <option lang="de" value="deutsch">Spanish</option>
                                        </select>
                                    </form>
                                </div>
                            </div> -->
                            <div class="dropdown">
                                <button class="btn text-white dropdown-toggle bg-none" type="button"  data-toggle="dropdown">
                                    @if(Session::has('locale'))
                                        @if( Session('locale') == "en" )
                                            <img src="{{ url('assets/images/united-kingdom.png') }}" class="langFlag"> English
                                        @elseif( Session('locale') == "es" )
                                            <img src="{{ url('assets/images/spain.png') }}" class="langFlag"> Spanish
                                        @endif
                                    @else
                                        @if( Config::get('app.locale') == "en" )
                                            <img src="{{ url('assets/images/united-kingdom.png') }}" class="langFlag"> English
                                        @elseif( Config::get('app.locale') == "es" )
                                            <img src="{{ url('assets/images/spain.png') }}" class="langFlag"> Spanish
                                        @endif
                                    @endif
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('change-lang', ['lang' => 'en']) }}"> <img src="{{ url('assets/images/united-kingdom.png') }}" class="langFlag"> English</a>
                                    <a class="dropdown-item" href="{{ route('change-lang', ['lang' => 'es']) }}"> <img src="{{ url('assets/images/spain.png') }}" class="langFlag"> Spanish</a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="dropdown">
                                <button class="btn text-white dropdown-toggle bg-none" type="button"  data-toggle="dropdown">
                                <i class="fas fa-sign-in-alt"></i> Eateries
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Edit Profile</a>
                                    <a class="dropdown-item" href="#">Account Info</a>
                                    <a class="dropdown-item" href="#">Change Password</a>
                                    <a class="dropdown-item" href="#">Logout</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                    {{--
                    @if(auth()->user())
                        <ul class="nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                                    {{ auth()->user()->first_name ?? '' }} {{ auth()->user()->last_name ?? '' }}
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                                    <a class="dropdown-item" href="#">Link 2</a>
                                    <a class="dropdown-item" href="#">Link 3</a>
                                </div>
                            </li>
                        </ul>
                    @else
                        <ul class="right-nav">
                            <li class="active"><a href="#">Client login</a> </li>
                            <li> <a href="#">Signup</a> </li>
                        </ul>
                    @endif
                    --}}
                </div>
            </div>
        </div>
    </div>
</header>

