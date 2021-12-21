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
                    <ul class="nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                                Dropdown link
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Link 1</a>
                                <a class="dropdown-item" href="#">Link 2</a>
                                <a class="dropdown-item" href="#">Link 3</a>
                            </div>
                        </li>
                    </ul>


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

                </div>
            </div>
        </div>
    </div>
</header>

