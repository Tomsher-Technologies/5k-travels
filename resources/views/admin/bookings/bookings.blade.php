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
                    <div class="x_title">
                        <h2>All Flight Bookings <small></small></h2>
                        <!-- <a href="{{ route('agent.create') }}" class="btn back-btn" ><i class="fa fa-plus"></i> Create Agent</a> -->
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <form class="" id="sort_sellers" action="" method="GET">
                                        <div class="title_right">
                                            <div class="col-md-5 col-sm-5  form-group pull-right top_search">
                                                <!-- <div class="input-group">
                                                    <input type="text" class="form-control" id="search" name="search" @isset($sort_search) value="{{ $sort_search }}" @endisset
                                                    placeholder="Type category or name or email or agent code & Enter">
                                                    <i class="fa fa-search form-control-feedback right" ></i>
                                                </div> -->
                                            </div>
                                        </div>
                                    </form>
                                    <table id="datatable-buttons" class="table table-bordered jambo_table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Sl no.</th>
                                                <th>Booking ID</th>
                                                <th>Agent Code</th>
                                                <th>Agent Name</th>
                                                <th>Origin</th>
                                                <th>Destination</th>
                                                <th>Amount</th>
                                                <th>Booking Date</th>
                                                <th>Booking Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($bookings[0]))
                                                @foreach($bookings as $key=>$book)
                                                    <tr>
                                                        <td>{{ ($key+1) + ($bookings->currentPage() - 1)*$bookings->perPage() }}</td>
                                                        <td>{{ $book->unique_booking_id }}</td>
                                                        <td>{{ $book->code }}</td>
                                                        <td>{{ $book->first_name }} {{ $book->last_name }}</td>
                                                        <td>{{ $book->origin }}</td>
                                                        <td>{{ $book->destination }}</td>
                                                        <td>AED {{ $book->total_amount }}</td>
                                                        <td>{{ date('d-m-Y' ,strtotime($book->created_at)) }}</td>
                                                        
                                                        <td class="complete">
                                                            @if($book->is_cancelled == 1)
                                                                <span class="danger-icon"> Cancelled</span>
                                                            @else
                                                                @if($book->ticket_status == "TktInProcess")
                                                                    <span class="complete"> Ticket In Process</span>
                                                                @elseif($book->ticket_status == "BookingInProcess")
                                                                    <span class="complete"> Booking In Process</span>
                                                                @else
                                                                    <span class="complete">{{ ucfirst(strtolower($book->ticket_status)) }}</span>
                                                                @endif

                                                            @endif

                                                        </td>
                                                        <td>
                                                           
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                            <tr>
                                                <td colspan='10' class="text-center">
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

@endsection

@section('footer')

<script>
    
  
</script>

@endsection