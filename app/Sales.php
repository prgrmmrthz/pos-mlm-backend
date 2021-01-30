<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sales extends Model
{
    use SoftDeletes;
    //protected $guarded = ['id']; 
    protected $fillable = [
        'customer_id',
        'subtotal',
        'less',
        'total',
        'mode',
        'user'
    ];
}
