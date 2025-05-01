<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'question','answer','created_at', 'updated_at',
    ];

    public function scopeSearch($query,$search){
        if(isset($search->search) && $search->search){
            $query->where('question','like', '%' . $search->search . '%');
        } 
    }
}
