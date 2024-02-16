<div class="flight_search_result_wrapper" id="one_way_trip">
    @if ($data['flightDetails'])
        @foreach ($data['flightDetails'] as $fdata)
            @php
                $cls = '';
                if (request()->direct == '1') {
                    if ($fdata['stops'] == 0) {
                        $cls = '';
                    } else {
                        $cls = 'hide';
                    }
                }
            @endphp
            <div class="flight_search_item_wrappper {{ $cls }}" data-stops="{{ $fdata['stops'] }}"
                data-airline="{{ $fdata['airline'] }}">
                @if ($fdata['api_provider'] == 'flydubai')
                    @include('web.search.providers.oneway-flydubai')
                    <div class="flight_policy_refund collapse" id="detialsView_{{ $loop->iteration }}">
                    </div>
                @elseif ($fdata['api_provider'] == 'yasin')
                    @include('web.search.providers.oneway-yasin')
                @endif
            </div>
        @endforeach
    @else
        <div class="text-center fontSize24">
            <span>No Flights Found. </span>
        </div>
    @endif

    <div class="text-center fontSize24" style="display: none" id="noFlightDiv">
        <span>No Flights Found. </span>
    </div>
</div>
