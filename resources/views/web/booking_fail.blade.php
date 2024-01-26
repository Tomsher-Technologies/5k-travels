@extends('web.layouts.app')
@section('content')
    <!-- Common Banner Area -->
    <section id="common_banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="common_bannner_text text-dark">
                        <h2>Booking Failed</h2>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- Tour Booking Submission Areas -->
    <section id="tour_booking_submission" class="section_padding" style="padding: 80px 0;">
        <div class="container container-bboking">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tou_booking_form_Wrapper padding20 text-center">
                        <i class="fa fa-xmark-circle" style=" color: #ff2121; font-size: 55px; margin-bottom: 20px;"> </i>
                        <h3>Your booking has failed due to an error, please try again.</h3>
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
