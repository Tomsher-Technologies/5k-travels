@extends('web.layouts.app')

@section('content')
<!-- search -->
<div class="search-overlay">
    <div class="d-table">
        <div class="d-table-cell">
            <div class="search-overlay-layer"></div>
            <div class="search-overlay-layer"></div>
            <div class="search-overlay-layer"></div>
            <div class="search-overlay-close">
                <span class="search-overlay-close-line"></span>
                <span class="search-overlay-close-line"></span>
            </div>
            <div class="search-overlay-form">
                <form>
                    <input type="text" class="input-search" placeholder="Search here...">
                    <button type="button"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Banner Area -->
<section id="home_one_banner">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="banner_four_text">

                    <h1>Wherever you go, we'll take you there</h1>
                    <h3>Explore the world, book your flight today</h3>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="banner_four_img">
                    <!-- <img src="assets/img/banner/banner.jpg" alt="img"> -->
                </div>
            </div>

            <div class="col-lg-12">
                <!-- Form Area -->
                @include('web.common.search_flight')
            </div>
        </div>
    </div>
</section>


<!-- banner bottom Area -->
<section class="banner_bootom_four">
    <div class="container">
        <div class="row align-items-end">
            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="four_banner_bottom_item">
                    <a href=""> <img src="{{ asset('assets/img/offer/ad1.png') }}" alt="icon"></a>

                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="four_banner_bottom_item">
                    <a href=""> <img src="{{ asset('assets/img/offer/ad2.png') }}" alt="icon"></a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="four_banner_bottom_item">
                    <a href=""> <img src="{{ asset('assets/img/offer/ad3.png') }}" alt="icon"></a>
                </div>
            </div>
        </div>
    </div>
</section>




<!-- Holiday Destinations  Area-->
<section id="holiday_destinations" class="section_padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="holiday_left_heading">
                            <div class="heading_left_area">
                                <h2>Experience <br> Our Best <span> Fares!</span></h2>
                                <h5>Discover your ideal experience with us</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="holiday_small_boxed">
                            <a href="tour-details.html">
                                <img src="{{ asset('assets/img/holiday-img/holiday-1.png') }}" alt="img">
                                <div class="holiday_small_box_content">
                                    <div class="holiday_inner_content">
                                        <div class="rating_outof">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <h5>5 Out of 5</h5>
                                        </div>
                                        <h3>China | $6000</h3>
                                        <h4>8 days 7 nights</h4>
                                        <p>Cupidatat consectetur ea cillum nt
                                            consectetur excepteur.</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="holiday_small_boxed">
                            <a href="tour-details.html">
                                <img src="{{ asset('assets/img/holiday-img/holiday-2.png') }}" alt="img">
                                <div class="holiday_small_box_content">
                                    <div class="holiday_inner_content">
                                        <div class="rating_outof">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <h5>5 Out of 5</h5>
                                        </div>
                                        <h3>China | $6000</h3>
                                        <h4>8 days 7 nights</h4>
                                        <p>Cupidatat consectetur ea cillum nt
                                            consectetur excepteur.</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="holiday_small_boxed">
                            <a href="tour-details.html">
                                <img src="{{ asset('assets/img/holiday-img/holiday-3.png') }}" alt="img">
                                <div class="holiday_small_box_content">
                                    <div class="holiday_inner_content">
                                        <div class="rating_outof">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <h5>5 Out of 5</h5>
                                        </div>
                                        <h3>China | $6000</h3>
                                        <h4>8 days 7 nights</h4>
                                        <p>Cupidatat consectetur ea cillum nt
                                            consectetur excepteur.</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="holiday_small_boxed">
                            <a href="tour-details.html">
                                <img src="{{ asset('assets/img/holiday-img/holiday-4.png') }}" alt="img">
                                <div class="holiday_small_box_content">
                                    <div class="holiday_inner_content">
                                        <div class="rating_outof">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <h5>5 Out of 5</h5>
                                        </div>
                                        <h3>China | $6000</h3>
                                        <h4>8 days 7 nights</h4>
                                        <p>Cupidatat consectetur ea cillum nt
                                            consectetur excepteur.</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                <div class="holiday_small_boxed">
                                    <a href="tour-details.html">
                                        <img src="{{ asset('assets/img/holiday-img/holiday-5.png') }}" alt="img">
                                        <div class="holiday_small_box_content">
                                            <div class="holiday_inner_content">
                                                <div class="rating_outof">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <h5>5 Out of 5</h5>
                                                </div>
                                                <h3>China | $6000</h3>
                                                <h4>8 days 7 nights</h4>
                                                <p>Cupidatat consectetur ea cillum nt
                                                    consectetur excepteur.</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                <div class="holiday_small_boxed">
                                    <a href="tour-details.html">
                                        <img src="{{ asset('assets/img/holiday-img/holiday-6.png') }}" alt="img">
                                        <div class="holiday_small_box_content">
                                            <div class="holiday_inner_content">
                                                <div class="rating_outof">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <h5>5 Out of 5</h5>
                                                </div>
                                                <h3>China | $6000</h3>
                                                <h4>8 days 7 nights</h4>
                                                <p>Cupidatat consectetur ea cillum nt
                                                    consectetur excepteur.</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- About Us -->
