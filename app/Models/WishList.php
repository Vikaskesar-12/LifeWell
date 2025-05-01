<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{
    use HasFactory;
    protected $fillable=['user_id','product_variant_id','cart_id'];

    public function product(){
        return $this->belongsTo(ProductVariant::class,'product_variant_id');
    }
}
