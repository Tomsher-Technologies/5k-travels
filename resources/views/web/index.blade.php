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
              <a href="#">
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
              <a href="#">
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
              <a href="#">
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
              <a href="#">
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
                  <a href="#">
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
                  <a href="#">
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
              <p>5k travels is a Dubai-based privately owned online flight booking agency in the travel industry.
                With an unwavering commitment to providing customers with limitless and unrestricted journeys,
                our company strives to become the globally recognized and trusted leader among e-commerce tourism
                companies. We value your trust and aim to become your go-to platform for all your flight booking
                needs. At 5k Travels, we invite you to embark on an exhilarating journey with us as we assist you
                in exploring the world, one flight at a time. </p>
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





<!-- Explore our hot deals -->
<section id="explore_area" class="section_padding_top">
  <div class="container">
    <!-- Section Heading -->
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="section_heading_center">
          <h2>Explore our hot deals</h2>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6 offset-lg-3">
        <div class="theme_nav_tab">
          <nav class="theme_nav_tab_item">
            <div class="nav nav-tabs" id="nav-tab1" role="tablist">


              <button class="nav-link active" id="nav-baggage-tab" data-bs-toggle="tab" data-bs-target="#nav-baggage"
                type="button" role="tab" aria-controls="nav-baggage" aria-selected="true">Baggage</button>


              <button class="nav-link" id="nav-seats-tab" data-bs-toggle="tab" data-bs-target="#nav-seats" type="button"
                role="tab" aria-controls="nav-seats" aria-selected="false">Seats</button>


              <button class="nav-link" id="nav-meals-tab" data-bs-toggle="tab" data-bs-target="#nav-meals" type="button"
                role="tab" aria-controls="nav-meals" aria-selected="false">Meals</button>





            </div>
          </nav>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">

        <div class="tab-content passenger-det" id="nav-tabContent">

          <div class="tab-pane fade show active" id="nav-baggage" role="tabpanel" aria-labelledby="nav-baggage-tab">
            <div class="row">

              <div class="col-lg-6 col-md-6 col-sm-12 col-12">

                <div class="faqs_main_item">
                  <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                          data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                          <div class="flight-card flights-list__item">
                            <div class="flight-card-list-dt">
                              <div class="flight-card__departure">
                                <h2 class="flight-card__city">Dubai (DXB)</h2>
                                <!-- <time class="flight-card__day">Tuesday, Apr 21, 2020</time> -->
                              </div>

                              <div class="flight-card__route">
                                <div class="flight-card__route-line route-line" aria-hidden="true">
                                  <i class="fas fa-plane-departure"></i>
                                </div>
                                <!-- flight-card__route-line -->
                              </div>

                              <div class="flight-card__arrival">
                                <h2 class="flight-card__city">Kozhikode (CCJ)</h2>
                                <!-- <time class="flight-card__day">Tuesday, Apr 21, 2020</time> -->
                              </div>
                            </div>
                            <hr>

                            <div class="flight-card-ft-typ">
                              <p>flydubai FZ 429</p>
                              <p>Economy (Value)</p>
                            </div>
                          </div>
                        </button>
                      </h2>
                      <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                        data-bs-parent="#accordionExample" style="">
                        <div class="accordion-body">

                          <div class="tabs-menus"> <!-- Tabs -->
                            <ul class="nav panel-tabs" role="tablist">
                              <li class="">

                                <a href="#tab1" class="active" data-bs-toggle="tab" aria-selected="false" role="tab"
                                  tabindex="-1">

                                  <div class="card border">
                                    <div class="card-header">
                                      <div class="crd-heady102 d-flex align-items-center justify-content-start">
                                        <div class="square--30 circle bg-light-primary  text-secondary flex-shrink-0">

                                          <img width="25" src="{{ asset('assets/img/adult.svg') }}" alt="img">
                                        </div>
                                        <div class="crd-heady102Title lh-1 ps-2"><span
                                            class="text-sm fw-semibold text-dark text-uppercase lh-1 mb-0">
                                            Adult 1</span></div>
                                      </div>
                                      <div class="d-flex align-items-center justify-content-start">
                                        <div class="text-dark fw-bold text-md me-2">+ 10 kg checked baggage</div>
                                      </div>
                                      <div class="crd-heady103">
                                        <p class="btn btn-secondary btn-sm px-4 fw-semibold text-uppercase">AED 0
                                        </p>
                                      </div>
                                    </div>
                                  </div>
                                </a>
                              </li>



                              <li><a href="#tab2" data-bs-toggle="tab" aria-selected="false" role="tab" class=""
                                  tabindex="-1">
                                  <div class="card border">
                                    <div class="card-header">
                                      <div class="crd-heady102 d-flex align-items-center justify-content-start">
                                        <div class="square--30 circle bg-light-primary  text-secondary flex-shrink-0">
                                          <img width="25" src="{{ asset('assets/img/infant.svg') }}" alt="img">
                                        </div>
                                        <div class="crd-heady102Title lh-1 ps-2"><span
                                            class="text-sm fw-semibold text-dark text-uppercase lh-1 mb-0">
                                            Infant 1</span></div>
                                      </div>
                                      <div class="d-flex align-items-center justify-content-start">
                                        <div class="text-dark fw-bold text-sm me-2">Infants can't buy extra baggage
                                          allowance
                                        </div>
                                      </div>
                                      <div class="crd-heady103">
                                        <p class="btn btn-secondary btn-sm px-4 fw-semibold text-uppercase">AED 0
                                        </p>
                                      </div>
                                    </div>
                                  </div>


                                </a></li>
                              <li><a href="#tab3" data-bs-toggle="tab" aria-selected="false" role="tab" class=""
                                  tabindex="-1">


                                  <div class="card border">
                                    <div class="card-header">
                                      <div class="crd-heady102 d-flex align-items-center justify-content-start">
                                        <div class="square--30 circle bg-light-primary  text-secondary flex-shrink-0">
                                          <img width="25" src="{{ asset('assets/img/adult.svg') }}" alt="img">
                                        </div>
                                        <div class="crd-heady102Title lh-1 ps-2"><span
                                            class="text-sm fw-semibold text-dark text-uppercase lh-1 mb-0">
                                            Adult 2</span></div>
                                      </div>
                                      <div class="d-flex align-items-center justify-content-start">
                                        <div class="text-dark fw-bold text-md me-2">+ 10 kg checked baggage</div>
                                      </div>
                                      <div class="crd-heady103">
                                        <p class="btn btn-secondary btn-sm px-4 fw-semibold text-uppercase">AED
                                          350</p>
                                      </div>
                                    </div>
                                  </div>



                                </a></li>
                              <li><a href="#tab4" data-bs-toggle="tab" aria-selected="false" role="tab" class=""
                                  tabindex="-1">


                                  <div class="card border">
                                    <div class="card-header">
                                      <div class="crd-heady102 d-flex align-items-center justify-content-start">
                                        <div class="square--30 circle bg-light-primary  text-secondary flex-shrink-0">
                                          <img width="25" src="{{ asset('assets/img/adult.svg') }}" alt="img">
                                        </div>
                                        <div class="crd-heady102Title lh-1 ps-2"><span
                                            class="text-sm fw-semibold text-dark text-uppercase lh-1 mb-0">
                                            Adult 3</span></div>
                                      </div>
                                      <div class="d-flex align-items-center justify-content-start">
                                        <div class="text-dark fw-bold text-md me-2">Not selected</div>
                                      </div>
                                      <div class="crd-heady103">
                                        <p class="btn btn-secondary btn-sm px-4 fw-semibold text-uppercase">AED
                                          350</p>
                                      </div>
                                    </div>
                                  </div>
                                </a>
                              </li>

                            </ul>
                          </div>


                        </div>
                      </div>
                    </div>

                  </div>



                  <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingtwo">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                          data-bs-target="#collapsetwo" aria-expanded="true" aria-controls="collapsetwo">
                          <div class="flight-card flights-list__item">
                            <div class="flight-card-list-dt">
                              <div class="flight-card__departure">
                                <h2 class="flight-card__city"> Kozhikode (CCJ) </h2>
                                <!-- <time class="flight-card__day">Tuesday, Apr 21, 2020</time> -->
                              </div>

                              <div class="flight-card__route">
                                <div class="flight-card__route-line route-line" aria-hidden="true">
                                  <i class="fas fa-plane-departure"></i>
                                </div>
                                <!-- flight-card__route-line -->
                              </div>

                              <div class="flight-card__arrival">
                                <h2 class="flight-card__city">Dubai (DXB)</h2>
                                <!-- <time class="flight-card__day">Tuesday, Apr 21, 2020</time> -->
                              </div>
                            </div>
                            <hr>

                            <div class="flight-card-ft-typ">
                              <p>flydubai FZ 429</p>
                              <p>Economy (Value)</p>
                            </div>
                          </div>
                        </button>
                      </h2>
                      <div id="collapsetwo" class="accordion-collapse collapse" aria-labelledby="headingtwo"
                        data-bs-parent="#accordionExample" style="">
                        <div class="accordion-body">

                          <div class="tabs-menus"> <!-- Tabs -->
                            <ul class="nav panel-tabs" role="tablist">
                              <li class="">

                                <a href="#tab1" class="" data-bs-toggle="tab" aria-selected="false" role="tab"
                                  tabindex="-1">

                                  <div class="card border">
                                    <div class="card-header">
                                      <div class="crd-heady102 d-flex align-items-center justify-content-start">
                                        <div class="square--30 circle bg-light-primary  text-secondary flex-shrink-0">

                                          <img width="25" src="{{ asset('assets/img/adult.svg') }}" alt="img">
                                        </div>
                                        <div class="crd-heady102Title lh-1 ps-2"><span
                                            class="text-sm fw-semibold text-dark text-uppercase lh-1 mb-0">
                                            Adult 1</span></div>
                                      </div>
                                      <div class="d-flex align-items-center justify-content-start">
                                        <div class="text-dark fw-bold text-md me-2">+ 10 kg checked baggage</div>
                                      </div>
                                      <div class="crd-heady103">
                                        <p class="btn btn-secondary btn-sm px-4 fw-semibold text-uppercase">AED 0
                                        </p>
                                      </div>
                                    </div>
                                  </div>
                                </a>
                              </li>



                              <li><a href="#tab2" data-bs-toggle="tab" aria-selected="false" role="tab" class=""
                                  tabindex="-1">
                                  <div class="card border">
                                    <div class="card-header">
                                      <div class="crd-heady102 d-flex align-items-center justify-content-start">
                                        <div class="square--30 circle bg-light-primary  text-secondary flex-shrink-0">
                                          <img width="25" src="{{ asset('assets/img/infant.svg') }}" alt="img">
                                        </div>
                                        <div class="crd-heady102Title lh-1 ps-2"><span
                                            class="text-sm fw-semibold text-dark text-uppercase lh-1 mb-0">
                                            Infant 1</span></div>
                                      </div>
                                      <div class="d-flex align-items-center justify-content-start">
                                        <div class="text-dark fw-bold text-sm me-2">Infants can't buy extra baggage
                                          allowance
                                        </div>
                                      </div>
                                      <div class="crd-heady103">
                                        <p class="btn btn-secondary btn-sm px-4 fw-semibold text-uppercase">AED 0
                                        </p>
                                      </div>
                                    </div>
                                  </div>


                                </a></li>
                              <li><a href="#tab3" data-bs-toggle="tab" aria-selected="false" role="tab" class=""
                                  tabindex="-1">


                                  <div class="card border">
                                    <div class="card-header">
                                      <div class="crd-heady102 d-flex align-items-center justify-content-start">
                                        <div class="square--30 circle bg-light-primary  text-secondary flex-shrink-0">
                                          <img width="25" src="{{ asset('assets/img/adult.svg') }}" alt="img">
                                        </div>
                                        <div class="crd-heady102Title lh-1 ps-2"><span
                                            class="text-sm fw-semibold text-dark text-uppercase lh-1 mb-0">
                                            Adult 2</span></div>
                                      </div>
                                      <div class="d-flex align-items-center justify-content-start">
                                        <div class="text-dark fw-bold text-md me-2">+ 10 kg checked baggage</div>
                                      </div>
                                      <div class="crd-heady103">
                                        <p class="btn btn-secondary btn-sm px-4 fw-semibold text-uppercase">AED
                                          350</p>
                                      </div>
                                    </div>
                                  </div>



                                </a></li>
                              <li><a href="#tab4" data-bs-toggle="tab" aria-selected="false" role="tab" class=""
                                  tabindex="-1">


                                  <div class="card border">
                                    <div class="card-header">
                                      <div class="crd-heady102 d-flex align-items-center justify-content-start">
                                        <div class="square--30 circle bg-light-primary  text-secondary flex-shrink-0">
                                          <img width="25" src="{{ asset('assets/img/adult.svg') }}" alt="img">
                                        </div>
                                        <div class="crd-heady102Title lh-1 ps-2"><span
                                            class="text-sm fw-semibold text-dark text-uppercase lh-1 mb-0">
                                            Adult 3</span></div>
                                      </div>
                                      <div class="d-flex align-items-center justify-content-start">
                                        <div class="text-dark fw-bold text-md me-2">Not selected</div>
                                      </div>
                                      <div class="crd-heady103">
                                        <p class="btn btn-secondary btn-sm px-4 fw-semibold text-uppercase">AED
                                          350</p>
                                      </div>
                                    </div>
                                  </div>
                                </a>
                              </li>

                            </ul>
                          </div>


                        </div>
                      </div>
                    </div>

                  </div>
                </div>

              </div>


              <div class="col-lg-6 col-md-6 col-sm-12 col-12">


                <div class="tab-content">
                  <div class="tab-pane table-responsive userprof-tab active show" id="tab1" role="tabpanel">

                    <div class="baggage-allw">
                      <p class="info-b pt-2">If your fare includes checked baggage, you can take up to 3 bags up to the
                        combined weight of your baggage allowance. Max. dimension 165 cm (height + width + depth).
                      </p>

                      <div class="included_baggage">


                        <div class="row align-items-center justify-content-between g-2 mb-2">

                          <div class="col-12">
                            <p class="pt-2">Included baggage</p>
                          </div>

                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/hand-baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Hand baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">7 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>


                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Checked baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">30 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>


                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/hand-baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Hand baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">7 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>



                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Checked baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">30 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>




                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/hand-baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Hand baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">7 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>



                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Checked baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">30 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 m-auto text-center">
                        <button class="btn add-baggage" type="button">+ 10 KG
                          AED 310</button>
                      </div>
                    </div>


                  </div>
                  <div class="tab-pane table-responsive userprof-tab" id="tab2" role="tabpanel">


                    <div class="baggage-allw">
                      <p class="info-b pt-2">If your fare includes checked baggage, you can take up to 3 bags up to the
                        combined weight of your baggage allowance. Max. dimension 165 cm (height + width + depth).
                      </p>

                      <div class="included_baggage">


                        <div class="row align-items-center justify-content-between g-2 mb-2">

                          <div class="col-12">
                            <p class="pt-2">Included baggage</p>
                          </div>

                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/hand-baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Hand baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">7 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>


                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Checked baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">30 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>






                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/hand-baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Hand baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">7 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>



                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Checked baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">30 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 m-auto text-center">
                        <button class="btn add-baggage" type="button">+ 10 KG
                          AED 310</button>
                      </div>
                    </div>

                  </div>



                  <div class="tab-pane table-responsive userprof-tab" id="tab3" role="tabpanel">



                    <div class="baggage-allw">
                      <p class="info-b pt-2">If your fare includes checked baggage, you can take up to 3 bags up to the
                        combined weight of your baggage allowance. Max. dimension 165 cm (height + width + depth).
                      </p>

                      <div class="included_baggage">


                        <div class="row align-items-center justify-content-between g-2 mb-2">

                          <div class="col-12">
                            <p class="pt-2">Included baggage</p>
                          </div>

                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/hand-baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Hand baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">7 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>


                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Checked baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">30 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>






                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/hand-baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Hand baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">7 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>



                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Checked baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">30 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 m-auto text-center">
                        <button class="btn add-baggage" type="button">+ 10 KG
                          AED 310</button>
                      </div>
                    </div>

                  </div>


                  <div class="tab-pane table-responsive userprof-tab" id="tab4" role="tabpanel">

                    <div class="baggage-allw">
                      <p class="info-b pt-2">If your fare includes checked baggage, you can take up to 3 bags up to the
                        combined weight of your baggage allowance. Max. dimension 165 cm (height + width + depth).
                      </p>

                      <div class="included_baggage">


                        <div class="row align-items-center justify-content-between g-2 mb-2">

                          <div class="col-12">
                            <p class="pt-2">Included baggage</p>
                          </div>

                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/hand-baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Hand baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">7 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>



                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Checked baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">30 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 m-auto text-center">
                        <button class="btn add-baggage" type="button">+ 10 KG
                          AED 310</button>
                      </div>
                    </div>

                  </div>
                </div>
              </div>




            </div>
          </div>






































          <div class="tab-pane fade" id="nav-seats" role="tabpanel" aria-labelledby="nav-seats-tab">
            <div class="row">





              <div class="col-lg-5 col-md-5 col-sm-12 col-12">

                <div class="faqs_main_item">

                  <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingtwo">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                          data-bs-target="#collapsetwo" aria-expanded="true" aria-controls="collapsetwo">
                          <div class="flight-card flights-list__item">
                            <div class="flight-card-list-dt">
                              <div class="flight-card__departure">
                                <h2 class="flight-card__city"> Kozhikode (CCJ) </h2>
                                <!-- <time class="flight-card__day">Tuesday, Apr 21, 2020</time> -->
                              </div>

                              <div class="flight-card__route">
                                <div class="flight-card__route-line route-line" aria-hidden="true">
                                  <i class="fas fa-plane-departure"></i>
                                </div>
                                <!-- flight-card__route-line -->
                              </div>

                              <div class="flight-card__arrival">
                                <h2 class="flight-card__city">Dubai (DXB)</h2>
                                <!-- <time class="flight-card__day">Tuesday, Apr 21, 2020</time> -->
                              </div>
                            </div>
                            <hr>

                            <div class="flight-card-ft-typ">
                              <p>flydubai FZ 429</p>
                              <p>Economy (Value)</p>
                            </div>
                          </div>
                        </button>
                      </h2>
                      <div id="collapsetwo" class="accordion-collapse collapse" aria-labelledby="headingtwo"
                        data-bs-parent="#accordionExample" style="">
                        <div class="accordion-body">

                          <div class="tabs-menus"> <!-- Tabs -->
                            <ul class="nav panel-tabs" role="tablist">
                              <li class="">

                                <a href="#tab11" class="" data-bs-toggle="tab" aria-selected="false" role="tab"
                                  tabindex="-1">

                                  <div class="card border">
                                    <div class="card-header">
                                      <div class="crd-heady102 d-flex align-items-center justify-content-start">
                                        <div class="square--30 circle bg-light-primary  text-secondary flex-shrink-0">

                                          <img width="25" src="{{ asset('assets/img/adult.svg') }}" alt="img">
                                        </div>
                                        <div class="crd-heady102Title lh-1 ps-2"><span
                                            class="text-sm fw-semibold text-dark text-uppercase lh-1 mb-0">
                                            Adult 1</span></div>
                                      </div>
                                      <div class="d-flex align-items-center justify-content-start">
                                        <div class="text-dark fw-bold text-md me-2">18B</div>
                                      </div>
                                      <div class="crd-heady103">
                                        <p class="btn btn-secondary btn-sm px-4 fw-semibold text-uppercase">AED
                                          120
                                        </p>
                                      </div>
                                    </div>
                                  </div>
                                </a>
                              </li>



                              <li><a href="#tab22" data-bs-toggle="tab" aria-selected="false" role="tab" class=""
                                  tabindex="-1">
                                  <div class="card border">
                                    <div class="card-header">
                                      <div class="crd-heady102 d-flex align-items-center justify-content-start">
                                        <div class="square--30 circle bg-light-primary  text-secondary flex-shrink-0">
                                          <img width="25" src="{{ asset('assets/img/infant.svg') }}" alt="img">
                                        </div>
                                        <div class="crd-heady102Title lh-1 ps-2"><span
                                            class="text-sm fw-semibold text-dark text-uppercase lh-1 mb-0">
                                            Infant 1</span></div>
                                      </div>
                                      <div class="d-flex align-items-center justify-content-start">
                                        <div class="text-dark fw-bold text-sm me-2">15C
                                        </div>
                                      </div>
                                      <div class="crd-heady103">
                                        <p class="btn btn-secondary btn-sm px-4 fw-semibold text-uppercase">AED
                                          100
                                        </p>
                                      </div>
                                    </div>
                                  </div>


                                </a></li>
                              <li><a href="#tab33" data-bs-toggle="tab" aria-selected="false" role="tab" class=""
                                  tabindex="-1">


                                  <div class="card border">
                                    <div class="card-header">
                                      <div class="crd-heady102 d-flex align-items-center justify-content-start">
                                        <div class="square--30 circle bg-light-primary  text-secondary flex-shrink-0">
                                          <img width="25" src="{{ asset('assets/img/adult.svg') }}" alt="img">
                                        </div>
                                        <div class="crd-heady102Title lh-1 ps-2"><span
                                            class="text-sm fw-semibold text-dark text-uppercase lh-1 mb-0">
                                            Adult 2</span></div>
                                      </div>
                                      <div class="d-flex align-items-center justify-content-start">
                                        <div class="text-dark fw-bold text-md me-2">21B</div>
                                      </div>
                                      <div class="crd-heady103">
                                        <p class="btn btn-secondary btn-sm px-4 fw-semibold text-uppercase">AED
                                          350</p>
                                      </div>
                                    </div>
                                  </div>



                                </a></li>
                              <li><a href="#tab44" data-bs-toggle="tab" aria-selected="false" role="tab" class=""
                                  tabindex="-1">


                                  <div class="card border">
                                    <div class="card-header">
                                      <div class="crd-heady102 d-flex align-items-center justify-content-start">
                                        <div class="square--30 circle bg-light-primary  text-secondary flex-shrink-0">
                                          <img width="25" src="{{ asset('assets/img/adult.svg') }}" alt="img">
                                        </div>
                                        <div class="crd-heady102Title lh-1 ps-2"><span
                                            class="text-sm fw-semibold text-dark text-uppercase lh-1 mb-0">
                                            Adult 3</span></div>
                                      </div>
                                      <div class="d-flex align-items-center justify-content-start">
                                        <div class="text-dark fw-bold text-md me-2">Not selected</div>
                                      </div>
                                      <div class="crd-heady103">
                                        <p class="btn btn-secondary btn-sm px-4 fw-semibold text-uppercase">AED
                                          350</p>
                                      </div>
                                    </div>
                                  </div>
                                </a>
                              </li>

                            </ul>
                          </div>


                        </div>
                      </div>
                    </div>

                  </div>
                </div>

              </div>


              <div class="col-lg-7 col-md-7 col-sm-12 col-12">


                <div class="tab-content">

                  <div class="tab-pane table-responsive userprof-tab active show" id="tab11" role="tabpanel">



                    <div class="bookyour-seat">
                     

                      <div class="seat-info">
                      <header>
                        <h3>Select seat</h3>
                        <h4>Boeing 777-300</h4>
                        <span>Cathay Pacific</span>
                        <span>CX-5169</span>
                      </header>

                        <ul class="seat-type">
                          <li>
                          <span class="gt-seat-eco seat-extra-legroom">
                          <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>
                                  </span>
                          Extra legroom</li>



                          <li>

