@extends('web.layouts.app')

@section('content')
    <!-- Common Banner Area -->
    <section id="common_banner">
        <!-- Form Area -->
        @include('web.common.search_flight')
    </section>
    <!-- Flight Search Areas -->
    <section id="explore_area" class="section_padding">
        <div class="container">
            @php
                $marginData = $data['margins'];
                $totalmargin = $marginData['totalmargin'];
            @endphp
            <!-- Section Heading -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="section_heading_left">
                        @if ($data['search_type'] == 'OneWay')
                            <h2>Flights from {{ $data['airports'][session('flight_search_oneway')['oFrom']]['City'] }} <span
                                    class="range_plan-place"><i
                                        class="fas fa-arrow-right"></i></span>{{ $data['airports'][session('flight_search_oneway')['oTo']]['City'] }}
                            </h2>
                        @elseif($data['search_type'] == 'Return')
                            <h2>Flights from {{ $data['airports'][session('flight_search_return')['rFrom']]['City'] }} <span
                                    class="range_plan-place"><i
                                        class="fas fa-exchange-alt"></i></span>{{ $data['airports'][session('flight_search_return')['rTo']]['City'] }}
                            </h2>
                        @endif
                        <h5 class="section_heading_left-sub">{{ $data['totalCount'] }} results Found</h5>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-3">
                    <div class="left_side_search_area">

                        @php $stopFilter = $airlineFilter = $refundFilter = array(); @endphp

                        @if ($data['search_type'] == 'OneWay')
                            @if (Session::has('flight_search_oneway'))
                                @php
                                    $stopFilter = explode(',', rtrim(Session::get('flight_search_oneway')['ostop_filter']));
                                    $airlineFilter = explode(',', rtrim(Session::get('flight_search_oneway')['oairline_filter']));
                                    $refundFilter = explode(',', rtrim(Session::get('flight_search_oneway')['orefund_filter']));
                                @endphp
                            @endif
                        @elseif($data['search_type'] == 'Return')
                            @if (Session::has('flight_search_return'))
                                @php
                                    $stopFilter = explode(',', rtrim(Session::get('flight_search_return')['rstop_filter']));
                                    $airlineFilter = explode(',', rtrim(Session::get('flight_search_return')['rairline_filter']));
                                    $refundFilter = explode(',', rtrim(Session::get('flight_search_return')['rrefund_filter']));
                                @endphp
                            @endif
                        @elseif($data['search_type'] == 'Circle')
                            @if (Session::has('flight_search_multi'))
                                @php
                                    $stopFilter = explode(',', rtrim(Session::get('flight_search_multi')['mstop_filter']));
                                    $airlineFilter = explode(',', rtrim(Session::get('flight_search_multi')['mairline_filter']));
                                    $refundFilter = explode(',', rtrim(Session::get('flight_search_multi')['mrefund_filter']));
                                @endphp
                            @endif
                        @endif

                        <input type="hidden" name="search_typeResult" id="search_typeResult"
                            value="{{ $data['search_type'] }}">
                        <div class="left_side_search_boxed">
                            <div class="left_side_search_heading">
                                <h5>Number of stops</h5>
                            </div>
                            <div class="tour_search_type">
                                <div class="form-check">
                                    <input class="form-check-input stopFilter"
                                        {{ in_array('1', $stopFilter) ? 'checked="checked"' : '' }} type="checkbox"
                                        value="1" id="flexCheckDefaultf1">
                                    <label class="form-check-label" for="flexCheckDefaultf1">
                                        <span class="area_flex_one">
                                            <span>1 stop</span>
                                            <span>{{ $data['one_stop'] }}</span>
                                        </span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input stopFilter" type="checkbox"
                                        {{ in_array('2', $stopFilter) ? 'checked="checked"' : '' }} value="2"
                                        id="flexCheckDefaultf2">
                                    <label class="form-check-label" for="flexCheckDefaultf2">
                                        <span class="area_flex_one">
                                            <span>2 stop</span>
                                            <span>{{ $data['two_stop'] }}</span>
                                        </span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input stopFilter" type="checkbox"
                                        {{ in_array('3', $stopFilter) ? 'checked="checked"' : '' }} value="3"
                                        id="flexCheckDefaultf3">
                                    <label class="form-check-label" for="flexCheckDefaultf3">
                                        <span class="area_flex_one">
                                            <span>3 stop</span>
                                            <span>{{ $data['three_stop'] }}</span>
                                        </span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input stopFilter" type="checkbox"
                                        {{ in_array('0', $stopFilter) ? 'checked="checked"' : '' }} value="0"
                                        id="flexCheckDefaultf4">
                                    <label class="form-check-label" for="flexCheckDefaultf4">
                                        <span class="area_flex_one">
                                            <span>Non-stop</span>
                                            <span> {{ $data['non_stop'] }}</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="left_side_search_boxed">
                            <div class="left_side_search_heading">
                                <h5>Airlines</h5>
                            </div>
                            <div class="tour_search_type">
                                @isset($data['airlines'])
                                    @foreach ($data['airlines'] as $airKey => $airValue)
                                        @php  $flightKey = isset($data['flightData'][$airKey]) ? $data['flightData'][$airKey] : [];  @endphp
                                        <div class="form-check">
                                            <input class="form-check-input airlineFilter"
                                                {{ in_array($airKey, $airlineFilter) ? 'checked="checked"' : '' }}
                                                type="checkbox" value="{{ $airKey }}" id="flexCheckDefaults1">
                                            <label class="form-check-label" for="flexCheckDefaults1">
                                                <span class="area_flex_one">
                                                    <span>{{ isset($flightKey['AirLineName']) ? $flightKey['AirLineName'] : '' }}</span>
                                                    <span>{{ $airValue }}</span>
                                                </span>
                                            </label>
                                        </div>
                                    @endforeach
                                @endisset
                            </div>
                        </div>
                        <div class="left_side_search_boxed">
                            <div class="left_side_search_heading">
                                <h5>Refundable</h5>
                            </div>
                            <div class="tour_search_type">
                                <div class="form-check">
                                    <input class="form-check-input refundFilter" type="checkbox"
                                        {{ in_array('yes', $refundFilter) ? 'checked="checked"' : '' }} value="yes"
                                        name="refund_yes" id="refundYes">
                                    <label class="form-check-label" for="refundYes">
                                        <span class="area_flex_one">
                                            <span>Yes</span>
                                            <span>{{ $data['refund'] }}</span>
                                        </span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input refundFilter" type="checkbox" value="no"
                                        {{ in_array('no', $refundFilter) ? 'checked="checked"' : '' }} name="refund_no"
                                        id="refundNo">
                                    <label class="form-check-label" for="refundNo">
                                        <span class="area_flex_one">
                                            <span>No</span>
                                            <span> {{ $data['no_refund'] }}</span>
                                        </span>
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-12">
                            @if ($data['search_type'] == 'OneWay')
                                @include('web.search.oneway')
                            @elseif ($data['search_type'] == 'Return')
                                @include('web.search.return')
                            @elseif ($data['search_type'] == 'Circle')
                                @include('web.search.circle')
                            @endif
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
    <script src="{{ asset('assets/js/booking.js') }}"></script>
@endpush
