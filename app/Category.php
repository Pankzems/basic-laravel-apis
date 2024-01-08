<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'status',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    public function dresses()
    {
        return $this->hasMany('App\Dress');
    }

    public static function laratablesCustomAction($category)
    {
        return view('admin.categories.action', compact('category'))->render();
    }
}

