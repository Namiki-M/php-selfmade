<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'shop_id',
        'quantity',
        'price',
    ];

    // public function shop(){
    //     return $this->belongsTo(Shop::class);
    // }

    // public function user(){
    //     return $this->belongsTo(User::class);
    // }

    // public function owner(){
    //     return $this->belongsTo(Owner::class);
    // }
    
    // public function product(){
    //     return $this->belongsTo(Owner::class);
    // }


}
