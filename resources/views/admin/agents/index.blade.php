@extends('admin.layouts.app')
@section('title', 'Agents')
@section('content')
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Agents</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>All Agents <small></small></h2>
                        <a href="{{ route('agent.create') }}" class="btn back-btn" ><i class="fa fa-plus"></i> Create Agent</a>
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
                                                    placeholder="Type category or name or email or agent code & Enter">
                                                    <i class="fa fa-search form-control-feedback right" ></i>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <table id="datatable-buttons" class="table table-bordered jambo_table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Sl No.</th>
                                                <th>Agent Code</th>
                                                <th>Category</th>
                                                <th>Agent Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Credit Balance</th>
                                                <th class="text-center">Approval Status</th>
                                                <th class="text-center">Agent Status</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($agents[0]))
                                                @foreach ($agents as $agent)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$agent->code}}</td>
                                                    <td>{{ ($agent->parent_id == '') ? 'Agent' : 'Sub Agent' }}</td>

                                                    <td>{{$agent->name}}</td>
                                                    <td>{{$agent->email}}</td>
                                                    <td>{{$agent->phone_number}}</td>
                                                    <td>{{$agent->credit_balance}}</td>
                                                    <td class="text-center" id="approve_{{$agent->user_id}}">
                                                        @if ($agent->is_approved == 1)
                                                            <span class="label label-success">Approved</span>
                                                        @else
                                                            <button class="btn btn-danger border-radius-20 p-10px" onclick="approveAgent({{$agent->user_id}})"><span class="label label-danger">Pending</span> </button>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <label class="switch" title="{{ (($agent->is_active) == 1) ? 'Enabled' : 'Disabled' }}">
                                                            <input type="checkbox" onchange="changeStatus({{$agent->user_id}},{{$agent->is_active}})" {{ (($agent->is_active) == 1) ? "checked" : '' }} >
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td class="text-center p-0">
                                                        <a href="{{route('agent.view', $agent->user_id)}}" class="view-icon btn btn-app" title="View Details"><i class="fa fa-eye"></i>View</a>

                                                        <a href="{{route('agent.edit', $agent->user_id)}}" class="edit-icon btn btn-app" title="Edit Details"><i class="fa fa-pencil"></i>Edit</a>

                                                        <a href="#" onclick="deleteAgent({{$agent->user_id}})" class="delete-icon btn btn-app" title="Delete Agent"><i class="fa fa-trash"></i>Delete</a>
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
                                        {{ $agents->appends(request()->input())->links() }}
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
    
    function approveAgent(id){
        Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to approve this agent?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
        }).then(function(result) {
            if (result.isConfirmed) {
                $('#approve_'+id).html('<i class="fa fa-spinner fa-spin font-20"></i>');
                var data = [];
                
                $.ajax({
                    url: "{{ route('agent.approve')}}",
                    type: "POST",
                    data: { "_token": "{{ csrf_token() }}", "id":id},
                    success: function( response ) {
                        var html = '<span class="label label-success">Approved</span>';
                     
                        $('#approve_'+id).html(html);
                        
                        Swal.fire(
                            'Approved successfully',
                            '',
                            'success'
                        );
                    }
                });
            } 
            
        })
    }

    function changeStatus(id,status){
        var statusW = (status == 1) ? 'Disable' : 'Enable' ;
        Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to "+statusW+" this agent?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
        }).then(function(result) {
            if (result.isConfirmed) {
                var data = []
                $.ajax({
                    url: "{{ route('agent.change.status')}}",
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

    function deleteAgent(id){
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
                $.ajax({
                    url: "{{ route('agent.delete')}}",
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