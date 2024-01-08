<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Address;
use App\SmsVerification;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;
use App\Http\Requests;
use Tymon\JWTAuth\Exceptions\JWTException;
use Password;
use Hash;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

use Twilio\Rest\Client;
use Twilio\Jwt\ClientToken;
use Twilio\Exceptions\RestException;

class LoginController extends Controller
{
    public function login(Request $request){
        try{
        $validator = Validator::make($request->all(), [
            //'email' => 'required|string|email|max:255',
            'phone' => 'required',
            'password'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'StatusCode' => '422', 
                'message' => $validator->errors(), 
                'result' => new \stdClass
            ]);
        }
        //$credentials = $request->only('email', 'password');
        $credentials = $request->only('phone', 'password');
        $device_token = $request->device_token;
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'StatusCode' => '401', 
                    'message' => 'Invalid credentials',
                    'result' => new \stdClass
                ]);
            }
        } catch (JWTException $e) {
            return response()->json([
                'StatusCode' => '500',
                 'message' => 'Could not create token', 
                 'result' => new \stdClass
             ]);
        }

        $user = JWTAuth::user();

        $user_id = $user->id;
        $user->profile_image_url = $user->profile_image->url();
        $user->token = $token;
        //$user->roles = $user->roles;
        if( $user->roles->where('id', 4)->count() ) {
            $query = Address::where('user_id', $user->id);
            if($query->count() > 0){
                $address = $query->first();
                $user->location = $address->location;
                $user->lat = $address->lat;
                $user->lng = $address->lng;
            } else {
                $user->location = '';
                $user->lat = '';
                $user->lng = '';
            }
        }
        $total_login = $user->total_login + 1;
        $user->total_login = $total_login;
        $user->device_token = $device_token;
        $user->last_login = date('Y-m-d H:i:s');
        User::update_user(array('last_login'=>date('Y-m-d H:i:s'), 'total_login'=>$total_login, 'device_token'=>$device_token), array('id'=>$user_id));

        return response()->json([
            'StatusCode' => '200', 
            'message' => 'Login successful!', 
            'result' => array('user' => $user)
        ]);

        } catch(Exception $e) {
            return response()->json(['StatusCode' => '422', 'message' => $e->getMessage(), 'result' => new \stdClass]);
        }
    }

    public function changepassword(Request $request){

        $user = JWTAuth::user();

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',            
            'new_password' => 'required|min:6',
            'confirm_password' => 'required_with:new_password|same:new_password|min:6'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'StatusCode' => '422', 
                'message' => $validator->errors(), 
                'result' => new \stdClass
            ]);
        }

        if(!Hash::check($request->current_password, $user->password)){
            return response()->json([
                'StatusCode' => '422', 
                'message' => 'Current passowrd is not match', 
                'result' => new \stdClass
            ]);
        }

        User::update_user(array('password'=>Hash::make($request->new_password)), array('id'=>$user->id));

        $user = $user->load('roles');
        $user->profile_image_url = $user->profile_image->url();
        $user->token = JWTAuth::fromUser($user);
        return response()->json([
            'StatusCode' => '200', 
            'message' => 'Change password successfully', 
            'result' => array('user' => $user)
        ]);
    }

    public function testfcm(){
        //echo trans('global.order.order_messages.del_accept_msg'); 

    $optionBuilder = new OptionsBuilder();
    $optionBuilder->setTimeToLive(60*20);

    $notificationBuilder = new PayloadNotificationBuilder('New Order');
    $notificationBuilder->setBody('Please check you have new order.')
                        ->setSound('default');

    $dataBuilder = new PayloadDataBuilder();
    $dataBuilder->addData(['a_data' => 'my_data']);

    $option = $optionBuilder->build();
    $notification = $notificationBuilder->build();
    $data = $dataBuilder->build();

    $token = "fEcG7cvDzjk:APA91bH74x1WhAZiePkewTnoClqG4pnzcZLpdBJmPYl62cs0j-U4AkkRz_USOkkMas2ZqZlYeo05MU5aYdytbQYX8nue8PcCq9rOwJbeeex9171MRD0j-uvOaGmGJbVZNVcNWy4YVKBG";

    $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
    print_r($downstreamResponse);die();

   
    

    }

    public function forgotpassword(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required',
                'isd_code' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['StatusCode' => '422', 'message' => $validator->errors(), 'result' => new \stdClass]);
            }

            $userexist = User::where('phone', $request->phone)->first();
            if(empty($userexist)){
                return response()->json([
                    'StatusCode' => '422', 
                    'message' => 'Phone number not exist', 
                    'result' => new \stdClass
                ]);
            } else {
                $code = rand(1000, 9999);
                $phone = $request->get('phone');
                $isd_code = $request->get('isd_code');

                $accountSid = env('TWILIO_ACCOUNT_SID');
                $authToken  = env('TWILIO_AUTH_TOKEN');
                $appSid     = env('TWILIO_APP_SID');
                $from     = env('TWILIO_AUTH_FROM');
                
                /*try{
                    $client = new Client($accountSid, $authToken);
                    $client->messages->create(
                            $isd_code.$phone,
                       array(
                             'from' => $from,
                             'body' => 'Your OTP for Dhoby is '.$code
                         )
                     );

                } catch(RestException $e) {
                    return response()->json(['StatusCode' => '422', 'message' => $e->getMessage(), 'result' => new \stdClass]);
                }*/
                
                $savecode = SmsVerification::create([
                    'code' => $code,
                    'phone' => $phone,
                ]);

                return response()->json([
                    'StatusCode' => '200', 
                    'message' => 'OTP send successfully', 
                    'result' => new \stdClass
                ]);
            }

        } catch (\Exception $e) {
            return response()->json(['StatusCode' => '422', 'message' => $e->getMessage(), 'result' => new \stdClass]);
        }
    }

    public function verifycode(Request $request){
        try {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'code' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['StatusCode' => '422', 'message' => $validator->errors(), 'result' => new \stdClass]);
        }

        $code = $request->code;
        $phone = $request->phone;

        $smsverify = SmsVerification::where('phone', '=', $phone)->where('status', 'pending')->orderBy('id', 'DESC')->limit(1)->first();
            if(!empty($smsverify) && $smsverify->code==$code){

                SmsVerification::update_sms(array('updated_at'=>date('Y-m-d H:i:s'), 'status'=>'verify'), array('phone'=>$phone, 'code' => $code));

                return response()->json([
                    'StatusCode' => '200',
                    'message' => 'Code verify successful!',
                    'result' => new \stdClass
                ]);

            } else {
                return response()->json([
                    'StatusCode' => '401', 
                    'message' => 'Invalid OTP Code', 
                    'result' => new \stdClass
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['StatusCode' => '422', 'message' => $e->getMessage(), 'result' => new \stdClass]);
        }
    }

    public function resetpassword(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'phone' => 'required',
                'new_password' => 'required|min:6',
                'confirm_password' => 'required_with:new_password|same:new_password|min:6'
            ]);

            if ($validator->fails()) {
                return response()->json(['StatusCode' => '422', 'message' => $validator->errors(), 'result' => new \stdClass]);
            }

            $phone = $request->phone;

            $codeverify = SmsVerification::where('phone', '=', $phone)->orderBy('id', 'DESC')->limit(1)->first();
            if(!empty($codeverify) && $codeverify->status=='verify'){

                User::update_user(array('password'=>Hash::make($request->new_password)), array('phone'=>$phone));

                SmsVerification::update_sms(array('updated_at'=>date('Y-m-d H:i:s'), 'status'=>'reset'), array('id'=>$codeverify->id));

                return response()->json([
                    'StatusCode' => '200',
                    'message' => 'Password reset successful!',
                    'result' => new \stdClass
                ]);

            } else {
                return response()->json([
                    'StatusCode' => '401', 
                    'message' => 'Please verify your code', 
                    'result' => new \stdClass
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['StatusCode' => '422', 'message' => $e->getMessage(), 'result' => new \stdClass]);
        }
    }

    public function logout(Request $request){
        $user = JWTAuth::user();
        $id = $user->id;
        User::update_user(array('device_token'=>NULL), array('id'=>$id));
        JWTAuth::invalidate();
        return response()->json([
            'StatusCode' => '200',
            'message' => 'Logged out Successfully.',
            'result' => new \stdClass
        ]);
        
    }

}
