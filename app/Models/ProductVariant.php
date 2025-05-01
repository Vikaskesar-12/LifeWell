<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'title', 'product_id','slug','base_price', 'price', 'stock', 'collection', 'discount', 'status', 'created_at', 'updated_at'];

    public function productSpecification(){
        return $this->hasMany(ProductSpecification::class,'product_id','id');
    }
    public function productImage(){
        return $this->hasOne(ProductImage::class,'product_id','id');
    }

    public function productImages(){
        return $this->hasMany(ProductImage::class,'product_id','id');
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function collection()
    {
        return $this->belongsToMany(Collection::class,'product_collection','Product_variant_id','collection_id');
    }

    // public function collection()
    // {
    //     return $this->belongsToMany(collection::class, 'product_collection');
    // }

    public function scopeSearch($query,$search){
        if(isset($search->search) && $search->search){
            $query->where('title','like', '%' . $search->search . '%');
        } 
    }
    public function scopeFilter($query,$search){
        if(isset($search->search) && $search->search){
            $query->where('title','like', '%' . $search->search . '%');
        }
        if(isset($search->category) && $search->category){
            $category     = Category::whereIn('slug',$search->category)->pluck('id')->toArray();
            $query->whereHas('product',function($query) use($category){
                $query->whereIn('child_cat_id',$category);
            }); 
        }
        if(isset($search->sort) && $search->sort){
            $sort = $search->sort == 'price_desc' ? 'desc'  : 'asc';
            if($search->sort == 'new_arrivals'){
                $query->latest();
            }else{
                $query->orderBy('price', $sort);
            }
        }
        if(isset($search->price_max) && $search->price_max){
            $min = $search->price_min;
            $max = $search->price_max;
            $query->where('price','>=',$min)->where('price','<=',$max);
        }
        if(isset($search->rating) && is_array($search->rating)){
            $rating = $search->rating;
            $query->whereHas('product',function($queries) use($rating){
                $queries->whereHas('getReview',function($query) use($rating){
                    $query->whereIn('rate',$rating);
                });
            });
        }
        if (is_array($search->specification) && !empty($search->specification)) {
            $specifications = $search->specification;
            foreach ($specifications as $name => $specification) {
                $query->whereHas('productSpecification', function($subQuery) use ($specification,$name) {
                    foreach($specification as $spec){
                        $subQuery->where('name', $name)->whereRaw("FIND_IN_SET(?, type)", [$spec]);
                    }
                });
            }
        }
        
    }
}
