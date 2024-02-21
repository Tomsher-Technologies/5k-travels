@extends('admin.layouts.app')
@section('title', 'Create Route')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Create Route</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Create New Route <small></small></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @if (session()->has('status'))
                                <div class="alert alert-success">
                                    {{ session()->get('status') }}
                                </div>
                            @endif
                            <br />
                            <form id="storeAgent" action="{{ route('yasin.routes.store') }}" method="POST"
                                enctype="multipart/form-data" class="form-horizontal form-label-left">
                                @csrf

                                <div class="item form-group col-md-12 col-sm-12" id="agentsDiv">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="from_airport">Select
                                        Orgin
                                        Airport</label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <select class="form-control select2" name="from_airport" id="from_airport" required>
                                        </select>
                                        @error('from_airport')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12" id="agentsDiv">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="to_airport">Select
                                        Destination
                                        Airport</label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <select class="form-control select2" name="to_airport" id="to_airport" required>
                                        </select>
                                        @error('to_airport')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12" id="agentsDiv">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align"
                                        for="status">Status</label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <select class="form-control" name="status" id="status" required>
                                            <option value="1" selected>Enabled</option>
                                            <option value="0">Disabled</option>
                                        </select>
                                        @error('status')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="ln_solid col-md-12 col-sm-12 "></div>
                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <div class="col-md-6 col-sm-6 offset-md-3">
                                        <button type="submit" class="btn btn-success">Save</button>
                                        <a href="{{ route('yasin.routes.index') }}" class="btn btn-danger"
                                            type="button">Cancel</a>
                                        <button class="btn btn-primary" type="reset">Reset</button>

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
            placeholder: "Select airport",

            width: '100%',
            allowClear: false,
            ajax: {
                delay: 250,
                url: '{{ route('yasin.autocompleteairports') }}',
                dataType: 'json',
                data: function(params) {
                    var query = {
                        term: params.term,
                    }
                    return query;
                },
                processResults: function(data, page) {
                    console.log(data);
                    return {
                        results: data.items
                    };
                },
            }
        });

    </script>

@endsection
