<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
       'id', 'name', 'email', 'email_verified_at','mobile','password', 'photo', 'role', 'provider', 'provider_id', 'status', 'remember_token', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function scopeSearch($query,$search){
        if(isset($search->search) && $search->search){
            $query->where('name','like', '%' . $search->search . '%');
        } 
    }
    public function wishList(){
        return $this->hasMany(WishList::class,'user_id')->with('product');
    }

    public function cart(){
        return $this->hasMany(Cart::class,'user_id')->with('product');
    }
}
