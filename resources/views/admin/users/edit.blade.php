@extends('admin.layouts.app')
@section('title', 'Edit User')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <!-- <div class="title_left">
                    <h3>Edit User Details</h3>
                </div> -->
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Edit User Details <small></small></h2>
                            <a href="{{ route('user.index') }}" class="btn back-btn" ><i class="fa fa-long-arrow-left"></i> Back</a>
                            <div class="clearfix"></div>
                           
                        </div>
                        <div class="x_content">
                            @if(session()->has('status'))
                                <div class="alert alert-success">
                                    {{ session()->get('status') }}
                                </div>
                            @endif
                            <br />
                            <form id="storeUser" action="{{ route('user.update') }}" method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left">
                                @csrf
                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="user_type">User Type<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <select class="form-control" id="user_type" name="user_type" onchange="showUsers(this.value)">
                                            <option {{ ($user->user_type == 'admin') ? 'selected' : '' }} value="admin">Admin</option>
                                            <option {{ ($user->user_type == 'user') ? 'selected' : '' }} value="user">User</option>
                                        </select>
                                        @error('user_type')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="user_code">User Code <span class="required">*</span> </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="user_code" name="user_code" required="required" readonly class="form-control" value="{{ $user->user_details->code }}">
                                        @error('user_code')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first_name">First Name <span class="required">*</span> </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="first_name" name="first_name" value="{{ old('first_name',$user->user_details->first_name) }}"  class="form-control ">
                                        @error('first_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="last_name">Last Name <span class="required">*</span> </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name',$user->user_details->last_name) }}" class="form-control">
                                        @error('last_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="email">Email <span class="required">*</span>  </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="email" id="email" name="email" value="{{ old('email',$user->email) }}" class="form-control">
                                        @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="password">Password</label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="password" id="password" name="password" autocomplete="new-password" value="{{ old('password') }}"  class="form-control">
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="phone_number">Phone Number </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="phone_number" name="phone_number" class="form-control"  value="{{ old('phone_number',$user->user_details->phone_number) }}">
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="gender">Gender</label>
                                    <div class="col-md-6 col-sm-6 radio">
                                        <label class="radio-label"><input type="radio" class=" radio-size" name="gender" id="genderM" value="male" {{ ( old('gender',$user->user_details->gender) =='male') ? "checked='checked'" : '' }}  /> Male </label>
                                        <label class="radio-label"><input type="radio" class=" radio-size" name="gender" id="genderF" value="female" {{ ( old('gender',$user->user_details->gender) =='female') ? "checked='checked'" : '' }}/> Female</label>
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="address">Address</label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <textarea id="address" name="address"  class="form-control"> {{ old('address', $user->user_details->address) }}</textarea>
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="city">City</label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="city" name="city" value="{{ old('city',$user->user_details->city) }}" class="form-control">
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="state">State</label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="state" name="state" class="form-control" value="{{ old('state',$user->user_details->state) }}">
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="country">Country</label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <select name="country" id="country" class="form-control select2">
                                            <option value="0">--Select--</option>
                                            @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ (( $user->user_details->country) == $country->id) ? 'selected' : '' }}>{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="zip_code">Zipcode/Pincode</label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="zip_code" name="zip_code" class="form-control"  value="{{ old('zip_code',$user->user_details->zip_code) }}">
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="logo">User Image</label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="file" id="image" name="image" class="form-control" >
                                        <br>
                                        @if($user->user_details->logo != NULL)
                                            <img src="{{ asset($user->user_details->logo) }}" class="wh-150" />
                                        @endif
                                        
                                        @error('logo')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="ln_solid col-md-12 col-sm-12 "></div>
                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <div class="col-md-6 col-sm-6 offset-md-3">
                                        <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
                                        <input type="hidden" name="image_url" id="image_url" value="{{ $user->user_details->logo }}">
                                        <button type="submit" class="btn btn-success">Save</button>
                                        <a href="{{ route('user.index') }}" class="btn btn-danger" type="button">Cancel</a>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('header')
<link href="{{ asset('assets/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
@endsection

@section('footer')
<script src="{{ asset('assets/plugins/select2/dist/js/select2.full.min.js') }}"></script>  
<script>
    $(".select2").select2({
        placeholder: "Select",
        width:'100%',
        allowClear: false
    });

    function showUsers(type){
        var code = '';
        if(type == 'admin'){
            code = '{{ generateUniqueCode("admin") }}';
        }else{
            code = '{{ generateUniqueCode("user") }}';
        }
        $('#user_code').val(code);
    }

</script>

@endsection
