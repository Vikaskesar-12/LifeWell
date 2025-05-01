<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSpecification extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'product_id', 'name','type','created_at', 'updated_at'];
    public function ProductVariants(){
        return $this->belongsTo(ProductVariant::class,'product_id');
    }

}
