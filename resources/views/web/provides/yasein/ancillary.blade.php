@extends('web.layouts.app')
@section('content')
    @php
        $passengers = [
            'ADT' => (int) $res_data['search_params']['adult'],
            'CHD' => (int) $res_data['search_params']['child'],
            'INF' => (int) $res_data['search_params']['infant'],
        ];

        $pax_count = 0;
        foreach ($passengers as $value) {
            $pax_count += $value;
        }

        // dd($res_data['flight_details']);

        if ($res_data['search_type'] == 'OneWay') {
            $route = str_split($res_data['flight_details']['FlightRoute'], 3);
        } else {
            $route = str_split($res_data['flight_details']['dep_route'], 3);
        }

        $origin = $route[0];
        $destination = $route[1];
    @endphp
    <!-- Common Banner Area -->
    <section id="common_banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="common_bannner_text text-dark">
                        @if ($res_data['search_type'] == 'OneWay')
                            <h2>Your trip to {{ getAirportData($origin)['City'] }} <img
                                    src="{{ asset('assets/img/icon/flight.png') }}" alt=""></h2>
                        @elseif($res_data['search_type'] == 'Return')
                            <h2>Your trip to {{ getAirportData($destination)['City'] }} and
                                back <img src="{{ asset('assets/img/icon/flight.png') }}" alt=""></h2>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Explore our hot deals -->
    <section id="explore_area" class="">
        <div class="container-fluid">
            <!-- Section Heading -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="section_heading_center">
                        <h2>Complete your booking</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="theme_nav_tab">
                                <nav class="theme_nav_tab_item">
                                    <div class="nav nav-tabs" id="nav-tab1" role="tablist">
                                        <button class="nav-link active" id="nav-details-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-details" type="button" role="tab"
                                            aria-controls="nav-details" aria-selected="false">Personal Details</button>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="{{ route('yasin.book') }}" method="post" id="bookingForm">
                                @csrf
                                <input value="{{ $res_data['search_type'] }}" type="hidden" name="search_type">
                                @if ($res_data['search_type'] == 'Return')
                                    <input value="{{ $res_data['flight_details']['search_id'] }}" type="hidden"
                                        name="search_id">
                                    <input value="{{ $res_data['flight_details']['dep_airline'] }}" type="hidden"
                                        name="dep_Airline">
                                    <input value="{{ $res_data['flight_details']['dep_route'] }}" type="hidden"
                                        name="dep_FlightRoute">
                                    <input value="{{ $res_data['flight_details']['dep_date_time'] }}" type="hidden"
                                        name="dep_FlightDateTime">
                                    <input value="{{ $res_data['flight_details']['dep_flight_num'] }}" type="hidden"
                                        name="dep_FlightNo">
                                    <input value="{{ $res_data['flight_details']['dep_rbd'] }}" type="hidden"
                                        name="dep_RBD">
                                    <input value="{{ $res_data['flight_details']['dep_rph'] }}" type="hidden"
                                        name="dep_RPH">


                                    <input value="{{ $res_data['flight_details']['rtn_airline'] }}" type="hidden"
                                        name="rtn_Airline">
                                    <input value="{{ $res_data['flight_details']['rtn_route'] }}" type="hidden"
                                        name="rtn_FlightRoute">
                                    <input value="{{ $res_data['flight_details']['rtn_date_time'] }}" type="hidden"
                                        name="rtn_FlightDateTime">
                                    <input value="{{ $res_data['flight_details']['rtn_flight_num'] }}" type="hidden"
                                        name="rtn_FlightNo">
                                    <input value="{{ $res_data['flight_details']['rtn_rbd'] }}" type="hidden"
                                        name="rtn_RBD">
                                    <input value="{{ $res_data['flight_details']['rtn_rph'] }}" type="hidden"
                                        name="rtn_RPH">
                                @else
                                    <input value="{{ $res_data['flight_details']['search_id'] }}" type="hidden"
                                        name="search_id">
                                    <input value="{{ $res_data['flight_details']['Airline'] }}" type="hidden"
                                        name="Airline">
                                    <input value="{{ $res_data['flight_details']['FlightRoute'] }}" type="hidden"
                                        name="FlightRoute">
                                    <input value="{{ $res_data['flight_details']['FlightDateTime'] }}" type="hidden"
                                        name="FlightDateTime">
                                    <input value="{{ $res_data['flight_details']['FlightNo'] }}" type="hidden"
                                        name="FlightNo">
                                    <input value="{{ $res_data['flight_details']['RBD'] }}" type="hidden" name="RBD">
                                    <input value="{{ $res_data['flight_details']['RPH'] }}" type="hidden" name="RPH">
                                @endif


                                <div class="tab-content passenger-det " id="nav-tabContent">
                                    @include('web.provides.flydubai.passenger-details', [
                                        'active' => true,
                                    ])
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="tour_details_right_sidebar_wrapper">
                        <div class="tour_detail_right_sidebar">
                            <div class="tour_details_right_boxed">
                                <div class="tour_details_right_box_heading">
                                    <h3>Booking amount</h3>
                                </div>
                                <div class="tour_booking_amount_area">
                                    <div class="tour_bokking_subtotal_area">
                                        <h6>Total Base Fare
                                            <span>{{ getDisplyPrice($res_data['flight_details']['price'], 'USD') }}</span>
                                        </h6>
                                    </div>
                                    <div class="total_subtotal_booking">
                                        <h4>Total Amount <span
                                                id="amountSpan">{{ getDisplyPrice($res_data['flight_details']['price'], 'USD') }}</span></span>
                                        </h4>
                                    </div>
                                </div>
                            </div>
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
    <link rel="stylesheet" href="{{ asset('assets/css/intlTelInput.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/search_flights.css') }}" />
    <style>
        /* .input_seat.active svg path {
                                                                                                                color: #05e800 !important;
                                                                                                                fill: #05e800 !important
                                                                                                            }

                                                                                                            .seating-area .area-sbc:not(:last-child) {
                                                                                                                border-bottom: 1px solid #000;
                                                                                                                padding-bottom: 25px;
                                                                                                            }

                                                                                                            .area-sbc.disabled {
                                                                                                                position: relative;
                                                                                                            }

                                                                                                            .area-sbc.disabled:after {
                                                                                                                content: '';
                                                                                                                display: block;
                                                                                                                position: absolute;
                                                                                                                left: 0;
                                                                                                                top: 0;
                                                                                                                background: #00000024;
                                                                                                                height: 100%;
                                                                                                                width: 100%;
                                                                                                                cursor: no-drop
                                                                                                            }

                                                                                                            .bookyour-seat .chooseyourseat .seating-area ul li span.seatnot-available,
                                                                                                            .area-sbc.disabled .left,
                                                                                                            .area-sbc.disabled .right {
                                                                                                                cursor: no-drop !important;
                                                                                                                pointer-events: none;
                                                                                                            }

                                                                                                            .area-sbc.disabled span {
                                                                                                                user-select: none;
                                                                                                                pointer-events: none;
                                                                                                            }

                                                                                                            #addon_items {
                                                                                                                padding-left: 15px;
                                                                                                            }

                                                                                                            #addon_items h6 {
                                                                                                                padding-top: 5px;
                                                                                                                /* display: block; */
        }

        #addon_items p {
            color: #212529;
            display: block;
        }

        #addon_items p:first-child span {
            display: block;
            font-size: 80%;
            line-height: 1;
        }

        .included_baggage label {
            cursor: pointer;
        }

        .tour_bokking_subtotal_area h6 {
            padding-left: 0;
        }

        .gt-seat-bus svg path,
        .gt-seat-eco.business-seat svg path {
            fill: #006496
        }

        .baggage_count,
        .baggage_countIn {
            border: none;
            width: 25px;
            text-align: center;
            pointer-events: none;
        }

        .f-7 {
            font-size: 7px !important;
        }

        .extraService {
            font-size: 12px;
            color: #4c4c4c;
            border: 1px solid #d8d8d8;
            width: 20px;
            height: 20px;
            margin-top: 3px;
        }

        #valid-msg {
            color: #00a457;
        }

        .iti {
            position: relative;
            display: block;
        }

        .total_subtotal_booking h4 {
            font-size: 20px;
            font-weight: 500;
            display: flex;
            justify-content: space-between;
        }

        .amount-head {
            color: #1fba71;
            text-decoration: underline;
            font-weight: 600;
        }

        .btn_lg {
            padding: 12px 100px;
            font-size: 18px;
        }

        .mt-30 {
            margin-top: 30px;
        }

        .form-control:disabled,
        .form-control[readonly] {
            background-color: #ffffff;
            opacity: 1;
        }

        .tour_package_details_bar_list table td {
            border: 1px solid #cdcdcd;
        }

        .tour_package_details_bar_list table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            vertical-align: top;
            border-color: #dee2e6;
        }

        table>:not(caption)>*>* {
            padding: 0.5rem 0.5rem;
        }

        .tour_package_details_bar_list ul li {
            display: block;
        }

        fieldset {
            padding: 0rem 1rem !important;
            border: 1px solid #c1c1c1 !important;
        }

        legend {
            float: none;
            width: 69px;
        }

        legend b {
            color: #818090;
        }

        */ .appearance-auto {
            appearance: auto !important;
        }

        @media (min-width: 1400px) {
            .container-bboking {
                max-width: 1600px;
            }
        }



        #explore_area {
            padding: 100px 0;
        }
    </style>
