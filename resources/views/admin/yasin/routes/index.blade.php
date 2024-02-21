@extends('admin.layouts.app')
@section('title', 'Routes')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Routes</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>All Routes<small></small></h2>
                            <a href="{{ route('yasin.routes.create') }}" class="btn back-btn"><i class="fa fa-plus"></i>
                                Create Route</a>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card-box table-responsive">
                                        <div class="card">
                                            <div class="card-body">
                                                <form class="" id="sort_sellers" action="" method="GET">
                                                    <div class="title_right">
                                                        <div class="col-md-4 col-sm-4  form-group pull-right top_search">
                                                            <label> Search by from or to</label>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control w-90"
                                                                    id="search" name="search"
                                                                    @isset($sort_search) value="{{ $sort_search }}" @endisset
                                                                    placeholder="Type route, from or to">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4  pt-25">
                                                            <button type="submit" class="btn btn-success"><i
                                                                    class="fa fa-search"></i> Search</button>
                                                            <a href="{{ route('yasin.routes.index') }}"
                                                                class="btn btn-primary" type="reset"><i
                                                                    class="fa fa-refresh"></i> Reset</a>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <table id="datatable-buttons" class="table table-bordered jambo_table mt-4"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Sl No.</th>
                                                    <th>From</th>
                                                    <th>To</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($routes))
                                                    @foreach ($routes as $route)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $route->from }}</td>
                                                            <td>{{ $route->to }}</td>

                                                            <td class="text-center">
                                                                <label class="switch"
                                                                    title="{{ $route->status == 1 ? 'Enabled' : 'Disabled' }}">
                                                                    <input type="checkbox"
                                                                        onchange="changeStatus({{ $route->id }},{{ $route->status }})"
                                                                        {{ $route->status == 1 ? 'checked' : '' }}>
                                                                    <span class="slider round"></span>
                                                                </label>
                                                            </td>
                                                            <td class="text-center p-0">
                                                                <a href="{{ route('yasin.routes.edit', $route->id) }}"
                                                                    class="edit-icon btn btn-app" title="Edit Details"><i
                                                                        class="fa fa-pencil"></i>Edit</a>

                                                                <a href="#"
                                                                    onclick="deleteAgent({{ $route->id }})"
                                                                    class="delete-icon btn btn-app" title="Delete Agent"><i
                                                                        class="fa fa-trash"></i>Delete</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan='10' class="text-center">
                                                            No Data Available
                                                        </td>
                                                    </tr>
                                                @endif

                                            </tbody>
                                        </table>
                                        <div class="aiz-pagination float-right">
                                            {{ $routes->appends(request()->input())->links() }}
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
@endsection

@section('header')
    <style>
        .top_search .form-control {
            border-radius: 0px !important;
        }
    </style>
@endsection

@section('footer')

    <script>
        function changeStatus(id, status) {
            var statusW = (status == 1) ? 'Disable' : 'Enable';
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to " + statusW + " this route?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
            }).then(function(result) {
                if (result.isConfirmed) {
                    var data = []
                    $.ajax({
                        url: "{{ route('yasin.routes.change_status') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": id,
                            "status": status
                        },
                        success: function(response) {
                            Swal.fire(
                                'Status changed successfully',
                                '',
                                'success'
                            );
                            setTimeout(function() {
                                window.location.reload();
                            }, 2000);
                        }
                    });
                } else {
                    window.location.reload();
                }

            })
        }

        function deleteAgent(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete this agent?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
            }).then(function(result) {
                if (result.isConfirmed) {
                    var data = []

                    var route = "{{ route('yasin.routes.destroy', ':id') }}";

                    $.ajax({
                        url: route.replace(':id', id),
                        type: "DELETE",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": id,
                            'method': 'DELETE'
                        },
                        success: function(response) {
                            if (response == 1) {
                                Swal.fire(
                                    'Deleted successfully',
                                    '',
                                    'success'
                                );
                                setTimeout(function() {
                                    window.location.reload();
                                }, 2000);
                            } else {
                                Swal.fire(
                                    'Route not deleted, please try again',
                                    '',
                                    'warning'
                                );
                            }

                        }
                    });
                }

            })
        }
    </script>

@endsection
