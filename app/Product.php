<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    //protected $guarded = ['id']; 
    protected $fillable = [
        'name',
        'regular_price',
        'is_for_sale',
        'available_stock'
    ];
}
