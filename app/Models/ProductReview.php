<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $fillable=['user_id','product_id','rate','review','status'];

    public function user_info(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public static function getAllReview(){
        return ProductReview::with('user_info')->paginate(10);
    }
    public static function getAllUserReview(){
        return ProductReview::where('user_id',auth()->user()->id)->with('user_info')->paginate(10);
    }

    public function product(){
        return $this->hasOne(Product::class,'id','product_id')->with('productImage');
    }

    public function scopeSearch($query,$search){
        if(isset($search->search) && $search->search){
            $query->whereHas('product',function($query) use($search){
                $query->where('title','like', '%' . $search->search . '%');
            });
        } 
    }

}
