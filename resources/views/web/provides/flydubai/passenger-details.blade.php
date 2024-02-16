<div class="tab-pane fade {{ isset($active) && $active == true ? 'active show' : '' }} " id="nav-details" role="tabpanel"
    aria-labelledby="nav-details-tab">
    <div class="row">
        <div class="col-lg-12">
            <div class="tou_booking_form_Wrapper">
                <div class="">
                    @php
                        $passengers = [
                            'ADT' => (int) $res_data['search_params']['adult'],
                            'CHD' => (int) $res_data['search_params']['child'],
                            'INF' => (int) $res_data['search_params']['infant'],
                        ];
                    @endphp
                    @if (isset($passengers))
                        @php
                            $countries = '';
                            $passCount = 1;
                        @endphp

                        @foreach ($res_data['countries'] as $country)
                            @php $countries .= '<option value="'.$country->code.'"> '.$country->name.' </option>'; @endphp
                        @endforeach
                    @endif

                    <div class="booking_tour_form">
                        <h3 class="heading_theme">Passenger information</h3>
                        @if (isset($passengers['ADT']))
                            @for ($ad = 1; $ad <= $passengers['ADT']; $ad++)
                                <div class="tour_booking_form_box {{ $ad != 1 ? 'mt-3' : '' }}">
                                    <h3>Passenger {{ $passCount }} (Adult)</h3>
                                    <div class="row form_area">
                                        <div class="col-lg-4">
                                            <label for="gender">Title<span class="required">*</span></label>
                                            <div class="form-group">
                                                <select class="form-control appearance-auto" name="adult_title[]"
                                                    id="adult_title{{ $passCount }}">
                                                    <option value=""> Select</option>
                                                    <option value="Mr">Mr</option>
                                                    <option value="Mrs">Mrs</option>
                                                    <option value="Miss">Miss</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="first_name">First Name<span
                                                        class="required">*</span></label>
                                                <input type="text" class="form-control bg_input "
                                                    id="adult_first_name{{ $passCount }}" name="adult_first_name[]"
                                                    placeholder="First Name">
                                                <div class="error-div"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="last_name">Last Name<span class="required">*</span></label>
                                                <input type="text" class="form-control bg_input"
                                                    id="adult_last_name{{ $passCount }}" name="adult_last_name[]"
                                                    placeholder="Last Name">
                                                <div class="error-div"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="gender">Gender<span class="required">*</span></label>
                                            <div class="form-group">
                                                <select class="form-control appearance-auto" name="adult_gender[]"
                                                    id="adult_gender{{ $passCount }}">
                                                    <option value=""> Select</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <label for="date">Date Of Birth<span class="required">*</span></label>
                                            <input type="text" class="form-control bg_input datepickerAdult" readonly
                                                placeholder="YYYY-MM-DD" name="adult_dob[]"
                                                id="datepickerAdult{{ $passCount }}" />
                                            <div class="error-div" id="adult_date_error{{ $passCount }}"></div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="date">Nationality<span class="required">*</span></label>
                                                <select class="form-control appearance-auto" name="adult_nationality[]"
                                                    id="adult_nationality{{ $passCount }}" placeholder="MM">
                                                    <option value=""> Select</option>
                                                    {!! $countries !!}
                                                </select>
                                                <div class="error-div"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="date">Passport Number<span
                                                        class="required">*</span></label>
                                                <input type="text" class="form-control bg_input"
                                                    placeholder="Passport Number"
                                                    id="adult_passport{{ $passCount }}" name="adult_passport[]">
                                                <div class="error-div"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="date">Passport Issuing Country<span
                                                        class="required">*</span></label>
                                                <select class="form-control appearance-auto"
                                                    name="adult_passport_country[]"
                                                    id="adult_passport_country{{ $passCount }}">
                                                    <option value=""> Select</option>
                                                    {!! $countries !!}
                                                </select>
                                                <div class="error-div"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <label for="date">Passport Issue<span class="required">*</span></label>
                                            <input type="text" class="form-control bg_input passportIssue" readonly
                                                placeholder="YYYY-MM-DD" name="adult_passport_issue[]"
                                                id="passportIssue{{ $passCount }}" />
                                            <div class="error-div"></div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="date">Passport Expiry<span
                                                    class="required">*</span></label>
                                            <input type="text" class="form-control bg_input passportExpiry"
                                                readonly placeholder="YYYY-MM-DD" name="adult_passport_expiry[]"
                                                id="passportExpiry{{ $passCount }}" />
                                            <div class="error-div"></div>
                                        </div>
                                    </div>
                                </div>
                                @php  $passCount++; @endphp
                            @endfor
                        @endif
                        @if (isset($passengers['CHD']))
                            @for ($ch = 1; $ch <= $passengers['CHD']; $ch++)
                                <div class="tour_booking_form_box mt-3">
                                    <h3>Passenger {{ $passCount }} (Child)</h3>
                                    <div class="row form_area">
                                        <div class="col-lg-4">
                                            <label for="gender">Title<span class="required">*</span></label>
                                            <div class="form-group">
                                                <select class="form-control appearance-auto" name="child_title[]"
                                                    id="child_title{{ $passCount }}">
                                                    <option value=""> Select</option>
                                                    <option value="Master">Master</option>
                                                    <option value="Miss">Miss</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="first_name">First Name<span
                                                        class="required">*</span></label>
                                                <input type="text" class="form-control bg_input "
                                                    name="child_first_name[]"
                                                    id="child_first_name{{ $passCount }}"
                                                    placeholder="First Name">
                                                <div class="error-div"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="last_name">Last Name<span
                                                        class="required">*</span></label>
                                                <input type="text" class="form-control bg_input"
                                                    name="child_last_name[]" id="child_last_name{{ $passCount }}"
                                                    placeholder="Last Name">
                                                <div class="error-div"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="gender">Gender<span class="required">*</span></label>
                                            <div class="form-group">
                                                <select class="form-control appearance-auto" name="child_gender[]"
                                                    id="child_gender{{ $passCount }}">
                                                    <option value=""> Select</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="date">Date Of Birth<span class="required">*</span></label>
                                            <input type="text" class="form-control bg_input datepickerChild"
                                                readonly placeholder="YYYY-MM-DD" name="child_dob[]"
                                                id="datepickerChild{{ $passCount }}" />
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="date">Nationality<span
                                                        class="required">*</span></label>
                                                <select class="form-control appearance-auto"
                                                    name="child_nationality[]"
                                                    id="child_nationality{{ $passCount }}" placeholder="MM">
                                                    <option value=""> Select</option>
                                                    {!! $countries !!}
                                                </select>
                                                <div class="error-div"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="date">Passport Number<span
                                                        class="required">*</span></label>
                                                <input type="text" class="form-control bg_input"
                                                    placeholder="Passport Number"
                                                    id="child_passport{{ $passCount }}" name="child_passport[]">
                                                <div class="error-div"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="date">Passport Issuing Country<span
                                                        class="required">*</span></label>
                                                <select class="form-control appearance-auto"
                                                    name="child_passport_country[]"
                                                    id="child_passport_country{{ $passCount }}">
                                                    <option value=""> Select</option>
                                                    {!! $countries !!}
                                                </select>
                                                <div class="error-div"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="date">Passport Issue<span
                                                    class="required">*</span></label>
                                            <input type="text" class="form-control bg_input passportIssue" readonly
                                                placeholder="YYYY-MM-DD" name="child_passport_issue[]"
                                                id="passportIssue{{ $passCount }}" />
                                            <div class="error-div"></div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="date">Passport Expiry<span
                                                    class="required">*</span></label>
                                            <input type="text" class="form-control bg_input passportExpiry"
                                                readonly placeholder="YYYY-MM-DD" name="child_passport_expiry[]"
                                                id="passportExpiry{{ $passCount }}" />
                                        </div>
                                    </div>
                                </div>
                                @php  $passCount++; @endphp
                            @endfor
                        @endif
                        @if (isset($passengers['INF']))
                            @for ($inf = 1; $inf <= $passengers['INF']; $inf++)
                                <div class="tour_booking_form_box mt-3">
                                    <h3>Passenger {{ $passCount }} (Infant)</h3>
                                    <div class="row form_area">
                                        <div class="col-lg-4">
                                            <label for="gender">Title<span class="required">*</span></label>
                                            <div class="form-group">
                                                <select class="form-control appearance-auto" name="infant_title[]"
                                                    id="infant_title{{ $passCount }}">
                                                    <option value=""> Select</option>
                                                    <option value="Master">Master</option>
                                                    <option value="Miss">Miss</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="first_name">First Name<span
                                                        class="required">*</span></label>
                                                <input type="text" class="form-control bg_input "
                                                    name="infant_first_name[]"
                                                    id="infant_first_name{{ $passCount }}"
                                                    placeholder="First Name">
                                                <div class="error-div"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="last_name">Last Name<span
                                                        class="required">*</span></label>
                                                <input type="text" class="form-control bg_input"
                                                    name="infant_last_name[]"
                                                    id="infant_last_name{{ $passCount }}" placeholder="Last Name">
                                                <div class="error-div"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="gender">Gender<span class="required">*</span></label>
                                            <div class="form-group">
                                                <select class="form-control appearance-auto" name="infant_gender[]"
                                                    id="infant_gender{{ $passCount }}">
                                                    <option value=""> Select</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="date">Date Of Birth<span class="required">*</span></label>
                                            <input type="text" id="datepickerInfant{{ $passCount }}" readonly
                                                placeholder="YYYY-MM-DD"
                                                class="form-control bg_input datepickerInfant" name="infant_dob[]" />
                                            <div class="error-div"></div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="date">Nationality<span
                                                        class="required">*</span></label>
                                                <select class="form-control appearance-auto"
                                                    name="infant_nationality[]"
                                                    id="infant_nationality{{ $passCount }}" placeholder="MM">
                                                    <option value=""> Select</option>
                                                    {!! $countries !!}
                                                </select>
                                                <div class="error-div"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="date">Passport Number<span
                                                        class="required">*</span></label>
                                                <input type="text" class="form-control bg_input"
                                                    placeholder="Passport Number"
                                                    id="infant_passport{{ $passCount }}" name="infant_passport[]">
                                                <div class="error-div"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="date">Passport Issuing Country<span
                                                        class="required">*</span></label>
                                                <select class="form-control appearance-auto"
                                                    name="infant_passport_country[]"
                                                    id="infant_passport_country{{ $passCount }}">
                                                    <option value=""> Select</option>
                                                    {!! $countries !!}
                                                </select>
                                                <div class="error-div"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="date">Passport Issue<span
                                                    class="required">*</span></label>
                                            <input type="text" class="form-control bg_input passportIssue" readonly
                                                placeholder="YYYY-MM-DD" name="infant_passport_issue[]"
                                                id="passportIssue{{ $passCount }}" />
                                            <div class="error-div"></div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="date">Passport Expiry<span
                                                    class="required">*</span></label>
                                            <input type="text" class="form-control bg_input passportExpiry"
                                                readonly placeholder="YYYY-MM-DD" name="infant_passport_expiry[]"
                                                id="passportExpiry{{ $passCount }}" />
                                        </div>
                                    </div>
                                </div>
                                @php  $passCount++; @endphp
                            @endfor
                        @endif

                        <div class="tour_booking_form_box mt-3">
                            <h3>Contact Details</h3>
                            <div class="row form_area">
                                <!-- <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="first_name">Country Code</label>
                                                <input type="text"  class="form-control bg_input " name="country_code"  id="country_code" >
                                                <div class="error-div"></div>
                                            </div>
                                        </div> -->
                                <div class="col-lg-6">
                                    <input type="hidden" name="mobile_code" id="mobile_code">
                                    <div class="form-group">
                                        <label for="first_name">Mobile No<span class="required">*</span></label>
                                        <input type="text" class="form-control bg_input " autocomplete="none"
                                            placeholder="Mobile No" name="mobile_no" id="mobile_no">
                                        <div class="error-div"></div>
                                        <span id="valid-msg" class="hide">✓ Valid</span>
                                        <span id="error-msg" class="hide"></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="last_name">Email<span class="required">*</span></label>
                                        <input type="text" class="form-control bg_input" name="email"
                                            id="email" placeholder="Email">
                                        <div class="error-div"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <button type="submit" class="btn btn_theme btn_md">Submit</button>
            </div>
        </div>
    </div>
</div>
