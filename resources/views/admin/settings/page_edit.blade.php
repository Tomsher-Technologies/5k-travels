@extends('admin.layouts.app')
@section('title', 'Edit Page')
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
                            <h2>Edit {{ $page->page_name }} Page Details <small></small></h2>
                            <a href="{{ route('settings.pages') }}" class="btn back-btn" ><i class="fa fa-long-arrow-left"></i> Back</a>
                            <div class="clearfix"></div>
                           
                        </div>
                        <div class="x_content">
                            @if(session()->has('status'))
                                <div class="alert alert-success">
                                    {{ session()->get('status') }}
                                </div>
                            @endif
                            <br />
                            <form id="storeUser" action="{{ route('settings.pages.update') }}" method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left">
                                @csrf
                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="page_title">Page Title <span class="required">*</span> </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="page_title" name="page_title" class="form-control" value="{{ old('page_title', $page->page_title) }}">
                                        @error('page_title')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="seo_url">SEO Url <span class="required">*</span> </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="seo_url" name="seo_url" value="{{ old('seo_url',$page->seo_url) }}"  class="form-control ">
                                        @error('seo_url')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="page_description">Description</label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <textarea id="page_description" name="page_description" class="form-control">{{ old('page_description',$page->page_description) }} </textarea>
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="image">Image </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="file" id="image" name="image" class="form-control" accept="image/*" onchange="sizeValidation();">
                                        <div class="alert alert-danger hide" id="file-error" > File size should be less than 5 MB </div>
                                        @if($page->image != NULL)
                                        <label class="col-form-label" for="exampleInputEmail1">Current Image</label>
                                        <img class="w-50 d-block mb-3" src="{{ $page->getImage() }}" alt="{{ $page->image_alt }}">
                                        @endif
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="image_alt">Image Alt</label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="image_alt" name="image_alt"  value="{{ old('image_alt', $page->image_alt) }}"  class="form-control">
                                    </div>
                                </div>

                                @include('admin.settings.seo')

                                <div class="ln_solid col-md-12 col-sm-12 "></div>
                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <div class="col-md-6 col-sm-6 offset-md-3">
                                        <input type="hidden" name="page_id" id="page_id" value="{{ $page->id }}">
                                        <input type="hidden" name="page_type" id="page_type" value="{{ $page->page_type }}">
                                        <input type="hidden" name="image_url" id="image_url" value="{{ $page->image }}">
                                        <button type="submit" class="btn btn-success">Save</button>
                                        <a href="{{ route('settings.pages') }}" class="btn btn-danger" type="button">Cancel</a>
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
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('page_description');

    function slugify(text) {
        return text.toString().toLowerCase().replace(/\s+/g, '-').replace(/ü/g, 'u').replace(/ö/g, 'o').replace(/ğ/g, 'g').replace(/ş/g, 's').replace(/ı/g, 'i').replace(/ç/g, 'c').replace(/[^\w\-]+/g, '').replace(/\-\-+/g, '-').replace(/^-+/, '').replace(/-+$/, '').replace(/[\s_-]+/g, '-');
    }

    $('#page_title').keyup(function() {
        $slug = slugify($(this).val());
        $('#seo_url').val($slug);
    });

    function sizeValidation(){
        const fi = document.getElementById('image'); 
        // Check if any file is selected. 
        if (fi.files.length > 0) { 
            for (const i = 0; i <= fi.files.length - 1; i++) { 
  
                const fsize = fi.files.item(i).size; 
                const file = Math.round((fsize / 1024)); 
                // The size of the file. 4096
                if (file >= 4096) { 
                    $('#file-error').removeClass('hide');
                }else{
                    $('#file-error').addClass('hide');
                }
            } 
        } 
    }

</script>

@endsection
