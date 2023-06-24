@extends('admin.layouts.app')
@section('title', 'Users')
@section('content')
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Users</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>All Users <small></small></h2>
                        <a href="{{ route('user.create') }}" class="btn back-btn" ><i class="fa fa-plus"></i> Create User</a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <form class="" id="sort_sellers" action="" method="GET">
                                        <div class="title_right">
                                            <div class="col-md-5 col-sm-5  form-group pull-right top_search">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="search" name="search" @isset($sort_search) value="{{ $sort_search }}" @endisset
                                                    placeholder="Type user type or name or email or user code & Enter">
                                                    <i class="fa fa-search form-control-feedback right" ></i>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <table id="datatable-buttons" class="table table-bordered jambo_table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Sl No.</th>
                                                <th>User Code</th>
                                                <th>User Type</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($users[0]))
                                                @foreach ($users as $user)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$user->code}}</td>
                                                    <td>{{ ($user->user_type == 'admin') ? 'Admin' : 'User' }}</td>

                                                    <td>{{$user->name}}</td>
                                                    <td>{{$user->email}}</td>
                                                    <td>{{$user->phone_number}}</td>
                                                    <td class="text-center">
                                                        <label class="switch" title="{{ (($user->is_active) == 1) ? 'Enabled' : 'Disabled' }}">
                                                            <input type="checkbox" onchange="changeStatus({{$user->user_id}},{{$user->is_active}})" {{ (($user->is_active) == 1) ? "checked" : '' }} >
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td class="text-center p-0">
                                                        <a href="{{route('user.view', $user->user_id)}}" class="view-icon btn btn-app" title="View Details"><i class="fa fa-eye"></i>View</a>

                                                        <a href="{{route('user.edit', $user->user_id)}}" class="edit-icon btn btn-app" title="Edit Details"><i class="fa fa-pencil"></i>Edit</a>
                                                        @if(Auth::user()->id != $user->user_id)
                                                        <a href="#" onclick="deleteUser({{$user->user_id}})" class="delete-icon btn btn-app" title="Delete User"><i class="fa fa-trash"></i>Delete</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @else
                                            <tr>
                                                <td colspan='8' class="text-center">
                                                    No Data Available
                                                </td>
                                            </tr>
                                            @endif

                                        </tbody>
                                    </table>
                                    <div class="aiz-pagination float-right">
                                        {{ $users->appends(request()->input())->links() }}
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

@endsection

@section('footer')

<script>
    function changeStatus(id,status){
        var statusW = (status == 1) ? 'Disable' : 'Enable' ;
        Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to "+statusW+" this user?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
        }).then(function(result) {
            if (result.isConfirmed) {
                var data = []
                $.ajax({
                    url: "{{ route('user.change.status')}}",
                    type: "POST",
                    data: { "_token": "{{ csrf_token() }}","id":id,"status":status },
                    success: function( response ) {
                        
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
            } else{
                window.location.reload();
            }
            
        })
    }

    function deleteUser(id){
        Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete this user?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
        }).then(function(result) {
            if (result.isConfirmed) {
                var data = []
                $.ajax({
                    url: "{{ route('user.delete')}}",
                    type: "POST",
                    data: { "_token": "{{ csrf_token() }}","id":id},
                    success: function( response ) {
                        
                        Swal.fire(
                            'Deleted successfully',
                            '',
                            'success'
                        );
                        setTimeout(function() {
                           window.location.reload();
                        }, 2000);
                    }
                });
            }
            
        })
    }
</script>

@endsection