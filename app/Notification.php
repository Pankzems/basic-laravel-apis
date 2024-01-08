<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class Notification extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'order_id',
        'type',
        'title',
        'message',
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

    public static function send_fcm_notification($message, $title, $token, $order_id){
        if(!empty($token)){
            $optionBuilder = new OptionsBuilder();
            $optionBuilder->setTimeToLive(60*20);

            $notificationBuilder = new PayloadNotificationBuilder($title);
            $notificationBuilder->setBody($message)
                                ->setSound('default');

            $dataBuilder = new PayloadDataBuilder();
            $dataBuilder->addData(['type' => 'order', 'order_id' => $order_id]);

            $option = $optionBuilder->build();
            $notification = $notificationBuilder->build();
            $data = $dataBuilder->build();

            $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
        }
        return true;

    }

}
