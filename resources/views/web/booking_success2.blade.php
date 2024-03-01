@extends('web.layouts.app')
@section('content')
    <!-- Common Banner Area -->
    <section id="common_banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="common_bannner_text text-dark">
                        <h2>
                            @if (!empty($booking))
                                Successfully Booked
                            @endif
                        </h2>
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
                    <div class="tou_booking_form_Wrapper padding20">

                        @if (!empty($booking))
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <div class="dashboard_common_table col-sm-12">
                                        <div id="tab-booking-details">
                                            <div class="tab-content">
                                                <div class="tab-pane fade show active" id="family-house" role="tabpanel">
                                                    <div class="accordion accordion--separated accordion--secondary"
                                                        id="accordionExample">
                                                        <div class="accordion-item">
                                                            @php $airlinePNR = ''; @endphp
                                                            <div id="collapseOne" style="">
                                                                <div class="">
                                                                    <div class="fb-cb" style="padding: 2%;">

                                                                        @if ($booking)
                                                                            <h3 class="fw-medium mb-3 text-left">
                                                                                {{ $booking->direction }} trip from
                                                                                {{ $booking->origin }} to
                                                                                {{ $booking->destination }}
                                                                                <span style="font-size: 14px;float: right;"
                                                                                    class="mt-2">Booking Id :
                                                                                    {{ $booking->unique_booking_id }}</span>
                                                                            </h3>
                                                                        @endif


                                                                        <div class="row">
                                                                            @foreach ($booking['passengers'] as $pass)
                                                                                <div class="col-md-6">
                                                                                    <div class="traveler-b-detl">

                                                                                        <h4>TRAVELLER
                                                                                            ({{ $pass->passenger_type == 'ADT' ? 'Adult' : ($pass->passenger_type == 'CHD' ? 'Child' : 'Infant') }})
                                                                                            - <span
                                                                                                class="head-travel">{{ $pass->is_return == 0 ? 'Onward Trip' : 'Return Trip' }}</span>
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
                                                                                                {{ date('Y-m-d', strtotime($pass->date_of_birth)) }}</span>
                                                                                            <span
                                                                                                class="fs-14 mb-2 fw-semibold  d-block">Passport
                                                                                                Number :
                                                                                                {{ $pass->passport_number }}</span>

                                                                                            <span
                                                                                                class=" mb-2 fw-600 d-block">E-TICKET
                                                                                                NUMBER :
                                                                                                {{ $pass->eticket_number }}</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach

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
                        @else
                            <i class="fa fa-xmark-circle" style=" color: #ff2121; font-size: 55px; margin-bottom: 20px;">
                            </i>
                            <h3>{{ $msg }}</h3>
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
        .head-travel {
            color: #1fba71;
            font-weight: 600;
        }

        .cta_content {
            color: black;
        }

        .text-left {
            text-align: left;
        }

        .padding20 {
            padding-left: 15%;
            padding-right: 15%;
        }
    </style>
@endpush
@push('footer')
@endpush
