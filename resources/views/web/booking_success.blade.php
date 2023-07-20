@extends('web.layouts.app')
@section('content')
<!-- Common Banner Area -->
<section id="common_banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="common_bannner_text text-dark">
                    <h2>@if(!empty($bookings)) Successfully Booked @endif</h2>
                </div>
            </div>
        </div>
    </div>
   
</section>
<!-- Tour Booking Submission Areas -->
<section id="tour_booking_submission" class="section_padding" style="padding: 20px 0;">
    <div class="container container-bboking">
        <div class="row">
            <div class="col-lg-12">
                <div class="tou_booking_form_Wrapper text-center padding20">
                    
                    @if(!empty($bookings))
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <div class="dashboard_common_table col-sm-12">
                                <div id="tab-booking-details">
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="family-house"
                                            role="tabpanel">
                                            <div class="accordion accordion--separated accordion--secondary" id="accordionExample">
                                                <div class="accordion-item">
                                                    @php $airlinePNR = ''; @endphp
                                                    <div id="collapseOne" style="">
                                                        <div class="">
                                                            <div class="fb-cb" style="padding: 2%;">
                                                                
                                                                @if(isset($bookings[0]))

                                                                <h3 class="fw-medium mb-1 mt-3 text-left">Trip from {{ $bookings[0]->origin }} to {{ $bookings[0]->destination }} 
                                                                <span style="font-size: 14px;float: right;" class="mt-2">Booking Id : {{ $bookings[0]->unique_booking_id }}</span>
                                                                </h3>

                                                                @foreach($bookings[0]['flights'] as $flights)
                                                                    @php
                                                                    $airlineData =
                                                                    getAirlineData($flights->marketing_airline_code);
                                                                    $deptAirportData = getAirportData($flights->departure_airport);
                                                                    $arrAirportData = getAirportData($flights->arrival_airport);
                                                                    $airlinePNR = $flights->airline_pnr;
                                                                    @endphp
                                                                    <div class="row y-gap-10 justify-between">
                                                                        <div class="col-auto">
                                                                            <div class="d-flex items-center mb-15">
                                                                                <div
                                                                                    class="flight_logo d-flex justify-center mr-15">
                                                                                    <img src="{{ $airlineData[0]['AirLineLogo'] }}"
                                                                                        alt="image">
                                                                                </div>
                                                                                <div class="text-14 text-light-1">
                                                                                    {{$airlineData[0]['AirLineName']}}
                                                                                    {{$flights->flight_number}}
                                                                                </div>
                                                                            </div>
                                                                            <div class="relative z-0">
                                                                                <div class="border-line-2"></div>
                                                                                <div class="d-flex items-center">
                                                                                    <div
                                                                                        class="w-28 d-flex justify-center mr-15">
                                                                                        <div
                                                                                            class="size-10 border-light rounded-full bg-white">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-auto">
                                                                                            <div
                                                                                                class="lh-14 fw-500">
                                                                                                {{ date('d M, Y', strtotime($flights->departure_date_time)) }}
                                                                                            </div>
                                                                                            <div
                                                                                                class="lh-14 fw-500">
                                                                                                {{ date('H:i', strtotime($flights->departure_date_time)) }}
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-auto">
                                                                                            <div
                                                                                                class="lh-14 fw-500">
                                                                                                {{ $deptAirportData[0]['AirportName'] }},
                                                                                                {{ $deptAirportData[0]['City'] }}
                                                                                                ({{ $flights->departure_airport }})
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="d-flex items-center m-15">
                                                                                    <div
                                                                                        class="w-28 d-flex justify-center mr-15">
                                                                                        <img src="{{ asset('assets/img/icon/plane.svg') }}"
                                                                                            alt="image">
                                                                                    </div>
                                                                                    <div
                                                                                        class="text-14 text-light-1">
                                                                                        {{ convertToHoursMins($flights->journey_duration) }}
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="d-flex items-center mt-15">
                                                                                    <div
                                                                                        class="w-28 d-flex justify-center mr-15">
                                                                                        <div
                                                                                            class="size-10 border-light rounded-full bg-border">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-auto">
                                                                                            <div
                                                                                                class="lh-14 fw-500">
                                                                                                {{ date('d M, Y', strtotime($flights->arrival_date_time)) }}
                                                                                            </div>
                                                                                            <div
                                                                                                class="lh-14 fw-500">
                                                                                                {{ date('H:i', strtotime($flights->arrival_date_time)) }}
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-auto">
                                                                                            <div
                                                                                                class="lh-14 fw-500">
                                                                                                {{ $arrAirportData[0]['AirportName'] }},
                                                                                                {{ $arrAirportData[0]['City'] }}
                                                                                                ({{ $flights->arrival_airport }})
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-auto text-right md:text-left"
                                                                            style="line-height:30px">
                                                                            @php
                                                                            $cabinClass = '';
                                                                            if($flights->cabin_class == "Y"){
                                                                            $cabinClass = "Economy";
                                                                            }elseif($flights->cabin_class == "S"){
                                                                            $cabinClass = "Premium Economy";
                                                                            }elseif($flights->cabin_class == "C"){
                                                                            $cabinClass = "Business";
                                                                            }elseif($flights->cabin_class == "F"){
                                                                            $cabinClass = "First";
                                                                            }
                                                                            @endphp

                                                                            <div class="text-14 text-light-1">
                                                                                {{$cabinClass}}</div>
                                                                            <div class="text-14 mt-15 md:mt-5">
                                                                                Airline PNR :<strong>
                                                                                    {{ $airlinePNR }}</strong>
                                                                            </div>
                                                                            <!-- <div class="text-14 mt-15 md:mt-5">Cabin bag <strong> 7
                                                                                        Kgs</strong><br>
                                                                                    Check-in<strong> 30 Kgs</strong><br>
                                                                                    Cancellation Fee Starting AED 307 upto 3 days before
                                                                                    departure


                                                                                </div> -->
                                                                        </div>
                                                                    </div>

                                                                    <hr>
                                                                @endforeach

                                                                <div class="row">
                                                                    @foreach($bookings[0]['passengers'] as $pass)
                                                                    <div class="col-md-6">
                                                                        <div class="traveler-b-detl">

                                                                            <h4>TRAVELLER {{ $loop->iteration }}
                                                                                ({{ ($pass->passenger_type =='ADT') ? "Adult" : (($pass->passenger_type =="CHD") ? "Child" : "Infant") }})
                                                                            </h4>
                                                                            <div class="form-check-label">
                                                                                <span
                                                                                    class="mb-2 fw-semibold fs-12 d-block text-muted text-uppercase fw-500">
                                                                                    {{ $pass->passenger_first_name }}
                                                                                    {{ $pass->passenger_last_name }}
                                                                                </span>
                                                                                @php

                                                                                @endphp
                                                                                <span
                                                                                    class="fs-14 mb-2 fw-semibold  d-block">Gender
                                                                                    : {{ $pass->gender }}</span>
                                                                                <span
                                                                                    class="fs-14 mb-2 fw-semibold  d-block">Date
                                                                                    Of Birth :
                                                                                    {{ $pass->date_of_birth }}</span>
                                                                                <span
                                                                                    class="fs-14 mb-2 fw-semibold  d-block">Passport
                                                                                    Number :
                                                                                    {{ $pass->passport_number }}</span>

                                                                                <span
                                                                                    class=" mb-2 fw-600 d-block">E-TICKET
                                                                                    NUMBER :
                                                                                    {{ $pass->eticket_number }}</span>
                                                                                <!-- <span class=" mb-2 fw-600 d-block">SEAT : 16F</span>
                                                                                <span class=" mb-2 fw-600 d-block">MEAL : Biriyani,
                                                                                    Coffee</span> -->
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    @endforeach

                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            @if(!empty($bookings[0]['extraServices'][0]))
                                @php
                                    $desc = array(
                                        'GROUP_PAX' => '(Entire group)', 
                                        'PER_PAX' => '(Each passenger)', 
                                        'GROUP_PAX_INBOUND' => '(Entire group only on the return trip)',
                                        'GROUP_PAX_OUTBOUND' => '(Entire group only on for the onward travel)', 
                                        'PER_PAX_INBOUND' => '(Each passenger only on the return trip)', 
                                        'PER_PAX_OUTBOUND' => '(Each passenger only on for the onward travel)'
                                    );
                                @endphp
                                <div class="tour_detail_right_sidebar mt-1 col-sm-12" style="padding: 1%;">
                                    <div class="tour_details_right_boxed">
                                        <div class="tour_details_right_box_heading">
                                            <h3>Extra Services</h3>
                                        </div>

                                        <div class="tour_booking_amount_area">
                                            <ul>
                                                @foreach($bookings[0]['extraServices'] as $extra)
                                                    <li style="border-bottom:none;">{{ $extra->description }} {{ (isset($desc[$extra->behavior])) ? $desc[$extra->behavior] : '' }}
                                                        <span>{{ $extra->currency }} {{ $extra->service_amount }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                           
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="tour_detail_right_sidebar mt-1 col-sm-12"  style="padding: 1%;">
                                <div class="tour_details_right_boxed">
                                    <div class="tour_details_right_box_heading">
                                        <h3>Fare Details</h3>
                                    </div>

                                    <div class="tour_booking_amount_area">
                                        <ul>
                                            @if($bookings[0]->adult_count != 0)
                                            <li>Adult Price x {{ $bookings[0]->adult_count }}
                                                <span>{{ $bookings[0]->currency }}
                                                    {{ $bookings[0]->adult_amount }}</span>
                                            </li>
                                            @endif

                                            @if($bookings[0]->child_count != 0)
                                            <li>Child Price x {{ $bookings[0]->child_count }}
                                                <span>{{ $bookings[0]->currency }}
                                                    {{ $bookings[0]->child_amount }}</span>
                                            </li>
                                            @endif

                                            @if($bookings[0]->infant_count != 0)
                                            <li>Infant Price x {{ $bookings[0]->infant_count }}
                                                <span>{{ $bookings[0]->currency }}
                                                    {{ $bookings[0]->infant_amount }}</span>
                                            </li>
                                            @endif
                                        </ul>
                                        <div class="tour_bokking_subtotal_area">
                                            <h6>Total Base Fare <span>{{ $bookings[0]->currency }}
                                                    {{ $bookings[0]->adult_amount + $bookings[0]->child_amount + $bookings[0]->infant_amount  }}</span>
                                            </h6>
                                        </div>
                                        <div class="tour_bokking_subtotal_area">
                                            <h6>Total Tax <span>{{ $bookings[0]->currency }}
                                                    {{ $bookings[0]->total_tax }}</span></h6>
                                        </div>

                                        <div class="tour_bokking_subtotal_area">
                                            <h6>Add Ons <span id="addons">{{ $bookings[0]->currency }}
                                                    {{ $bookings[0]->addon_amount }}</span></h6>
                                        </div>
                                        <!-- <div class="coupon_add_area">
                                        <h6><span class="remove_coupon_tour">Remove</span> Coupon code (OFF 50)
                                            <span>AED 50.00</span>
                                        </h6>
                                    </div> -->
                                        <div class="total_subtotal_booking">
                                            <h4 class="font-size20 bold">Total Amount <span>{{ $bookings[0]->currency }}
                                                    {{ $bookings[0]->total_amount }}</span> </h4>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                        <i class="fa fa-xmark-circle" style=" color: #ff2121; font-size: 55px; margin-bottom: 20px;"> </i>
                        <h3>{{$msg}}</h3>
                    @endif
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
<link rel="stylesheet" href="{{ asset('assets/css/search_flights.css') }}" />
<style>
.cta_content{
    color: black;
}
.text-left{
    text-align:left;
}
.padding20{
    padding-left: 15%;
    padding-right: 15%;
}
</style>
@endpush
@push('footer')
<script type="text/javascript">

</script>
@endpush