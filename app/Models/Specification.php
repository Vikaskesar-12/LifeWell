<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'category_id', 'name', 'type', 'created_at', 'updated_at'];

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function ProductSpec()
    {
        return $this->hasMany(ProductSpecification::class, 'name', 'name')->distinct('type');;
    }

    public function scopeSearch($query,$search){
        if(isset($search->search) && $search->search){
            $query->whereHas('category',function($query) use($search){
                $query->where('title','like', '%' . $search->search . '%');
            });
            
        } 
    }
}
