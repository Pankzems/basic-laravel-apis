<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Favourite_shop extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'shop_id',
        'user_id',
        'status',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function shop()
    {
        return $this->belongsTo('App\Shop');
    }
}
