<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'valid_from',
        'valid_to',
        'amount',
        'discount',
        'attempts',
        'duration',
        'status',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    public static function laratablesCustomAction($coupon)
    {
        return view('admin.coupons.action', compact('coupon'))->render();
    }
}
