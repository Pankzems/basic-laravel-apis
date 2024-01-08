<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'shop_id',
        'user_id',
        'address_id',
        'delperson_id',
        'delperson_id2',
        'quantity',
        'price',
        'tax',
        'total',
        'status',
        'shop_order_status',
        'del_person_order_status'
    ];  

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    protected $appends = ['feedback'];

    public function order_items()
    {
        return $this->hasMany('App\OrderItem');
    }

    public function shop()
    {
        return $this->belongsTo('App\Shop')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function deliveryperson()
    {
        return $this->belongsTo('App\User', 'delperson_id', 'id')->withDefault()->withTrashed();
    }

    public function deliveryperson2()
    {
        return $this->belongsTo('App\User', 'delperson_id2', 'id')->withDefault()->withTrashed();
    }

    public function address()
    {
        return $this->belongsTo('App\Address')->withTrashed();
    }

    public function review()
    {
        return $this->hasOne('App\Review');
    }

    public function getFeedbackAttribute() {
        return $this->review ? 'yes' : 'no';
    }


}