<section id="about_us_top" class="section_padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="about_us_left">
                    <div class="row">

                        <div class="col-lg-6">
                            <h5>About us</h5>
                            <h2>Discover your all the <br>
                                destinations with us!</h2>

                            <!-- <a href="tour-search.html" class="btn btn_theme btn_md">Find tours</a> -->
                        </div>
                        <div class="col-lg-6">
                            <p>At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren,
                                no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum
                                dolor sit amet, consetetur sadipscing elitr
                                At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren,
                                no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum
                                dolor sit amet, consetetur sadipscing elitr </p>
                        </div>


                    </div>

                </div>
            </div>
            <div class="col-lg-12">
                <div class="about_us_right">
                    <img src="{{ asset('assets/img/5k-explore-banner.png') }}" alt="img">
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Our partners Area -->
<section id="our_partners_four" class="section_padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="partner_slider_area owl-theme owl-carousel">
                    <div class="partner_logo">
                        <a href="#!"><img src="{{ asset('assets/img/partner/1.png') }}" alt="logo"></a>
                    </div>
                    <div class="partner_logo">
                        <a href="#!"><img src="{{ asset('assets/img/partner/2.png') }}" alt="logo"></a>
                    </div>
                    <div class="partner_logo">
                        <a href="#!"><img src="{{ asset('assets/img/partner/3.png') }}" alt="logo"></a>
                    </div>
                    <div class="partner_logo">
                        <a href="#!"><img src="{{ asset('assets/img/partner/4.png') }}" alt="logo"></a>
                    </div>
                    <div class="partner_logo">
                        <a href="#!"><img src="{{ asset('assets/img/partner/5.png') }}" alt="logo"></a>
                    </div>
                    <div class="partner_logo">
                        <a href="#!"><img src="{{ asset('assets/img/partner/6.png') }}" alt="logo"></a>
                    </div>
                    <div class="partner_logo">
                        <a href="#!"><img src="{{ asset('assets/img/partner/7.png') }}" alt="logo"></a>
                    </div>
                    <div class="partner_logo">
                        <a href="#!"><img src="{{ asset('assets/img/partner/8.png') }}" alt="logo"></a>
                    </div>
                    <div class="partner_logo">
                        <a href="#!"><img src="{{ asset('assets/img/partner/5.png') }}" alt="logo"></a>
                    </div>
                    <div class="partner_logo">
                        <a href="#!"><img src="{{ asset('assets/img/partner/3.png') }}" alt="logo"></a>
                    </div>
                    <div class="partner_logo">
                        <a href="#!"><img src="{{ asset('assets/img/partner/2.png') }}" alt="logo"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- newsletter content -->
@include('web.includes.newsletter')
<!-- /newsletter content -->
@endsection
@push('header')
<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/search_flights.css') }}" />

<style>

</style>
@endpush
@push('footer')

<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/search_flights.js') }}"></script>

<script  type="text/javascript">
   
</script>

@endpush