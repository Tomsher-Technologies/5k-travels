
    <div class="ln_solid col-md-12 col-sm-12 "></div>

    <div class="item form-group col-md-12 col-sm-12 ">
        <h5 class="col-md-3 col-sm-3 label-align"><b> SEO Details</b> </h5>
    </div>

    <div class="item form-group col-md-12 col-sm-12 ">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="seo_title">SEO Title</label>
        <div class="col-md-6 col-sm-6 ">
            <input type="text" name="seo_title" class="form-control" value="{{ old('seo_title', $page->seo_title) }}"/>
            @error('seo_title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="item form-group col-md-12 col-sm-12 ">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="seo_description">SEO Description</label>
        <div class="col-md-6 col-sm-6 ">
            <textarea  name="seo_description" id="seo_description" cols="30" rows="3" class="form-control">{{ old('seo_description', $page->seo_description) }}</textarea>
            @error('seo_description')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="item form-group col-md-12 col-sm-12 ">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="og_title">OG Title</label>
        <div class="col-md-6 col-sm-6 ">
            <input type="text" name="og_title" class="form-control"  value="{{ old('og_title', $page->og_title) }}"/>
            @error('og_title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="item form-group col-md-12 col-sm-12 ">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="og_description">OG Description</label>
        <div class="col-md-6 col-sm-6 ">
            <textarea name="og_description" id="og_description" cols="30" rows="3" class="form-control">{{ old('og_description', $page->og_description) }}</textarea>
            @error('og_description')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="item form-group col-md-12 col-sm-12 ">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="twitter_title">Twitter Title</label>
        <div class="col-md-6 col-sm-6 ">
            <input type="text" name="twitter_title" class="form-control" value="{{ old('twitter_title', $page->twitter_title) }}" />
            @error('twitter_title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    
    <div class="item form-group col-md-12 col-sm-12 ">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="twitter_description">Twitter Description</label>
        <div class="col-md-6 col-sm-6 ">
            <textarea name="twitter_description" id="twitter_description" cols="30" rows="3" class="form-control">{{ old('twitter_description', $page->twitter_description) }}</textarea>
            @error('twitter_description')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="item form-group col-md-12 col-sm-12 ">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="keywords">Keywords</label>
        <div class="col-md-6 col-sm-6 ">
            <input type="text" name="keywords" class="form-control" value="{{ old('keywords', $page->keywords) }}"/>
            @error('keywords')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

