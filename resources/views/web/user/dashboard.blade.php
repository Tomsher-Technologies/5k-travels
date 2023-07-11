@extends('web.layouts.app')
@section('content')


 <!-- Common Banner Area -->
 <section id="common_banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="common_bannner_text">
                        <h2>{{ ($type == 'my_bookings') ? 'My Bookings' : 'Upcoming Bookings' }}  </h2>
                        
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
                        <h3>{{ ($type == 'my_bookings') ? 'My Bookings' : 'Upcoming Bookings' }}  </h3>
                        <div class="table-responsive-lg table_common_area">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sl no.</th>
                                        <th>Booking ID</th>
                                        <th>Direction</th>
                                        <th>Origin</th>
                                        <th>Destination</th>
                                        <th>Amount</th>
                                        <th>Booking Date</th>
                                        <th>Ticket Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($bookings)
                                        @foreach($bookings as $key=>$book)
                                            <tr>
                                                <td>{{ ($key+1) + ($bookings->currentPage() - 1)*$bookings->perPage() }}</td>
                                                <td>{{ $book->unique_booking_id }}</td>
                                                <td>{{ $book->direction }}</td>
                                                <td>{{ $book->origin }}</td>
                                                <td>{{ $book->destination }}</td>
                                                <td>{{ $book->currency }} {{ $book->total_amount }}</td>
                                                <td>{{ date('d-m-Y' ,strtotime($book->created_at)) }}</td>
                                                
                                                <td class="complete">
                                                    @if($book->is_cancelled == 1)
                                                        <span class="danger-icon"> Cancelled</span>
                                                    @else
                                                        @if($book->ticket_status == "TktInProcess")
                                                            <span class="complete"> In Process</span>
                                                        @elseif($book->ticket_status == "BookingInProcess")
                                                            <span class="complete"> Booking In Process</span>
                                                        @else
                                                            <span class="complete">{{ ucfirst(strtolower($book->ticket_status)) }}</span>
                                                        @endif

                                                    @endif

                                                </td>
                                                <td>
                                                   
                                                    @php   
                                                        $timeDiff = time() - strtotime($book->created_at);
                                                    @endphp
                                                    <a href="{{ route('booking-details', ['type' => $type, 'id' => $book->id] ) }}" class="info-icon" title="View Ticket Details"><i class="fas fa-eye"></i></a> &nbsp;
                                                    @if($book->is_cancelled == 0 && $book->cancel_request == 0)
                                                        @if($timeDiff < 86400)
                                                            @if(strtolower($book->fare_type) == 'webfare' )
                                                                <a href="javascript:void(0)" class="refundQuoteTicket danger-icon" title="Cancel Ticket" id=""  data-bookid="{{ $book->id }}" data-id="{{ $book->unique_booking_id }}"><i class="fas fa-times"> </i></a>
                                                            @else
                                                                @if($book->ticket_status == "Ticketed" || $book->ticket_status == "OK")
                                                                    <a href="javascript:void(0)" class="voidQuoteTicket danger-icon" title="Cancel Ticket" id="" data-bookid="{{ $book->id }}" data-id="{{ $book->unique_booking_id }}"><i class="fas fa-times"> </i></a>
                                                                @else
                                                                    <a href="javascript:void(0)" class="cancelTicket danger-icon" title="Cancel Ticket" data-type="void" id="" data-bookid="{{ $book->id }}" data-id="{{ $book->unique_booking_id }}"><i class="fas fa-times"> </i></a>
                                                                @endif
                                                            @endif
                                                        @elseif($timeDiff > 86400)
                                                            @if(strtolower($book->fare_type) == 'webfare' )
                                                                <a href="javascript:void(0)" class="refundQuoteTicket danger-icon" title="Cancel Ticket" id="" data-bookid="{{ $book->id }}" data-id="{{ $book->unique_booking_id }}"><i class="fas fa-times"> </i></a>
                                                            @else
                                                                @if($book->ticket_status == "Ticketed" || $book->ticket_status == "OK")
                                                                    <a href="javascript:void(0)" class="refundQuoteTicket danger-icon" title="Cancel Ticket" id="" data-bookid="{{ $book->id }}" data-id="{{ $book->unique_booking_id }}"><i class="fas fa-times"> </i></a>
                                                                @else
                                                                    <a href="javascript:void(0)" class="cancelTicket danger-icon" data-type="refund" title="Cancel Ticket" id="" data-bookid="{{ $book->id }}" data-id="{{ $book->unique_booking_id }}"><i class="fas fa-times"> </i></a>
                                                                @endif
                                                            @endif
                                                        @endif
                                                        <!-- @if($timeDiff < 86400)
                                                            @if(strtolower($book->fare_type) == 'webfare' )
                                                                <a href="javascript:void(0)" class="refundQuoteTicket danger-icon" title="Cancel Ticket" id=""  data-bookid="{{ $book->id }}" data-id="{{ $book->unique_booking_id }}"><i class="fas fa-times"> </i></a>
                                                            @else
                                                                <a href="javascript:void(0)" class="voidQuoteTicket danger-icon" title="Cancel Ticket" id="" data-bookid="{{ $book->id }}" data-id="{{ $book->unique_booking_id }}"><i class="fas fa-times"> </i></a>
                                                            @endif
                                                        @elseif($timeDiff > 86400)
                                                            <a href="javascript:void(0)" class="refundQuoteTicket danger-icon" title="Cancel Ticket" id="" data-bookid="{{ $book->id }}" data-id="{{ $book->unique_booking_id }}"><i class="fas fa-times"> </i></a>
                                                        @endif -->
                                                    @elseif($book->is_cancelled == 0 && $book->cancel_request == 1)
                                                        <a href="javascript:void(0)" class="success-icon cancelPTRStatusCheck" title="Check Cancel Status" data-id="{{ $book->unique_booking_id }}" data-ptr="{{ $book->cancel_ptr }}"><i class="fas fa-refresh"></i></a> 
                                                    @endif

                                                   
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                    <div class="pagination_area">
                        {{ $bookings->appends(request()->input())->links() }}
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
    </section>
<!-- newsletter content -->
@include('web.includes.newsletter')
<!-- /newsletter content -->
@endsection
@push('header')
<link rel="stylesheet" href="{{ asset('assets/css/search_flights.css') }}" />
<style>

</style>
@endpush
@push('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">

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
                        title: "Something went wrong!", 
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
        var bookId = $(this).attr('data-id');
        var id = $(this).attr('data-bookid');
        $.ajax({
            url: "{{ route('flight.voidQuote')}}",
            type: "GET",
            data: { "_token": "{{ csrf_token() }}", "bookId" : bookId, "id" : id},
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
                        title: "Something went wrong!", 
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
                        title: "Something went wrong!", 
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
                        title: "Something went wrong!", 
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