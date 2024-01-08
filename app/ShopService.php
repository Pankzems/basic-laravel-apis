<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopService extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'shop_id',
        'service_category_id',
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

    public function service_category()
    {
        return $this->belongsTo('App\ServiceCategory');
    }

}
