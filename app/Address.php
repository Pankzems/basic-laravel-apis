<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'house_no',
        'location',
        'landmark',
        'city_id',
        'state_id',
        'country_id',
        'zipcode',
        'lat',
        'lng',
        'current',
        'status',
        'type',
        'other_name'
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

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function state()
    {
        return $this->belongsTo('App\State');
    }

    public function country()
    {
        return $this->belongsTo('App\Country');
    }


}
