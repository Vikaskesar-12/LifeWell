<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;
    protected $fillable = ['title','status'];

    public function scopeSearch($query,$search){
        if(isset($search->search) && $search->search){
            $query->where('title','like', '%' . $search->search . '%');
        } 
    }
}
