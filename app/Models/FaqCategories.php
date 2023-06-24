<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqCategories extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name', 
        'is_active'
    ];

    public function question_answers()
    {
        return $this->hasMany(FaqContents::class,'faq_category_id');
    }
}
