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
                                        <th>Customer Name</th>
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
                                                <td>{{ $book->customer_name }}</td>
                                                <td>{{ $book->origin }}</td>
                                                <td>{{ $book->destination }}</td>
                                                <td>{{ $book->currency }} {{ $book->total_amount }}</td>
                                                <td>{{ date('d-m-Y' ,strtotime($book->created_at)) }}</td>
                                                
                                                <td class="complete">
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
                                                            <span class="complete"> In Process</span>
                                                        @elseif($book->ticket_status == "BookingInProcess")
                                                            <span class="complete"> Booking In Process</span>
                                                        @else
                                                            @if($book->ticket_status != '')
                                                            <span class="complete">{{ ucfirst(strtolower($book->ticket_status)) }}</span>
                                                            @else
                                                            <span class="warning">Ticket Not Generated</span> 
                                                            @endif
                                                        @endif

                                                    @endif

                                                </td>
                                                <td>
                                                   
                                                    <a href="{{ route('booking-details', ['type' => $type, 'id' => $book->id] ) }}" class="info-icon" title="View Ticket Details"><i class="fas fa-eye"></i></a> &nbsp;
                                                
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

    
</script>
@endpush