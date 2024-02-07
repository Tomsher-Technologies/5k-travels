@extends('web.layouts.app')
@section('content')


<!-- Common Banner Area -->
<section id="common_banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="common_bannner_text">
                    <h2>Booking Details </h2>

                </div>
            </div>
        </div>
    </div>
</section>


<!-- Dashboard Area -->
<section id="dashboard_main_arae" class="section_padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                @include('web.common.dashboard_sidebar')
            </div>
            <div class="col-lg-9">
                <div class="dashboard_common_table">

                    <div id="tab-booking-details">

                        <div class="mt-n5 d-flex gap-3 flex-wrap align-items-end">
                            <div>
                                <h3>Booking Details</h3>
                                @php
                                    $childId = '';
                                    if($bookings[0]->is_reissued == 1){
                                        $childId = getNewReissuedBooking($bookings[0]->id);
                                        $childId = isset($childId[0]) ? $childId[0] : $bookings[0]->id;
                                    }
                                @endphp
                            </div>
                               
                            <div class="ms-md-auto">
                                @if($type == 'my_bookings' || $type == 'upcoming')
                                    <!-- <a href="product-list.html" class="btn btn-cancel">Cancel Booking</a> -->
                                    @php   
                                        $timeDiff = time() - strtotime($bookings[0]->created_at);
                                    @endphp
                                    @if($bookings[0]->reissue_request == 0)
                                        @if($bookings[0]->is_cancelled == 0 && $bookings[0]->cancel_request == 0)
                                            @if($timeDiff < 86400)
                                                @if(strtolower($bookings[0]->fare_type) == 'webfare' )
                                                    <a href="javascript:void(0)" class="refundQuoteTicket btn btn-cancel" title="Cancel Ticket" id=""  data-bookid="{{ $bookings[0]->id }}" data-id="{{ $bookings[0]->unique_booking_id }}">Cancel Booking</a>
                                                @else
                                                    @if($bookings[0]->ticket_status == "Ticketed" || $bookings[0]->ticket_status == "OK")
                                                        <a href="javascript:void(0)" class="voidQuoteTicket btn btn-cancel" title="Cancel Ticket" id="" data-provider="{{ $bookings[0]->api_provider }}" data-bookid="{{ $bookings[0]->id }}" data-id="{{ $bookings[0]->unique_booking_id }}">Cancel Booking</a>
                                                    @else
                                                        <a href="javascript:void(0)" class="cancelTicket btn btn-cancel" title="Cancel Ticket" data-type="void" id="" data-provider="{{ $bookings[0]->api_provider }}" data-bookid="{{ $bookings[0]->id }}" data-id="{{ $bookings[0]->unique_booking_id }}">Cancel Booking</a>
                                                    @endif
                                                @endif
                                            @elseif($timeDiff > 86400)
                                                @if(strtolower($bookings[0]->fare_type) == 'webfare' )
                                                    <a href="javascript:void(0)" class="refundQuoteTicket btn btn-cancel" title="Cancel Ticket" id="" data-bookid="{{ $bookings[0]->id }}" data-id="{{ $bookings[0]->unique_booking_id }}">Cancel Booking</a>
                                                @else
                                                    @if($bookings[0]->ticket_status == "Ticketed" || $bookings[0]->ticket_status == "OK")
                                                        <a href="javascript:void(0)" class="refundQuoteTicket btn btn-cancel" title="Cancel Ticket" id="" data-bookid="{{ $bookings[0]->id }}" data-id="{{ $bookings[0]->unique_booking_id }}">Cancel Booking</a>
                                                    @else
                                                        <a href="javascript:void(0)" class="cancelTicket btn btn-cancel" data-type="refund" title="Cancel Ticket" id="" data-bookid="{{ $bookings[0]->id }}" data-id="{{ $bookings[0]->unique_booking_id }}">Cancel Booking</a>
                                                    @endif
                                                @endif
                                            @endif
                                        @elseif($bookings[0]->is_cancelled == 0 && $bookings[0]->cancel_request == 1)
                                            <a href="javascript:void(0)" class="btn btn-info cancelPTRStatusCheck" title="Check Cancel Status" data-id="{{ $bookings[0]->unique_booking_id }}" data-ptr="{{ $bookings[0]->cancel_ptr }}">Check Cancel Status</a> 
                                        @elseif($bookings[0]->is_cancelled == 1)
                                            <span class="badge bg-danger line-height-badge"> Cancelled </span>
                                        @endif
                                    @endif

                                    @if($bookings[0]->cancel_request == 0)
                                        @if($bookings[0]->is_reissued == 0 && $bookings[0]->reissue_request == 1)
                                            <a href="javascript:void(0)" class="btn btn-info reissuePTRStatusCheck" title="Check Cancel Status" data-id="{{ $bookings[0]->id }}" data-uniqueid="{{ $bookings[0]->unique_booking_id }}"  data-ptr="{{ $bookings[0]->reissue_ptr }}">Check Reissue Status</a> 
                                        @elseif($bookings[0]->is_reissued == 1)
                                            <a href="{{ route('booking-details', ['type' => $type, 'id' => $childId] ) }}">
                                                <span class="badge bg-info line-height-badge"> Rescheduled </span>
                                            </a>
                                        @else
                                            <a href="{{ route('change-date',['type' => $type,'id' => $bookings[0]->id,'unique_id' => $bookings[0]->unique_booking_id] ) }}" class="btn btn-warning ">Reschedule Booking</a>
                                        @endif
                                    @endif
                                @else
                                    @if($bookings[0]->is_cancelled == 1)
                                        <span class="badge bg-danger line-height-badge"> Cancelled </span>
                                    @elseif($bookings[0]->is_reissued == 1)
                                        <a href="{{ route('booking-details', ['type' => $type, 'id' => $childId] ) }}"><span class="badge bg-info line-height-badge"> Rescheduled </span></a>
                                    @endif

                                @endif
                            </div>


                        </div>

                        <div class="tab-content mt-4">
                            <div class="tab-pane fade show active" id="family-house" role="tabpanel">
                                <div class="accordion accordion--separated accordion--secondary" id="accordionExample">
                                    

                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"  data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                aria-expanded="false" aria-controls="collapseOne">
                                                <div class="d-flex gap-4 flex-wrap align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center gap-4 flex-wrap">
                                                        <div class="d-grid place-content-center w-12 h-12 box-shadow rounded-circle flex-shrink-0">
                                                            <div class="round-icon-p d-grid place-content-center w-10 h-10 bg-primary-50 clr-primary-300">
                                                                <span class="icon-round-bb"> <i class="fas fa-plane-departure"></i> </span>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h5 class="fw-medium mb-1"> {{ $bookings[0]->origin }} To {{ $bookings[0]->destination }} </h5>
                                                            <ul  class="list list-row align-items-center flex-wrap list-divider-half-xs">
                                                                <li>
                                                                    <span class="d-inline-block fs-14">
                                                                        <span class="d-inline-block clr-neutral-500">
                                                                            Booking ID : </span>
                                                                        <span lass="d-inline-block clr-neutral-700 fw-medium">
                                                                        {{ $bookings[0]->unique_booking_id }} </span>
                                                                    </span>
                                                                </li>
                                                                <li>
                                                                    <!-- <span class="d-inline-block fs-14">
                                                                        <span class="d-inline-block clr-neutral-500">
                                                                            Travel Class : </span>
                                                                        <span class="d-inline-block clr-neutral-700 fw-medium">
                                                                            Economy </span>
                                                                    </span> -->
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>

                                                </div>

                                            </button>
                                        </h2>
                                        @php   $airlinePNR = '';  @endphp
                                        <div id="collapseOne" class="accordion-collapse collapse"
                                            data-bs-parent="#accordionExample" style="">
                                            <div class="accordion-body">
                                                <div class="fb-cb">
                                                    @if(isset($bookings[0]))
                                                        @foreach($bookings[0]['flights'] as $flights)
                                                            @php   
                                                                $airlineData = getAirlineData($flights->marketing_airline_code);
                                                                $deptAirportData = getAirportData($flights->departure_airport);
                                                                $arrAirportData = getAirportData($flights->arrival_airport);
                                                                $airlinePNR = $flights->airline_pnr;
                                                            @endphp
                                                            <div class="row y-gap-10 justify-between">
                                                                <div class="col-auto">
                                                                    <div class="d-flex items-center mb-15">
                                                                        <div class="flight_logo d-flex justify-center mr-15"><img src="{{ isset($airlineData[0]) ? $airlineData[0]['AirLineLogo'] :'' }}" alt="image"></div>
                                                                        <div class="text-14 text-light-1">{{isset($airlineData[0]) ? $airlineData[0]['AirLineName'] : '' }} {{$flights->flight_number}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="relative z-0">
                                                                        <div class="border-line-2"></div>
                                                                        <div class="d-flex items-center">
                                                                            <div class="w-28 d-flex justify-center mr-15">
                                                                                <div class="size-10 border-light rounded-full bg-white">
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-auto">
                                                                                    <div class="lh-14 fw-500">{{ date('d M, Y', strtotime($flights->departure_date_time)) }}</div>
                                                                                    <div class="lh-14 fw-500">{{ date('H:i', strtotime($flights->departure_date_time)) }}</div>
                                                                                </div>
                                                                                <div class="col-auto">
                                                                                    <div class="lh-14 fw-500">{{ $deptAirportData[0]['AirportName'] }}, {{ $deptAirportData[0]['City'] }} ({{ $flights->departure_airport }})</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-flex items-center m-15">
                                                                            <div class="w-28 d-flex justify-center mr-15"><img
                                                                                    src="{{ asset('assets/img/icon/plane.svg') }}" alt="image">
                                                                            </div>
                                                                            <div class="text-14 text-light-1">{{ convertToHoursMins($flights->journey_duration) }}</div>
                                                                        </div>
                                                                        <div class="d-flex items-center mt-15">
                                                                            <div class="w-28 d-flex justify-center mr-15">
                                                                                <div
                                                                                    class="size-10 border-light rounded-full bg-border">
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-auto">
                                                                                    <div class="lh-14 fw-500">{{ date('d M, Y', strtotime($flights->arrival_date_time)) }}</div>
                                                                                    <div class="lh-14 fw-500">{{ date('H:i', strtotime($flights->arrival_date_time)) }}</div>
                                                                                </div>
                                                                                <div class="col-auto">
                                                                                <div class="lh-14 fw-500">{{ $arrAirportData[0]['AirportName'] }}, {{ $arrAirportData[0]['City'] }} ({{ $flights->arrival_airport }})</div>
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

                                                                    <div class="text-14 text-light-1">{{$cabinClass}}</div>
                                                                    <div class="text-14 mt-15 md:mt-5">
                                                                        Airline PNR :<strong> {{ $airlinePNR }}</strong>
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

                                                                    <h4>TRAVELLER ({{ ($pass->passenger_type =='ADT') ? "Adult" : (($pass->passenger_type =="CHD") ? "Child" : "Infant") }})
                                                                        - <span class="head-travel">{{ ($pass->is_return == 0) ? "Onward Trip" : "Return Trip" }}</span>
                                                                    </h4>
                                                                    <div class="form-check-label">
                                                                        <span class="mb-2 fw-semibold fs-12 d-block text-muted text-uppercase fw-500">
                                                                            {{ $pass->passenger_first_name }} {{ $pass->passenger_last_name }}
                                                                        </span>
                                                                        @php
                                                                           
                                                                        @endphp
                                                                        <span class="fs-14 mb-2 fw-semibold  d-block">Gender : {{ $pass->gender }}</span>
                                                                        <span class="fs-14 mb-2 fw-semibold  d-block">Date Of Birth : {{ date('Y-m-d',strtotime($pass->date_of_birth)) }}</span>
                                                                        <span class="fs-14 mb-2 fw-semibold  d-block">Passport Number : {{ $pass->passport_number }}</span>
                                                                        
                                                                        <span class=" mb-2 fw-600 d-block">E-TICKET NUMBER : {{ $pass->eticket_number }}</span>
                                                                        <!-- <span class=" mb-2 fw-600 d-block">SEAT : 16F</span>
                                                                        <span class=" mb-2 fw-600 d-block">MEAL : Biriyani,
                                                                            Coffee</span> -->
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            @endforeach
                                                            @if(!empty($bookings[0]['extraServices']))
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
                                                                <div class=" mt-1 col-sm-12" style="padding: 1%;">
                                                                    <div class="">
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
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="tour_detail_right_sidebar mt-4">
                            <div class="tour_details_right_boxed">
                                <div class="tour_details_right_box_heading">
                                    <h3>Booking amount</h3>
                                </div>

                                <div class="tour_booking_amount_area">
                                    <ul>
                                        @if($bookings[0]->adult_count != 0)
                                            <li>Adult Price x {{ $bookings[0]->adult_count }} <span>{{ $bookings[0]->currency }} {{ $bookings[0]->adult_amount }}</span></li>
                                        @endif

                                        @if($bookings[0]->child_count != 0)
                                            <li>Child Price x {{ $bookings[0]->child_count }} <span>{{ $bookings[0]->currency }} {{ $bookings[0]->child_amount }}</span></li>
                                        @endif

                                        @if($bookings[0]->infant_count != 0)
                                            <li>Infant Price x {{ $bookings[0]->infant_count }} <span>{{ $bookings[0]->currency }} {{ $bookings[0]->infant_amount }}</span></li>
                                        @endif
                                    </ul>
                                    <div class="tour_bokking_subtotal_area">
                                        <h6>Total Base Fare <span>{{ $bookings[0]->currency }} {{ $bookings[0]->adult_amount + $bookings[0]->child_amount + $bookings[0]->infant_amount  }}</span></h6>
                                    </div>
                                    <div class="tour_bokking_subtotal_area">
                                        <h6>Total Tax <span>{{ $bookings[0]->currency }} {{ $bookings[0]->total_tax }}</span></h6>
                                    </div>

                                    <div class="tour_bokking_subtotal_area">
                                        <h6>Add Ons <span id="addons">{{ $bookings[0]->currency }} {{ $bookings[0]->addon_amount }}</span></h6>
                                    </div>
                                    <!-- <div class="coupon_add_area">
                                        <h6><span class="remove_coupon_tour">Remove</span> Coupon code (OFF 50)
                                            <span>AED 50.00</span>
                                        </h6>
                                    </div> -->
                                    <div class="total_subtotal_booking">
                                        <h4>Total Amount <span >{{ $bookings[0]->currency }} {{ $bookings[0]->total_amount }}</span> </h4>
                                    </div>
                                    <hr>

                                    
                                </div>
                            </div>
                            @if($bookings[0]->parent_id != '')
                            <div class="tour_details_right_boxed mt-4">
                                <div class="tour_details_right_box_heading">
                                    <h3>Reschedule Fare Details</h3>
                                </div>

                                <div class="tour_booking_amount_area">
                                    <div class="tour_bokking_subtotal_area">
                                        <h6>Old Booking Fare<span>{{ $bookings[0]->currency }} {{ $bookings[0]->total_amount - $bookings[0]->reschedule_fare_difference }}</span></h6>
                                    </div>
                                    <div class="tour_bokking_subtotal_area">
                                        <h6>New Booking Fare Difference <span>{{ $bookings[0]->currency }} {{ $bookings[0]->reschedule_fare_difference }}</span></h6>
                                    </div>
                                    <div class="total_subtotal_booking">
                                        <h4>Total Amount <span >{{ $bookings[0]->currency }} {{ $bookings[0]->total_amount }}</span> </h4>
                                    </div>
                                    <hr>

                                    
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                <!-- The Modal -->
                <div class="modal " id="cancelQuote" data-backdrop="static" data-keyboard="false">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Cancellation Charges</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <!-- Form Area -->
                                                <section id="theme_search_form_tour">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-sm-12 d-flex padding-1rem">
                                                                <div class="col-sm-6">
                                                                    Cancellation Fee :
                                                                </div>
                                                                <div class="col-sm-6" id="totalCancelFee">
                                                                
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 d-flex padding-1rem">
                                                                <div class="col-sm-6">
                                                                    Service Charge :
                                                                </div>
                                                                <div class="col-sm-6" id="serviceCharge">
                                                                
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 d-flex padding-1rem">
                                                                <div class="col-sm-6">
                                                                    Total Refund Amount :
                                                                </div>
                                                                <div class="col-sm-6" id="totalRefund">
                                                                
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <input type="hidden" id="book_Id" name="book_Id" value="">
                                                <input type="hidden" id="unique_BookId" name="unique_BookId" value="">
                                                <input type="hidden" id="cancel_fee" name="cancel_fee" value="">
                                                <input type="hidden" id="refund_amount" name="refund_amount" value="">
                                                <input type="hidden" id="request_type" name="request_type" value="">
                                                <button type="button" class="btn btn-success" id="requestCancel">Send Cancel Request</button>
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
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
<link rel="stylesheet" href="{{ asset('assets/css/search_flights.css') }}" />
<style>
.head-travel{
    color: #1fba71;
    font-weight: 600;
}
</style>
@endpush
@push('footer')

<script>
$('.reissuePTRStatusCheck').on('click', function () {
        $('.ajaxloader').css('display','block');
        var id = $(this).attr('data-id');
        var ptr = $(this).attr('data-ptr');
        var uniqueid = $(this).attr('data-uniqueid');
        $.ajax({
            url: "{{ route('flight.reissue_prtStatus')}}",
            type: "GET",
            data: { "_token": "{{ csrf_token() }}", "ptr" : ptr, "id" : id, "uniqueid" : uniqueid},
            success: function( response ) {
                $('.ajaxloader').css('display','none');
                swal({
                    title: "", 
                    text: response, 
                    icon: "info",
                    closeOnClickOutside: false,
                }).then(function() {
                    location.reload();
                });
                // setTimeout(() => {
                //     history.go(-1);
                //     location.reload(); 
                // }, 2000);
            }
        });
    }) 
    $('.cancelTicket').on('click', function () {
        $('.ajaxloader').css('display','block');
        var uniquebookId = $(this).attr('data-id');
        var id = $(this).attr('data-bookid');
        var type = $(this).attr('data-type');
        $.ajax({
            url: "{{ route('flight.cancel')}}",
            type: "GET",
            data: { "_token": "{{ csrf_token() }}", "uniquebookId" : uniquebookId, "id" : id, "type" : type},
            success: function( response ) {
                $('.ajaxloader').css('display','none');
                console.log(response);
                var resp = JSON.parse(response);
                if(resp.status == true){
                    if(resp.type == 'cancel'){
                        swal({
                            title: "Success!", 
                            text: resp.msg, 
                            icon: "success",
                            closeOnClickOutside: false,
                        }).then(function() {
                            location.reload();
                        });
                    }else{
                        $('#book_Id').val(resp.data.id);
                        $('#request_type').val(resp.type);
                        $('#unique_BookId').val(resp.data.UniqueID);

                        $('#refund_amount').val(resp.data.refundAmount);
                        if(resp.type == 'refund'){
                            $('#cancel_fee').val(resp.data.refundFee);
                            $('#totalCancelFee').html(resp.data.currency +' '+ resp.data.refundFee);
                        }else{
                            $('#cancel_fee').val(resp.data.voidFee);
                            $('#totalCancelFee').html(resp.data.currency +' '+ resp.data.voidFee);
                        }
                        

                        $('#serviceCharge').html(resp.data.currency +' '+ resp.data.serviceCharge);
                        $('#totalRefund').html(resp.data.currency +' '+ resp.data.refundAmount);
                        $('#cancelQuote').modal({backdrop: 'static', keyboard: false})  
                        $('#cancelQuote').modal('show');
                    }
                }else{
                    $('#cancelQuote').modal('hide');
                    swal({
                        title: "Cancellation Failed!", 
                        text: resp.msg, 
                        icon: "error",
                        closeOnClickOutside: false,
                    }).then(function() {
                        location.reload();
                    });
                }
            }
        });
    })   

    $('.voidQuoteTicket').on('click', function () {
        $('.ajaxloader').css('display','block');
        $('#totalCancelFee').html('');
        $('#serviceCharge').html('');
        $('#totalRefund').html('');
        $('#bookId').val('');
        $('#uniqueBookId').val('');
        var id = $(this).attr('data-id');
        var bookId = $(this).attr('data-bookid');
        var provider = $(this).attr('data-provider');
        $.ajax({
            url: "{{ route('flight.cancel')}}",
            type: "GET",
            data: { 
                "_token": "{{ csrf_token() }}",
                 "bookid" : bookId,
                  "id" : id,
                  'provider': provider
                },
            success: function( response ) {
                $('.ajaxloader').css('display','none');
                console.log(response);
                var resp = JSON.parse(response);
                if(resp.status == true){
                    $('#book_Id').val(resp.data.id);
                    $('#request_type').val('void');
                    $('#unique_BookId').val(resp.data.UniqueID);

                    $('#refund_amount').val(resp.data.refundAmount);
                    $('#cancel_fee').val(resp.data.voidFee);

                    $('#totalCancelFee').html(resp.data.currency +' '+ resp.data.voidFee);
                    $('#serviceCharge').html(resp.data.currency +' '+ resp.data.serviceCharge);
                    $('#totalRefund').html(resp.data.currency +' '+ resp.data.refundAmount);
                    $('#cancelQuote').modal({backdrop: 'static', keyboard: false})  
                    $('#cancelQuote').modal('show');
                }else{
                    $('#cancelQuote').modal('hide');
                    swal({
                        title: "Cancellation Failed!",  
                        text: resp.msg, 
                        icon: "error",
                        closeOnClickOutside: false,
                    }).then(function() {
                        location.reload();
                    });
                }
                
            }
        });
    })  
    
    $('#requestCancel').on('click', function () {
        $('.ajaxloader').css('display','block');
       
        var request_type = $('#request_type').val();

         var data ={'id' : $('#book_Id').val(),
                    'bookId' : $('#unique_BookId').val(),
                    'refund_amount' : $('#refund_amount').val(),
                    'cancel_fee'    :  $('#cancel_fee').val(),
                    '_token' : "{{ csrf_token() }}"
                    };
        var requesturl = '';
        if(request_type == 'void'){
            requesturl = "{{ route('flight.void')}}";
        }else{
            requesturl = "{{ route('flight.refund')}}";
        }
        $.ajax({
            url: requesturl,
            type: "POST",
            data: data,
            success: function( response ) {
                $('.ajaxloader').css('display','none');
                var resp = JSON.parse(response);
                if(resp.status == true){
                    $('#cancelQuote').modal('hide');
                    swal({
                        title: "Success!", 
                        text: resp.msg, 
                        icon: "success",
                        closeOnClickOutside: false,
                    }).then(function() {
                        location.reload();
                    });
                }else{
                    $('#cancelQuote').modal('hide');
                    swal({
                        title: "Cancellation Failed!", 
                        text: resp.msg, 
                        icon: "error",
                        closeOnClickOutside: false,
                    }).then(function() {
                        location.reload();
                    });
                }
            }
        });
    })   

    $('.cancelPTRStatusCheck').on('click', function () {
        $('.ajaxloader').css('display','block');
        var id = $(this).attr('data-id');
        var ptr = $(this).attr('data-ptr');
        $.ajax({
            url: "{{ route('flight.prtStatus')}}",
            type: "GET",
            data: { "_token": "{{ csrf_token() }}", "ptr" : ptr, "id" : id},
            success: function( response ) {
                $('.ajaxloader').css('display','none');
                swal({
                    title: "", 
                    text: response, 
                    icon: "info",
                    closeOnClickOutside: false,
                }).then(function() {
                        location.reload();
                    });
            }
        });
    })   

    $('.refundQuoteTicket').on('click', function () {
        $('.ajaxloader').css('display','block');
        $('#totalCancelFee').html('');
        $('#serviceCharge').html('');
        $('#totalRefund').html('');
        $('#bookId').val('');
        $('#uniqueBookId').val('');
        var bookId = $(this).attr('data-id');
        var id = $(this).attr('data-bookid');
        $.ajax({
            url: "{{ route('flight.refundQuote')}}",
            type: "GET",
            data: { "_token": "{{ csrf_token() }}", "bookId" : bookId, "id" : id},
            success: function( response ) {
                $('.ajaxloader').css('display','none');
                console.log(response);
                var resp = JSON.parse(response);
                if(resp.status == true){
                    $('#book_Id').val(resp.data.id);
                    $('#unique_BookId').val(resp.data.UniqueID);
                    $('#refund_amount').val(resp.data.refundAmount);
                    $('#cancel_fee').val(resp.data.refundFee);
                    $('#request_type').val('refund');
                    $('#totalCancelFee').html(resp.data.currency +' '+ resp.data.refundFee);
                    $('#serviceCharge').html(resp.data.currency +' '+ resp.data.serviceCharge);
                    $('#totalRefund').html(resp.data.currency +' '+ resp.data.refundAmount);
                    $('#cancelQuote').modal({backdrop: 'static', keyboard: false})  
                    $('#cancelQuote').modal('show');
                }else{
                    $('#cancelQuote').modal('hide');
                    swal({
                        title: "Cancellation Failed!",  
                        text: resp.msg, 
                        icon: "error",
                        closeOnClickOutside: false,
                    }).then(function() {
                        location.reload();
                    });
                }
                
            }
        });
    })   
  
</script>
@endpush