<div class="tab-pane fade" id="nav-seats" role="tabpanel" aria-labelledby="nav-seats-tab">
    <div class="row">


        <div class="col-lg-5 col-md-5 col-sm-12 col-12">
            <div class="faqs_main_item">
                @if ($seat_response['exceptions'][0]['code'] == 0)
                    @foreach ($seat_response['seatQuotes']['flights'] as $flights)
                        @php
                            $leg_details = getLegDetails($flights['pfID'], $res_data['search_result']['legDetails']);
                        @endphp
        
                        <div class="accordion" id="accordionExample{{ $flights['pfID'] }}">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingtwo{{ $flights['pfID'] }}">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapsetwo{{ $flights['pfID'] }}" aria-expanded="true"
                                        aria-controls="collapsetwo{{ $flights['pfID'] }}">
                                        <div class="flight-card flights-list__item">
                                            <div class="flight-card-list-dt">
                                                <div class="flight-card__departure">
                                                    <h2 class="flight-card__city">
                                                        {{ getAirportData($leg_details['Origin'])['AirportName'] }}
                                                        ({{ $leg_details['Origin'] }})
                                                    </h2>
                                                </div>
        
                                                <div class="flight-card__route">
                                                    <div class="flight-card__route-line route-line" aria-hidden="true">
                                                        <i class="fas fa-plane-departure"></i>
                                                    </div>
                                                </div>
        
                                                <div class="flight-card__arrival">
                                                    <h2 class="flight-card__city">
                                                        {{ getAirportData($leg_details['Destination'])['AirportName'] }}
                                                        ({{ $leg_details['Destination'] }})
                                                    </h2>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapsetwo{{ $flights['pfID'] }}" class="accordion-collapse collapse"
                                    aria-labelledby="headingtwo{{ $flights['pfID'] }}"
                                    data-bs-parent="#accordionExample{{ $flights['pfID'] }}" style="">
                                    <div class="accordion-body">
                                        <div class="tabs-menus"> <!-- Tabs -->
                                            <ul class="nav panel-tabs" role="tablist">
                                                @if (isset($passengers['ADT']))
                                                    @for ($ad = 1; $ad <= $passengers['ADT']; $ad++)
                                                        <li class="">
                                                            <a href="#seatADT{{ $ad }}" class=""
                                                                data-bs-toggle="tab" aria-selected="false" role="tab"
                                                                tabindex="-1">
                                                                <div class="card border">
                                                                    <div class="card-header">
                                                                        <div
                                                                            class="crd-heady102 d-flex align-items-center justify-content-start">
                                                                            <div
                                                                                class="square--30 circle bg-light-primary  text-secondary flex-shrink-0">
        
                                                                                <img width="25"
                                                                                    src="{{ asset('assets/img/adult.svg') }}"
                                                                                    alt="img">
                                                                            </div>
                                                                            <div class="crd-heady102Title lh-1 ps-2">
                                                                                <span
                                                                                    class="text-sm fw-semibold text-dark text-uppercase lh-1 mb-0">
                                                                                    Adult {{ $ad }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    @endfor
                                                @endif
                                                @if (isset($passengers['CHD']))
                                                    @for ($ad = 1; $ad <= $passengers['CHD']; $ad++)
                                                        <li class="">
                                                            <a href="#seatCHD{{ $ad }}" class=""
                                                                data-bs-toggle="tab" aria-selected="false" role="tab"
                                                                tabindex="-1">
                                                                <div class="card border">
                                                                    <div class="card-header">
                                                                        <div
                                                                            class="crd-heady102 d-flex align-items-center justify-content-start">
                                                                            <div
                                                                                class="square--30 circle bg-light-primary  text-secondary flex-shrink-0">
        
                                                                                <img width="25"
                                                                                    src="{{ asset('assets/img/adult.svg') }}"
                                                                                    alt="img">
                                                                            </div>
                                                                            <div class="crd-heady102Title lh-1 ps-2">
                                                                                <span
                                                                                    class="text-sm fw-semibold text-dark text-uppercase lh-1 mb-0">
                                                                                    Child {{ $ad }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    @endfor
                                                @endif 
                                                @if (isset($passengers['INF']))
                                                    @for ($ad = 1; $ad <= $passengers['INF']; $ad++)
                                                        <li class="">
                                                            <a href="javascript:void(0)" class=""
                                                                data-bs-toggle="tab" aria-selected="false" role="tab"
                                                                tabindex="-1">
                                                                <div class="card border">
                                                                    <div class="card-header">
                                                                        <div
                                                                            class="crd-heady102 d-flex align-items-center justify-content-start">
                                                                            <div
                                                                                class="square--30 circle bg-light-primary  text-secondary flex-shrink-0">
        
                                                                                <img width="25"
                                                                                    src="{{ asset('assets/img/infant.svg') }}"
                                                                                    alt="img">
                                                                            </div>
                                                                            <div class="crd-heady102Title lh-1 ps-2">
                                                                                <span
                                                                                    class="text-sm fw-semibold text-dark text-uppercase lh-1 mb-0">
                                                                                    Infant {{ $ad }}</span>
                                                                            </div>
                                                                            <div class="d-flex align-items-center justify-content-start">
                                                                                <div class="text-dark fw-bold text-md me-2">
                                                                                    Infants aren't assigned their own seat
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    @endfor
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        
        


        <div class="col-lg-7 col-md-7 col-sm-12 col-12">
            <div class="tab-content">
                <div class="tab-pane table-responsive userprof-tab active show" id="tab11"
                    role="tabpanel">
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
                                        <svg width="30" height="30" viewBox="0 0 464 564"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
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
                                                    <rect width="464" height="564"
                                                        fill="white" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </span>
                                    Extra legroom
                                </li>



                                <li>

                                    <span class="gt-seat-eco standard-seat">
                                        <svg width="30" height="30" viewBox="0 0 464 564"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
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
                                                    <rect width="464" height="564"
                                                        fill="white" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </span>

                                    Standard seat
                                </li>


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
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X50</p>
                                            </span>






                                            <span class="gt-seat-business" data-seat-id="2">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X51</p>
                                            </span>

                                        </div>



                                        <div class="right">


                                            <span class="gt-seat-business seatnot-available"
                                                data-seat-id="3" style="cursor: not-allowed;">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X53</p>
                                            </span>



                                            <span class="gt-seat-business seatnot-available"
                                                data-seat-id="4" style="cursor: not-allowed;">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X54</p>
                                            </span>


                                        </div>


                                    </li>
                                    <li>
                                        <div class="left">


                                            <span class="gt-seat-business" data-seat-id="5"
                                                style="cursor: not-allowed;">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X54</p>
                                            </span>


                                            <span class="gt-seat-business" data-seat-id="6"
                                                style="cursor: not-allowed;">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X54</p>
                                            </span>



                                        </div>
                                        <div class="right">

                                            <span class="gt-seat-business seatnot-available"
                                                data-seat-id="7" style="cursor: not-allowed;">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X54</p>
                                            </span>


                                            <span class="gt-seat-business seatnot-available"
                                                data-seat-id="8" style="cursor: not-allowed;">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
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
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X50</p>
                                            </span>


                                            <span class="gt-seat-business" data-seat-id="10">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X50</p>
                                            </span>

                                        </div>
                                        <div class="right">



                                            <span class="gt-seat-business seatnot-available"
                                                data-seat-id="11">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X50</p>
                                            </span>


                                            <span class="gt-seat-business seatnot-available"
                                                data-seat-id="12">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X50</p>
                                            </span>


                                        </div>
                                    </li>
                                    <li>
                                        <div class="left">
                                            <span class="gt-seat-business"
                                                data-seat-id="13"></span>
                                            <span class="gt-seat-business"
                                                data-seat-id="14"></span>
                                        </div>
                                        <div class="right">
                                            <span class="gt-seat-business"
                                                data-seat-id="15"></span>
                                            <span class="gt-seat-business"
                                                data-seat-id="16"></span>
                                        </div>
                                    </li>
                                </ul>

                                <!-- Economy class -->
                                <ul class="area-ec">
                                    <!-- <div class="row-pointer">Economy class</div> -->



                                    <li>
                                        <div class="left">


                                            <span class="gt-seat-standard" data-seat-id="17">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X17</p>
                                            </span>

                                            <span class="gt-seat-standard" data-seat-id="18">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X18</p>
                                            </span>


                                            <span class="gt-seat-standard" data-seat-id="19">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X19</p>
                                            </span>


                                        </div>
                                        <div class="right">


                                            <span class="gt-seat-standard" data-seat-id="20">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X20</p>
                                            </span>



                                            <span class="gt-seat-standard" data-seat-id="21">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X21</p>
                                            </span>




                                            <span class="gt-seat-standard" data-seat-id="22">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
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
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X17</p>
                                            </span>

                                            <span class="gt-seat-standard" data-seat-id="18">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X18</p>
                                            </span>


                                            <span class="gt-seat-standard" data-seat-id="19">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X19</p>
                                            </span>


                                        </div>
                                        <div class="right">


                                            <span class="gt-seat-standard" data-seat-id="20">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X20</p>
                                            </span>



                                            <span class="gt-seat-standard" data-seat-id="21">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X21</p>
                                            </span>




                                            <span class="gt-seat-standard" data-seat-id="22">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
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
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X17</p>
                                            </span>

                                            <span class="gt-seat-standard" data-seat-id="18">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X18</p>
                                            </span>


                                            <span class="gt-seat-standard" data-seat-id="19">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X19</p>
                                            </span>


                                        </div>
                                        <div class="right">


                                            <span class="gt-seat-standard" data-seat-id="20">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X20</p>
                                            </span>



                                            <span class="gt-seat-standard" data-seat-id="21">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X21</p>
                                            </span>




                                            <span class="gt-seat-standard" data-seat-id="22">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
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
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X17</p>
                                            </span>

                                            <span class="gt-seat-standard" data-seat-id="18">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X18</p>
                                            </span>


                                            <span class="gt-seat-standard" data-seat-id="19">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X19</p>
                                            </span>


                                        </div>
                                        <div class="right">


                                            <span class="gt-seat-standard" data-seat-id="20">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X20</p>
                                            </span>



                                            <span class="gt-seat-standard " data-seat-id="21">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X21</p>
                                            </span>




                                            <span class="gt-seat-standard" data-seat-id="22">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
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
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X17</p>
                                            </span>

                                            <span class="gt-seat-standard" data-seat-id="18">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X18</p>
                                            </span>


                                            <span class="gt-seat-standard" data-seat-id="19">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X19</p>
                                            </span>


                                        </div>
                                        <div class="right">


                                            <span class="gt-seat-standard" data-seat-id="20">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X20</p>
                                            </span>



                                            <span class="gt-seat-standard" data-seat-id="21">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X21</p>
                                            </span>




                                            <span class="gt-seat-standard" data-seat-id="22">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
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
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X17</p>
                                            </span>

                                            <span class="gt-seat-standard" data-seat-id="18">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X18</p>
                                            </span>


                                            <span class="gt-seat-standard" data-seat-id="19">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X19</p>
                                            </span>


                                        </div>
                                        <div class="right">


                                            <span class="gt-seat-standard" data-seat-id="20">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X20</p>
                                            </span>



                                            <span class="gt-seat-standard" data-seat-id="21">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X21</p>
                                            </span>




                                            <span class="gt-seat-standard" data-seat-id="22">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
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
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X17</p>
                                            </span>

                                            <span class="gt-seat-standard" data-seat-id="18">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X18</p>
                                            </span>


                                            <span class="gt-seat-standard" data-seat-id="19">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X19</p>
                                            </span>


                                        </div>
                                        <div class="right">


                                            <span class="gt-seat-standard" data-seat-id="20">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X20</p>
                                            </span>



                                            <span class="gt-seat-standard" data-seat-id="21">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X21</p>
                                            </span>




                                            <span class="gt-seat-standard" data-seat-id="22">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
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
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X17</p>
                                            </span>

                                            <span class="gt-seat-standard" data-seat-id="18">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X18</p>
                                            </span>


                                            <span class="gt-seat-standard" data-seat-id="19">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X19</p>
                                            </span>


                                        </div>
                                        <div class="right">


                                            <span class="gt-seat-standard" data-seat-id="20">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X20</p>
                                            </span>



                                            <span class="gt-seat-standard" data-seat-id="21">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X21</p>
                                            </span>




                                            <span class="gt-seat-standard" data-seat-id="22">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
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
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X17</p>
                                            </span>

                                            <span class="gt-seat-standard" data-seat-id="18">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X18</p>
                                            </span>


                                            <span class="gt-seat-standard" data-seat-id="19">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X19</p>
                                            </span>


                                        </div>
                                        <div class="right">


                                            <span class="gt-seat-standard" data-seat-id="20">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X20</p>
                                            </span>



                                            <span class="gt-seat-standard" data-seat-id="21">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X21</p>
                                            </span>




                                            <span class="gt-seat-standard" data-seat-id="22">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
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
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X17</p>
                                            </span>

                                            <span class="gt-seat-standard" data-seat-id="18">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X18</p>
                                            </span>


                                            <span class="gt-seat-standard" data-seat-id="19">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X19</p>
                                            </span>


                                        </div>
                                        <div class="right">


                                            <span class="gt-seat-standard" data-seat-id="20">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X20</p>
                                            </span>



                                            <span class="gt-seat-standard" data-seat-id="21">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X21</p>
                                            </span>




                                            <span class="gt-seat-standard" data-seat-id="22">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
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
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X17</p>
                                            </span>

                                            <span class="gt-seat-standard" data-seat-id="18">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X18</p>
                                            </span>


                                            <span class="gt-seat-standard" data-seat-id="19">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X19</p>
                                            </span>


                                        </div>
                                        <div class="right">


                                            <span class="gt-seat-standard" data-seat-id="20">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X20</p>
                                            </span>



                                            <span class="gt-seat-standard" data-seat-id="21">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X21</p>
                                            </span>




                                            <span class="gt-seat-standard" data-seat-id="22">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
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
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X17</p>
                                            </span>

                                            <span class="gt-seat-standard" data-seat-id="18">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X18</p>
                                            </span>


                                            <span class="gt-seat-standard" data-seat-id="19">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X19</p>
                                            </span>


                                        </div>
                                        <div class="right">


                                            <span class="gt-seat-standard" data-seat-id="20">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X20</p>
                                            </span>



                                            <span class="gt-seat-standard" data-seat-id="21">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X21</p>
                                            </span>




                                            <span class="gt-seat-standard" data-seat-id="22">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
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
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X17</p>
                                            </span>

                                            <span class="gt-seat-standard" data-seat-id="18">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X18</p>
                                            </span>


                                            <span class="gt-seat-standard" data-seat-id="19">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X19</p>
                                            </span>


                                        </div>
                                        <div class="right">


                                            <span class="gt-seat-standard" data-seat-id="20">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X20</p>
                                            </span>



                                            <span class="gt-seat-standard" data-seat-id="21">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X21</p>
                                            </span>




                                            <span class="gt-seat-standard" data-seat-id="22">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
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
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X17</p>
                                            </span>

                                            <span class="gt-seat-standard" data-seat-id="18">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X18</p>
                                            </span>


                                            <span class="gt-seat-standard" data-seat-id="19">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X19</p>
                                            </span>


                                        </div>
                                        <div class="right">


                                            <span class="gt-seat-standard" data-seat-id="20">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X20</p>
                                            </span>



                                            <span class="gt-seat-standard" data-seat-id="21">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X21</p>
                                            </span>




                                            <span class="gt-seat-standard" data-seat-id="22">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
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
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X17</p>
                                            </span>

                                            <span class="gt-seat-standard" data-seat-id="18">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X18</p>
                                            </span>


                                            <span class="gt-seat-standard" data-seat-id="19">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X19</p>
                                            </span>


                                        </div>
                                        <div class="right">


                                            <span class="gt-seat-standard" data-seat-id="20">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X20</p>
                                            </span>



                                            <span class="gt-seat-standard" data-seat-id="21">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X21</p>
                                            </span>




                                            <span class="gt-seat-standard" data-seat-id="22">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
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
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X17</p>
                                            </span>

                                            <span class="gt-seat-standard" data-seat-id="18">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X18</p>
                                            </span>


                                            <span class="gt-seat-standard" data-seat-id="19">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X19</p>
                                            </span>


                                        </div>
                                        <div class="right">


                                            <span class="gt-seat-standard" data-seat-id="20">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X20</p>
                                            </span>



                                            <span class="gt-seat-standard" data-seat-id="21">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <p class="seat-number">X21</p>
                                            </span>




                                            <span class="gt-seat-standard" data-seat-id="22">
                                                <svg width="30" height="30"
                                                    viewBox="0 0 464 564" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1138_4421)">
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M346.388 376.247H123.517L95.6584 63.7295C95.6584 63.7295 79.4231 0.482422 234.905 0.482422C390.482 0.482422 374.2 63.7295 374.2 63.7295L346.388 376.247Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M421.635 528.624C421.635 548.154 409.776 563.919 395.141 563.919H74.0584C59.4231 563.919 47.6113 548.154 47.6113 528.624C47.6113 528.624 67.7996 425.754 100.976 425.754H368.364C405.964 425.754 421.635 528.624 421.635 528.624Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M463.799 393.707C463.799 410.13 454.858 423.401 443.987 423.401C433.07 423.401 424.223 410.13 424.223 393.707V267.448C424.223 251.024 433.07 237.754 443.987 237.754C454.811 237.754 463.799 251.024 463.799 267.448V393.707Z"
                                                            fill="#434343" />
                                                        <path fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M43.8 393.707C43.8 410.13 33.9648 423.401 21.9177 423.401C9.77652 423.401 -0.0117188 410.13 -0.0117188 393.707V267.448C-0.0117188 251.024 9.77652 237.754 21.9177 237.754C33.9648 237.754 43.8 251.024 43.8 267.448V393.707Z"
                                                            fill="#434343" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1138_4421">
                                                            <rect width="464" height="564"
                                                                fill="white" />
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
                                            <span class="gt-seat-eco seatnot-available"
                                                data-seat-id="34"
                                                style="cursor: not-allowed;"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="left">
                                            <span class="gt-seat-eco seatnot-available"
                                                data-seat-id="35"
                                                style="cursor: not-allowed;"></span>
                                            <span class="gt-seat-eco seatnot-available"
                                                data-seat-id="36"
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
                                            <span class="gt-seat-eco seatnot-available"
                                                data-seat-id="48"
                                                style="cursor: not-allowed;"></span>
                                            <span class="gt-seat-eco" data-seat-id="49"></span>
                                        </div>
                                        <div class="right">
                                            <span class="gt-seat-eco" data-seat-id="50"></span>
                                            <span class="gt-seat-eco seatnot-available"
                                                data-seat-id="51"
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

                                </ul>
                            </div>


                            <span>
                                <img src="{{ asset('assets/img/f-back.png') }}" alt="">
                            </span>
                        </div>



                    </div>









                </div>

            </div>
        </div>
    </div>
</div>