@endpush
@push('footer')
    <!-- SweetAlert -->
    <script src="{{ asset('assets/js/sweetalert.min.js') }}" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="{{ asset('assets/js/intlTelInput.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>


    <script type="text/javascript">
        $('#loginCheck').on('click', function() {
            $('#common_author-forms').modal('show');
        });

        var input = document.querySelector("#mobile_no"),
            errorMsg = document.querySelector("#error-msg"),
            validMsg = document.querySelector("#valid-msg");

        // Error messages based on the code returned from getValidationError
        var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

        // Initialise plugin
        var intl = window.intlTelInput(input, {
            separateDialCode: true,
            preferredCountries: ['ae', 'us', 'gb'],
            utilsScript: "{{ asset('assets/js/utils.js') }}",
            autoFormat: false
        });

        var code = intl.getSelectedCountryData();
        $('#mobile_code').val(code.dialCode);

        var reset = function() {
            input.classList.remove("error");
            errorMsg.innerHTML = "";
            errorMsg.classList.add("hide");
            validMsg.classList.add("hide");
        };

        // Validate on blur event
        input.addEventListener('blur', function() {
            reset();
            var code = intl.getSelectedCountryData();
            console.log(code);
            $('#mobile_code').val(code.dialCode);
            if (input.value.trim()) {
                if (intl.isValidNumber()) {
                    validMsg.classList.remove("hide");
                } else {
                    input.classList.add("error");
                    var errorCode = intl.getValidationError();
                    errorMsg.innerHTML = errorMap[errorCode];
                    errorMsg.classList.remove("hide");
                }
            }
        });

        // Reset on keyup/change event
        input.addEventListener('change', reset);
        input.addEventListener('keyup', reset);


        $(".passportExpiry").datepicker({
            dateFormat: "yy-mm-dd",
            changeYear: true,
            changeMonth: true,
            maxDate: "+20y",
            minDate: "y"
        });
        $(".passportIssue").datepicker({
            dateFormat: "yy-mm-dd",
            changeYear: true,
            changeMonth: true,
            maxDate: "y",
        });
        $(".datepickerAdult").datepicker({
            dateFormat: "yy-mm-dd",
            changeYear: true,
            changeMonth: true,
            maxDate: "-12y",
            minDate: "-100y",
            yearRange: '-100y:-12y'
        });
        $(".datepickerChild").datepicker({
            dateFormat: "yy-mm-dd",
            changeYear: true,
            changeMonth: true,
            maxDate: "-2y",
            minDate: "-12y"
        });
        $(".datepickerInfant").datepicker({
            dateFormat: "yy-mm-dd",
            changeYear: true,
            changeMonth: true,
            maxDate: "y",
            minDate: "-2y"
        });

        $(document).ready(function() {
            $("#bookingForm").validate({
                rules: {
                    terms_conditions: {
                        required: true
                    },
                    mobile_no: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    // country_code:{
                    //     required:true
                    // },
                    "adult_title[]": {
                        required: true
                    },
                    "adult_first_name[]": {
                        required: true,
                        maxlength: 50
                    },
                    "adult_last_name[]": {
                        required: true,
                        maxlength: 50,
                        minlength: 2,
                    },
                    "adult_gender[]": {
                        required: true
                    },
                    "adult_nationality[]": {
                        required: true
                    },
                    "adult_passport[]": {
                        required: true
                    },
                    "adult_passport_country[]": {
                        required: true
                    },
                    "adult_dob[]": {
                        required: true
                    },
                    "adult_passport_expiry[]": {
                        required: true
                    },
                    "child_title[]": {
                        required: true
                    },
                    "child_first_name[]": {
                        required: true,
                        maxlength: 50
                    },
                    "child_last_name[]": {
                        required: true,
                        maxlength: 50,
                        minlength: 2
                    },
                    "child_gender[]": {
                        required: true
                    },
                    "child_nationality[]": {
                        required: true
                    },
                    "child_passport[]": {
                        required: true
                    },
                    "child_passport_country[]": {
                        required: true
                    },
                    "child_dob[]": {
                        required: true
                    },
                    "child_passport_expiry[]": {
                        required: true
                    },
                    "infant_title[]": {
                        required: true
                    },
                    "infant_first_name[]": {
                        required: true,
                        maxlength: 50
                    },
                    "infant_last_name[]": {
                        required: true,
                        maxlength: 50,
                        minlength: 2,
                    },
                    "infant_gender[]": {
                        required: true
                    },
                    "infant_nationality[]": {
                        required: true
                    },
                    "infant_passport[]": {
                        required: true
                    },
                    "infant_passport_country[]": {
                        required: true
                    },
                    "infant_dob[]": {
                        required: true
                    },
                    "infant_passport_expiry[]": {
                        required: true
                    },
                },
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent("div"));
                },
                submitHandler: function(form, event) {
                    swal({
                        title: "Are you sure?",
                        text: "Do you want to proceed with this booking?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((isConfirmed) => {
                        if (isConfirmed) {
                            $('.ajaxloader').css('display', 'block');
                            form.submit();
                        }
                    });
                }
            });
        });
    </script>
@endpush
