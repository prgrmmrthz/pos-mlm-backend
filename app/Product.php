<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    //protected $guarded = ['id']; 
    protected $fillable = [
                'name',
                'is_for_sale',
                'available_stock',
                'class_id',
                'flooring',
                'ceiling',
                'unit_price',
                'retail_price',
                'wholesale_price',
                'supplier_id',
    ];
}
