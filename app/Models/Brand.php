<?php

namespace App\Models;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable=['title','slug','status','category_id'];

    // public static function getProductByBrand($id){
    //     return Product::where('brand_id',$id)->paginate(10);
    // }
    public function products(){
        return $this->hasMany('App\Models\Product','brand_id','id')->where('status','active');
    }
    public static function getProductByBrand($slug){
        return Brand::with('products')->where('slug',$slug)->first();
    }
    public function categories(){
        return $this->belongsToMany(Category::class,'brand_category',);
    }
    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public static function countActiveBrand(){
        $data=Brand::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }

    public function scopeSearch($query,$search){
        if(isset($search->search) && $search->search){
            $query->where('title','like', '%' . $search->search . '%');
        } 
    }
}
