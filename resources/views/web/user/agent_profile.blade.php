@extends('web.layouts.app')
@section('content')
    <!-- Common Banner Area -->
    <section id="common_banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="common_bannner_text">
                        <h2>My Profile</h2>
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

                        <h3>My Profile</h3>

                        <div class="profile_update_form">
                            @if (session()->has('status'))
                                <div class="alert alert-success">
                                    {{ session()->get('status') }}
                                </div>
                            @endif
                            <form id="storeAgent" class="form_area" action="{{ route('agent.profile.update') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                    @if (Auth::user()->user_type !== 'user')
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="agent_code">Agent Code<span class="required">*</span></label>
                                                <input type="text" class="form-control" id="agent_code" name="agent_code"
                                                    required="required" readonly value="{{ $agent[0]->code }}">
                                                @error('agent_code')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif


                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="f-name">First name<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="first_name" name="first_name"
                                                value="{{ old('first_name', $agent[0]->first_name) }}"
                                                placeholder="First Name">
                                            @error('first_name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="l-name">Last name<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="last_name" name="last_name"
                                                placeholder="Last Name"
                                                value="{{ old('last_name', $agent[0]->last_name) }}">
                                            @error('last_name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="mail-address">Email<span class="required">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="Email" value="{{ old('email', $agent[0]->email) }}">
                                            @error('email')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 ">
                                        <div class="form-group">
                                            <label for="password">Password</label>

                                            <input type="password" id="password" name="password" placeholder="Password"
                                                autocomplete="new-password" value="{{ old('password') }}"
                                                class="form-control">
                                            <!-- <span class="password-eye" onclick="hideshow()">
                                                            <i id="slash" class="fa fa-eye-slash" style="display: block;"></i>
                                                            <i id="eye" class="fa fa-eye" style="display: none;"></i>
                                                        </span> -->
                                            @error('password')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="mobil-number">Phone Number</label>
                                            <input type="text" id="phone_number" name="phone_number"
                                                placeholder="Phone Number" class="form-control"
                                                value="{{ old('phone_number', $agent[0]->phone_number) }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="u-name">Gender</label>
                                            <div class="radio">
                                                <label class="radio-label"><input type="radio" class=" radio-size"
                                                        name="gender" id="genderM" value="male"
                                                        {{ old('gender', $agent[0]->gender) == 'male' ? "checked='checked'" : '' }} />
                                                    Male </label>
                                                <label class="radio-label"><input type="radio" class=" radio-size"
                                                        name="gender" id="genderF" value="female"
                                                        {{ old('gender', $agent[0]->gender) == 'female' ? "checked='checked'" : '' }} />
                                                    Female</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="u-name">Designation</label>
                                            <input type="text" id="designation" name="designation"
                                                placeholder="Designation" class="form-control"
                                                value="{{ old('designation', $agent[0]->designation) }}">
                                        </div>
                                    </div>

                                    @if (Auth::user()->user_type !== 'user')
                                        <div class="change_password_input_boxed">
                                            <h3 style="font-size: 18px;">Company Details</h3>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="u-name">Company Name<span
                                                                class="required">*</span></label>
                                                        <input type="text" id="company_name" name="company_name"
                                                            placeholder="Company Name"
                                                            value="{{ old('company_name', $agent[0]->company_name) }}"
                                                            class="form-control">
                                                        @error('company_name')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="u-name">Company Reg. No.</label>
                                                        <input type="text" id="company_reg_no"
                                                            placeholder="Company Reg. No." name="company_reg_no"
                                                            class="form-control"
                                                            value="{{ old('company_reg_no', $agent[0]->company_reg_no) }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="u-name">Nature Of Business</label>
                                                        <select name="business_nature" id="business_nature"
                                                            class="form-control">
                                                            <option
                                                                {{ $agent[0]->business_nature == '0' ? 'selected' : '' }}
                                                                value="0">--Select--</option>
                                                            <option
                                                                {{ $agent[0]->business_nature == '1' ? 'selected' : '' }}
                                                                value="1">Corporate </option>
                                                            <option
                                                                {{ $agent[0]->business_nature == '2' ? 'selected' : '' }}
                                                                value="2">Destination Management Company</option>
                                                            <option
                                                                {{ $agent[0]->business_nature == '3' ? 'selected' : '' }}
                                                                value="3">Tour Operator</option>
                                                            <option
                                                                {{ $agent[0]->business_nature == '4' ? 'selected' : '' }}
                                                                value="4">Travel Agent</option>
                                                            <option
                                                                {{ $agent[0]->business_nature == '5' ? 'selected' : '' }}
                                                                value="5">Wholesale Travel Company</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="u-name">Address</label>
                                                        <textarea id="address" name="address" class="form-control"> {{ old('address', $agent[0]->address) }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="u-name">City</label>
                                                        <input type="text" id="city" name="city"
                                                            placeholder="City" value="{{ old('city', $agent[0]->city) }}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="u-name">State</label>
                                                        <input type="text" id="state" name="state"
                                                            placeholder="State" class="form-control"
                                                            value="{{ old('state', $agent[0]->state) }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="u-name">Country</label>
                                                        <select name="country" id="country"
                                                            class="form-control select2">
                                                            <option value="0">--Select--</option>
                                                            @foreach ($countries as $country)
                                                                <option value="{{ $country->id }}"
                                                                    {{ $agent[0]->country == $country->id ? 'selected' : '' }}>
                                                                    {{ $country->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="u-name">Zipcode/Pincode</label>
                                                        <input type="text" id="zip_code"
                                                            placeholder="Zipcode/Pincode" name="zip_code"
                                                            class="form-control"
                                                            value="{{ old('zip_code', $agent[0]->zip_code) }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="u-name">Agent Margin (%)<span
                                                                class="required">*</span></label>
                                                        <input type="number" id="agent_margin"
                                                            placeholder="Agent Margin (%)" name="agent_margin"
                                                            class="form-control"
                                                            value="{{ old('agent_margin', $agent[0]->agent_margin) }}">
                                                        @error('agent_margin')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="u-name">Credit Balance (USD)</label>
                                                        <input type="number" placeholder="Credit Balance (USD)"
                                                            value="{{ $agent[0]->credit_balance }}" class="form-control "
                                                            readonly>

                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="u-name">Logo </label>
                                                        <input type="file" id="logo" name="logo"
                                                            class="form-control">
                                                        @if ($agent[0]->logo != '')
                                                            <br>
                                                            <img src="{{ asset($agent[0]->logo) }}" class="wh-150" />
                                                        @endif
                                                    </div>
                                                </div>

                                               

                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input type="hidden" name="agent_id" id="agent_id"
                                                value="{{ $agent[0]->user_id }}">
                                            <input type="hidden" name="image_url" id="image_url"
                                                value="{{ $agent[0]->logo }}">
                                            <button type="submit"
                                                class="btn btn-success w-150">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
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
        .alert {
            margin-top: 1rem;
            margin-bottom: 0;
        }
    </style>
@endpush
@push('footer')
@endpush
