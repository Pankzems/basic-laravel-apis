<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => false,

    'http' => [
        'server_key' => 'AAAA5LVIRIU:APA91bG3HFfnFeSQ8TBkUI-wDlB__J32HyUAA2K7ucic-OfQX_JYK7RVmBtG3jKOhnQkE601CPJS7BxeQWDRlyEQXBGD0NJUMkqFMWRv3T9tQb30x3c_2BcHhS6krbUKVmw4AiWNGUda',
        'sender_id' => '7696084848',
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'timeout' => 30.0, // in second
    ],
];
