<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order_notification extends Model
{
    use SoftDeletes;

    protected $table = 'order_notifications';

    protected $fillable = [
        'order_id',
        'user_id',
        'code',
        'status',
        'service_status',
        'live_status',
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

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
