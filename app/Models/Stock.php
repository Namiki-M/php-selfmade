<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    
    protected $table = 't_stocks'; //テーブル名を変える時はこの記述が必須

    protected $fillable = [
        'product_id',
        'type',
        'quantity'
    ];

}
