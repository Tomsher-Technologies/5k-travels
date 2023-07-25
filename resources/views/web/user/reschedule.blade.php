@extends('web.layouts.app')
@section('content')


 <!-- Common Banner Area -->
 <section id="common_banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="common_bannner_text">
                        <h2>Reschedule Booking </h2>
                        
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
              
                    <div class="dashboard_common_table" style="min-height:700px;">
                        <div class="mt-n5 d-flex gap-3 flex-wrap align-items-end">
                            <div>
                                <h3>Reschedule Booking</h3>
                            </div>
                               
                            <div class="ms-md-auto">
                                <a href="{{ route('booking-details', ['type' => $type, 'id' => $data['id']] ) }}" class="btn back-btn"><i class="fa fa-arrow-left"></i>&nbsp; Back</a>
                            </div>
                        </div>

                        <div class="tab-content mt-4">
                            <div class="row">
                                <form id="reschedule" action="#">
                                    <div class="col-sm-12">
                                        @if($data['search'])
                                            @foreach($data['search'] as $search)
                                                <div class="col-sm-12 d-flex mt-3">
                                                    <div class="form-group col-sm-3">
                                                        <label class="form-label">Origin </label>
                                                        <input class="form-control" type="text" name="origin[]" readonly value="{{ $search->departure_airport }}">
                                                    </div>
                                                    <div class="form-group col-sm-3 ml-10">
                                                        <label class="form-label">Destination </label>
                                                        <input  class="form-control" type="text" name="destination[]" readonly value="{{ $search->arrival_airport }}">
                                                    </div>
                                                    <div class="form-group col-sm-3 ml-10">
                                                        <label class="form-label">Journey Date </label>
                                                        <input  class="form-control reschedule_date" type="text" readonly placeholder="YYYY-MM-DD" name="date[{{ $search->departure_airport }}-{{ $search->arrival_airport }}]" value="{{ date('Y-m-d',strtotime($search->departure_date_time)) }}">
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                        <!-- <div class="form-group d-flex">
                                            <div class="col-sm-3">
                                                <label class="mt-10" for="agent_code">Select Reschedule Date :<span class="required">*</span></label>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" placeholder="YYYY-MM-DD" id="reschedule_date" name="reschedule_date" required="required" value="">
                                                <div class="required hide " id="errorDate" >Choose schedule date</div>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group ">
                                            <div class="col-sm-12">
                                                <input type="hidden" name="booking_id" id="booking_id" value="{{$data['id']}}">
                                                <input type="hidden" name="unique_id" id="unique_id" value="{{$data['uniqueBookId']}}">
                                                <button type="submit" class="btn back-btn btn btn_theme btn_lg mt-10" id="checkNewFlights">Check Available Flights</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <div class="col-sm-12">
                                    <div id="availableFlights">
                                       
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
.ml-10{
    margin-left : 10px;
}
.form-control[readonly] {
    background-color: #fff;
    opacity: 1;
}
</style>
@endpush
@push('footer')

<script type="text/javascript">
    $(".reschedule_date").datepicker({
        dateFormat: "yy-mm-dd",
        changeYear: true,
        changeMonth: true,
        maxDate: "+1y",
        minDate: "-0y"
    });

    $("#reschedule").validate({
        rules: {
            'origin[]': {
                required : true,
                minlength:3
            },
            'destination[]':{
                required : true,
                minlength:3
            },
            'date[]': 'required'
        },
        errorPlacement: function (error, element) {
            if(element.hasClass('select2')) {
                error.insertAfter(element.next('.select2-container'));
            }else{
                error.appendTo(element.parent("div"));
            }
        },
        submitHandler: function(form, event) {
            event.preventDefault();
            $('.ajaxloader').css('display','block');
            $.ajax({
                url: "{{ route('reschedule-flight')}}",
                type: "POST",
                data: $(form).serialize(),
                success: function( response ) {
                    $('.ajaxloader').css('display','none');
                    var resp = JSON.parse(response);
                    if(resp.status == true){
                        $('#availableFlights').html(resp.data);
                    }else{
                        swal({
                            title: "Failed", 
                            text: resp.msg, 
                            icon: "error",
                            closeOnClickOutside: false,
                        });
                    }
                }
            });
        }
    });

    $('#checkFlights').on('click', function () {
        $('#errorDate').addClass('hide');
        var rescheduleDate = $('#reschedule_date').val();

        if(rescheduleDate != ''){
            $('.ajaxloader').css('display','block');
            var id = $(this).attr('data-id');
            var uniqueBookId = $(this).attr('data-uniqueid');
            var rescheduleDate = $('#reschedule_date').val();
            $.ajax({
                url: "{{ route('reschedule-flight')}}",
                type: "GET",
                data: {"uniqueBookId" : uniqueBookId, "id" : id,'rescheduleDate': rescheduleDate},
                success: function( response ) {
                    $('.ajaxloader').css('display','none');
                    var resp = JSON.parse(response);
                    if(resp.status == true){
                        $('#availableFlights').html(resp.data);
                    }else{
                        swal({
                            title: "Failed", 
                            text: resp.msg, 
                            icon: "error",
                            closeOnClickOutside: false,
                        });
                    }
                }
            });
        }else{
            $('#errorDate').removeClass('hide');
        }
        
    });  

    $(document).on('click','.reissueButton', function () {
        swal({
            title: "Are you sure?",
            text: "Do you want to send reschedule request?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((isConfirmed) => {
            if (isConfirmed) {
                var details = {
                    '_token': '{{csrf_token()}}',
                    'preference': $(this).attr('data-preference'),
                    'currency': $(this).attr('data-currency'),
                    'fare': parseFloat($(this).attr('data-fare')),
                    'uniqueID': $(this).attr('data-uniqueID'),
                    'ptrUniqueID': $(this).attr('data-ptrUniqueID')

                }
                // console.log(details);
                $('.ajaxloader').css('display','block');
                $.ajax({
                    url: "{{ route('send-reschedule-request')}}",
                    type: "POST",
                    data: details,
                    success: function( response ) {
                        $('.ajaxloader').css('display','none');
                        var resp = JSON.parse(response);
                        if(resp.status == true){
                            swal({
                                title: "Success!", 
                                text: resp.msg, 
                                icon: "success",
                                closeOnClickOutside: false,
                            });
                            setTimeout(() => {
                                history.go(-1);
                                location.reload(); 
                            }, 2000);
                        }else{
                            swal({
                                title: "Failed", 
                                text: resp.msg, 
                                icon: "error",
                                closeOnClickOutside: false,
                            });
                        }
                    }
                });
            }
        });

    }); 

    
    

</script>
@endpush