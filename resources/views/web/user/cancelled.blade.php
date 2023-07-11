@extends('web.layouts.app')
@section('content')


 <!-- Common Banner Area -->
 <section id="common_banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="common_bannner_text">
                        <h2>{{ ($type == 'cancelled') ? 'Cancelled' : 'Completed' }} Bookings </h2>
                        
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
                        <h3>{{ ($type == 'cancelled') ? 'Cancelled' : 'Completed' }} Bookings</h3>
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
                                                <td>
                                                    <a href="{{ route('booking-details', ['type' => $type, 'id' => $book->id]) }}" class="info-icon" title="View Ticket Details"><i class="fas fa-eye"></i></a> &nbsp;
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
<script type="text/javascript">

</script>
@endpush