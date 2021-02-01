<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    //protected $guarded = ['id']; 
    protected $fillable = [
        'sales_id',
        'product_id',
        'price',
        'quantity',
        'subtotal',
        'user'
    ];
}
