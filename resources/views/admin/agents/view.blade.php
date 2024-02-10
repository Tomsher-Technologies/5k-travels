@extends('admin.layouts.app')
@section('title', 'View Agent')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <!-- <div class="title_left">
                    <h3>View Agent</h3>
                </div> -->
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>View Agent Details<small></small></h2>
                            <a href="{{ route('agent.index') }}" class="btn back-btn" ><i class="fa fa-long-arrow-left"></i> Back</a>
                            <div class="clearfix"></div>
                           
                        </div>
                        <div class="x_content">
                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="agent_type">Agent Type : </label>
                                <div class="col-md-6 col-sm-6 col-form-label ">
                                    {{ ($agent->parent_id == '') ? 'Agent' : 'Sub Agent' }}
                                </div>
                            </div>

                            <div class="item form-group col-md-12 col-sm-12 {{ ($agent->parent_id != '') ? 'show' : 'hide' }}" id="agentsDiv">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="main_agent">Main Agent : </label>
                                <div class="col-md-6 col-sm-6 col-form-label ">
                                    {{($agent->parent_id != '') ? $agent->parent->name : '' }}
                                </div>
                            </div>

                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="agent_code">Agent Code : </label>
                                <div class="col-md-6 col-sm-6 col-form-label ">
                                {{$agent->user_details->code}}
                                </div>
                            </div>

                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="first_name">First Name : </label>
                                <div class="col-md-6 col-sm-6 col-form-label ">
                                {{$agent->user_details->first_name}}
                                </div>
                            </div>

                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="last_name">Last Name : </label>
                                <div class="col-md-6 col-sm-6 col-form-label ">
                                {{$agent->user_details->last_name}}
                                </div>
                            </div>

                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="email">Email : </label>
                                <div class="col-md-6 col-sm-6 col-form-label ">
                                {{$agent->email}}
                                </div>
                            </div>

                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="phone_number">Phone Number : </label>
                                <div class="col-md-6 col-sm-6 col-form-label ">
                                {{$agent->user_details->phone_number}}
                                </div>
                            </div>

                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="gender">Gender : </label>
                                <div class="col-md-6 col-sm-6 col-form-label radio">
                                {{$agent->user_details->gender}}
                                </div>
                            </div>

                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="designation">Designation : </label>
                                <div class="col-md-6 col-sm-6 col-form-label ">
                                {{$agent->user_details->designation}}
                                </div>
                            </div>
                            <div class="ln_solid col-md-12 col-sm-12 "></div>

                            <div class="item form-group col-md-12 col-sm-12 ">
                                <h4 class="col-form-label col-md-4 col-sm-4 label-align"><b> Company Details</b> </h4>
                            </div>

                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="company_name">Company Name : </label>
                                <div class="col-md-6 col-sm-6 col-form-label ">
                                {{$agent->user_details->company_name}}
                                </div>
                            </div>
                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="company_reg_no">Company Reg. No. : </label>
                                <div class="col-md-6 col-sm-6 col-form-label ">
                                {{$agent->user_details->company_reg_no}}
                                </div>
                            </div>

                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="business_nature">Nature Of Business : </label>
                                <div class="col-md-6 col-sm-6 col-form-label ">
                                {{$agent->user_details->business_nature}}
                                </div>
                            </div>

                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="address">Address : </label>
                                <div class="col-md-6 col-sm-6 col-form-label ">
                                {{$agent->user_details->address}}
                                </div>
                            </div>

                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="city">City : </label>
                                <div class="col-md-6 col-sm-6 col-form-label ">
                                {{$agent->user_details->city}}
                                </div>
                            </div>

                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="state">State : </label>
                                <div class="col-md-6 col-sm-6 col-form-label ">
                                {{$agent->user_details->state}}
                                </div>
                            </div>

                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="country">Country : </label>
                                <div class="col-md-6 col-sm-6 col-form-label ">
                                {{ ($agent->user_details->country != '') ? $agent->user_details->country_name : ''}}
                                </div>
                            </div>
                            
                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="zip_code">Zipcode/Pincode : </label>
                                <div class="col-md-6 col-sm-6 col-form-label ">
                                {{$agent->user_details->zip_code}}
                                </div>
                            </div>

                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="agent_margin">Agent Margin (%) : </label>
                                <div class="col-md-6 col-sm-6 col-form-label ">
                                {{$agent->user_details->agent_margin}}
                                </div>
                            </div>

                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="admin_margin">Admin Margin (%) : </label>
                                <div class="col-md-6 col-sm-6 col-form-label ">
                                {{$agent->user_details->admin_margin}}
                                </div>
                            </div>

                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="credit_balance">Credit Balance (USD): </label>
                                <div class="col-md-6 col-sm-6 col-form-label ">
                                USD {{$agent->user_details->credit_balance}}
                                </div>
                            </div>

                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="logo">Logo : </label>
                                <div class="col-md-6 col-sm-6 col-form-label ">
                                    @if($agent->user_details->logo != NULL)
                                        <img src="{{ asset($agent->user_details->logo) }}" class="wh-150" />
                                    @endif
                                </div>
                            </div>

                            <div class="ln_solid col-md-12 col-sm-12 "></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('header')

@endsection

@section('footer')

@endsection
