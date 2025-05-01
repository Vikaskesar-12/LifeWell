<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'type'];

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function productValues()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }
}
