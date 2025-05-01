<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;
class Product extends Model
{
    protected $fillable=[
        'title_en','title_fr','slug_en','slug_fr','summary_en','summary_fr','description_en','description_fr','return_policy_en','return_policy_fr','on_sale','top_rated','cat_id','child_cat_id','price','brand_id','discount','status','photo',
        'size','stock','is_featured','condition','deal_of_the_day','best_seller','old_price','price_type','b2b_price','b2c_price','country_ability','discount_price','discount_start_date','discount_end_date','minimum_order_quantity'
    ];

    // Product model
public function productSpecification()
{
    // Assuming a product has one product specification, adjust the relation type as needed (e.g., hasMany, belongsTo)
    return $this->hasOne(ProductSpecification::class);  // Change `hasOne` to `hasMany` if there are multiple specifications
}

    
public function productImages()
{
    return $this->hasMany(ProductImage::class);  // Assuming product has many images
}




public function attributeValues()
{
    return $this->hasMany(ProductAttributeValue::class);
}



// App\Models\Product.php

// public function category()
// {
//     return $this->belongsTo(Category::class, 'category_id');
// }

public function getPriceTypeTextAttribute()
{
    return match($this->price_type){
        '0' => 'B2B',
        '1' => 'B2C',
        '2' => 'Both',
        default => 'Unknown', // Ensure default is 'Unknown' for anything else
    };
}


public function getCountryAbilityTextAttribute()
{
    return match($this->country_ability){
        '0' => 'India',
        '1' => 'Other',
        '2' => 'All',
        default => 'Unknown', // Ensure default is 'Unknown' for anything else
    };
}


   
    public function cat_info(){
        return $this->hasOne(Category::class,'id','cat_id');
    }
    public function sub_cat_info(){
        return $this->hasOne(Category::class,'id','child_cat_id');
    }




    public static function getAllProduct(){
        return Product::with(['cat_info','sub_cat_info'])->orderBy('id','desc')->paginate(10);
    }
    public function rel_prods(){
        return $this->hasMany('App\Models\Product','cat_id','cat_id')->where('status','active')->orderBy('id','DESC')->limit(8);
    }
    public function getReview(){
        return $this->hasMany('App\Models\ProductReview','product_id','id')->with('user_info')->where('status','active')->orderBy('id','DESC');
    }
    public static function getProductBySlug($slug){
        return Product::with(['cat_info','rel_prods','getReview'])->where('slug',$slug)->first();
    }
    public static function countActiveProduct(){
        $data=Product::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }

    // public function carts(){
    //     return $this->hasMany(Cart::class)->whereNotNull('order_id');
    // }

    // public function wishlists(){
    //     $auth = auth()->user() ? auth()->user()->id : null;
    //     return $this->hasOne(Wishlist::class)->where('user_id',$auth);
    // }
    
    public function variant(){
        return $this->hasMany(ProductVariant::class)->with('productSpecification');
    }

    public function brand(){
        return $this->hasOne(Brand::class,'id','brand_id');
    }

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
            $query->whereIn('child_cat_id',$category);
        }
        if(isset($search->sort) && $search->sort){
            $sort = $search->sort == 'price_desc' ? 'desc'  : 'asc';
            if($search->sort == 'new_arrivals'){
                $query->latest();
            }else{
                $query->orderBy('price', $sort);
            }
        }
        if(isset($search->rating) && is_array($search->rating)){
            $rating = $search->rating;
            $query->whereHas('getReview',function($query) use($rating){
                $query->whereIn('rate',$rating);
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
        // if(is_array($search->specification) && !empty($search->specification)){
        //     $specifications = $search->specification;
        //     $query->whereHas('productSpecification',function($query) use($specifications){
        //         // $names = array_keys($specifications);
        //         // $query->whereIn('name',$names);
        //         foreach($specifications as $name => $specification){
        //             foreach($specification as $spec){
        //                 $query->where('name',$name)->whereRaw("FIND_IN_SET(?, type)", [$spec]);
        //             }
                    
        //         }
        //     });
        // }

        
    }

    public function scopeCustom($query,$search){
        if(auth()->check()){
            $query->with('wishlists');
        }
    }




}
