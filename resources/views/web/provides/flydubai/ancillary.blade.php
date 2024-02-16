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

        if ($res_data['search_type'] == 'OneWay') {
            $flight = getFlightDetails(request()->LFID, $res_data['search_result']['flights']);
            $fare = getFareDetails(request()->FareTypeID, $flight);
            $prices = getFarePrices($fare['FareInfos']);
        } elseif ($res_data['search_type'] == 'Return') {
            $depFlight = getFlightDetails(request()->dep_LFID, $res_data['search_result']['flights']);
            $rtnFlight = getFlightDetails(request()->rtn_LFID, $res_data['search_result']['flights']);

            $depFare = getFareDetails(request()->dep_FareTypeID, $depFlight);
            $rtnFare = getFareDetails(request()->rtn_FareTypeID, $rtnFlight);

            $depPrices = getFarePrices($depFare['FareInfos']);
            $rtnPrices = getFarePrices($rtnFare['FareInfos']);

            $prices = [];

            foreach ($depPrices as $key => $value) {
                // Add the corresponding values from both arrays
                $prices[$key] = $depPrices[$key] + $rtnPrices[$key];
            }
        }
    @endphp
    <!-- Common Banner Area -->
    <section id="common_banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="common_bannner_text text-dark">
                        @if ($res_data['search_type'] == 'OneWay')
                            <h2>Your trip to {{ getAirportData($res_data['flight']['destination'])['City'] }} <img
                                    src="{{ asset('assets/img/icon/flight.png') }}" alt=""></h2>
                        @elseif($res_data['search_type'] == 'Return')
                            <h2>Your trip to {{ getAirportData($res_data['depFlight']['destination'])['City'] }} and
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
                            <form action="{{ route('flydubai.pnrsummery') }}" method="post" id="bookingForm">
                                @csrf
                                <input type="hidden" name="search_id" value="{{ request()->search_id }}">

                                @if ($res_data['search_type'] == 'OneWay')
                                    <input type="hidden" name="LFID" value="{{ request()->LFID }}">
                                    <input type="hidden" name="FareTypeID" value="{{ request()->FareTypeID }}">
                                @elseif($res_data['search_type'] == 'Return')
                                    <input type="hidden" name="dep_LFID" value="{{ request()->dep_LFID }}">
                                    <input type="hidden" name="rtn_LFID" value="{{ request()->rtn_LFID }}">
                                    <input type="hidden" name="dep_FareTypeID" value="{{ request()->dep_FareTypeID }}">
                                    <input type="hidden" name="rtn_FareTypeID" value="{{ request()->rtn_FareTypeID }}">
                                    <input type="hidden" name="dep_solnid" value="{{ request()->dep_solnid }}">
                                    <input type="hidden" name="rtn_solnid" value="{{ request()->rtn_solnid }}">
                                @endif

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
                                        <h6>Total Base Fare <span>{{ getDisplyPrice($prices['base_fare']) }}</span></h6>
                                    </div>
                                    <div class="tour_bokking_subtotal_area">
                                        <h6>Total Tax <span>{{ getDisplyPrice($prices['tax_fare']) }}</span></h6>
                                    </div>
                                    <div class="tour_bokking_subtotal_area">
                                        <h6>Add Ons <span>{{ getActiveCurrency() }} <span id="addons">0</span></span>
                                        </h6>
                                        <div id="addon_items">

                                        </div>
                                    </div>
                                    <div class="total_subtotal_booking">
                                        <h4>Total Amount <span>{{ getActiveCurrency() }} <span
                                                    id="amountSpan">{{ convertCurrency($prices['total_fare'], 'AED') }}</span></span>
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
        .input_seat.active svg path {
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

        #explore_area {
            padding: 100px 0;
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

        .appearance-auto {
            appearance: auto !important;
        }

        @media (min-width: 1400px) {
            .container-bboking {
                max-width: 1600px;
            }
        }
    </style>

    <style>
        /* TOOLTIP STYLES */
        [tooltip] {
            position: relative;
            /* opinion 1 */
        }

        /* Applies to all tooltips */
        [tooltip]::before,
        [tooltip]::after {
            text-transform: none;
            /* opinion 2 */
            font-size: 15px;
            /* opinion 3 */
            line-height: 1;
            user-select: none;
            pointer-events: none;
            position: absolute;
            display: none;
            opacity: 0;
        }

        [tooltip]::before {
            content: '';
            border: 5px solid transparent;
            /* opinion 4 */
            z-index: 1001;
            /* absurdity 1 */
        }

        [tooltip]::after {
            content: attr(tooltip);
            /* magic! */
            text-align: center;
            min-width: 2em;
            max-width: 10em;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            padding: 1ch 1.5ch;
            border-radius: .3ch;
            box-shadow: 0 1em 2em -.5em rgba(0, 0, 0, 0.35);
            background: #333;
            color: #fff;
            z-index: 1000;
        }

        /* Make the tooltips respond to hover */
        [tooltip]:not(.seatnot-available):hover::before,
        [tooltip]:not(.seatnot-available):hover::after {
            display: block;
        }

        /* don't show empty tooltips */
        [tooltip='']::before,
        [tooltip='']::after {
            display: none !important;
        }

        /* FLOW: UP */
        [tooltip]:not([flow])::before,
        [tooltip][flow^="up"]::before {
            bottom: 100%;
            border-bottom-width: 0;
            border-top-color: #333;
        }

        [tooltip]:not([flow])::after,
        [tooltip][flow^="up"]::after {
            bottom: calc(100% + 5px);
        }

        [tooltip]:not([flow])::before,
        [tooltip]:not([flow])::after,
        [tooltip][flow^="up"]::before,
        [tooltip][flow^="up"]::after {
            left: 50%;
            transform: translate(-50%, -.5em);
        }

        /* FLOW: DOWN */
        [tooltip][flow^="down"]::before {
            top: 100%;
            border-top-width: 0;
            border-bottom-color: #333;
        }

        [tooltip][flow^="down"]::after {
            top: calc(100% + 5px);
        }

        [tooltip][flow^="down"]::before,
        [tooltip][flow^="down"]::after {
            left: 50%;
            transform: translate(-50%, .5em);
        }

        /* FLOW: LEFT */
        [tooltip][flow^="left"]::before {
            top: 50%;
            border-right-width: 0;
            border-left-color: #333;
            left: calc(0em - 5px);
            transform: translate(-.5em, -50%);
        }

        [tooltip][flow^="left"]::after {
            top: 50%;
            right: calc(100% + 5px);
            transform: translate(-.5em, -50%);
        }

        /* FLOW: RIGHT */
        [tooltip][flow^="right"]::before {
            top: 50%;
            border-left-width: 0;
            border-right-color: #333;
            right: calc(0em - 5px);
            transform: translate(.5em, -50%);
        }

        [tooltip][flow^="right"]::after {
            top: 50%;
            left: calc(100% + 5px);
            transform: translate(.5em, -50%);
        }

        /* KEYFRAMES */
        @keyframes tooltips-vert {
            to {
                opacity: .9;
                transform: translate(-50%, 0);
            }
        }

        @keyframes tooltips-horz {
            to {
                opacity: .9;
                transform: translate(0, -50%);
            }
        }

        /* FX All The Things */
        [tooltip]:not([flow]):hover::before,
        [tooltip]:not([flow]):hover::after,
        [tooltip][flow^="up"]:hover::before,
        [tooltip][flow^="up"]:hover::after,
        [tooltip][flow^="down"]:hover::before,
        [tooltip][flow^="down"]:hover::after {
            animation: tooltips-vert 300ms ease-out forwards;
        }

        [tooltip][flow^="left"]:hover::before,
        [tooltip][flow^="left"]:hover::after,
        [tooltip][flow^="right"]:hover::before,
        [tooltip][flow^="right"]:hover::after {
            animation: tooltips-horz 300ms ease-out forwards;
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

    <script>
        const activeCurrency = '{{ getActiveCurrency() }}';
        const grandTotal = parseFloat($('#amountSpan').html())

        function updateTotal() {
            total = 0
            $("#addon_items .rates").each(function() {
                total = total + parseFloat($(this).html());
            });
            $('#addons').html(parseFloat(total).toFixed(2));
            $('#amountSpan').html(total + grandTotal);
        }

        $('.tabselector').on('click', function() {
            $('.tabselector.active').removeClass('active');
            $('.userprof-tab.active').removeClass('active');

            $(this).addClass('active')
            var id = $(this).attr('href');
            $(id).addClass('active')
        });


        $('.mealselector').on('click', function() {
            $('.meal-tab.active').removeClass('active');
            $('.mealselector.active').removeClass('active');
            $(this).addClass('active');
            var id = $(this).attr('href');
            $(id).addClass('active')
        });

        $('.seatselector').on('click', function() {
            $('.userprof-tab.active').removeClass('active');
            $('.seatselector.active').removeClass('active');
            $(this).addClass('active');
            var id = $(this).attr('href');
            $(id).addClass('active')
        });

        $('.tabswitch_btn').on('click', function() {
            $('.tab-pane.active').removeClass('active');
            $('.nav-link.active').removeClass('active');

            var target = $(this).data('target');
            console.log(target);
            $(target).addClass('active')
            $(target).addClass('show')

            var targetbtn = $(this).data('targetbtn');
            console.log(targetbtn);
            $(targetbtn).addClass('active')

        });


        // baggage script
        $('.input_baggage').on('change', function() {
            var name = $(this).attr('name')
            name = name.replaceAll('[', '_').replaceAll(']', '_');

            $('#addon_items .' + name).remove();

            var html = '<h6 class="' + name + '">' +
                '<p style="display:block">' +
                $(this).data('user') +
                '<span>' + $(this).data('des') + '</span>' +
                '</p>' +
                '<p>' +
                activeCurrency + ' ' +
                '<span class="rates">' +
                $(this).data('rate') +
                '</span>' +
                '</p>' +
                '</h6>';

            $('#addon_items').append(html);
            // $('#addon_items').append('<h6 class="' + name + '">' + $(this).data('rate') + '</h6>');
            updateTotal();
        });

        $('.removeSeatSelection').on('click', function() {
            var name = $(this).data('seatseleted')
            name = name.replaceAll('[', '_').replaceAll(']', '_');
            $('#addon_items .' + name).remove();
            $(".input_baggage").prop('checked', false);
            updateTotal();
        });



        // Meals script
        $('.input_meal').on('change', function() {
            var name = $(this).attr('name')
            name = name.replaceAll('[', '_').replaceAll(']', '_');
            $('#addon_items .' + name).remove();

            var html = '<h6 class="' + name + '">' +
                '<p style="display:block">' +
                $(this).data('user') +
                '<span>' + $(this).data('des') + '</span>' +
                '</p>' +
                '<p>' +
                activeCurrency + ' ' +
                '<span class="rates">' +
                $(this).data('rate') +
                '</span>' +
                '</p>' +
                '</h6>';

            $('#addon_items').append(html);
            updateTotal();

        });
        $('.removeMealSelection').on('click', function() {
            var name = $(this).data('mealseleted')
            name = name.replaceAll('[', '_').replaceAll(']', '_');
            $('#addon_items .' + name).remove();
            $(".input_meal").prop('checked', false);
            updateTotal();
        });


        // Seat script
        var pax_count = {{ $pax_count }}
        var selected_seat_count = 0;
        $(document).on('click', '.input_seat', function() {
            if (!$(this).hasClass('seatnot-available') && !$(this).hasClass('active')) {
                var user_id = $('.seatselector.active').attr('data-user_id');
                console.log(user_id);
                var lfid = $('.seatselector.active').attr('data-lfid');
                var cont_id = '#seating_area_' + lfid;
                if ($('.input_seat.active').length > 0) {
                    $('.input_seat.active').each(function() {
                        console.log($(this).attr('data-user'));
                        if ($(this).attr('data-user') === user_id) {
                            $(this).attr('data-user', '');
                            $(this).removeClass('active');
                        }
                    })
                }
                $(this).toggleClass('active');
                $(this).attr('data-user', user_id);


                var seat_input_id = '#seat_input_' + $('.seatselector.active').attr('data-user-type') + '_' + $(
                    '.seatselector.active').attr('data-user-count') + '_' + lfid;

                $(seat_input_id).val($(this).attr('data-code'))

                $('#addon_items .' + user_id).remove();

                var html = '<h6 class="' + user_id + '">' +
                    '<p style="display:block">' +
                    $('.seatselector.active .seta_pas_text ').html() +
                    '<span>Seat: ' + $(this).attr('data-seat-id') + '</span>' +
                    '</p>' +
                    '<p>' +
                    activeCurrency + ' ' +
                    '<span class="rates">' +
                    $(this).data('rate') +
                    '</span>' +
                    '</p>' +
                    '</h6>';

                $('#addon_items').append(html);
                // $('#addon_items').append('<h6 class="' + name + '">' + $(this).data('rate') + '</h6>');
                updateTotal();
            }
        });
    </script>
@endpush
