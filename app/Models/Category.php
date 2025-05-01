<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable=['title_en','title_fr','slug_en','slug_fr','summary_en','summary_fr','photo','status','is_parent','parent_id','added_by','icon','hot_sale','category_banner','price_filter'];

    public function parent_info(){
        return $this->hasOne(Category::class,'id','parent_id');
    }
    public static function shiftChild($cat_id){
        return Category::whereIn('id',$cat_id)->update(['is_parent'=>1]);
    }
    public static function getChildByParentID($id){
        return Category::where('parent_id',$id)->orderBy('id','ASC')->pluck('title_en','id');
    }
    public function child_cat(){
        return $this->hasMany('App\Models\Category','parent_id','id')->where('status','active');
    }
    public static function getAllParentWithChild(){
        return Category::with('child_cat')->where('is_parent',1)->where('status','active')->orderBy('title_en','ASC')->get();
    }
    public function products(){
        return $this->hasMany(Product::class,'cat_id','id')->where('status','active');
    }
    public function sub_products(){
        return $this->hasMany('App\Models\Product','child_cat_id','id')->where('status','active');
    }
    public static function getProductByCat($slug){
        return Category::with('products')->where('slug',$slug)->first();
    }
    public static function getProductBySubCat($slug){
        // return $slug;
        return Category::with('sub_products')->where('slug',$slug)->first();
    }
    public static function countActiveCategory(){
        $data=Category::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }
    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'brand_category');
    }

    public function scopeSearch($query,$search){
        if(isset($search->search) && $search->search){
            $query->where('title','like', '%' . $search->search . '%');
        } 
    }
}
