<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Product;
use App\Models\Message;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'postal_code',
        'pref_id', 'city',
        'town',
        'building',
        'phone_number',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function histories(){
        return $this->belongsToMany(Shop::class, 'purchase_histories')
        ->withPivot(['id', 'quantity']);
    }

    public function products(){
        return $this->belongsToMany(Product::class, 'carts')
        ->withPivot(['id', 'quantity']);
    }



 


    // チャット練習用１対多
    // public function messages()
    // {
    //     return $this->hasMany(Messages::class);
    // }
}
