@extends('admin.layouts.app')
@section('title', 'FAQ Categories')
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
                            <h2>FAQ Category Details <small></small></h2>
                            <a href="{{ route('settings.faq') }}" class="btn back-btn" ><i class="fa fa-long-arrow-left"></i> Back</a>
                            <div class="clearfix"></div>
                           
                        </div>
                        <div class="x_content">
                            @if(session()->has('status'))
                                <div class="alert alert-success">
                                    {{ session()->get('status') }}
                                </div>
                            @endif
                            <br />
                            <form id="storeUser" action="{{ route('settings.faq.update') }}" method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left">
                                @csrf
                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-2 col-sm-2 label-align" for="category_name">Category Name <span class="required">*</span> </label>
                                    <div class="col-md-7 col-sm-7 ">
                                        <input type="text" id="category_name" name="category_name" class="form-control" value="{{ old('category_name', $faq[0]->category_name) }}">
                                        @error('category_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-2 col-sm-2 label-align">Contents</label>
                                    <div class="col-md-8 col-sm-8 no-padding-left">
                                        <table class="table " >
                                            <tbody id="qn_table">
                                                @php $i=0; @endphp
                                                @foreach($faq[0]->question_answers as $qa)
                                                    <tr>
                                                        <td>
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Question</label>
                                                                <input type="text" name="question[]" id="question_{{$i}}" class="form-control year" value="{{$qa->question}}" />
                                                            </div>
                                                            <div class="form-group"> 
                                                                <label for="exampleInputEmail1">Answer</label>
                                                                <textarea name="answer[]" id="answer_{{$i}}" cols="40" rows="4" class="form-control" >{{$qa->answer}}</textarea> 
                                                            </div>
                                                        </td>
                                                        <td class="w-12">
                                                            <button type="button" name="remove" id="" class="btn btn-danger remove">Remove</button>
                                                        </td>
                                                    </tr>
                                                    @php $i++; @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="ln_solid col-md-12 col-sm-12 "></div>
                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <div class="col-md-8 col-sm-8 offset-md-2">
                                        <input type="hidden" name="category_id" value="{{$faq[0]->id}}">
                                        <button type="submit" class="btn btn-success">Save</button>
                                        <a href="{{ route('settings.faq') }}" class="btn btn-danger" type="button">Cancel</a>
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
<style>
.table td, .table th{
    border:0;
}
</style>
@endsection

@section('footer')

<script>
    var count = 1;
    dynamic_field(1)
    function dynamic_field(number)
    {

            html = '<tr>';
            html += '<td><div class="form-group"><label for="exampleInputEmail1">Question</label><input type="text" name="question[]" id="question_'+number+'" class="form-control year" value="" /></div>';
            html += '   <div class="form-group"> <label for="exampleInputEmail1">Answer</label><textarea name="answer[]" id="answer_'+number+'" cols="40" rows="4" class="form-control" ></textarea> </div>';
            html += '</td>';
            
            if(number > 1)
            {
                html += '<td class="w-12"><button type="button" name="remove" id="" class="btn btn-danger remove">Remove</button></td></tr>';
                $('#qn_table').append(html);
            }
            else
            {   
                html += '<td class="w-12"><button type="button" name="add" id="add" class="btn btn-success">Add</button></td></tr>';
                $('#qn_table').append(html);
            }
        
    }

    $(document).on('click', '#add', function(){
        count++;
        dynamic_field(count);
    });

    $(document).on('click', '.remove', function(){
        count--;
        $(this).closest("tr").remove();
    });

</script>

@endsection
