<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'address_id',
        'shop_id',
        'dress_id',
        'quantity',
        'price',
        'tax',
        'total',
        'status',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    public function shop()
    {
        return $this->belongsTo('App\Shop');
    }

    public function dress()
    {
        return $this->belongsTo('App\Dress');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    
}
