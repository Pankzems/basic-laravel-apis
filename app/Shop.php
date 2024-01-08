<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model implements \Czim\Paperclip\Contracts\AttachableInterface
{
    use SoftDeletes;
    use \Czim\Paperclip\Model\PaperclipTrait;
    
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'city_id',
        'state_id',
        'country_id',
        'zipcode',
        'lat',
        'lng',
        'image',
        'status',
    ];

    protected $appends = ['shop_image_url', 'favourite', 'phone', 'isd_code', 'average_rating', 'total_rating'];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];

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

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

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

    public function favourite_shop()
    {
        return $this->hasOne('App\Favourite_shop');
    }

    public function shop_services()
    {
        return $this->hasMany('App\ShopService');
    }

    public static function laratablesCustomAction($shop)
    {
        return view('admin.shops.action', compact('shop'))->render();
    }

    public function cart()
    {
        return $this->hasOne('App\Cart');
    }

    public static function laratablesCustomImage($shop)
    {
        return $shop->image->url();
    }

    public function getShopImageUrlAttribute() {
        return $this->image->url();
    }

    public function getFavouriteAttribute() {
        return $this->favourite_shop ? (int)$this->favourite_shop->status : 0;
    }

    public function getPhoneAttribute() {
        return $this->user->phone;
    }

    public function getIsdCodeAttribute() {
        return $this->user->isd_code;
    }

    public function review()
    {
        return $this->hasMany('App\Review');
    }

    public function getAverageRatingAttribute() {
        $avg_rating =  $this->review->avg('rating');
        return number_format($avg_rating, 2);
    }

    public function getTotalRatingAttribute() {
        return count($this->review);
    }

    
}
