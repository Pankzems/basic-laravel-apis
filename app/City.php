<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{

    protected $fillable = [
        'name',
        'state_id',
    ];

    public function state()
    {
        return $this->belongsTo('App\State');
    }

    public function adrresses()
    {
        return $this->hasMany('App\Address');
    }

    public function shops()
    {
        return $this->hasMany('App\Shop');
    }
    
}
