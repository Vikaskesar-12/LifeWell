<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable=['id', 'about_us', 'privacy_policy', 'return_policy', 'logo', 'address', 'phone', 'email', 'created_at', 'updated_at'];
}
