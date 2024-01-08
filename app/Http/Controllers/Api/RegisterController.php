<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\RoleUser;
use App\Role;
use App\Shop;
use App\Address;
use App\SmsVerification;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;
use App\Http\Requests;
use Tymon\JWTAuth\Exceptions\JWTException;
use Twilio\Rest\Client;
use Twilio\Jwt\ClientToken;
use Twilio\Exceptions\RestException;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        try{
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required',
            'phone' => 'required|integer|min:9|unique:users',
            'password'=> 'required',
            'isd_code' => 'required',
            'device_token' => 'required',
            'role' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['StatusCode' => '422', 'message' => $validator->errors(), 'result' => new \stdClass]);
        }
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'password' => bcrypt($request->get('password')),
            'device_token' => $request->get('device_token'),
            'isd_code' => $request->get('isd_code')
        ]);

        $role = RoleUser::create([
            'user_id' => $user->id,
            'role_id' => $request->get('role')
        ]);

        if($request->role=='3'){
            Shop::create([
                'user_id' => $user->id,
                'name' => $request->get('name')
            ]);
        }

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

        //if(!empty($status)){
            $savecode = SmsVerification::create([
                'code' => $code,
                'phone' => $request->get('phone'),
            ]);
        //}

        $token = JWTAuth::fromUser($user);
        $user = $user->load('roles');
        $user->is_phone_verified = '0';
        $user->profile_image_url = $user->profile_image->url();
        $user->token = $token;
        //$user->roles = $user->roles;

        return response()->json(['StatusCode' => '200', 'message' => 'Register successful!', 'result' => array('user' => $user)]);
        } catch(Exception $e) {
            return response()->json(['StatusCode' => '422', 'message' => $e->getMessage(), 'result' => new \stdClass]);
        }
    }


    public function sendSms(Request $request)
    {

        $accountSid = env('TWILIO_ACCOUNT_SID');
        $authToken  = env('TWILIO_AUTH_TOKEN');
        $appSid     = env('TWILIO_APP_SID');
        $from     = env('TWILIO_AUTH_FROM');
        $client = new Client($accountSid, $authToken);

        $status = $client->messages->create(
                '+61407780032',
           array(
                 'from' => $from,
                 'body' => 'Hey Ketav! It’s good to see you after long time!'
             )
         );

        print_r($status);
    }

    public function verifyphone(Request $request){
        try{
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'code' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['StatusCode' => '422', 'message' => $validator->errors(), 'result' => new \stdClass]);
        }

        $code = $request->code;
        $phone = $request->phone;

        $smsverify = SmsVerification::where('phone', '=', $phone)->orderBy('id', 'DESC')->limit(1)->first();
        if(!empty($smsverify) && $smsverify->code==$code){
            User::update_user(array('updated_at'=>date('Y-m-d H:i:s'), 'is_phone_verified'=>'1'), array('phone'=>$phone));

            SmsVerification::update_sms(array('updated_at'=>date('Y-m-d H:i:s'), 'status'=>'active'), array('phone'=>$phone, 'code' => $code));

            $user = User::where('phone', $phone)->where('is_phone_verified', '1')->first();
            $token = JWTAuth::fromUser($user);
            $user->profile_image_url = $user->profile_image->url();
            $user->token = $token;
            $user->roles = $user->roles;
            
            return response()->json([
                'StatusCode' => '200',
                'message' => 'Verify successful!',
                'result' => array('user' => $user)
            ]);

        } else {
            return response()->json(['StatusCode' => '401', 'message' => 'Invalid OTP Code', 'result' => new \stdClass], 401);
        }

        } catch(Exception $e) {
            return response()->json(['StatusCode' => '422', 'message' => $e->getMessage(), 'result' => new \stdClass]);
        }

    }

    public function resendotp(Request $request){
        try{
        
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'isd_code' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['StatusCode' => '422', 'message' => $validator->errors(), 'result' => new \stdClass]);
        }

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
            'phone' => $request->get('phone'),
        ]);

        return response()->json(['StatusCode' => '200', 'message' => 'Resend code successful!', 'result' => new \stdClass]);
        
        } catch(Exception $e) {
            return response()->json(['StatusCode' => '422', 'message' => $e->getMessage(), 'result' => new \stdClass]);
        }
    }

    public function logout(Request $request) 
    {
        // Get JWT Token from the request header key "Authorization"
        $token = $request->header('Authorization');

        // Invalidate the token
        try {
            JWTAuth::invalidate($token);

            return response()->json(['StatusCode' => '200', 'message' => 'User successfully logged out.', 'result' => new \stdClass]);
            
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['StatusCode' => '422', 'message' => 'Failed to logout, please try again.', 'result' => new \stdClass]);
            
        }
    }

    public function refresh($token = null){
         $token = $token ? $token : JWTAuth::getToken();
         if(!$token){
            return response()->json(['StatusCode' => '422', 'message' => 'Token not provided', 'result' => new \stdClass]);
         }
         try{
             $token = JWTAuth::refresh($token);
         }catch(TokenInvalidException $e){
            return response()->json(['StatusCode' => '422', 'message' => 'The token is invalid', 'result' => new \stdClass]);
         }

         $user = JWTAuth::user();
         $user->profile_image_url = $user->profile_image->url();
         $user->token = $token;
         $user->roles = $user->roles;
         return response()->json([
            'StatusCode' => '200',
            'message' => 'Token refresh successfully',
            'result' => array('user' => $user)
        ]);
    }

    public function editdetails(Request $request){
        try{
        $user = JWTAuth::user();
        $params = $request->all();
        $user->fill($params);
        $update = $user->save();

        $user = $user->load('roles');
        $user->profile_image_url = $user->profile_image->url();
        $user->token = JWTAuth::fromUser($user);

        if($update){
            return response()->json([
                'StatusCode' => '200',
                'message' => 'Details updated successfully', 
                'result' => array('user' => $user)
            ]);
        } else {
            return response()->json(['StatusCode' => '200', 
                'message' => 'Details not updated', 
                'result' => array('user' => $user)
            ]);
        }

        }catch(TokenInvalidException $e){
            return response()->json(['StatusCode' => '422', 'message' => $e->getMessage(), 'result' => new \stdClass]);
        }
    }

    public function editprofile(Request $request){
        try{
        $user = JWTAuth::user();

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'name' => 'required',
            'phone' => 'required|integer|min:9',
            'isd_code' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['StatusCode' => '422', 'message' => $validator->errors(), 'result' => new \stdClass]);
        }

        $checkExistEmail = User::where('email', $request->email)->where('id', '!=', $user->id)->first();
        if(!empty($checkExistEmail)){
            return response()->json(['StatusCode' => '422', 'message' => 'Email already exist', 'result' => new \stdClass]);
        }

        $checkExistEmail = User::where('phone', $request->phone)->where('id', '!=', $user->id)->first();
        if(!empty($checkExistEmail)){
            return response()->json(['StatusCode' => '422', 'message' => 'Phone number already exist', 'result' => new \stdClass]);
        }

        $is_phone_verified = $user->phone==$request->phone ? '1' : '0';

        $params = $request->all();
        $params['is_phone_verified'] = $is_phone_verified;

        $user->fill($params);

        $update = $user->save();

        if($is_phone_verified=='0'){
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
                'phone' => $request->get('phone'),
            ]);
        }

        $user = $user->load('roles');
        $user->profile_image_url = $user->profile_image->url();
        $user->token = JWTAuth::fromUser($user);

        if($update){
            return response()->json(['StatusCode' => '200', 'message' => 'Details updated successfully', 'result' => array('user' => $user)]);
        } else {
            return response()->json(['StatusCode' => '200', 'message' => 'Details not updated', 'result' => array('user' => $user)]);
        }

        }catch(TokenInvalidException $e){
            return response()->json(['StatusCode' => '422', 'message' => $e->getMessage(), 'result' => new \stdClass]);
        }

    }

    public function editdelprofile(Request $request){
        $user = JWTAuth::user();
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'name' => 'required',
            'phone' => 'required|integer|min:9',
            'isd_code' => 'required',
            'location' => 'required',
            'lat' => 'required',
            'lng' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['StatusCode' => '422', 'message' => $validator->errors(), 'result' => new \stdClass]);
        }

        $checkExistEmail = User::where('email', $request->email)->where('id', '!=', $user->id)->first();
        if(!empty($checkExistEmail)){
            return response()->json(['StatusCode' => '422', 'message' => 'Email already exist', 'result' => new \stdClass]);
        }

        $checkExistEmail = User::where('phone', $request->phone)->where('id', '!=', $user->id)->first();
        if(!empty($checkExistEmail)){
            return response()->json(['StatusCode' => '422', 'message' => 'Phone number already exist', 'result' => new \stdClass]);
        }

        $is_phone_verified = $user->phone==$request->phone ? '1' : '0';

        $params = $request->all();
        $params['is_phone_verified'] = $is_phone_verified;

        $userparams = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'isd_code' => $request->isd_code,
            'is_phone_verified' => $is_phone_verified,
            'profile_image' => $request->profile_image,
        ];

        $addressparams = [
            'location' => $request->location,
            'lat' => $request->lat,
            'lng' => $request->lng,
        ];

        $user->fill($userparams);
        $update = $user->save();

        $matchThese = array('user_id'=>$user->id);
        Address::updateOrCreate($matchThese,$addressparams);

        if($is_phone_verified=='0'){
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
                'phone' => $request->get('phone'),
            ]);
        }

        $user = $user->load('roles');
        $user->profile_image_url = $user->profile_image->url();
        $user->token = JWTAuth::fromUser($user);
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

        if($update){
            return response()->json(['StatusCode' => '200', 'message' => 'Details updated successfully', 'result' => array('user' => $user)]);
        } else {
            return response()->json(['StatusCode' => '200', 'message' => 'Details not updated', 'result' => array('user' => $user)]);
        }

    }

    
}