<span class="gt-seat-eco standard-seat">
                          <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>
                                  </span>

                          Standard seat</li>


                        </ul>
                      </div>


                      <div class="chooseyourseat">
                        <span class="flight-body">
                          <!-- <img src="{{ asset('assets/img/flight-structure-front.png') }}" alt=""> -->
                          <img src="{{ asset('assets/img/f-front.png') }}" alt="">

                        </span>

                        <div class="seating-area">
                          <!-- Supper business class -->
                          <ul class="area-sbc">
                            <!-- <div class="row-pointer">Supper business class</div> -->
                            <li>
                              <div class="left">

                                <span class="gt-seat-business" data-seat-id="1">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X50</p>
                                </span>


                                



                                <span class="gt-seat-business" data-seat-id="2">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X51</p>
                                </span>

                              </div>



                              <div class="right">


<span class="gt-seat-business seatnot-available" data-seat-id="3" style="cursor: not-allowed;">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X53</p>
                                </span>



                                <span class="gt-seat-business seatnot-available" data-seat-id="4" style="cursor: not-allowed;">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X54</p>
                                </span>


                              </div>


                            </li>
                            <li>
                              <div class="left">


                              <span class="gt-seat-business" data-seat-id="5" style="cursor: not-allowed;">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X54</p>
                                </span>


                                <span class="gt-seat-business" data-seat-id="6" style="cursor: not-allowed;">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X54</p>
                                </span>



                              </div>
                              <div class="right">

                              <span class="gt-seat-business seatnot-available" data-seat-id="7" style="cursor: not-allowed;">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X54</p>
                                </span>


                                <span class="gt-seat-business seatnot-available" data-seat-id="8" style="cursor: not-allowed;">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X54</p>
                                </span>

                              </div>
                            </li>
                          </ul>


                          

                          <!-- Business class -->
                          <ul class="area-bc">
                            <!-- <div class="row-pointer"> business class</div> -->
                            <li>
                              <div class="left">



                              <span class="gt-seat-business" data-seat-id="9">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X50</p>
                                </span>


                                  <span class="gt-seat-business" data-seat-id="10">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X50</p>
                                </span>

                              </div>
                              <div class="right">



                              <span class="gt-seat-business seatnot-available" data-seat-id="11">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X50</p>
                                </span>


                                  <span class="gt-seat-business seatnot-available" data-seat-id="12">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X50</p>
                                </span>
                                
                              
                              </div>
                            </li>
                            <li>
                              <div class="left">
                                <span class="gt-seat-business" data-seat-id="13"></span>
                                <span class="gt-seat-business" data-seat-id="14"></span>
                              </div>
                              <div class="right">
                                <span class="gt-seat-business" data-seat-id="15"></span>
                                <span class="gt-seat-business" data-seat-id="16"></span>
                              </div>
                            </li>
                          </ul>

                          <!-- Economy class -->
                          <ul class="area-ec">
                            <!-- <div class="row-pointer">Economy class</div> -->
                          
                          
                          
                            <li>
                              <div class="left">


                              <span class="gt-seat-standard" data-seat-id="17">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X17</p>
                                </span>

                                <span class="gt-seat-standard" data-seat-id="18">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X18</p>
                                </span>


                                <span class="gt-seat-standard" data-seat-id="19">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X19</p>
                                </span>


                              </div>
                              <div class="right">


                              <span class="gt-seat-standard" data-seat-id="20">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X20</p>
                                </span>



                                <span class="gt-seat-standard" data-seat-id="21">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X21</p>
                                </span>




                                <span class="gt-seat-standard" data-seat-id="22">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X22</p>
                                </span>

                              </div>
                            </li>





                            <li>
                              <div class="left">


                              <span class="gt-seat-standard" data-seat-id="17">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X17</p>
                                </span>

                                <span class="gt-seat-standard" data-seat-id="18">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X18</p>
                                </span>


                                <span class="gt-seat-standard" data-seat-id="19">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X19</p>
                                </span>


                              </div>
                              <div class="right">


                              <span class="gt-seat-standard" data-seat-id="20">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X20</p>
                                </span>



                                <span class="gt-seat-standard" data-seat-id="21">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X21</p>
                                </span>




                                <span class="gt-seat-standard" data-seat-id="22">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X22</p>
                                </span>

                              </div>
                            </li>


                            <li>
                              <div class="left">


                              <span class="gt-seat-standard" data-seat-id="17">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X17</p>
                                </span>

                                <span class="gt-seat-standard" data-seat-id="18">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X18</p>
                                </span>


                                <span class="gt-seat-standard" data-seat-id="19">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X19</p>
                                </span>


                              </div>
                              <div class="right">


                              <span class="gt-seat-standard" data-seat-id="20">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X20</p>
                                </span>



                                <span class="gt-seat-standard" data-seat-id="21">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X21</p>
                                </span>




                                <span class="gt-seat-standard" data-seat-id="22">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X22</p>
                                </span>

                              </div>
                            </li>
                            <li>
                              <div class="left">


                              <span class="gt-seat-standard" data-seat-id="17">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X17</p>
                                </span>

                                <span class="gt-seat-standard" data-seat-id="18">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X18</p>
                                </span>


                                <span class="gt-seat-standard" data-seat-id="19">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X19</p>
                                </span>


                              </div>
                              <div class="right">


                              <span class="gt-seat-standard" data-seat-id="20">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X20</p>
                                </span>



                                <span class="gt-seat-standard " data-seat-id="21">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X21</p>
                                </span>




                                <span class="gt-seat-standard" data-seat-id="22">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X22</p>
                                </span>

                              </div>
                            </li>
 <li>
                              <div class="left">


                              <span class="gt-seat-standard" data-seat-id="17">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X17</p>
                                </span>

                                <span class="gt-seat-standard" data-seat-id="18">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X18</p>
                                </span>


                                <span class="gt-seat-standard" data-seat-id="19">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X19</p>
                                </span>


                              </div>
                              <div class="right">


                              <span class="gt-seat-standard" data-seat-id="20">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X20</p>
                                </span>



                                <span class="gt-seat-standard" data-seat-id="21">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X21</p>
                                </span>




                                <span class="gt-seat-standard" data-seat-id="22">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X22</p>
                                </span>

                              </div>
                            </li>
 <li>
                              <div class="left">


                              <span class="gt-seat-standard" data-seat-id="17">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X17</p>
                                </span>

                                <span class="gt-seat-standard" data-seat-id="18">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X18</p>
                                </span>


                                <span class="gt-seat-standard" data-seat-id="19">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X19</p>
                                </span>


                              </div>
                              <div class="right">


                              <span class="gt-seat-standard" data-seat-id="20">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X20</p>
                                </span>



                                <span class="gt-seat-standard" data-seat-id="21">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X21</p>
                                </span>




                                <span class="gt-seat-standard" data-seat-id="22">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X22</p>
                                </span>

                              </div>
                            </li>
 <li>
                              <div class="left">


                              <span class="gt-seat-standard" data-seat-id="17">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X17</p>
                                </span>

                                <span class="gt-seat-standard" data-seat-id="18">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X18</p>
                                </span>


                                <span class="gt-seat-standard" data-seat-id="19">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X19</p>
                                </span>


                              </div>
                              <div class="right">


                              <span class="gt-seat-standard" data-seat-id="20">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X20</p>
                                </span>



                                <span class="gt-seat-standard" data-seat-id="21">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X21</p>
                                </span>




                                <span class="gt-seat-standard" data-seat-id="22">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X22</p>
                                </span>

                              </div>
                            </li>
 <li>
                              <div class="left">


                              <span class="gt-seat-standard" data-seat-id="17">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X17</p>
                                </span>

                                <span class="gt-seat-standard" data-seat-id="18">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X18</p>
                                </span>


                                <span class="gt-seat-standard" data-seat-id="19">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X19</p>
                                </span>


                              </div>
                              <div class="right">


                              <span class="gt-seat-standard" data-seat-id="20">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X20</p>
                                </span>



                                <span class="gt-seat-standard" data-seat-id="21">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X21</p>
                                </span>




                                <span class="gt-seat-standard" data-seat-id="22">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X22</p>
                                </span>

                              </div>
                            </li>
 <li>
                              <div class="left">


                              <span class="gt-seat-standard" data-seat-id="17">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X17</p>
                                </span>

                                <span class="gt-seat-standard" data-seat-id="18">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X18</p>
                                </span>


                                <span class="gt-seat-standard" data-seat-id="19">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X19</p>
                                </span>


                              </div>
                              <div class="right">


                              <span class="gt-seat-standard" data-seat-id="20">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X20</p>
                                </span>



                                <span class="gt-seat-standard" data-seat-id="21">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X21</p>
                                </span>




                                <span class="gt-seat-standard" data-seat-id="22">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X22</p>
                                </span>

                              </div>
                            </li>
 <li>
                              <div class="left">


                              <span class="gt-seat-standard" data-seat-id="17">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X17</p>
                                </span>

                                <span class="gt-seat-standard" data-seat-id="18">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X18</p>
                                </span>


                                <span class="gt-seat-standard" data-seat-id="19">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X19</p>
                                </span>


                              </div>
                              <div class="right">


                              <span class="gt-seat-standard" data-seat-id="20">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X20</p>
                                </span>



                                <span class="gt-seat-standard" data-seat-id="21">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X21</p>
                                </span>




                                <span class="gt-seat-standard" data-seat-id="22">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X22</p>
                                </span>

                              </div>
                            </li>
 <li>
                              <div class="left">


                              <span class="gt-seat-standard" data-seat-id="17">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X17</p>
                                </span>

                                <span class="gt-seat-standard" data-seat-id="18">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X18</p>
                                </span>


                                <span class="gt-seat-standard" data-seat-id="19">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X19</p>
                                </span>


                              </div>
                              <div class="right">


                              <span class="gt-seat-standard" data-seat-id="20">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X20</p>
                                </span>



                                <span class="gt-seat-standard" data-seat-id="21">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X21</p>
                                </span>




                                <span class="gt-seat-standard" data-seat-id="22">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X22</p>
                                </span>

                              </div>
                            </li>
 <li>
                              <div class="left">


                              <span class="gt-seat-standard" data-seat-id="17">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X17</p>
                                </span>

                                <span class="gt-seat-standard" data-seat-id="18">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X18</p>
                                </span>


                                <span class="gt-seat-standard" data-seat-id="19">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X19</p>
                                </span>


                              </div>
                              <div class="right">


                              <span class="gt-seat-standard" data-seat-id="20">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X20</p>
                                </span>



                                <span class="gt-seat-standard" data-seat-id="21">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X21</p>
                                </span>




                                <span class="gt-seat-standard" data-seat-id="22">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X22</p>
                                </span>

                              </div>
                            </li>
 <li>
                              <div class="left">


                              <span class="gt-seat-standard" data-seat-id="17">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X17</p>
                                </span>

                                <span class="gt-seat-standard" data-seat-id="18">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X18</p>
                                </span>


                                <span class="gt-seat-standard" data-seat-id="19">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X19</p>
                                </span>


                              </div>
                              <div class="right">


                              <span class="gt-seat-standard" data-seat-id="20">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X20</p>
                                </span>



                                <span class="gt-seat-standard" data-seat-id="21">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X21</p>
                                </span>




                                <span class="gt-seat-standard" data-seat-id="22">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X22</p>
                                </span>

                              </div>
                            </li>
 <li>
                              <div class="left">


                              <span class="gt-seat-standard" data-seat-id="17">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X17</p>
                                </span>

                                <span class="gt-seat-standard" data-seat-id="18">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X18</p>
                                </span>


                                <span class="gt-seat-standard" data-seat-id="19">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X19</p>
                                </span>


                              </div>
                              <div class="right">


                              <span class="gt-seat-standard" data-seat-id="20">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X20</p>
                                </span>



                                <span class="gt-seat-standard" data-seat-id="21">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X21</p>
                                </span>




                                <span class="gt-seat-standard" data-seat-id="22">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X22</p>
                                </span>

                              </div>
                            </li>
 <li>
                              <div class="left">


                              <span class="gt-seat-standard" data-seat-id="17">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X17</p>
                                </span>

                                <span class="gt-seat-standard" data-seat-id="18">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X18</p>
                                </span>


                                <span class="gt-seat-standard" data-seat-id="19">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X19</p>
                                </span>


                              </div>
                              <div class="right">


                              <span class="gt-seat-standard" data-seat-id="20">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X20</p>
                                </span>



                                <span class="gt-seat-standard" data-seat-id="21">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X21</p>
                                </span>




                                <span class="gt-seat-standard" data-seat-id="22">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X22</p>
                                </span>

                              </div>
                            </li>
 <li>
                              <div class="left">


                              <span class="gt-seat-standard" data-seat-id="17">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X17</p>
                                </span>

                                <span class="gt-seat-standard" data-seat-id="18">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X18</p>
                                </span>


                                <span class="gt-seat-standard" data-seat-id="19">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X19</p>
                                </span>


                              </div>
                              <div class="right">


                              <span class="gt-seat-standard" data-seat-id="20">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X20</p>
                                </span>



                                <span class="gt-seat-standard" data-seat-id="21">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X21</p>
                                </span>




                                <span class="gt-seat-standard" data-seat-id="22">
                                  <svg width="30" height="30" viewBox="0 0 464 564" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1138_4421)">
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                        fill="#434343" />
                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                        fill="#434343" />
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_1138_4421">
                                        <rect width="464" height="564" fill="white" />
                                      </clipPath>
                                    </defs>
                                  </svg>

                                  <p class="seat-number">X22</p>
                                </span>

                              </div>
                            </li>








                            <li>
                              <div class="left">
                                <span class="gt-seat-eco" data-seat-id="23"></span>
                                <span class="gt-seat-eco" data-seat-id="24"></span>
                                <span class="gt-seat-eco" data-seat-id="25"></span>
                              </div>
                              <div class="right">
                                <span class="gt-seat-eco" data-seat-id="26"></span>
                                <span class="gt-seat-eco" data-seat-id="27"></span>
                                <span class="gt-seat-eco" data-seat-id="28"></span>
                              </div>
                            </li>
                            <li>
                              <div class="left">
                                <span class="gt-seat-eco" data-seat-id="29"></span>
                                <span class="gt-seat-eco" data-seat-id="30"></span>
                                <span class="gt-seat-eco" data-seat-id="31"></span>
                              </div>
                              <div class="right">
                                <span class="gt-seat-eco" data-seat-id="32"></span>
                                <span class="gt-seat-eco" data-seat-id="33"></span>
                                <span class="gt-seat-eco seatnot-available" data-seat-id="34"
                                  style="cursor: not-allowed;"></span>
                              </div>
                            </li>
                            <li>
                              <div class="left">
                                <span class="gt-seat-eco seatnot-available" data-seat-id="35"
                                  style="cursor: not-allowed;"></span>
                                <span class="gt-seat-eco seatnot-available" data-seat-id="36"
                                  style="cursor: not-allowed;"></span>
                                <span class="gt-seat-eco" data-seat-id="37"></span>
                              </div>
                              <div class="right">
                                <span class="gt-seat-eco" data-seat-id="38"></span>
                                <span class="gt-seat-eco" data-seat-id="39"></span>
                                <span class="gt-seat-eco" data-seat-id="40"></span>
                              </div>
                            </li>
                            <li>
                              <div class="left">
                                <span class="gt-seat-eco" data-seat-id="41"></span>
                                <span class="gt-seat-eco" data-seat-id="42"></span>
                                <span class="gt-seat-eco" data-seat-id="43"></span>
                              </div>
                              <div class="right">
                                <span class="gt-seat-eco" data-seat-id="44"></span>
                                <span class="gt-seat-eco" data-seat-id="45"></span>
                                <span class="gt-seat-eco" data-seat-id="46"></span>
                              </div>
                            </li>
                            <li>
                              <div class="left">
                                <span class="gt-seat-eco" data-seat-id="47"></span>
                                <span class="gt-seat-eco seatnot-available" data-seat-id="48"
                                  style="cursor: not-allowed;"></span>
                                <span class="gt-seat-eco" data-seat-id="49"></span>
                              </div>
                              <div class="right">
                                <span class="gt-seat-eco" data-seat-id="50"></span>
                                <span class="gt-seat-eco seatnot-available" data-seat-id="51"
                                  style="cursor: not-allowed;"></span>
                                <span class="gt-seat-eco" data-seat-id="52"></span>
                              </div>
                            </li>
                            <li>
                              <div class="left">
                                <span class="gt-seat-eco" data-seat-id="53"></span>
                                <span class="gt-seat-eco" data-seat-id="54"></span>
                                <span class="gt-seat-eco" data-seat-id="55"></span>
                              </div>
                              <div class="right">
                                <span class="gt-seat-eco" data-seat-id="56"></span>
                                <span class="gt-seat-eco" data-seat-id="57"></span>
                                <span class="gt-seat-eco" data-seat-id="58"></span>

                              </div>
                            </li>


                            <li>
                              <div class="left">
                                <span class="gt-seat-eco" data-seat-id="53"></span>
                                <span class="gt-seat-eco" data-seat-id="54"></span>
                                <span class="gt-seat-eco" data-seat-id="55"></span>
                              </div>
                              <div class="right">
                                <span class="gt-seat-eco" data-seat-id="56"></span>
                                <span class="gt-seat-eco" data-seat-id="57"></span>
                                <span class="gt-seat-eco" data-seat-id="58"></span>

                              </div>
                            </li>
                            <li>
                              <div class="left">
                                <span class="gt-seat-eco" data-seat-id="53"></span>
                                <span class="gt-seat-eco" data-seat-id="54"></span>
                                <span class="gt-seat-eco" data-seat-id="55"></span>
                              </div>
                              <div class="right">
                                <span class="gt-seat-eco" data-seat-id="56"></span>
                                <span class="gt-seat-eco" data-seat-id="57"></span>
                                <span class="gt-seat-eco" data-seat-id="58"></span>

                              </div>
                            </li>

                            <li>
                              <div class="left">
                                <span class="gt-seat-eco" data-seat-id="53"></span>
                                <span class="gt-seat-eco" data-seat-id="54"></span>
                                <span class="gt-seat-eco" data-seat-id="55"></span>
                              </div>
                              <div class="right">
                                <span class="gt-seat-eco" data-seat-id="56"></span>
                                <span class="gt-seat-eco" data-seat-id="57"></span>
                                <span class="gt-seat-eco" data-seat-id="58"></span>

                              </div>
                            </li>
                            <li>
                              <div class="left">
                                <span class="gt-seat-eco" data-seat-id="53"></span>
                                <span class="gt-seat-eco" data-seat-id="54"></span>
                                <span class="gt-seat-eco" data-seat-id="55"></span>
                              </div>
                              <div class="right">
                                <span class="gt-seat-eco" data-seat-id="56"></span>
                                <span class="gt-seat-eco" data-seat-id="57"></span>
                                <span class="gt-seat-eco" data-seat-id="58"></span>

                              </div>
                            </li>
                            <li>
                              <div class="left">
                                <span class="gt-seat-eco" data-seat-id="53"></span>
                                <span class="gt-seat-eco" data-seat-id="54"></span>
                                <span class="gt-seat-eco" data-seat-id="55"></span>
                              </div>
                              <div class="right">
                                <span class="gt-seat-eco" data-seat-id="56"></span>
                                <span class="gt-seat-eco" data-seat-id="57"></span>
                                <span class="gt-seat-eco" data-seat-id="58"></span>

                              </div>
                            </li>

                            <!-- <li>
                                        <div class="left">
                                            <span class="gt-seat-eco" data-seat-id="53"></span>
                                            <span class="gt-seat-eco" data-seat-id="54"></span>
                                            <span class="gt-seat-eco" data-seat-id="55"></span>
                                        </div>
                                        <div class="right">
                                            <span class="gt-seat-eco" data-seat-id="56"></span>
                                            <span class="gt-seat-eco" data-seat-id="57"></span>
                                            <span class="gt-seat-eco" data-seat-id="58"></span>
                                            
                                        </div>
                                    </li><li>
                                        <div class="left">
                                            <span class="gt-seat-eco" data-seat-id="53"></span>
                                            <span class="gt-seat-eco" data-seat-id="54"></span>
                                            <span class="gt-seat-eco" data-seat-id="55"></span>
                                        </div>
                                        <div class="right">
                                            <span class="gt-seat-eco" data-seat-id="56"></span>
                                            <span class="gt-seat-eco" data-seat-id="57"></span>
                                            <span class="gt-seat-eco" data-seat-id="58"></span>
                                            
                                        </div>
                                    </li><li>
                                        <div class="left">
                                            <span class="gt-seat-eco" data-seat-id="53"></span>
                                            <span class="gt-seat-eco" data-seat-id="54"></span>
                                            <span class="gt-seat-eco" data-seat-id="55"></span>
                                        </div>
                                        <div class="right">
                                            <span class="gt-seat-eco" data-seat-id="56"></span>
                                            <span class="gt-seat-eco" data-seat-id="57"></span>
                                            <span class="gt-seat-eco" data-seat-id="58"></span>
                                            
                                        </div>
                                    </li> -->

                            <!-- <li>
                                        <div class="left">
                                            <span class="gt-seat-eco" data-seat-id="53"></span>
                                            <span class="gt-seat-eco" data-seat-id="54"></span>
                                            <span class="gt-seat-eco" data-seat-id="55"></span>
                                        </div>
                                        <div class="right">
                                            <span class="gt-seat-eco" data-seat-id="56"></span>
                                            <span class="gt-seat-eco" data-seat-id="57"></span>
                                            <span class="gt-seat-eco" data-seat-id="58"></span>
                                            
                                        </div>
                                    </li><li>
                                        <div class="left">
                                            <span class="gt-seat-eco" data-seat-id="53"></span>
                                            <span class="gt-seat-eco" data-seat-id="54"></span>
                                            <span class="gt-seat-eco" data-seat-id="55"></span>
                                        </div>
                                        <div class="right">
                                            <span class="gt-seat-eco" data-seat-id="56"></span>
                                            <span class="gt-seat-eco" data-seat-id="57"></span>
                                            <span class="gt-seat-eco" data-seat-id="58"></span>
                                            
                                        </div>
                                    </li><li>
                                        <div class="left">
                                            <span class="gt-seat-eco" data-seat-id="53"></span>
                                            <span class="gt-seat-eco" data-seat-id="54"></span>
                                            <span class="gt-seat-eco" data-seat-id="55"></span>
                                        </div>
                                        <div class="right">
                                            <span class="gt-seat-eco" data-seat-id="56"></span>
                                            <span class="gt-seat-eco" data-seat-id="57"></span>
                                            <span class="gt-seat-eco" data-seat-id="58"></span>
                                            
                                        </div>
                                    </li><li>
                                        <div class="left">
                                            <span class="gt-seat-eco" data-seat-id="53"></span>
                                            <span class="gt-seat-eco" data-seat-id="54"></span>
                                            <span class="gt-seat-eco" data-seat-id="55"></span>
                                        </div>
                                        <div class="right">
                                            <span class="gt-seat-eco" data-seat-id="56"></span>
                                            <span class="gt-seat-eco" data-seat-id="57"></span>
                                            <span class="gt-seat-eco" data-seat-id="58"></span>
                                            
                                        </div>
                                    </li> -->
                          </ul>
                        </div>


                        <span>
                          <img src="{{ asset('assets/img/f-back.png') }}" alt="">
                        </span>
                      </div>



                      <!-- <div class="exp-and-photos">
                    <strong class="exp-title">
                      <span>Get the best</span> of service experience the best!
                    </strong>
                    <ul class="flights-photos">
                      <li> <img src="{{ asset('assets/img/flight-pic1.jpg') }}" alt=""> <span>Seats</span></li>
                      <li> <img src="{{ asset('assets/img/flight-pic2.jpg') }}" alt=""> <span>services</span></li>
                      <li> <img src="{{ asset('assets/img/flight-pic3.jpg') }}" alt=""> <span>flight</span></li>
                    </ul>

                  </div> -->

                      <!-- <footer>
                        <h4>You have selected</h4>
                        <span>you have selected following optionst</span>

                        <ul class="seat-dtls">
                          <li><i class="gt-seat-eco seat-ec"></i> Passenger name 1 </li>
                          <li><i class="gt-seat-eco seat-ec"></i>Passenger name 2</li>
                          <li><i class="gt-seat-business seat-sbc"></i>Passenger name 3</li>
                        </ul>

                        <p>We have written example text for over 40 industry sectors, this is an ongoing project and we
                          will
                          be adding more copy if there</p>
                      </footer> -->
                    </div>









                  </div>
                  <div class="tab-pane table-responsive userprof-tab" id="tab22" role="tabpanel">


                    <div class="baggage-allw">
                      <p class="info-b pt-2">If your fare includes checked baggage, you can take up to 3 bags up to the
                        combined weight of your baggage allowance. Max. dimension 165 cm (height + width + depth).
                      </p>

                      <div class="included_baggage">


                        <div class="row align-items-center justify-content-between g-2 mb-2">

                          <div class="col-12">
                            <p class="pt-2">Included baggage</p>
                          </div>

                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/hand-baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Hand baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">7 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>


                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Checked baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">30 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>






                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/hand-baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Hand baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">7 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>



                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Checked baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">30 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 m-auto text-center">
                        <button class="btn add-baggage" type="button">+ 10 KG
                          AED 310</button>
                      </div>
                    </div>

                  </div>



                  <div class="tab-pane table-responsive userprof-tab" id="tab33" role="tabpanel">



                    <div class="baggage-allw">
                      <p class="info-b pt-2">If your fare includes checked baggage, you can take up to 3 bags up to the
                        combined weight of your baggage allowance. Max. dimension 165 cm (height + width + depth).
                      </p>

                      <div class="included_baggage">


                        <div class="row align-items-center justify-content-between g-2 mb-2">

                          <div class="col-12">
                            <p class="pt-2">Included baggage</p>
                          </div>

                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/hand-baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Hand baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">7 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>


                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Checked baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">30 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>






                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/hand-baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Hand baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">7 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>



                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Checked baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">30 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 m-auto text-center">
                        <button class="btn add-baggage" type="button">+ 10 KG
                          AED 310</button>
                      </div>
                    </div>

                  </div>


                  <div class="tab-pane table-responsive userprof-tab" id="tab44" role="tabpanel">

                    <div class="baggage-allw">
                      <p class="info-b pt-2">If your fare includes checked baggage, you can take up to 3 bags up to the
                        combined weight of your baggage allowance. Max. dimension 165 cm (height + width + depth).
                      </p>

                      <div class="included_baggage">


                        <div class="row align-items-center justify-content-between g-2 mb-2">

                          <div class="col-12">
                            <p class="pt-2">Included baggage</p>
                          </div>

                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/hand-baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Hand baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">7 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>



                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Checked baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">30 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 m-auto text-center">
                        <button class="btn add-baggage" type="button">+ 10 KG
                          AED 310</button>
                      </div>
                    </div>

                  </div>
                </div>
              </div>








            </div>
          </div>



          <div class="tab-pane fade" id="nav-meals" role="tabpanel" aria-labelledby="nav-meals-tab">

            <div class="row">

              <div class="col-lg-6 col-md-6 col-sm-12 col-12">

                <div class="faqs_main_item">
                  <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                          data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                          <div class="flight-card flights-list__item">
                            <div class="flight-card-list-dt">
                              <div class="flight-card__departure">
                                <h2 class="flight-card__city">Dubai (DXB)</h2>
                                <!-- <time class="flight-card__day">Tuesday, Apr 21, 2020</time> -->
                              </div>

                              <div class="flight-card__route">
                                <div class="flight-card__route-line route-line" aria-hidden="true">
                                  <i class="fas fa-plane-departure"></i>
                                </div>
                                <!-- flight-card__route-line -->
                              </div>

                              <div class="flight-card__arrival">
                                <h2 class="flight-card__city">Kozhikode (CCJ)</h2>
                                <!-- <time class="flight-card__day">Tuesday, Apr 21, 2020</time> -->
                              </div>
                            </div>
                            <hr>

                            <div class="flight-card-ft-typ">
                              <p>flydubai FZ 429</p>
                              <p>Economy (Value)</p>
                            </div>
                          </div>
                        </button>
                      </h2>


                      <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                        data-bs-parent="#accordionExample" style="">
                        <div class="accordion-body">

                          <div class="tabs-menus"> <!-- Tabs -->
                            <ul class="nav panel-tabs" role="tablist">
                              <li class="">

                                <a href="#tab100" class="active" data-bs-toggle="tab" aria-selected="false" role="tab"
                                  tabindex="-1">
                                  <div class="card border">
                                    <div class="card-header">
                                      <div class="crd-heady102 d-flex align-items-center justify-content-start">
                                        <div class="square--30 circle bg-light-primary  text-secondary flex-shrink-0">

                                          <img width="25" src="{{ asset('assets/img/adult.svg') }}" alt="img">
                                        </div>
                                        <div class="crd-heady102Title lh-1 ps-2"><span
                                            class="text-sm fw-semibold text-dark text-uppercase lh-1 mb-0">
                                            Adult 1</span></div>
                                      </div>
                                      <div class="d-flex align-items-center justify-content-start">
                                        <div class="text-dark fw-bold text-md me-2">+ 10 kg checked baggage</div>
                                      </div>
                                      <div class="crd-heady103">
                                        <p class="btn btn-secondary btn-sm px-4 fw-semibold text-uppercase">AED 0
                                        </p>
                                      </div>
                                    </div>
                                  </div>
                                </a>


                              </li>



                              <li><a href="#tab200" data-bs-toggle="tab" aria-selected="false" role="tab" class=""
                                  tabindex="-1">
                                  <div class="card border">
                                    <div class="card-header">
                                      <div class="crd-heady102 d-flex align-items-center justify-content-start">
                                        <div class="square--30 circle bg-light-primary  text-secondary flex-shrink-0">
                                          <img width="25" src="{{ asset('assets/img/infant.svg') }}" alt="img">
                                        </div>
                                        <div class="crd-heady102Title lh-1 ps-2"><span
                                            class="text-sm fw-semibold text-dark text-uppercase lh-1 mb-0">
                                            Infant 1</span></div>
                                      </div>
                                      <div class="d-flex align-items-center justify-content-start">
                                        <div class="text-dark fw-bold text-sm me-2">Infants can't buy extra baggage
                                          allowance
                                        </div>
                                      </div>
                                      <div class="crd-heady103">
                                        <p class="btn btn-secondary btn-sm px-4 fw-semibold text-uppercase">AED 0
                                        </p>
                                      </div>
                                    </div>
                                  </div>


                                </a></li>
                              <li><a href="#tab300" data-bs-toggle="tab" aria-selected="false" role="tab" class=""
                                  tabindex="-1">


                                  <div class="card border">
                                    <div class="card-header">
                                      <div class="crd-heady102 d-flex align-items-center justify-content-start">
                                        <div class="square--30 circle bg-light-primary  text-secondary flex-shrink-0">
                                          <img width="25" src="{{ asset('assets/img/adult.svg') }}" alt="img">
                                        </div>
                                        <div class="crd-heady102Title lh-1 ps-2"><span
                                            class="text-sm fw-semibold text-dark text-uppercase lh-1 mb-0">
                                            Adult 2</span></div>
                                      </div>
                                      <div class="d-flex align-items-center justify-content-start">
                                        <div class="text-dark fw-bold text-md me-2">+ 10 kg checked baggage</div>
                                      </div>
                                      <div class="crd-heady103">
                                        <p class="btn btn-secondary btn-sm px-4 fw-semibold text-uppercase">AED
                                          350</p>
                                      </div>
                                    </div>
                                  </div>



                                </a></li>
                              <li><a href="#tab400" data-bs-toggle="tab" aria-selected="false" role="tab" class=""
                                  tabindex="-1">


                                  <div class="card border">
                                    <div class="card-header">
                                      <div class="crd-heady102 d-flex align-items-center justify-content-start">
                                        <div class="square--30 circle bg-light-primary  text-secondary flex-shrink-0">
                                          <img width="25" src="{{ asset('assets/img/adult.svg') }}" alt="img">
                                        </div>
                                        <div class="crd-heady102Title lh-1 ps-2"><span
                                            class="text-sm fw-semibold text-dark text-uppercase lh-1 mb-0">
                                            Adult 3</span></div>
                                      </div>
                                      <div class="d-flex align-items-center justify-content-start">
                                        <div class="text-dark fw-bold text-md me-2">Not selected</div>
                                      </div>
                                      <div class="crd-heady103">
                                        <p class="btn btn-secondary btn-sm px-4 fw-semibold text-uppercase">AED
                                          350</p>
                                      </div>
                                    </div>
                                  </div>
                                </a>
                              </li>

                            </ul>
                          </div>


                        </div>
                      </div>
                    </div>

                  </div>



                  <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingtwo">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                          data-bs-target="#collapsetwo" aria-expanded="true" aria-controls="collapsetwo">
                          <div class="flight-card flights-list__item">
                            <div class="flight-card-list-dt">
                              <div class="flight-card__departure">
                                <h2 class="flight-card__city"> Kozhikode (CCJ) </h2>
                                <!-- <time class="flight-card__day">Tuesday, Apr 21, 2020</time> -->
                              </div>

                              <div class="flight-card__route">
                                <div class="flight-card__route-line route-line" aria-hidden="true">
                                  <i class="fas fa-plane-departure"></i>
                                </div>
                                <!-- flight-card__route-line -->
                              </div>

                              <div class="flight-card__arrival">
                                <h2 class="flight-card__city">Dubai (DXB)</h2>
                                <!-- <time class="flight-card__day">Tuesday, Apr 21, 2020</time> -->
                              </div>
                            </div>
                            <hr>

                            <div class="flight-card-ft-typ">
                              <p>flydubai FZ 429</p>
                              <p>Economy (Value)</p>
                            </div>
                          </div>
                        </button>
                      </h2>

                      <div id="collapsetwo" class="accordion-collapse collapse" aria-labelledby="headingtwo"
                        data-bs-parent="#accordionExample" style="">
                        <div class="accordion-body">

                          <div class="tabs-menus"> <!-- Tabs -->
                            <ul class="nav panel-tabs" role="tablist">
                              <li class="">

                                <a href="#tab100" class="" data-bs-toggle="tab" aria-selected="false" role="tab"
                                  tabindex="-1">
                                  <div class="card border">
                                    <div class="card-header">
                                      <div class="crd-heady102 d-flex align-items-center justify-content-start">
                                        <div class="square--30 circle bg-light-primary  text-secondary flex-shrink-0">

                                          <img width="25" src="{{ asset('assets/img/adult.svg') }}" alt="img">
                                        </div>
                                        <div class="crd-heady102Title lh-1 ps-2"><span
                                            class="text-sm fw-semibold text-dark text-uppercase lh-1 mb-0">
                                            Adult 1</span></div>
                                      </div>
                                      <div class="d-flex align-items-center justify-content-start">
                                        <div class="text-dark fw-bold text-md me-2">+ 10 kg checked baggage</div>
                                      </div>
                                      <div class="crd-heady103">
                                        <p class="btn btn-secondary btn-sm px-4 fw-semibold text-uppercase">AED 0
                                        </p>
                                      </div>
                                    </div>
                                  </div>
                                </a>
                              </li>



                              <li><a href="#tab200" data-bs-toggle="tab" aria-selected="false" role="tab" class=""
                                  tabindex="-1">
                                  <div class="card border">
                                    <div class="card-header">
                                      <div class="crd-heady102 d-flex align-items-center justify-content-start">
                                        <div class="square--30 circle bg-light-primary  text-secondary flex-shrink-0">
                                          <img width="25" src="{{ asset('assets/img/infant.svg') }}" alt="img">
                                        </div>
                                        <div class="crd-heady102Title lh-1 ps-2"><span
                                            class="text-sm fw-semibold text-dark text-uppercase lh-1 mb-0">
                                            Infant 1</span></div>
                                      </div>
                                      <div class="d-flex align-items-center justify-content-start">
                                        <div class="text-dark fw-bold text-sm me-2">Infants can't buy extra baggage
                                          allowance
                                        </div>
                                      </div>
                                      <div class="crd-heady103">
                                        <p class="btn btn-secondary btn-sm px-4 fw-semibold text-uppercase">AED 0
                                        </p>
                                      </div>
                                    </div>
                                  </div>


                                </a></li>
                              <li>
                                <a href="#tab300" data-bs-toggle="tab" aria-selected="false" role="tab" class=""
                                  tabindex="-1">
                                  <div class="card border">
                                    <div class="card-header">
                                      <div class="crd-heady102 d-flex align-items-center justify-content-start">
                                        <div class="square--30 circle bg-light-primary  text-secondary flex-shrink-0">
                                          <img width="25" src="{{ asset('assets/img/adult.svg') }}" alt="img">
                                        </div>
                                        <div class="crd-heady102Title lh-1 ps-2"><span
                                            class="text-sm fw-semibold text-dark text-uppercase lh-1 mb-0">
                                            Adult 2</span></div>
                                      </div>
                                      <div class="d-flex align-items-center justify-content-start">
                                        <div class="text-dark fw-bold text-md me-2">+ 10 kg checked baggage</div>
                                      </div>
                                      <div class="crd-heady103">
                                        <p class="btn btn-secondary btn-sm px-4 fw-semibold text-uppercase">AED
                                          350</p>
                                      </div>
                                    </div>
                                  </div>
                                </a>
                              </li>

                              <li><a href="#tab400" data-bs-toggle="tab" aria-selected="false" role="tab" class=""
                                  tabindex="-1">


                                  <div class="card border">
                                    <div class="card-header">
                                      <div class="crd-heady102 d-flex align-items-center justify-content-start">
                                        <div class="square--30 circle bg-light-primary  text-secondary flex-shrink-0">
                                          <img width="25" src="{{ asset('assets/img/adult.svg') }}" alt="img">
                                        </div>
                                        <div class="crd-heady102Title lh-1 ps-2"><span
                                            class="text-sm fw-semibold text-dark text-uppercase lh-1 mb-0">
                                            Adult 3</span></div>
                                      </div>
                                      <div class="d-flex align-items-center justify-content-start">
                                        <div class="text-dark fw-bold text-md me-2">Not selected</div>
                                      </div>
                                      <div class="crd-heady103">
                                        <p class="btn btn-secondary btn-sm px-4 fw-semibold text-uppercase">AED
                                          350</p>
                                      </div>
                                    </div>
                                  </div>
                                </a>
                              </li>

                            </ul>
                          </div>


                        </div>
                      </div>
                    </div>

                  </div>
                </div>

              </div>


              <div class="col-lg-6 col-md-6 col-sm-12 col-12">


                <div class="tab-content meal-selector">
                  <div class="tab-pane table-responsive userprof-tab active show" id="tab100" role="tabpanel">

                    <div class="baggage-allw">
                      <p class="info-b pt-2">
                        Please select your dietary preference. All food served on board is halal.

                      </p>

                      <div class="included_baggage">


                        <div class="row align-items-center justify-content-between g-2 mb-2">


                          <div class="col-6">
                            <div class="meal-box-w">
                              <input type="radio" id="control_01" name="select" value="1" checked>
                              <label for="control_01">
                                <h2>Standard meal</h2>
                              </label>
                            </div>

                          </div>


                          <div class="col-6">

                            <div class="meal-box-w">
                              <input type="radio" id="control_02" name="select" value="2">
                              <label for="control_02">
                                <h2>Child meal</h2>
                              </label>
                            </div>
                          </div>


                          <div class="col-6">
                            <div class="meal-box-w">
                              <input type="radio" id="control_03" name="select" value="3" checked>
                              <label for="control_03">
                                <h2>Diabetic meal</h2>
                              </label>
                            </div>

                          </div>


                          <div class="col-6">

                            <div class="meal-box-w">
                              <input type="radio" id="control_04" name="select" value="4">
                              <label for="control_04">
                                <h2>Fruit platter</h2>
                              </label>
                            </div>
                          </div>



                          <div class="col-6">

                            <div class="meal-box-w">
                              <input type="radio" id="control_05" name="select" value="5">
                              <label for="control_05">
                                <h2>Gluten-free meal</h2>
                              </label>
                            </div>
                          </div>






                          <div class="col-6">

                            <div class="meal-box-w">
                              <input type="radio" id="control_06" name="select" value="6">
                              <label for="control_06">
                                <h2> Low-fat meal</h2>
                              </label>
                            </div>
                          </div>





                          <div class="col-6">

                            <div class="meal-box-w">
                              <input type="radio" id="control_07" name="select" value="7">
                              <label for="control_07">
                                <h2>Fruit platter</h2>
                              </label>
                            </div>
                          </div>










                        </div>
                      </div>

                    </div>


                  </div>
                  <div class="tab-pane table-responsive userprof-tab" id="tab200" role="tabpanel">


                    <div class="baggage-allw">
                      <p class="info-b pt-2">If your fare includes checked baggage, you can take up to 3 bags up to the
                        combined weight of your baggage allowance. Max. dimension 165 cm (height + width + depth).
                      </p>

                      <div class="included_baggage">


                        <div class="row align-items-center justify-content-between g-2 mb-2">

                          <div class="col-12">
                            <p class="pt-2">Included baggage</p>
                          </div>

                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/hand-baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Hand baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">7 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>


                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Checked baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">30 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>






                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/hand-baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Hand baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">7 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>



                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Checked baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">30 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 m-auto text-center">
                        <button class="btn add-baggage" type="button">+ 10 KG
                          AED 310</button>
                      </div>
                    </div>

                  </div>



                  <div class="tab-pane table-responsive userprof-tab" id="tab300" role="tabpanel">



                    <div class="baggage-allw">
                      <p class="info-b pt-2">If your fare includes checked baggage, you can take up to 3 bags up to the
                        combined weight of your baggage allowance. Max. dimension 165 cm (height + width + depth).
                      </p>

                      <div class="included_baggage">


                        <div class="row align-items-center justify-content-between g-2 mb-2">

                          <div class="col-12">
                            <p class="pt-2">Included baggage</p>
                          </div>

                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/hand-baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Hand baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">7 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>


                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Checked baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">30 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>






                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/hand-baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Hand baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">7 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>



                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Checked baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">30 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 m-auto text-center">
                        <button class="btn add-baggage" type="button">+ 10 KG
                          AED 310</button>
                      </div>
                    </div>

                  </div>


                  <div class="tab-pane table-responsive userprof-tab" id="tab400" role="tabpanel">

                    <div class="baggage-allw">
                      <p class="info-b pt-2">If your fare includes checked baggage, you can take up to 3 bags up to the
                        combined weight of your baggage allowance. Max. dimension 165 cm (height + width + depth).
                      </p>

                      <div class="included_baggage">


                        <div class="row align-items-center justify-content-between g-2 mb-2">

                          <div class="col-12">
                            <p class="pt-2">Included baggage</p>
                          </div>

                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/hand-baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Hand baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">7 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>



                          <div class="col-6">
                            <div class="bg-white rounded-2 p-2">
                              <div class="d-flex align-items-center justify-content-between g-2">
                                <div class="img-baggage">
                                  <img width="50" src="{{ asset('assets/img/baggage.svg') }}" alt="img">
                                </div>
                                <div class="">
                                  <small class="d-block text-muted text-md fw-medium ">Checked baggage</small>
                                  <p class="text-dark fw-bold lh-base text-md mb-0">30 KG</p>
                                </div>

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 m-auto text-center">
                        <button class="btn add-baggage" type="button">+ 10 KG
                          AED 310</button>
                      </div>
                    </div>

                  </div>
                </div>
              </div>




            </div>



          </div>

        </div>
      </div>
    </div>
  </div>
