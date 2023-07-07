@extends('web.layouts.app')
@section('content')


 <!-- Common Banner Area -->
 <section id="common_banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="common_bannner_text">
                        <h2>Sub-agents</h2>
                        
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
                        <div class="d-flex">
                            <h3 style="width:780px;">Sub-agents Listing</h3>
                            <a href="{{ route('subagent.create') }}" class="btn btn-success">Create New Sub-agent</a>
                        </div>
                        
                        <div class="table-responsive-lg table_common_area">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sl no.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Credit Balance</th>
                                        <th>Approval Status</th>
                                        <th>Active Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($agents)
                                        @foreach($agents as $key=>$agent)
                                            <tr>
                                                <td>{{ ($key+1) + ($agents->currentPage() - 1)*$agents->perPage() }}</td>
                                                <td>{{$agent->name}}</td>
                                                <td>{{$agent->email}}</td>
                                                <td>{{$agent->credit_balance}}</td>
                                                <td class="text-center" id="approve_{{$agent->user_id}}">
                                                    @if ($agent->is_approved == 1)
                                                        <span class="label label-success">Approved</span>
                                                    @else
                                                        <span class="label label-danger"> Not Approved</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <label class="switch" title="{{ (($agent->is_active) == 1) ? 'Enabled' : 'Disabled' }}">
                                                        <input type="checkbox" onchange="changeStatus({{$agent->user_id}},{{$agent->is_active}})" {{ (($agent->is_active) == 1) ? "checked" : '' }} >
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                                <td class="">
                                                    <a href="{{route('subagent.view', $agent->user_id)}}" class="info-icon" title="View Details"><i class="fa fa-eye"></i></a>

                                                    <a href="{{route('subagent.edit', $agent->user_id)}}" class="success-icon ms-2" title="Edit Details"><i class="fa fa-pencil"></i></a>

                                                    <a href="#" onclick="deleteAgent({{$agent->user_id}})" class="danger-icon ms-2" title="Delete Agent"><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                    <div class="pagination_area">
                        {{ $agents->appends(request()->input())->links() }}
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

</style>
@endpush
@push('footer')
<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
<script type="text/javascript">
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
                    url: "{{ route('change.agent.status')}}",
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
                text: "Do you want to delete this Sub-agent?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
        }).then(function(result) {
            if (result.isConfirmed) {
                var data = []
                $.ajax({
                    url: "{{ route('subagent.delete')}}",
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
@endpush