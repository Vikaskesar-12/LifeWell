<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable=['id', 'first_name', 'last_name', 'email', 'message', 'status', 'created_at', 'updated_at'];

    public function scopeSearch($query,$search){
        if(isset($search->search) && $search->search){
            $query->where('first_name','like', '%' . $search->search . '%');
        } 
    }
}
