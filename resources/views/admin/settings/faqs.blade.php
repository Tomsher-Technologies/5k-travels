@extends('admin.layouts.app')
@section('title', 'FAQ')
@section('content')
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>FAQ Contents</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>FAQ Categories <small></small></h2>
                        <a href="{{ route('settings.faq.create') }}" class="btn back-btn" ><i class="fa fa-plus"></i> Create FAQ Category</a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    @if(session()->has('status'))
                                        <div class="alert alert-success">
                                            {{ session()->get('status') }}
                                        </div>
                                    @endif
                                    <table id="datatable-buttons" class="table table-bordered jambo_table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Sl No.</th>
                                                <th>Category Name</th>
                                                <th>Status</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($faqs[0]))
                                                @foreach ($faqs as $faq)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$faq->category_name}}</td>
                                                    <td class="text-center">
                                                        <label class="switch" title="{{ (($faq->is_active) == 1) ? 'Enabled' : 'Disabled' }}">
                                                            <input type="checkbox" onchange="changeStatus({{$faq->id}},{{$faq->is_active}})" {{ (($faq->is_active) == 1) ? "checked" : '' }} >
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td class="text-center p-0">
                                                        <a href="{{route('settings.faq.edit', $faq)}}" class="edit-icon btn btn-app" title="Edit Details"><i class="fa fa-pencil"></i>Edit</a>
                                                        <a href="#" onclick="deleteFaqCategory('{{$faq->id}}')" class="delete-icon btn btn-app" title="Delete Details"><i class="fa fa-trash"></i>Delete</a>
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
                                        {{ $faqs->appends(request()->input())->links() }}
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
                text: "Do you want to "+statusW+" this category?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
        }).then(function(result) {
            if (result.isConfirmed) {
                var data = []
                $.ajax({
                    url: "{{ route('faq.change.status')}}",
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

    function deleteFaqCategory(id){
        Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete this category?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
        }).then(function(result) {
            if (result.isConfirmed) {
                var data = []
                $.ajax({
                    url: "{{ route('faq.category.delete')}}",
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