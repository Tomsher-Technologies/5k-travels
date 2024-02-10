<header class="main_header_arae navbar_color_black">
        <!-- Top Bar -->
        <div class="topbar-area">
            <div class="container">
                @php
                    $settings = getGeneralSettings();
                @endphp
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6">
                        <ul class="topbar-list">
                            <li>
                                <a href="{{ $settings['facebook']['value'] }}" target="_blank"><i class="fab fa-facebook"></i></a>
                                <a href="{{ $settings['twitter']['value'] }}" target="_blank"><i class="fab fa-twitter-square"></i></a>
                                <a href="{{ $settings['instagram']['value'] }}" target="_blank"><i class="fab fa-instagram"></i></a>
                                <a href="{{ $settings['linkedin']['value'] }}" target="_blank"><i class="fab fa-linkedin"></i></a>
                            </li>
                            <li><a href="#!"><span>{{ $settings['site_phone']['value'] }}</span></a></li>
                            <li><a href="#!"><span>{{ $settings['site_mail']['value'] }}</span></a></li>
                        </ul>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <ul class="topbar-others-options">
                            @if(Auth::check())
                                <li><a href="{{ route('web.logout') }}" >Logout</a></li>
                            @else
                                <li><a href="#common_author-forms" data-bs-toggle="modal"
                                    data-bs-target="#common_author-forms">Login</a></li>
                            @endif
                            @if(Route::currentRouteName() != 'flight.booking')
                            <li>
                                <div class="dropdown language-option">
                                    @php
                                        if(Session::has('user_currency') && Session::get('user_currency') == 'USD'){
                                            $currency = 'USD';
                                        }elseif(Session::has('user_currency') && Session::get('user_currency') == 'AFN'){
                                            $currency = 'AFN';
                                        }elseif(Session::has('user_currency') && Session::get('user_currency') == 'IRR'){
                                            $currency = 'IRR';
                                        }elseif(Session::has('user_currency') && Session::get('user_currency') == 'AED'){
                                            $currency = 'AED';
                                        }elseif(Session::has('user_currency') && Session::get('user_currency') == 'INR'){
                                            $currency = 'INR';
                                        }else{
                                            $currency = 'USD';
                                        }

                                    @endphp
                                    <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <span class="lang-name">{{ $currency }}</span>
                                    </button>
                                    
                                    <div class="dropdown-menu language-dropdown-menu" style="min-width: 5rem;text-align: center;">
                                        
                                        <a class="dropdown-item {{ ($currency == 'AED') ? 'selected' : '' }}" href="{{ route('change-currency','AED') }}">AED</a>
                                        <a class="dropdown-item {{ ($currency == 'AFN') ? 'selected' : '' }}" href="{{ route('change-currency','AFN') }}">AFN</a>
                                        <a class="dropdown-item {{ ($currency == 'INR') ? 'selected' : '' }}" href="{{ route('change-currency','INR') }}">INR</a>
                                        <a class="dropdown-item {{ ($currency == 'IRR') ? 'selected' : '' }}" href="{{ route('change-currency','IRR') }}">IRR</a>
                                        <a class="dropdown-item {{ ($currency == 'USD') ? 'selected' : '' }}" href="{{ route('change-currency','USD') }}">USD</a>
                                    </div>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navbar Bar -->
        <div class="navbar-area">
            <div class="main-responsive-nav">
                <div class="container">
                    <div class="main-responsive-menu">
                        <div class="logo">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset('assets/img/logo.png') }}" alt="logo">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-navbar">
                <div class="container">
                    <nav class="navbar navbar-expand-md navbar-light">
                        <a class="navbar-brand" href="{{ route('home') }}">
                            <img class="logo-main" src="{{ asset('assets/img/logo.png') }}" alt="logo">
                            <!-- <img class="logo-white" src="assets/img/logo_white.png" alt="logo"> -->
                        </a>
                        <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                            <ul class="navbar-nav">
                                <li class="nav-item"><a href="#" class="nav-link ">Super Offers</a>
                                <li class="nav-item"><a href="#" class="nav-link ">Top Destinations</a>
                                <li class="nav-item"><a href="#" class="nav-link ">Support</a>
                                <li class="nav-item"><a href="#" class="nav-link ">5K for Business</a>
                                <li class="nav-item"><a href="#" class="nav-link ">Help</a>
                            </ul>
                            </li>


                            </ul>
                            <div class="others-options d-flex align-items-center">
                                @if(Auth::check())
                                    <div class="option-item">
                                        <a href="{{ route('dashboard') }}"  class="btn  btn_navber">My Account</a>
                                    </div>
                                @else
                                    <div class="option-item">
                                        <a href="#common_author-forms" data-bs-toggle="modal"
                                        data-bs-target="#common_author-forms" class="btn  btn_navber">LOGIN</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
            <div class="others-option-for-responsive">
                <div class="container">
                    <div class="dot-menu">
                        <div class="inner">
                            <div class="circle circle-one"></div>
                            <div class="circle circle-two"></div>
                            <div class="circle circle-three"></div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="option-inner">
                            <div class="others-options d-flex align-items-center">
                             
                                <div class="option-item">
                                    <a href="#common_author-forms" data-bs-target="#common_author-forms" data-bs-toggle="modal" class="btn  btn_navber">LOGIN</a>
                           
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>