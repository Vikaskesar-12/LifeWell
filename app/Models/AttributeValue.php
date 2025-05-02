<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'attribute_id',
        'value_en',
        'value_fr',
        'color',
        'text',
        'option_type',
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
