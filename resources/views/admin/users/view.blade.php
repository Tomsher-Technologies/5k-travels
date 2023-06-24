@extends('admin.layouts.app')
@section('title', 'View User')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <!-- <div class="title_left">
                    <h3>View User</h3>
                </div> -->
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>View User Details<small></small></h2>
                            <a href="{{ route('user.index') }}" class="btn back-btn" ><i class="fa fa-long-arrow-left"></i> Back</a>
                            <div class="clearfix"></div>
                           
                        </div>
                        <div class="x_content">
                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="user_type">User Type : </label>
                                <div class="col-md-6 col-sm-6 col-form-label ">
                                    {{ ($user->user_type == 'admin') ? 'Admin' : 'User' }}
                                </div>
                            </div>

                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="user_code">User Code : </label>
                                <div class="col-md-6 col-sm-6 col-form-label ">
                                {{$user->user_details->code}}
                                </div>
                            </div>

                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="first_name">First Name : </label>
                                <div class="col-md-6 col-sm-6 col-form-label ">
                                {{$user->user_details->first_name}}
                                </div>
                            </div>

                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="last_name">Last Name : </label>
                                <div class="col-md-6 col-sm-6 col-form-label ">
                                {{$user->user_details->last_name}}
                                </div>
                            </div>

                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="email">Email : </label>
                                <div class="col-md-6 col-sm-6 col-form-label ">
                                {{$user->email}}
                                </div>
                            </div>

                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="phone_number">Phone Number : </label>
                                <div class="col-md-6 col-sm-6 col-form-label ">
                                {{$user->user_details->phone_number}}
                                </div>
                            </div>

                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="gender">Gender : </label>
                                <div class="col-md-6 col-sm-6 col-form-label radio">
                                {{$user->user_details->gender}}
                                </div>
                            </div>

                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="address">Address : </label>
                                <div class="col-md-6 col-sm-6 col-form-label ">
                                {{$user->user_details->address}}
                                </div>
                            </div>

                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="city">City : </label>
                                <div class="col-md-6 col-sm-6 col-form-label ">
                                {{$user->user_details->city}}
                                </div>
                            </div>

                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="state">State : </label>
                                <div class="col-md-6 col-sm-6 col-form-label ">
                                {{$user->user_details->state}}
                                </div>
                            </div>

                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="country">Country : </label>
                                <div class="col-md-6 col-sm-6 col-form-label ">
                                {{ ($user->user_details->country != '' && $user->user_details->country != 0) ? $user->user_details->country_name->name : ''}}
                                </div>
                            </div>
                            
                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="zip_code">Zipcode/Pincode : </label>
                                <div class="col-md-6 col-sm-6 col-form-label ">
                                {{$user->user_details->zip_code}}
                                </div>
                            </div>

                            <div class="item form-group col-md-12 col-sm-12 ">
                                <label class="col-form-label col-md-4 col-sm-4 label-align" for="logo">User Image : </label>
                                <div class="col-md-6 col-sm-6 col-form-label ">
                                    @if($user->user_details->logo != NULL)
                                        <img src="{{ asset($user->user_details->logo) }}" class="wh-150" />
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
