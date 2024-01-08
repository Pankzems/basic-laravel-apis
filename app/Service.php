<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'shop_id',
        'dress_id',
        'address',
        'quantity',
        'iron',
        'wash',
        'amount',
        'delivery_time',
        'status',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    /*public static function boot() {
        parent::boot();
        static::retrieved(function($model) {
        $model->category = $model->dress->category->name;
        return true;
        });
    }*/

    public function shop()
    {
        return $this->belongsTo('App\Shop');
    }

    public function dress()
    {
        return $this->belongsTo('App\Dress');
    }

    public static function laratablesCustomAction($service)
    {
        return view('admin.services.action', compact('service'))->render();
    }


    

}
