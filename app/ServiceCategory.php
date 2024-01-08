<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    protected $fillable = [
        'name',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
    ];
}
