<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'meta_title', 'meta_keywords','meta_description','status'
    ];

    // public static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($page) {
    //         $page->slug = Str::slug($page->title);
    //     });
    // }
}


