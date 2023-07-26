<div
            style="max-width: 650px;margin:auto; box-shadow: rgba(135, 138, 153, 0.10) 0 5px 20px -6px;border-radius: 6px;border: 1px solid #eef1f5;overflow: hidden;background-color: #fff;">
            <div
                style="padding: 1.5rem; display: flex;gap: 8px; align-items: center; justify-content: space-between;flex-wrap: wrap;">
                <div>
                    <a href="index.html"><img src="{{ asset('assets/img/logo.png') }}" alt="" height="24"></a>
                </div>
                <div style="display: flex;gap: 6px;">
                    <p style="margin-bottom: 0px; font-size: 14px;font-weight: 500;margin-top: 0px;"><span
                            style="color: #878a99 !important;">Booking ID:</span> {{ $bookings[0]->unique_booking_id }}</p>
                    <p style="margin-bottom: 0px; font-size: 14px;font-weight: 500;margin-top: 0px;"><span
                            style="color: #878a99 !important;">Date:</span> {{ date('Y-m-d') }}</p>
                </div>
            </div>
            <div style="padding: 1.5rem; background-color: #a9cf82; text-align: left;">
                <h5
                    style="font-size: 18px;font-family: 'Poppins', sans-serif;font-weight: 600;margin-bottom: 0px;margin-top: 0px;line-height: 1.2;color: #fff !important;">
                    Hi {{$name}},</h5>
                <h6
                    style="font-size: 15px;font-weight: 500;margin-bottom: 12px;margin-top: 0px;line-height: 1.2;color: rgba(255, 255, 255, 0.80) !important;">
                    Thank you for booking with us. We wish you a pleasant journey!</h6>

                <div style="padding: 1.5rem; background-color: #fff; text-align: left; border-radius: 10px;">
                    <h5
                        style="font-size: 18px;font-family: 'Poppins', sans-serif;font-weight: 600;margin-bottom: 0px;margin-top: 0px;line-height: 1.2;color: #1a7971 !important;">
                        {{ $bookings[0]->origin }} To {{ $bookings[0]->destination }} </h5>

                    <!-- <p style="color: #333 !important; margin-bottom: 0px;margin-top: 0px;">One way • Fri, 14 April</p> -->

                </div>
            </div>
            <div style="padding: 1.5rem;">
                <h6
                    style="font-family: 'Poppins', sans-serif; font-size: 15px;font-weight: 600; text-decoration-line: underline;margin-bottom: 16px;margin-top: 20px;">
                    BOOKING DETAILS:</h6>

                <h5
                    style="font-size: 18px;font-family: 'Poppins', sans-serif;font-weight: 600;margin-bottom: 0px;margin-top: 0px;line-height: 1.2;color: #1a7971 !important;">
                    {{ $bookings[0]->origin }} To {{ $bookings[0]->destination }}</h5>

                <!-- <p style="color: #333 !important; margin-bottom: 10px;margin-top: 0px;">Thu, 13 Apr 2023 • Non stop • 4h
                    0m duration
                </p> -->

                <table style="width: 100%;border-collapse: collapse;" cellspacing="0" cellpadding="0">
                    
                    @if(isset($bookings[0]))
                        @foreach($bookings[0]['flights'] as $flights)
                            <tr>
                                @php   
                                    $airlineData = getAirlineData($flights->marketing_airline_code);
                                    $deptAirportData = getAirportData($flights->departure_airport);
                                    $arrAirportData = getAirportData($flights->arrival_airport);
                                    $airlinePNR = $flights->airline_pnr;
                                @endphp
                                <td  colspan="2"
                                    style="padding: 12px 5px; vertical-align: middle ;text-align: center; border: 1px solid #eee;background-color: #eee;">
                                    <div
                                        style="height: 64px;width: 64px;display: flex; align-items: center;justify-content: center;border-radius: 6px; margin: auto; ">
                                        <img src="{{ $airlineData[0]['AirLineLogo'] }}" alt="" height="38">

                                    </div>
                            
                                    <h6 style="font-size: 15px; margin: 0px;font-weight: 500; font-family: 'Poppins', sans-serif;">
                                    {{$airlineData[0]['AirLineName']}}</h6>
                                    <p style="color: #878a99 !important; margin-bottom: 0px; font-size: 13px;font-weight: 500;margin-top: 6px;">
                                    {{$flights->flight_number}}</p>
                                    <p style="color: #878a99 !important; margin-bottom: 0px; font-size: 13px;font-weight: 500;margin-top: 6px;">
                                    Duration : {{ convertToHoursMins($flights->journey_duration) }}</p>
                                    <p style="padding: 10px; color: #fff !important; text-align: center; margin-bottom: 0px; font-size: 13px;font-weight: 500;margin-top: 6px; background-color: #1a7971;">
                                        PNR : {{ $airlinePNR }}</p>
                                </td>

                                <td  style="padding: 15px 10px; vertical-align: middle; border: 1px solid #eee;">

                                    <h6 style="font-size: 15px; margin: 0px;font-weight: 500; font-family: 'Poppins', sans-serif;">
                                    {{ $deptAirportData[0]['AirportName'] }}</h6>
                                    <p style="color: #878a99 !important; margin-bottom: 10px; font-size: 13px;font-weight: 500;margin-top: 6px;">
                                    {{ $flights->departure_airport }} {{ date('H:i', strtotime($flights->departure_date_time)) }} hrs
                                    </p>

                                    <p style="color: #878a99 !important; margin-bottom: 0px; font-size: 13px;font-weight: 500;margin-top: 0;">
                                    {{ date('d M, Y', strtotime($flights->departure_date_time)) }}</p>
                                        <hr>
                                    <p style="color: #333 !important; margin-bottom: 10px; font-size: 13px;font-weight: 500;margin-top: 6px;">
                                    {{ $deptAirportData[0]['AirportName'] }} Terminal {{$flights->departure_terminal}}
                                    </p>
                                </td>

                                <td style="padding: 15px 10px; vertical-align: middle; border: 1px solid #eee;">
                                    <h6 style="font-size: 15px; margin: 0px;font-weight: 500; font-family: 'Poppins', sans-serif;">
                                    {{ $arrAirportData[0]['AirportName'] }}</h6>
                                    <p style="color: #878a99 !important; margin-bottom: 10px; font-size: 13px;font-weight: 500;margin-top: 6px;">
                                    {{ date('H:i', strtotime($flights->arrival_date_time)) }} hrs
                                    </p>

                                    <p style="color: #878a99 !important; margin-bottom: 0px; font-size: 13px;font-weight: 500;margin-top: 0;">
                                    {{ date('d M, Y', strtotime($flights->arrival_date_time)) }}
                                    </p>
                                    <hr>

                                    <p style="color: #333 !important; margin-bottom: 10px; font-size: 13px;font-weight: 500;margin-top: 6px;">
                                    {{ $arrAirportData[0]['AirportName'] }} Terminal ({{ $flights->arrival_terminal }}) </p>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                   
                    @if(!empty($bookings[0]['extraServices']))
                        @php
                            $desc = array(
                                'GROUP_PAX' => '(Entire group)', 
                                'PER_PAX' => '(Each passenger)', 
                                'GROUP_PAX_INBOUND' => '(Entire group only on the return trip)',
                                'GROUP_PAX_OUTBOUND' => '(Entire group only on for the onward travel)', 
                                'PER_PAX_INBOUND' => '(Each passenger only on the return trip)', 
                                'PER_PAX_OUTBOUND' => '(Each passenger only on for the onward travel)'
                            );
                        @endphp

                        <tr>
                            <td colspan="2" style="padding: 12px 8px; font-size: 15px;border-top: 1px solid #e9ebec;">
                            <strong> Extra Services</strong>
                            </td>
                        </tr>
                        @foreach($bookings[0]['extraServices'] as $extra)
                            <tr>
                                <td colspan="2" style="padding: 12px 8px; font-size: 15px;">
                                {{ $extra->description }} {{ (isset($desc[$extra->behavior])) ? $desc[$extra->behavior] : '' }}
                                </td>
                                <td  colspan="2" style="padding: 12px 8px; font-size: 15px;text-align: end; ">
                                    <h6 style="font-size: 15px; margin: 0px;font-weight: 600; font-family: 'Poppins', sans-serif;">
                                    {{ $extra->currency }} {{ $extra->service_amount }}</h6>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    <tr>
                        <td colspan="2" style="padding: 12px 8px; font-size: 15px;border-top: 1px solid #e9ebec;">
                           <strong> Booking Amount</strong>
                        </td>
                      
                    </tr>
                    <tr>
                        <td colspan="2" style="padding: 12px 8px; font-size: 15px;">
                            Base Fare
                        </td>
                        <td  colspan="2" style="padding: 12px 8px; font-size: 15px;text-align: end; ">
                            <h6 style="font-size: 15px; margin: 0px;font-weight: 600; font-family: 'Poppins', sans-serif;">
                            {{ $bookings[0]->currency }} {{ $bookings[0]->adult_amount + $bookings[0]->child_amount + $bookings[0]->infant_amount  }}</h6>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding: 12px 8px; font-size: 15px;">
                            Tax
                        </td>
                        <td colspan="2" style="padding: 12px 8px; font-size: 15px;text-align: end; ">
                            <h6 style="font-size: 15px; margin: 0px;font-weight: 600; font-family: 'Poppins', sans-serif;">
                            {{ $bookings[0]->currency }} {{ $bookings[0]->total_tax }}</h6>
                        </td>
                    </tr>
                    @if($bookings[0]->addon_amount != 0)
                        <tr>
                            <td colspan="2" style="padding: 12px 8px; font-size: 15px;">
                            Add Ons
                            </td>
                            <td colspan="2" style="padding: 12px 8px; font-size: 15px;text-align: end; ">
                                <h6 style="font-size: 15px; margin: 0px;font-weight: 600; font-family: 'Poppins', sans-serif;">
                                {{ $bookings[0]->currency }} {{ $bookings[0]->addon_amount }}</h6>
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="2" style="padding: 12px 8px; font-size: 15px;">
                            Total Fare
                        </td>
                        <td colspan="2" style="padding: 12px 8px; font-size: 15px;text-align: end; ">
                            <h6 style="font-size: 15px; margin: 0px;font-weight: 600; font-family: 'Poppins', sans-serif;">
                            {{ $bookings[0]->currency }} {{ $bookings[0]->total_amount }} </h6>
                            </th>
                    </tr>

                    

                    <!-- <tr>
                        <td colspan="4" style="padding: 12px 8px; font-size: 10px;">
                            *Baggage allowance shown above is per passenger

                        </td>
                   
                    </tr> -->

                    @foreach($bookings[0]['passengers'] as $pass)

                        <tr>
                            <td colspan="4" style="padding: 12px 8px; font-size: 15px;border-top: 1px solid #e9ebec;">
                                <div style="padding: 1.5rem; background-color: #eee; text-align: left; border-radius: 10px;">
                                    <p style="color: #333 !important; margin-bottom: 0px;margin-top: 0px;">TRAVELLER ({{ ($pass->passenger_type =='ADT') ? "Adult" : (($pass->passenger_type =="CHD") ? "Child" : "Infant") }})
                                    - <span style="color: #1fba71;font-weight: 600;">{{ ($pass->is_return == 0) ? "Onward Trip" : "Return Trip" }}</span></p>
                                    <h5 style="font-size: 18px;font-family: 'Poppins', sans-serif;font-weight: 600;margin-bottom: 0px;margin-top: 0px;line-height: 1.2;color: #1a7971 !important;">
                                    {{ $pass->passenger_first_name }} {{ $pass->passenger_last_name }} <span style="font-size: 13px; color: #333;"></span>
                                    </h5>
                
                                    <p style="color: #333 !important; margin-bottom: 5px;margin-top: 5px;">E-TICKET NO:  {{ $pass->eticket_number }}
                                    </p>
                                </div>
                            </td>
                            
                        </tr>
                    @endforeach
                </table>
         
              
            </div>
            <div style="padding: 1.5rem;background-color: #fafafa;">
                <div style="text-align: center;">
                    <p style="color: #878a99; margin: 0;font-weight: 500;">
                        <script>document.write(new Date().getFullYear())</script> © 5K-Travels
                    </p>
                </div>
            </div>
        </div>