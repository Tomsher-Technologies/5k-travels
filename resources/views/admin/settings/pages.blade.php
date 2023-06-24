@extends('admin.layouts.app')
@section('title', 'Pages')
@section('content')
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>All Pages</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Page Settings <small></small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <table id="datatable-buttons" class="table table-bordered jambo_table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Sl No.</th>
                                                <th>Page Name</th>
                                                <th>Page Title</th>
                                                <th>Seo Url</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($pages[0]))
                                                @foreach ($pages as $page)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$page->page_name}}</td>
                                                    <td>{{$page->page_title}}</td>
                                                    <td>{{$page->seo_url}}</td>
                                                    
                                                    <td class="text-center p-0">
                                                        <a href="{{route('settings.pages.edit', $page)}}" class="edit-icon btn btn-app" title="Edit Details"><i class="fa fa-pencil"></i>Edit Details</a>
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
                                        {{ $pages->appends(request()->input())->links() }}
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
  

</script>

@endsection