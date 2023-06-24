<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqContents extends Model
{
    use HasFactory;

    protected $fillable = [
        'faq_category_id', 
        'question',
        'answer'
    ];

    public function faq_category()
    {
        return $this->belongsTo(FaqCategories::class, 'faq_category_id','id');
    }
}
