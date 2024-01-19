@extends('web.layouts.app')
@section('content')
    @php
        $passengers = [
            'ADT' => (int) $res_data['search_params']['adult'],
            'CHD' => (int) $res_data['search_params']['child'],
            'INF' => (int) $res_data['search_params']['infant'],
        ];
    @endphp
    <!-- Common Banner Area -->
    <section id="common_banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="common_bannner_text text-dark">
                        {{-- @if ($res_data['search_type'] == 'OneWay' && Session::has('flight_search_oneway'))
                            <h2>Your trip to {{ $res_data['airports'][session('flight_search_oneway')['oTo']]['City'] }} <img
                                    src="{{ asset('assets/img/icon/flight.png') }}" alt=""></h2>
                        @elseif($res_data['search_type'] == 'Return' && Session::has('flight_search_return'))
                            <h2>Your trip to {{ $res_data['airports'][session('flight_search_return')['rTo']]['City'] }} and
                                back <img src="{{ asset('assets/img/icon/flight.png') }}" alt=""></h2>
                        @endif --}}
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Explore our hot deals -->
    <section id="explore_area" class="section_padding_top">
        <div class="container-fluid">
            <!-- Section Heading -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="section_heading_center">
                        <h2>Explore our hot deals</h2>
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


                                        @if ($acc_response && isset($acc_response['ancillaryQuotes']['flights']))
                                            <button class="nav-link active" id="nav-baggage-tab" data-bs-toggle="tab"
                                                data-bs-target="#nav-baggage" type="button" role="tab"
                                                aria-controls="nav-baggage" aria-selected="true">Baggage</button>

                                            <button class="nav-link" id="nav-meals-tab" data-bs-toggle="tab"
                                                data-bs-target="#nav-meals" type="button" role="tab"
                                                aria-controls="nav-meals" aria-selected="false">Meals</button>
                                        @endif

                                        @if ($seat_response && $seat_response['exceptions'][0]['code'] == 0)
                                            <button class="nav-link" id="nav-seats-tab" data-bs-toggle="tab"
                                                data-bs-target="#nav-seats" type="button" role="tab"
                                                aria-controls="nav-seats" aria-selected="false">Seats</button>
                                        @endif
                                        <button class="nav-link" id="nav-details-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-details" type="button" role="tab"
                                            aria-controls="nav-details" aria-selected="false">Personal Details</button>

                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="tab-content passenger-det" id="nav-tabContent">

                                @if ($acc_response)
                                    @include('web.provides.flydubai.baggage')
                                    @include('web.provides.flydubai.meals')
                                @endif

                                @if ($seat_response && $seat_response['exceptions'][0]['code'] == 0)
                                    @include('web.provides.flydubai.seats')
                                @endif

                                @include('web.provides.flydubai.passenger-details')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="tour_details_right_sidebar_wrapper">
                        <!-- <div class="tour_detail_right_sidebar">
                                    <div class="tour_details_right_boxed">
                                        <div class="tour_details_right_box_heading">
                                            <h3>Coupon code</h3>
                                        </div>
                                        <div class="coupon_code_area_booking">
                                            <form action="#!">
                                                <div class="form-group">
                                                    <input type="text" class="form-control bg_input"
                                                        placeholder="Enter coupon code">
                                                </div>
                                                <div class="coupon_code_submit">
                                                    <button class="btn btn_theme btn_md">Apply voucher</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div> -->
                        <div class="tour_detail_right_sidebar">
                            <div class="tour_details_right_boxed">
                                <div class="tour_details_right_box_heading">
                                    <h3>Booking amount</h3>
                                </div>
                                <div class="tour_booking_amount_area">
                                    <div class="tour_bokking_subtotal_area">
                                        <h6>Total Base Fare <span>AED 100</span></h6>
                                    </div>
                                    <div class="tour_bokking_subtotal_area">
                                        <h6>Total Tax <span>AED 100</span></h6>
                                    </div>

                                    <div class="tour_bokking_subtotal_area">
                                        <h6>Add Ons <span id="addons">AED 0</span></h6>
                                    </div>
                                    <div class="coupon_add_area">
                                        <!-- <h6><span class="remove_coupon_tour">Remove</span> Coupon code (OFF 50)
                                                    <span>AED 50.00</span>
                                                </h6> -->
                                    </div>
                                    <div class="total_subtotal_booking">
                                        <h4>Total Amount <span id="amountSpan">AED 120</span> </h4>
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

        .appearance-auto {
            appearance: auto !important;
        }

        @media (min-width: 1400px) {
            .container-bboking {
                max-width: 1600px;
            }
        }
    </style>
@endpush
@push('footer')
    <!-- SweetAlert -->
    <script src="{{ asset('assets/js/sweetalert.min.js') }}" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="{{ asset('assets/js/intlTelInput.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>

    
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
            maxDate: "+10y",
            minDate: "y"
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
