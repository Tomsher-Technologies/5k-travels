@extends('admin.layouts.app')
@section('title', 'General Settings')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>General Settings</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Update General Settings <small></small></h2>
                            
                            <div class="clearfix"></div>
                           
                        </div>
                        <div class="x_content">
                            @if(session()->has('status'))
                                <div class="alert alert-success">
                                    {{ session()->get('status') }}
                                </div>
                            @endif
                            <br />
                            <form id="storeUser" action="{{ route('settings.general.store') }}" method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left">
                                @csrf
                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="admin_margin">Admin Margin For Users (%) <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="number" id="admin_margin_users" step="any" name="admin_margin_users" value="{{ (isset($general_settings['admin_margin_users'])) ? $general_settings['admin_margin_users']['value'] : '' }}" class="form-control">
                                        @error('admin_margin_users')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="site_mail">Site Email <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="site_mail" name="site_mail" value="{{  (isset($general_settings['site_mail'])) ? $general_settings['site_mail']['value'] : ''}}" class="form-control">
                                        @error('site_mail')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="site_phone">Site Phone Number <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="site_phone" name="site_phone" value="{{ (isset($general_settings['site_phone'])) ? $general_settings['site_phone']['value'] : '' }}" class="form-control">
                                        @error('site_phone')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="facebook">Facebook Link </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="facebook" name="facebook" value="{{ (isset($general_settings['facebook'])) ? $general_settings['facebook']['value'] : '' }}" class="form-control">
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="instagram">Instagram Link </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="instagram" name="instagram" value="{{ (isset($general_settings['instagram'])) ? $general_settings['instagram']['value'] : '' }}" class="form-control">
                                    </div>
                                </div>
                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="twitter">Twitter Link </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="twitter" name="twitter" value="{{ (isset($general_settings['twitter'])) ? $general_settings['twitter']['value'] : '' }}" class="form-control">
                                    </div>
                                </div>
                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="linkedin">LinkedIn Link </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="linkedin" name="linkedin" value="{{ (isset($general_settings['linkedin'])) ? $general_settings['linkedin']['value'] : '' }}" class="form-control">
                                    </div>
                                </div>

                                <div class="ln_solid col-md-12 col-sm-12 "></div>
                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <div class="col-md-6 col-sm-6 offset-md-3">
                                        <button type="submit" class="btn btn-success">Save</button>
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

@endsection

@section('footer')

<script>
   

</script>

@endsection
