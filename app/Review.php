<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'shop_id',
        'user_id',
        'order_id',
        'rating',
        'comment',
        'status',
    ];  

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    public function shop()
    {
        return $this->belongsTo('App\Shop');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }


}
