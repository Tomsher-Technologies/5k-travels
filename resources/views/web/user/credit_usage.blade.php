@extends('web.layouts.app')
@section('content')


 <!-- Common Banner Area -->
 <section id="common_banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="common_bannner_text">
                        <h2>Your Credit Usage</h2>
                        
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
                        <h3>Credit Usage</h3>
                        <div class="table-responsive-lg table_common_area">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sl no.</th>
                                        <th>Date</th>
                                        <th class="width-40">Details</th>
                                        <th class="width-10">Debit</th>
                                        <th class="width-10">Credit</th>
                                        <th class="width-15">Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($usage)
                                        @foreach($usage as $key=>$use)

                                            @php
                                                if($use->transaction_type == 'cr'){
                                                    $credit = $use->usd_amount;
                                                    $debit = '-';
                                                    $action = 'Credited';
                                                }else{
                                                    $credit = '-';
                                                    $debit = $use->usd_amount;
                                                    $action = 'Debited';
                                                }

                                                if($use->booking_id == '' && $use->from_agent_id == ''){
                                                    $details = "Admin transfer";
                                                }elseif($use->booking_id == '' && $use->from_agent_id != ''){
                                                    $details = $action. " By ".$use->name;
                                                }elseif($use->booking_id != '' && $use->from_agent_id != '' ){
                                                    $details = $action. " for Booking Id (<b>" .$use->unique_booking_id. '</b>) by '.$use->name;
                                                }elseif($use->booking_id != '' && $use->from_agent_id == '' ){
                                                    $details = $action. " for Booking Id (<b>".$use->unique_booking_id.'</b>)';
                                                }
                                            @endphp
                                            <tr>
                                                <td>{{ ($key+1) + ($usage->currentPage() - 1)*$usage->perPage() }}</td>
                                                <td>{{ date('d-m-Y' ,strtotime($use->created_at)) }}</td>
                                                <td>{!! $details !!}</td>
                                                <td>{{ $debit }}</td>
                                                <td>{{ $credit }}</td>
                                                <td>USD {{ $use->credit_balance }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                    <div class="pagination_area">
                        {{ $usage->appends(request()->input())->links() }}
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

@endpush