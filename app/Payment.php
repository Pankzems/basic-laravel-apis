<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    protected $fillable = [  
        'user_id',
        'txn_id',
        'charge_id',
        'order_id',
        'amount',
        'receipt_url',
        'status',
        'transfer_group',
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
