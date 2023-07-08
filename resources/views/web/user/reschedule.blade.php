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