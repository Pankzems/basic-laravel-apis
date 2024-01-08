<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use SoftDeletes;

    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'dress_id',
        'quantity',
        'price',
        'status',
    ];  

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function dress()
    {
        return $this->belongsTo('App\Dress');
    }
}
