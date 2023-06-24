<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'code', 
        'first_name', 
        'last_name', 
        'gender', 
        'business_nature', 
        'phone_number', 
        'address', 
        'city', 
        'state', 
        'zip_code', 
        'country', 
        'logo', 
        'designation', 
        'company_name', 
        'company_reg_no', 
        'admin_margin', 
        'agent_margin', 
        'credit_balance'
    ];
    
    public function user(){
    	return $this->belongsTo(User::class,'user_id','id');
    }
    public function country_name(){
    	return $this->belongsTo(Countries::class,'country','id');
    }
}
