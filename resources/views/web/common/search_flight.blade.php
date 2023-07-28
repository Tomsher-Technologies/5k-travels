    <div id="theme_search_form">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="theme_search_form_area">
                        <div class="theme_search_form_tabbtn">
                        <!-- {{ json_encode(Session::get('flight_search_oneway')) }}
            {{ json_encode(Session::get('flight_search_return')) }}-->
            <!-- {{ json_encode(Session::get('flight_search_multi')) }}  -->
                            <div class="flight_categories_search">
                                <ul class="nav nav-tabs" role="tablist" id="searchTab">
                                    <li class="nav-item" role="presentation">
                                        <!-- <button class="nav-link  " id="oneway-tab" data-bs-toggle="tab" data-bs-target="#oneway_flight" type="button" role="tab"
                                            aria-controls="oneway_flight" aria-selected="true">One Way</button> -->
                                        <a class="nav-link active" href="#oneway_flight">One Way</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <!-- <button class="nav-link" id="roundtrip-tab" data-bs-toggle="tab" data-bs-target="#roundtrip" type="button" role="tab"
                                            aria-controls="roundtrip" aria-selected="false">Roundtrip</button> -->
                                        <a class="nav-link" href="#roundtrip">Roundtrip</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <!-- <button class="nav-link" id="multi_city-tab" data-bs-toggle="tab" data-bs-target="#multi_city" type="button" role="tab"
                                            aria-controls="multi_city" aria-selected="false">Multi city</button> -->
                                        <a class="nav-link" href="#multi_city">Multi city</a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                        

                        @php
                            $oAdult = $rAdult =  $mAdult = 1;
                            $oChild = $oInfant = $rChild = $rInfant =  $mChild = $mInfant = 0;
                            $oClass = $rClass = $mClass = 'Economy'; 
                            $direct = '';
                            $ostopFilter = $rstopFilter = $mstopFilter = $oairlineFilter = $rairlineFilter = $mairlineFilter = $orefundFilter = $mrefundFilter = $rrefundFilter ='';
                        @endphp
                        @if(Session::has("flight_search_oneway"))
                       
                            @php
                                $oAdult = Session::get("flight_search_oneway")['oAdult'];
                                $oChild = Session::get("flight_search_oneway")['oChild'];
                                $oInfant = Session::get("flight_search_oneway")['oInfant'];
                                $oClass = Session::get("flight_search_oneway")['oClass'];
                                $direct = (isset(Session::get("flight_search_oneway")['direct'])) ? Session::get("flight_search_oneway")['direct'] : '';

                                $ostopFilter = (isset(Session::get("flight_search_oneway")['ostop_filter'])) ? Session::get("flight_search_oneway")['ostop_filter'] : '';
                                $oairlineFilter = (isset(Session::get("flight_search_oneway")['oairline_filter'])) ? Session::get("flight_search_oneway")['oairline_filter'] : '';
                                $orefundFilter = (isset(Session::get("flight_search_oneway")['orefund_filter'])) ? Session::get("flight_search_oneway")['orefund_filter'] : '';
                            @endphp
                        @endif

                        @if(Session::has("flight_search_return"))
                            @php
                                $rAdult = Session::get("flight_search_return")['rAdult'];
                                $rChild = Session::get("flight_search_return")['rChild'];
                                $rInfant = Session::get("flight_search_return")['rInfant'];
                                $rClass = Session::get("flight_search_return")['rClass'];

                                $rstopFilter = (isset(Session::get("flight_search_return")['rstop_filter'])) ? Session::get("flight_search_return")['rstop_filter'] : '';
                                $rairlineFilter = (isset(Session::get("flight_search_return")['rairline_filter'])) ? Session::get("flight_search_return")['rairline_filter'] : '';
                                $rrefundFilter = (isset(Session::get("flight_search_return")['rrefund_filter'])) ? Session::get("flight_search_return")['rrefund_filter'] : '';
                            @endphp
                        @endif
                        @if(Session::has("flight_search_multi"))
                            @php
                                $mAdult = Session::get("flight_search_multi")['mAdult'];
                                $mChild = Session::get("flight_search_multi")['mChild'];
                                $mInfant = Session::get("flight_search_multi")['mInfant'];
                                $mClass = Session::get("flight_search_multi")['mClass'];

                                $mstopFilter = (isset(Session::get("flight_search_multi")['mstop_filter'])) ? Session::get("flight_search_multi")['mstop_filter'] : '';
                                $mairlineFilter = (isset(Session::get("flight_search_multi")['mairline_filter'])) ? Session::get("flight_search_multi")['mairline_filter'] : '';
                                $mrefundFilter = (isset(Session::get("flight_search_multi")['mrefund_filter'])) ? Session::get("flight_search_multi")['mrefund_filter'] : '';
                            @endphp
                        @endif
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="flights" role="tabpanel" aria-labelledby="flights-tab">
                                <div class="tab-content" id="myTabContent1">
                                    <div class="tab-pane fade show active" id="oneway_flight" role="tabpanel" aria-labelledby="oneway-tab">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="oneway_search_form">
                                                    <form action="{{ route('flight.search') }}" id="oFromForm">
                                                        <div class="row">
                                                            <input type="hidden" id="search_type" name="search_type" value="OneWay">
                                                            <input type="hidden" class="stop_filterField" id="ostop_filter" name="ostop_filter" value="{{$ostopFilter}}">
                                                            <input type="hidden" class="airline_filterField" id="oairline_filter" name="oairline_filter" value="{{$oairlineFilter}}">
                                                            <input type="hidden" class="refund_filterField" id="orefund_filter" name="orefund_filter" value="{{$orefundFilter}}">
                                                            <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                                <div class="flight_Search_boxed">
                                                                    <p>From</p>
                                                                   <input type="text" name="oFrom" placeholder="Enter Departure City" class="selectAirportFrom load_airports col-sm-12 " id="oFrom">
                                                                   <input type="hidden" class="airport" name="oFrom_label"  id="oFrom_label">
                                                                    <span class="place-label from_airport" id="oFrom_labels"></span>
                                                                    <div class="plan_icon_posation">
                                                                        <i class="fas fa-plane-departure"></i>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                            <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                                <div class="flight_Search_boxed">
                                                                    <p>To </p>
                                                                    <input type="text" name="oTo" placeholder="Enter Destination City" class="selectAirportTo load_airports col-sm-12 " id="oTo">
                                                                    <input type="hidden"  class="airport"  name="oTo_label"  id="oTo_label">
                                                                    <span  class="place-label to_airport" id="oTo_labels"></span>
                                                                    <div class="plan_icon_posation">
                                                                        <i class="fas fa-plane-arrival"></i>
                                                                    </div>
                                                                    <div class="range_plan">
                                                                        <i class="fas fa-exchange-alt"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4  col-md-6 col-sm-12 col-12">
                                                                <div class="form_search_date">
                                                                    <div class="flight_Search_boxed date_flex_area">
                                                                        <div class="Journey_date">
                                                                            <p>Journey date</p>
                                                                            <input type="date" value="" class="travel_date" id="oDate" name="oDate">
                                                                            <span class="place-label day_label oDate_label" id=""></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2  col-md-6 col-sm-12 col-12">
                                                                <div  class="flight_Search_boxed dropdown_passenger_area">
                                                                    <p>Passenger, Class </p>
                                                                    <div class="dropdown">
                                                                        @php $passengers = ($oAdult + $oChild + $oInfant); @endphp
                                                                        <button class="dropdown-toggle one_way_final_count" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        {{ ($passengers > 1) ? $passengers .' Passengers' : $passengers.' Passenger' }} 
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown_passenger_info" aria-labelledby="dropdownMenuButton1">
                                                                            <div class="traveller-calulate-persons">
                                                                                <div class="passengers">
                                                                                    <h6>Passengers</h6>
                                                                                    <div class="passengers-types">
                                                                                        <div class="passengers-type">
                                                                                            <div class="text">
                                                                                                <input type="text" name="oAdult" id="oAdult" class="count" value="{{$oAdult}}">
                                                                                                <div class="type-label">
                                                                                                    <p>Adult </p>
                                                                                                    <span>12+ yrs</span>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="button-set"> 
                                                                                                <button type="button" class="oAdult" id="plus">
                                                                                                    <i class="fas fa-plus"></i>
                                                                                                </button>
                                                                                                <button type="button" class="oAdult" id="minus">
                                                                                                    <i class="fas fa-minus"></i>
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="passengers-type">
                                                                                            <div class="text">
                                                                                                <input type="text" name="oChild" id="oChild" class="count" value="{{$oChild}}">
                                                                                                <div class="type-label">
                                                                                                    <p class="fz14 mb-xs-0"> Children </p>
                                                                                                    <span>2 - Less than 12 yrs</span>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="button-set">
                                                                                                <button type="button" class="oChild" id="plus">
                                                                                                    <i class="fas fa-plus"></i>
                                                                                                </button>
                                                                                                <button type="button" class="oChild" id="minus">
                                                                                                    <i class="fas fa-minus"></i>
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="passengers-type">
                                                                                            <div  class="text">
                                                                                                <input type="text" name="oInfant" id="oInfant" class="count" value="{{$oInfant}}">
                                                                                                <div class="type-label">
                                                                                                    <p class="fz14 mb-xs-0"> Infant </p>
                                                                                                    <span>Less than 2 yrs</span>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="button-set">
                                                                                                <button type="button" class="oInfant" id="plus">
                                                                                                    <i class="fas fa-plus"></i>
                                                                                                </button>
                                                                                                <button type="button" class="oInfant" id="minus">
                                                                                                    <i class="fas fa-minus"></i>
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="cabin-selection">
                                                                                    <h6>Cabin Class</h6>
                                                                                    <div class="cabin-list one_way_cabin">
                                                                                        <input class="form-check-input hide"  type="text" value="{{$oClass}}" name="oClass" id="oClass">
                                                                                        <button type="button" class="label-select-btn {{ $oClass == 'Economy' ? 'active' : ''}} " data-id="Economy">
                                                                                            <span class="muiButton-label">Economy </span>
                                                                                        </button>
                                                                                        <button type="button" class="label-select-btn {{ $oClass == 'Business' ? 'active' : ''}}"  data-id="Business">
                                                                                            <span class="muiButton-label"> Business </span>
                                                                                        </button>
                                                                                        <button type="button" class="label-select-btn {{ $oClass == 'First' ? 'active' : ''}}"  data-id="First">
                                                                                            <span  class="MuiButton-label">First Class </span>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <span class="place-label" id="oClass_label">{{$oClass}}</span>
                                                                </div>
                                                            </div>
                                                            <div class="top_form_search_button">
                                                                <div class="form-check write_spical_check">
                                                                    <input class="form-check-input" type="checkbox" value="1" {{ $direct != '' ? 'checked' : '' }} name="direct" id="flexCheckDefaultf1">
                                                                    <label class="form-check-label" for="flexCheckDefaultf1"> Direct Flight Only </label>
                                                                </div>
                                                               
                                                                <button class="btn btn_theme btn_md show_flights" type="submit" onclick="return oneWayCheckFilter()">Show flights</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="roundtrip" role="tabpanel" aria-labelledby="roundtrip-tab">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="oneway_search_form">
                                                    <form action="{{ route('flight.search') }}" id="rForm">
                                                        <input type="hidden" id="search_type" name="search_type" value="Return">
                                                        <input type="hidden" class="stop_filterField" id="rstop_filter" name="rstop_filter" value="{{$rstopFilter}}">
                                                        <input type="hidden" class="airline_filterField" id="rairline_filter" name="rairline_filter" value="{{$rairlineFilter}}">
                                                        <input type="hidden" class="refund_filterField" id="rrefund_filter" name="rrefund_filter" value="{{$rrefundFilter}}">
                                                        <div class="row">
                                                            <div class="col-lg-3  col-md-6 col-sm-12 col-12">
                                                                <div class="flight_Search_boxed">
                                                                    <p>From</p>
                                                                    
                                                                    <input type="text" name="rFrom" placeholder="Enter Departure City" class="selectAirportFrom load_airports col-sm-12 " id="rFrom">
                                                                    <input type="hidden"  class="airport" name="rFrom_label"  id="rFrom_label">
                                                                    <span class="place-label from_airport" id="rFrom_labels"></span>
                                                                    <div class="plan_icon_posation">
                                                                        <i class="fas fa-plane-departure"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3  col-md-6 col-sm-12 col-12">
                                                                <div class="flight_Search_boxed">
                                                                    <p>To</p>
                                                                   
                                                                    <input type="text" name="rTo" placeholder="Enter Destination City" class="selectAirportTo load_airports col-sm-12 " id="rTo">
                                                                    <input type="hidden"  class="airport" name="rTo_label"  id="rTo_label">
                                                                    <span  class="place-label to_airport" id="rTo_labels"></span>
                                                                    <div class="plan_icon_posation">
                                                                        <i class="fas fa-plane-arrival"></i>
                                                                    </div>
                                                                    <div class="range_plan">
                                                                        <i class="fas fa-exchange-alt"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4  col-md-6 col-sm-12 col-12">
                                                                <div class="form_search_date">
                                                                    <div class="flight_Search_boxed date_flex_area">
                                                                        <div class="Journey_date">
                                                                            <p>Journey date</p>
                                                                            <input type="date" value="" class="travel_date" id="rDate" name="rDate">
                                                                            <span class="place-label day_label rDate_label" id=""></span>
                                                                        </div>
                                                                        <div class="Journey_date">
                                                                            <p>Return date</p>
                                                                            <input type="date" value="" class="travel_date" id="rReturnDate" name="rReturnDate">
                                                                            <span class="place-label day_label rReturnDate_label" id=""></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2  col-md-6 col-sm-12 col-12">
                                                                <div class="flight_Search_boxed dropdown_passenger_area">
                                                                    <p>Passenger, Class </p>
                                                                        @php $passengersReturn = ($rAdult + $rChild + $rInfant); @endphp
                                                                    <div class="dropdown">
                                                                        <button class="dropdown-toggle return_final_count" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        {{ ($passengersReturn > 1) ? $passengersReturn .' Passengers' : $passengersReturn.' Passenger' }} 
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown_passenger_info" aria-labelledby="dropdownMenuButton1">
                                                                            <div class="traveller-calulate-persons">
                                                                                <div class="passengers">
                                                                                    <h6>Passengers</h6>
                                                                                    <div class="passengers-types">
                                                                                        <div class="passengers-type">
                                                                                            <div class="text">
                                                                                                <input type="text" name="rAdult" id="rAdult" class="count" value="{{$rAdult}}">
                                                                                                <div class="type-label">
                                                                                                    <p>Adult </p>
                                                                                                    <span>12+ yrs</span>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="button-set"> 
                                                                                                <button type="button" class="rAdult" id="plus">
                                                                                                    <i class="fas fa-plus"></i>
                                                                                                </button>
                                                                                                <button type="button" class="rAdult" id="minus">
                                                                                                    <i class="fas fa-minus"></i>
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="passengers-type">
                                                                                            <div class="text">
                                                                                                <input type="text" name="rChild" id="rChild" class="count" value="{{$rChild}}">
                                                                                                <div class="type-label">
                                                                                                    <p class="fz14 mb-xs-0"> Children </p>
                                                                                                    <span>2 - Less than 12 yrs</span>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="button-set">
                                                                                                <button type="button" class="rChild" id="plus">
                                                                                                    <i class="fas fa-plus"></i>
                                                                                                </button>
                                                                                                <button type="button" class="rChild" id="minus">
                                                                                                    <i class="fas fa-minus"></i>
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="passengers-type">
                                                                                            <div  class="text">
                                                                                                <input type="text" name="rInfant" id="rInfant" class="count" value="{{$rInfant}}">
                                                                                                <div class="type-label">
                                                                                                    <p class="fz14 mb-xs-0"> Infant </p>
                                                                                                    <span>Less than 2 yrs</span>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="button-set">
                                                                                                <button type="button" class="rInfant" id="plus">
                                                                                                    <i class="fas fa-plus"></i>
                                                                                                </button>
                                                                                                <button type="button" class="rInfant" id="minus">
                                                                                                    <i class="fas fa-minus"></i>
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="cabin-selection">
                                                                                    <h6>Cabin Class</h6>
                                                                                    <div class="cabin-list return_cabin">
                                                                                        <input class="form-check-input hide"  type="hidden" value="{{$rClass}}" name="rClass" id="rClass">
                                                                                        <button type="button" class="label-select-btn {{ $rClass == 'Economy' ? 'active' : ''}}" data-id="Economy">
                                                                                            <span class="muiButton-label">Economy </span>
                                                                                        </button>
                                                                                        <button type="button" class="label-select-btn {{ $rClass == 'Business' ? 'active' : ''}}"  data-id="Business">
                                                                                            <span class="muiButton-label"> Business </span>
                                                                                        </button>
                                                                                        <button type="button" class="label-select-btn {{ $rClass == 'First' ? 'active' : ''}}"  data-id="First">
                                                                                            <span  class="MuiButton-label">First Class </span>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <span class="place-label" id="rClass_label">{{$rClass}}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="top_form_search_button">
                                                            <button class="btn btn_theme btn_md show_flights" onclick="return returnCheckFilter()">Show flights</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="multi_city" role="tabpanel" aria-labelledby="multi_city-tab">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="oneway_search_form">
                                                    <form action="{{ route('flight.search') }}" id="mForm">
                                                        <input type="hidden" class="stop_filterField" id="mstop_filter" name="mstop_filter" value="{{$mstopFilter}}">
                                                        <input type="hidden" class="airline_filterField" id="mairline_filter" name="mairline_filter" value="{{$mairlineFilter}}">
                                                        <input type="hidden" class="refund_filterField" id="mrefund_filter" name="mrefund_filter" value="{{$mrefundFilter}}">
                                                        <input type="hidden" name="search_type" id="search_type" value="Circle">
                                                        <div class="multi_city_form_wrapper">
                                                            <div class="multi_city_form">
                                                                <div class="row">
                                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                                        <div class="flight_Search_boxed">
                                                                            <p>From</p>
                                                                            
                                                                            <input type="text" name="mFrom[]" placeholder="Enter Departure City" class="selectAirportFrom load_airports col-sm-12 " id="mFrom0">
                                                                            <input type="hidden"  class="airport" name="mFrom_label0"  id="mFrom_label0">
                                                                            <span class="place-label from_airport" id="mFrom_labels0"  ></span>
                                                                            <div class="plan_icon_posation">
                                                                                <i class="fas fa-plane-departure"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                                        <div class="flight_Search_boxed">
                                                                            <p>To</p>
                                                                           
                                                                            <input type="text" name="mTo[]" placeholder="Enter Destination City" class="selectAirportTo load_airports col-sm-12 " id="mTo0">
                                                                            <input type="hidden"  class="airport" name="mTo_label0"  id="mTo_label0">
                                                                            <span class="place-label to_airport" id="mTo_labels0"></span>
                                                                            <div class="plan_icon_posation">
                                                                                <i class="fas fa-plane-departure"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                                                                        <div class="form_search_date">
                                                                            <div class="flight_Search_boxed date_flex_area">
                                                                                <div class="Journey_date">
                                                                                    <p>Journey date</p>
                                                                                    <input type="date" value="" class="travel_date" id="mDate0" name="mDate[]">
                                                                                    <span class="place-label day_label mDate_label" id=""></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2  col-md-6 col-sm-12 col-12">
                                                                        <div class="flight_Search_boxed dropdown_passenger_area">
                                                                            <p>Passenger, Class </p>
                                                                            @php  $passengersMulti = ($mAdult + $mChild + $mInfant); @endphp
                                                                            <div class="dropdown">
                                                                                <button class="dropdown-toggle multi_final_count" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                                               
                                                                                {{ ($passengersMulti > 1) ? $passengersMulti .' Passengers' : $passengersMulti.' Passenger' }} 
                                                                                </button>
                                                                                <div class="dropdown-menu dropdown_passenger_info" aria-labelledby="dropdownMenuButton1">
                                                                                    <div class="traveller-calulate-persons">
                                                                                        <div class="passengers">
                                                                                            <h6>Passengers</h6>
                                                                                            <div class="passengers-types">
                                                                                                <div class="passengers-type">
                                                                                                    <div class="text">
                                                                                                        <input type="text" name="mAdult" id="mAdult" class="count" value="{{$mAdult}}">
                                                                                                        <div class="type-label">
                                                                                                            <p>Adult </p>
                                                                                                            <span>12+ yrs</span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="button-set"> 
                                                                                                        <button type="button" class="mAdult" id="plus">
                                                                                                            <i class="fas fa-plus"></i>
                                                                                                        </button>
                                                                                                        <button type="button" class="mAdult" id="minus">
                                                                                                            <i class="fas fa-minus"></i>
                                                                                                        </button>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="passengers-type">
                                                                                                    <div class="text">
                                                                                                        <input type="text" name="mChild" id="mChild" class="count" value="{{$mChild}}">
                                                                                                        <div class="type-label">
                                                                                                            <p class="fz14 mb-xs-0"> Children </p>
                                                                                                            <span>2 - Less than 12 yrs</span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="button-set">
                                                                                                        <button type="button" class="mChild" id="plus">
                                                                                                            <i class="fas fa-plus"></i>
                                                                                                        </button>
                                                                                                        <button type="button" class="mChild" id="minus">
                                                                                                            <i class="fas fa-minus"></i>
                                                                                                        </button>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="passengers-type">
                                                                                                    <div  class="text">
                                                                                                        <input type="text" name="mInfant" id="mInfant" class="count" value="{{$mInfant}}">
                                                                                                        <div class="type-label">
                                                                                                            <p class="fz14 mb-xs-0"> Infant </p>
                                                                                                            <span>Less than 2 yrs</span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="button-set">
                                                                                                        <button type="button" class="mInfant" id="plus">
                                                                                                            <i class="fas fa-plus"></i>
                                                                                                        </button>
                                                                                                        <button type="button" class="mInfant" id="minus">
                                                                                                            <i class="fas fa-minus"></i>
                                                                                                        </button>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="cabin-selection">
                                                                                            <h6>Cabin Class</h6>
                                                                                            <div class="cabin-list multi_cabin">
                                                                                                <input class="form-check-input hide"  type="hidden" value="{{$mClass}}" name="mClass" id="mClass">
                                                                                                <button type="button" class="label-select-btn {{ $mClass == 'Economy' ? 'active' : ''}}" data-id="Economy">
                                                                                                    <span class="muiButton-label">Economy </span>
                                                                                                </button>
                                                                                                <button type="button" class="label-select-btn {{ $mClass == 'Business' ? 'active' : ''}}"  data-id="Business">
                                                                                                    <span class="muiButton-label"> Business </span>
                                                                                                </button>
                                                                                                <button type="button" class="label-select-btn {{ $mClass == 'First' ? 'active' : ''}}"  data-id="First">
                                                                                                    <span  class="MuiButton-label">First Class </span>
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <span class="place-label" id="mClass_label">{{$mClass}}</span>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="multi_city_form">
                                                                <div class="row">
                                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                                        <div class="flight_Search_boxed">
                                                                            <p>From</p>
                                                                           
                                                                            <input type="text" name="mFrom[]" placeholder="Enter Departure City" class="selectAirportFrom load_airports col-sm-12 " id="mFrom1">
                                                                            <input type="hidden"  class="airport" name="mFrom_label1"  id="mFrom_label1">
                                                                            <span class="place-label from_airport" id="mFrom_labels1"></span>
                                                                            <div class="plan_icon_posation">
                                                                                <i class="fas fa-plane-departure"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                                        <div class="flight_Search_boxed">
                                                                            <p>To</p>
                                                                            
                                                                            <input type="text" name="mTo[]" placeholder="Enter Destination City" class="selectAirportTo load_airports col-sm-12 " id="mTo1">
                                                                            <input type="hidden"  class="airport" name="mTo_label1"  id="mTo_label1">
                                                                            <span class="place-label to_airport" id="mTo_labels1"></span>
                                                                            <div class="plan_icon_posation">
                                                                                <i class="fas fa-plane-departure"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                                                                        <div class="form_search_date">
                                                                            <div class="flight_Search_boxed date_flex_area">
                                                                                <div class="Journey_date">
                                                                                    <p>Journey date</p>
                                                                                    <input type="date" value="" class="travel_date" id="mDate1" name="mDate[]">
                                                                                    <span class="place-label day_label mDate_label" id=""></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2  col-md-6 col-sm-12 col-12 m-auto">
                                                                        <div class="add_multy_form">
                                                                            <button type="button" id="addMulticityRow">+ Add another flight</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                           
                                                        </div>
                                            
                                                        <div class="top_form_search_button">
                                                            <button class="btn btn_theme btn_md show_flights" onclick=" return multiCheckFilter()">Show flights</button>
                                                        </div>
                                                    </form>
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
    </div>
    @push('footer')
    <script>
        
    </script>
    @endpush