</section>


























<!-- Our partners Area -->
<!-- <section id="our_partners_four" class="section_padding">
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
</section> -->



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

<script type="text/javascript">

  // seatselect js////////////////////////////////////////


  var seatData = [{ id: 1, booked: false, type: 1 }, { id: 2, booked: false, type: 1 }, { id: 3, booked: true, type: 1 }, { id: 4, booked: true, type: 1 }, { id: 5, booked: false, type: 1 }, { id: 6, booked: false, type: 1 }, { id: 7, booked: false, type: 1 }, { id: 8, booked: false, type: 1 }, { id: 9, booked: false, type: 1 }, { id: 10, booked: false, type: 1 }, { id: 11, booked: true, type: 1 }, { id: 12, booked: false, type: 1 }, { id: 13, booked: false, type: 1 }, { id: 14, booked: false, type: 1 }, { id: 15, booked: false, type: 1 }, { id: 16, booked: false, type: 1 }, { id: 17, booked: true, type: 1 }, { id: 18, booked: false, type: 1 }, { id: 19, booked: false, type: 1 }, { id: 20, booked: false, type: 1 }, { id: 21, booked: false, type: 1 }, { id: 22, booked: false, type: 1 }, { id: 23, booked: false, type: 1 }, { id: 24, booked: false, type: 1 }, { id: 25, booked: false, type: 1 }, { id: 26, booked: false, type: 1 }, { id: 27, booked: false, type: 1 }, { id: 28, booked: false, type: 1 }, { id: 29, booked: false, type: 1 }, { id: 30, booked: false, type: 1 }, { id: 31, booked: false, type: 1 }, { id: 32, booked: false, type: 1 }, { id: 33, booked: false, type: 1 }, { id: 34, booked: true, type: 1 }, { id: 35, booked: true, type: 1 }, { id: 36, booked: true, type: 1 }, { id: 37, booked: false, type: 1 }, { id: 38, booked: false, type: 1 }, { id: 39, booked: false, type: 1 }, { id: 40, booked: false, type: 1 }, { id: 41, booked: false, type: 1 }, { id: 42, booked: false, type: 1 }, { id: 43, booked: false, type: 1 }, { id: 44, booked: false, type: 1 }, { id: 45, booked: false, type: 1 }, { id: 46, booked: false, type: 1 }, { id: 47, booked: false, type: 1 }, { id: 48, booked: true, type: 1 }, { id: 49, booked: false, type: 1 }, { id: 50, booked: false, type: 1 }, { id: 51, booked: true, type: 1 }, { id: 52, booked: false, type: 1 }, { id: 53, booked: false, type: 1 }, { id: 54, booked: false, type: 1 }, { id: 55, booked: false, type: 1 }, { id: 56, booked: false, type: 1 }, { id: 57, booked: false, type: 1 }];
  var selectedSeat = [];
  if ($('.seating-area').length) {
    var seats = $('.seating-area ul li span');
    seats.on('click', function () {
      var seat = $(this);
      var seatId = seat.attr('data-seat-id');
      var seatDataItem = seatData.find(function (seat) {
        return +seatId === seat.id;
      });

      if (!seatDataItem.booked) {
        if (selectedSeat.findIndex(function (s) {
          return s.id === +seatId;
        }) !== -1) {
          selectedSeat.push(seatDataItem);
        } else {
          selectedSeat = selectedSeat.filter(function (s) {
            return s.id !== +seatId;
          });
        }
        seat.toggleClass('seat-selected');
      }
    });

    seats.each(function (i) {
      var seat = $('.seating-area ul li span').eq(i);
      var seatId = seat.attr('data-seat-id');
      var seatItemData = seatData.find(function (s) {
        return s.id === +seatId;
      });
      if (seatItemData && seatItemData.booked) {
        // console.log(1)
        seat.addClass('seatnot-available').css('cursor', 'not-allowed');
      }
    });
  }

</script>

@endpush