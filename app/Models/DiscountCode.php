<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCode extends Model
{
    use HasFactory;

    // Agar table ka naam custom hai to yeh specify karo
    protected $table = 'discount_codes';

    // Fillable fields jo mass-assignment ke liye allowed hain
    protected $fillable = [
        'code',
        'type',
        'value', // or 'value' if you prefer
        'start_date',
        'end_date',
        'usage_limit',
        'used_count',
        'is_active', // Add 'is_active' here
    ];
    
    

    // Casts (optional) - date formatting or boolean conversion
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        // 'is_active' => 'boolean',
    ];
}
