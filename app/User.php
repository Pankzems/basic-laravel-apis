<?php

namespace App;

use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Order_notification;
use App\Notification;
use DB;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class User extends Authenticatable implements JWTSubject, \Czim\Paperclip\Contracts\AttachableInterface
{
    use SoftDeletes, Notifiable;
    use \Czim\Paperclip\Model\PaperclipTrait;

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
        'email_verified_at',
    ];

    protected $appends = ['profile_image_url'];

    protected $fillable = [  
        'name',
        'email',
        'phone',
        'password',
        'gender',
        'created_at',
        'updated_at',
        'deleted_at',
        'remember_token',
        'email_verified_at',
        'is_phone_verified',
        'device_token',
        'isd_code',
        'last_login',
        'total_login',
        'profile_image',
        'stripe_account_id',
        'stripe_bank_id',
        'service_status',
        'current_lat',
        'current_lng',
        'visibility'
    ];

     public function __construct( array $attributes = [] ) {
      $this->hasAttachedFile('profile_image');
      parent::__construct($attributes);
    }

   /* public static function boot() {
        parent::boot();
        static::retrieved(function($model) {
        $model->profile_image_url = $model->profile_image->url();
        return true;
        });
    }*/

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function role_user(){
        return $this->hasMany('App\RoleUser');
    }

    public static function laratablesCustomRoles($user)
    {
        return view('admin.users.roles', compact('user'))->render();
    }  

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function addresses()
    {
        return $this->hasMany('App\Address');
    }

    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }

    public function order_notification()
    {
        return $this->hasOne('App\Order_notification');
    }

    public function shops()
    {
        return $this->hasOne('App\Shop');
    }

    public function favourite_shop()
    {
        return $this->hasMany('App\Favourite_shop');
    }

    public static function laratablesCustomAction($user)
    {
        return view('admin.users.action', compact('user'))->render();
    }

    public static function update_user($input, $where){
        $query = User::where($where);
        if($query->update($input)) {    
            return 'true';
        } else {
            return 'false';
        }
    }

    public function hasRole( $role ) {
        $roles =  array_column($this->roles->toArray(), 'title');
        $roles = array_map('strtolower', $roles);
        return ( in_array($role, $roles) ) ? true : false ;
    }

    public function getProfileImageUrlAttribute() {
        return $this->profile_image->url();
    }

    public static function send_delivery_order_notification($lat, $lng, $orderid, $servicestatus){

        $deliveryusers = RoleUser::where('role_id', '4')->pluck('user_id');
        $orderrejectusers = Order_notification::where('order_id', $orderid)->where('status', 'reject')->pluck('user_id');

        $query = User::whereIN('id', $deliveryusers)->where('service_status', 'free');
        if(!empty($lat) && !empty($lng)){
            $circle_radius = trans('global.radius_unit') == 'km' ? trans('global.earth_radius_in_km') : trans('global.earth_radius_in_mi');
           $query =  $query->selectRaw('*, ('.$circle_radius.' * acos( cos( radians('.$lat.') ) * cos( radians( current_lat ) ) * cos( radians( current_lng ) - radians('.$lng.') ) + sin( radians('.$lat.') ) * sin( radians( current_lat ) ) ) ) AS 
           distance');
        } else {
            $query =  $query->selectRaw('*, (NULL) AS distance');
        }
        
        $deliveryussers = $query->whereNOTIN('id', $orderrejectusers)->having('distance', '<', '20')->get();

                /*->where(function($query) {
                    $query->whereNotNull('device_token')->orWhere('device_token', '!=', '');
                })
        ->orderBy('distance', 'ASC')->get();*/

        if(count($deliveryussers) > 0){
            foreach($deliveryussers as $deliveryuser){
                $code = rand(1000, 9999);
                $savecode = Order_notification::create([
                    'order_id' => $orderid,
                    'user_id' => $deliveryuser->id,
                    'code' => $code,
                    'service_status' => $servicestatus,
                ]);

                $message = trans('global.order.order_messages.new_order_msg');
                $title = 'New Order';
                $token = $deliveryuser->device_token;

                $notificationparams = [
                    'user_id' => $deliveryuser->id,
                    'title' => $title,
                    'order_id' => $orderid,
                    'type' => 'new_order',
                    'message' => $message,
                ];
                $newnotification = Notification::create($notificationparams);

                if(!empty($token)){
                    Notification::send_fcm_notification($message, $title, $token, $orderid);
                }
            }
        }

        return true;

    }

    public static function send_notification($device_token, $message){
        if(!empty($device_token)){
            $optionBuilder = new OptionsBuilder();
            $optionBuilder->setTimeToLive(60*20);

            $notificationBuilder = new PayloadNotificationBuilder('Dhobby');
            $notificationBuilder->setBody($message)->setSound('default');

            $dataBuilder = new PayloadDataBuilder();
            $dataBuilder->addData(['a_data' => 'my_data']);

            $option = $optionBuilder->build();
            $notification = $notificationBuilder->build();
            $data = $dataBuilder->build();

            $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
        }
    }


    public static function upload_stripe_document($stripekey, $accountid, $personid, $field){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/accounts/'.$accountid.'/persons/'.$personid);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $field);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $stripekey . ':' . '');

        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return $result;
    }



}
