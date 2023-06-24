<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Storage;
use Str;

class Pages extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_type', 
        'page_name', 
        'page_title', 
        'page_description', 
        'image', 
        'image_alt', 
        'seo_url', 
        'seo_title', 
        'seo_description', 
        'og_title', 
        'og_description', 
        'twitter_title', 
        'twitter_description', 
        'keywords'
    ];

    public function getImage()
    {
        return Storage::url(Str::replace('/storage/', '', $this->image));
    }
    
}
