@extends('web.layouts.app')
@section('content')
<!-- Common Banner Area -->
<section id="common_banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="common_bannner_text text-dark">
                   
                </div>
            </div>
        </div>
    </div>
   
</section>
<!-- Tour Booking Submission Areas -->
<section id="tour_booking_submission" class="section_padding">
    <div class="container container-bboking">
        <div class="row">
            <div class="col-lg-12">
                <div class="tou_booking_form_Wrapper text-center">
                    
                    @if($msg == "success")
                        <i class="fa fa-check-circle" style=" color: #1fba71; font-size: 55px; margin-bottom: 20px;"> </i>
                        <h3>Successfully Booked.</h3>
                        <button class="btn btn_theme btn_md" style="margin-top: 25px;"><a href="{{route('web-dashboard')}}" style="font-weight:700;color: white;">Go To Dashboard</button>
                    @else
                        <i class="fa fa-xmark-circle" style=" color: #ff2121; font-size: 55px; margin-bottom: 20px;"> </i>
                        <h3>{{$msg}}</h3>
                    @endif
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
.cta_content{
    color: black;
}
</style>
@endpush
@push('footer')
<script type="text/javascript">

</script>
@endpush