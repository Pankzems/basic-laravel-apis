<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dress extends Model implements \Czim\Paperclip\Contracts\AttachableInterface
{
	use SoftDeletes;
    use \Czim\Paperclip\Model\PaperclipTrait;

    protected $fillable = [
        'name',
        'category_id',
        'image',
        'status',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    protected $appends = ['dress_image_url'];

    public function __construct( array $attributes = [] ) {
      $this->hasAttachedFile('image');
      parent::__construct($attributes);
    }

    /*public static function boot() {
        parent::boot();
        static::retrieved(function($model) {
        $model->image_url = $model->image->url();
        return true;
        });
    }*/

    public function services()
    {
        return $this->hasMany('App\Service');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function cart(){
        return $this->hasOne('App\Cart')->withDefault(new \stdClass);
    }

    public function order_items()
    {
        return $this->hasMany('App\OrderItem');
    }

    public static function laratablesCustomAction($dress)
    {
        return view('admin.dresses.action', compact('dress'))->render();
    }

    public function getDressImageUrlAttribute() {
        return $this->image->url();
    }


}
