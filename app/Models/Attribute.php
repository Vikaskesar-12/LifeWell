<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'type',
        'is_required',
        'is_unique',
        'value_per_locale',
        'value_per_channel',
        'is_configurable',
        'visible_on_front',
        'is_comparable',
        'use_in_navigation',
    ];

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function productValues()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }
}
