<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = [
        'id', // Optional – only if you're manually filling it
        'logo',
        'favicon',
        'site_title',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'address',
        'phone',
        'email',
        'facebook',
        'twitter',
        'instagram',
        'linkedin'
    ];
    
}
