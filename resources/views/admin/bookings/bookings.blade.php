@extends('admin.layouts.app')
@section('title', 'Flight Bookings')
@section('content')
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Flight Bookings</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                     <!-- <div class="x_title">
                        <h2>All Flight Bookings <small></small></h2>
                       <a href="{{ route('agent.create') }}" class="btn back-btn" ><i class="fa fa-plus"></i> Create Agent</a> 
                        <div class="clearfix"></div>
                    </div>-->
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <div class="card">
                                        <div class="card-body">
                                            <form class="" id="searchBookings" action="" method="GET">
                                                <div class="col-sm-3">
                                                    <label> Booking ID</label>
                                                    <div class="form-group input-group">
                                                        <input type="text" class="form-control" id="bookingID" name="bookingID" @isset($data['bookingID']) value="{{ $data['bookingID'] }}" @endisset
                                                        placeholder="Enter Booking ID">
                                                        <i class="fa fa-search form-control-feedback right" ></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label> Agent</label>
                                                    <div class="form-group input-group">
                                                        <select class="form-control w-50 pointer" name="agent" id="agent">
                                                            @if($agents)
                                                                <option value="" >Select Agent</option>
                                                                @foreach ($agents as $agent )
                                                                    @php 
                                                                        $selected = '';
                                                                        if(isset($data['agent'])){
                                                                            $selected = ($data['agent'] == $agent->id) ? 'selected' : '';
                                                                        }  
                                                                    @endphp
                                                                    <option value="{{ $agent->id }}" {{ $selected }}>{{ ucfirst(strtolower($agent->name)) }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label> Date</label>
                                                    <div class="form-group input-group">
                                                        <input type="text" class="form-control" id="date_range" name="date_range" @isset($data['date_range']) value="{{ $data['date_range'] }}" @endisset
                                                        placeholder="Select Booking Date">
                                                        <i class="fa fa-calendar form-control-feedback right" ></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label> Status</label>
                                                    @php $statusSelected = 'selected'; @endphp
                                                    <div class="form-group input-group">
                                                        <select class="form-control w-50 pointer" name="status" id="status">
                                                            <option value="" >Select Status</option>
                                                            <option @isset($data['status'])) @if($data['status'] == 'BookingInProcess') {{ $statusSelected }} @endif @endisset value="BookingInProcess">Booking In Process</option>
                                                            <option  @isset($data['status'])) @if($data['status'] == 'cancelled') {{ $statusSelected }} @endif @endisset value="cancelled">Cancelled</option>
                                                            <option  @isset($data['status'])) @if($data['status'] == 'cancel_request') {{ $statusSelected }} @endif @endisset value="cancel_request">Cancellation Requested</option>
                                                            <option  @isset($data['status'])) @if($data['status'] == 'resheduled') {{ $statusSelected }} @endif @endisset value="resheduled">Rescheduled</option>
                                                            <option  @isset($data['status'])) @if($data['status'] == 'reshedule_request') {{ $statusSelected }} @endif @endisset value="reshedule_request">Reschedule Requested</option>
                                                            <option  @isset($data['status'])) @if($data['status'] == 'Ticketed') {{ $statusSelected }} @endif @endisset value="Ticketed">Ticketed</option>
                                                            <option  @isset($data['status'])) @if($data['status'] == 'TktInProcess') {{ $statusSelected }} @endif @endisset value="TktInProcess">Ticketing In Process</option>
                                                            <option  @isset($data['status'])) @if($data['status'] == 'others') {{ $statusSelected }} @endif @endisset value="others">Ticket Not Generated</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 text-center mt-4">
                                                    <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
                                                    <a href="{{ route('bookings') }}" class="btn btn-primary" type="reset"><i class="fa fa-refresh"></i> Reset</a>
                                                    <a class="btn btn-info" href="{{route('export')}}"><i class="fa fa-download"></i> Export To Excel</a>
                                                </div>
                                                
                                            </form>
                                        </div>
                                    </div>

                                    <table id="datatable-buttons" class="table table-bordered jambo_table mt-4" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Sl no.</th>
                                                <th class="text-center">Booking ID</th>
                                                <th class="text-center">Agent Code</th>
                                                <th class="text-center">Agent Name</th>
                                                <th class="text-center">Origin</th>
                                                <th class="text-center">Destination</th>
                                                <th class="text-center">Direction</th>
                                                <th class="text-center">Amount</th>
                                                <th class="text-center">Booking Date</th>
                                                <th class="text-center">Booking Status</th>
                                                <th class="text-center">Admin Commission </th>
                                                <th class="w-10 text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($bookings[0]))
                                                @foreach($bookings as $key=>$book)
                                                    <tr>
                                                        <td class="text-center">{{ ($key+1) + ($bookings->currentPage() - 1)*$bookings->perPage() }}</td>
                                                        <td class="text-center">{{ $book->unique_booking_id }}</td>
                                                        <td class="text-center">{{ $book->code }}</td>
                                                        <td class="text-center">{{ $book->first_name }} {{ $book->last_name }}</td>
                                                        <td class="text-center">{{ $book->origin }}</td>
                                                        <td class="text-center">{{ $book->destination }}</td>
                                                        <td class="text-center">{{ $book->direction }}</td>
                                                        <td class="text-center">{{ $book->currency }} {{ $book->total_amount }}</td>
                                                        <td class="text-center">{{ date('d-m-Y' ,strtotime($book->created_at)) }}</td>
                                                        
                                                        <td class="complete text-center">
                                                        @if($book->is_cancelled == 1)
                                                            <span class="danger-icon"> Cancelled</span>
                                                        @elseif($book->is_reissued == 1)
                                                            <span class="info-icon"> Rescheduled</span>
                                                        @elseif($book->cancel_request == 1)
                                                            <span class="warning"> Cancellation Requested</span>
                                                        @elseif($book->reissue_request == 1)
                                                            <span class="warning"> Reschedule Requested</span>
                                                        @else
                                                            @if($book->ticket_status == "TktInProcess")
                                                                <span class="complete"> Ticketing In Process</span>
                                                            @elseif($book->ticket_status == "BookingInProcess")
                                                                <span class="complete"> Booking In Process</span>
                                                            @elseif($book->ticket_status == "Ticketed" || $book->ticket_status == "OK")
                                                                <span class="complete"> Ticketed</span>
                                                            @else
                                                                @if($book->ticket_status != '')
                                                                <span class="complete">{{ ucfirst(strtolower($book->ticket_status)) }}</span>
                                                                @else
                                                                <span class="warning">Ticket Not Generated</span> 
                                                                @endif
                                                            @endif

                                                        @endif

                                                        </td>
                                                        <td class="text-center">
                                                           USD {{ $book->admin_amount }}
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{route('booking.view', $book->id)}}" class="view-icon btn btn-app" title="View Details"><i class="fa fa-eye"></i>View Details</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                            <tr>
                                                <td colspan='12' class="text-center">
                                                    No Data Available
                                                </td>
                                            </tr>
                                            @endif

                                        </tbody>
                                    </table>
                                    <div class="aiz-pagination float-right">
                                        {{ $bookings->appends(request()->input())->links() }}
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
@endsection

@section('header')
<style>
.table td, .table th {
    padding: 0.25rem;
}
</style>
<link href="{{ asset('assets/css/daterangepicker.css') }}" rel="stylesheet" />
@endsection

@section('footer')
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="{{ asset('assets/js/daterangepicker.js') }}"></script>
<script type="text/javascript">
    $('#date_range').daterangepicker({
        // timePickerSeconds: true,
        autoApply: false,
        //startDate: "${defaultStart}",
        //endDate: "${defaultEnd}",
        // timePicker: true,
        locale: {
            format: 'DD-MM-YYYY'
        },
        autoUpdateInput: false,
    });

    $('input[name="date_range"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
    });

    $('input[name="date_range"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
  
</script>

@endsection