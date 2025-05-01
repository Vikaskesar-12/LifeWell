<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherBanner extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'title', 'slug', 'button_text', 'url', 'photo', 'category_id', 'description', 'status', 'created_at', 'updated_at'];
}
