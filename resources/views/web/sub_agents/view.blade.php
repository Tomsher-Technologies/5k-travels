@extends('web.layouts.app')
@section('content')


 <!-- Common Banner Area -->
 <section id="common_banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="common_bannner_text">
                        <h2>Sub-agent Details</h2>
                        
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
                        
                        <h3>Sub-agent Details</h3>
                        
                        <div class="profile_update_form">
                           
                            <div id="storeAgent" class="form_area">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="agent_code">Agent Code</label>
                                            <input type="text" class="form-control readonly"  required="required" readonly value="{{ $agent[0]->code }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="f-name">First name</label>
                                            <input type="text" class="form-control readonly" placeholder="First Name" value="{{ $agent[0]->first_name }}" >
                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="l-name">Last name</label>
                                            <input type="text" class="form-control readonly" placeholder="Last Name" value="{{ $agent[0]->last_name }}">
                                           
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="mail-address">Email</label>
                                            <input type="email" class="form-control readonly" placeholder="Email" value="{{ $agent[0]->email }}">
                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="mobil-number">Phone Number</label>
                                            <input type="text" class="form-control readonly" placeholder="Phone Number"  value="{{ $agent[0]->phone_number }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="u-name">Gender</label>
                                            <div class="radio">
                                                <label class="radio-label readonly"><input type="radio" class="readonly radio-size" {{ ( $agent[0]->gender =='male') ? "checked='checked'" : '' }} /> Male </label>
                                                <label class="radio-label readonly"><input type="radio" class="readonly radio-size" {{ ( $agent[0]->gender =='female') ? "checked='checked'" : '' }}/> Female</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="u-name">Designation</label>
                                            <input type="text" class="form-control readonly" placeholder="Designation" value="{{ $agent[0]->designation }}">
                                        </div>
                                    </div>
                                    
                                    <div class="change_password_input_boxed">
                                        <h3 style="font-size: 18px;">Company Details</h3>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">Company Name</label>
                                                    <input type="text" placeholder="Company Name" value="{{ $agent[0]->company_name }}" class="form-control readonly">
                                                   
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">Company Reg. No.</label>
                                                    <input type="text" class="form-control readonly" placeholder="Company Reg. No." value="{{ $agent[0]->company_reg_no }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">Nature Of Business</label>
                                                    @php
                                                        $nature = '';
                                                        if($agent[0]->business_nature == '1'){
                                                            $nature = 'Corporate';
                                                        }elseif($agent[0]->business_nature == '2'){
                                                            $nature = 'Destination Management Company';
                                                        }elseif($agent[0]->business_nature == '3'){
                                                            $nature = 'Tour Operator';
                                                        }elseif($agent[0]->business_nature == '4'){
                                                            $nature = 'Travel Agent';
                                                        }elseif($agent[0]->business_nature == '5'){
                                                            $nature = 'Wholesale Travel Company';
                                                        }
                                                    @endphp
                                                    <input type="text" placeholder="Nature Of Business" class="form-control readonly" value="{{ $nature }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">Address</label>
                                                    <textarea  class="form-control readonly"> {{ $agent[0]->address }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">City</label>
                                                    <input type="text" placeholder="City" value="{{ $agent[0]->city }}" class="form-control readonly">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">State</label>
                                                    <input type="text" placeholder="State" class="form-control readonly" value="{{ $agent[0]->state }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">Country</label>
                                                    <input type="text" placeholder="Country" class="form-control readonly" value="{{ $agent[0]->country_name }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">Zipcode/Pincode</label>
                                                    <input type="text" placeholder="Zipcode/Pincode" class="form-control readonly"  value="{{ $agent[0]->zip_code }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">Agent Margin (%)</label>
                                                    <input type="number" placeholder="Agent Margin (%)" class="form-control readonly"  value="{{ $agent[0]->agent_margin }}">
                                                   
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">Credit Balance (USD)</label>
                                                    <input type="number" placeholder="Credit Balance (USD)" value="{{ $agent[0]->credit_balance }}" class="readonly form-control">
                                                  
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">Logo </label>
                                                    @if($agent[0]->logo != '')
                                                        <br>
                                                        <img src="{{ asset($agent[0]->logo) }}" class="wh-150" />
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

<script type="text/javascript">
 
</script>
@endpush