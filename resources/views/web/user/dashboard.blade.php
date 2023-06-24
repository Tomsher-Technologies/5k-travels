@extends('web.layouts.app')
@section('content')


 <!-- Common Banner Area -->
 <section id="common_banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="common_bannner_text">
                        <h2>Dashboard </h2>
                        
                    </div>
                </div>
            </div>
        </div>
</section>


    <!-- Dashboard Area -->
    <section id="dashboard_main_arae" class="section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="dashboard_sidebar">
                        <div class="dashboard_sidebar_user">
                            <img src="{{ asset('assets/img/avatar-place.png') }}" alt="img">
                            <h3>Sherlyn Chopra</h3>
                            <p><a href="tel:+00-123-456-789">+00 123 456 789</a></p>
                            <p><a href="mailto:sherlyn@domain.com">sherlyn@domain.com</a></p>
                        </div>
                        <div class="dashboard_menu_area">
                            <ul>
                                <li><a href="{{ route('web-dashboard')}}" class="active"><i class="fas fa-arrow-right"></i>My Bookings</a></li>
                                <li><a href="#"><i class="fas fa-arrow-right"></i>Upcoming</a></li>
                                <li><a href="#"><i class="fas fa-arrow-right"></i>Canceled</a></li>
                                <li><a href="#"><i class="fas fa-arrow-right"></i>Completed</a></li>
                                <li><a href="#"><i class="fas fa-arrow-right"></i>Unsuccessful</a></li>
                                <li><a href="#"><i class="fas fa-user-circle"></i>My profile</a></li>
                                <li><a href="#"><i class="fas fa-bell"></i>Notifications</a></li><li>
                                    <a href="#!" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <i class="fas fa-sign-out-alt"></i>Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
              
                    <div class="dashboard_common_table">
                        <h3>My Bookings</h3>



                        



                        <div class="table-responsive-lg table_common_area">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sl no.</th>
                                        <th>Booking ID</th>
                                        <th>Origin</th>
                                        <th>Destination</th>
                                        <th>Total Amount</th>
                                        <th>Booking Date</th>
                                        <th>Booking Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($bookings)
                                        @foreach($bookings as $book)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $book->unique_booking_id }}</td>
                                                <td>{{ $book->origin }}</td>
                                                <td>{{ $book->destination }}</td>
                                                <td>AED {{ $book->total_amount }}</td>
                                                <td>{{ date('d-m-Y' ,strtotime($book->created_at)) }}</td>
                                                <td class="complete">{{ ($book->ticket_status == 'OK') ? 'CONFIRMED' : 'IN PROCESS' }}</td>
                                                <td><i class="fas fa-eye"></i></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- <div class="pagination_area">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">«</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">»</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </div> -->
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