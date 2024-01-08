<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTFactory;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator;
use Response;
use DB;
use Stripe\Stripe;
use Config;
use App\User;

class StripeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $stripe = '';

    public function __construct(){
        $this->stripe = config('services.stripe');
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      try{
        $user = JWTAuth::user();
        $individual= [];
        $company = [];
        $individuals = [];
        $companys = [];
        if($request->account_holder_type=='individual'){
            $individual = array('first_name' => 'required', 'last_name' => 'required', 'phone' => 'required', 'day' => 'required', 'month' => 'required', 'year' => 'required', 'url' => 'required');

            $individuals = array();
        }
        if($request->account_holder_type=='company'){
            $company = array('name' => 'required', 'phone' => 'required', 'tax_id' => 'required', 'mcc' => 'required', 'url' => 'required', 'title' => 'required', 'executive' => 'required', 'first_name' => 'required', 'last_name' => 'required', 'phone' => 'required', 'day' => 'required', 'month' => 'required', 'year' => 'required',);
        }

        $address = array('line1' => 'required', 'city' => 'required', 'state' => 'required', 'postal_code' => 'required');

        $validate = [
            'email' => 'required',
            'account_holder_name' => 'required',
            'account_holder_type'=> 'required',
            'routing_number' => 'required',
            'account_number' => 'required',
        ];
        $validator = Validator::make($request->all(), array_merge($validate,$individual,$company,$address));

        if ($validator->fails()) {
            return response()->json(['StatusCode' => '422', 'message' => $validator->errors(), 'result' => new \stdClass]);
        }

        Stripe\Stripe::setApiKey($this->stripe['secret']);

        /*if($request->account_holder_type=='company'){
            $account = Stripe\Account::create([
                "type" => "custom",
                "country" => "AU",
                "email" => $request->email,
                'type' => 'custom',
                "business_type" => $request->account_holder_type,
                "requested_capabilities" => ["card_payments", "transfers"],
                'company' => [
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'tax_id' => $request->tax_id,
                    'address' => [
                        'city' => $request->city,
                        'line1' => $request->line1,
                        'postal_code' => $request->postal_code,
                        'state' => $request->state,
                    ],
                ],
                'business_profile' => [
                    'mcc' => $request->mcc,
                    'url' => $request->url,
                ],
                'tos_acceptance' => [
                    'date' => time(),
                    'ip' => $_SERVER['REMOTE_ADDR']
                ],
                'relationship' => [
                  'title' => $request->title,
                  'executive' => $request->executive,
                  'first_name' => $request->first_name,
                  'last_name' => $request->last_name,
                  'email' => $request->email,
                  'phone' => $request->phone,
                  'address' => [
                    'city' => $request->city,
                    'line1' => $request->line1,
                    'postal_code' => $request->postal_code,
                    'state' => $request->state,
                  ],
                  'dob' => [
                    'day' => $request->day,
                    'month' => $request->month,
                    'year' => $request->year,
                  ],
                ],
            ]);
        }*/

        if($request->account_holder_type=='individual'){
            $account = Stripe\Account::create([
                "type" => "custom",
                "country" => "AU",
                "email" => $request->email,
                "business_type" => $request->account_holder_type,
                'type' => 'custom',
                "requested_capabilities" => ["card_payments", "transfers"],
                'individual' => [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'dob' => [
                        'day' => $request->day,
                        'month' => $request->month,
                        'year' => $request->year,
                    ],
                    'address' => [
                        'city' => $request->city,
                        'line1' => $request->line1,
                        'postal_code' => $request->postal_code,
                        'state' => $request->state,
                    ]
                ],
                'business_profile' => [
                    'mcc' => $request->mcc,
                    'url' => $request->url,
                ],
                'tos_acceptance' => [
                    'date' => time(),
                    'ip' => $_SERVER['REMOTE_ADDR']
                ]
            ]);

        }

        $bank = Stripe\Token::create([
          'bank_account' => [
            'country' => 'AU',
            'currency' => 'AUD',
            'account_holder_name' => $request->account_holder_name,
            'account_holder_type' => $request->account_holder_type,
            'routing_number' => $request->routing_number,
            'account_number' => $request->account_number,
          ]
        ]);

       if(!empty($account) && !empty($bank)){
        $bank_account = Stripe\Account::createExternalAccount(
          $account->id,
          [
            'external_account' => $bank->id,
          ]
        );

        if(!empty($bank_account)){

          if($request->account_holder_type=='individual'){
            User::update_user(array('stripe_account_id'=>$bank_account->account, 'stripe_bank_id'=>$bank_account->id, 'stripe_person_id'=>$account->individual->id, 'stripe_user_details' => $account), array('id'=>$user->id));
          } else {
              User::update_user(array('stripe_account_id'=>$bank_account->account, 'stripe_bank_id'=>$bank_account->id, 'stripe_user_details' => $account), array('id'=>$user->id));
          }
            

            return response()->json([
                'StatusCode' => '200',
                'message' => 'Account add successfully',
                'result' => array('bank_account' => $bank_account, 'account' => $account)
            ]);

        } else {

            return response()->json([
                'StatusCode' => '403',
                'message' => 'Account not added',
                'result' => array()
            ]);
        }
        

        } else {
            return response()->json([
                'StatusCode' => '403',
                'message' => 'Account not added',
                'result' => array()
            ]);
        }
       
        } catch (\Exception $e) {
            return response()->json([
                'StatusCode' => '500',
                 'message' => $e->getMessage(), 
                 'result' => new \stdClass
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function uploaddocument(Request $request)
    {
      try{
      $user = JWTAuth::user();
      Stripe\Stripe::setApiKey($this->stripe['secret']);

      $validate = [
          'document_front' => 'required',
          'document_back' => 'required',
          'additional_document_front'=> 'required',
      ];
      $validator = Validator::make($request->all(), $validate);

      if ($validator->fails()) {
          return response()->json(['StatusCode' => '422', 'message' => $validator->errors(), 'result' => new \stdClass]);
      }

      if(!empty($request->document_front)){
        $file = Stripe\File::create(
          [
            'purpose' => 'identity_document',
            'file' => fopen($request->document_front, 'r')
          ],
          ['stripe_account' => $user->stripe_account_id]
        );
        $field = "verification[document][front]=".$file->id;
        User::upload_stripe_document($this->stripe['secret'], $user->stripe_account_id, $user->stripe_person_id, $field);
      }

      if(!empty($request->document_back)){
        $file = Stripe\File::create(
          [
            'purpose' => 'identity_document',
            'file' => fopen($request->document_back, 'r')
          ],
          ['stripe_account' => $user->stripe_account_id]
        );
        $field = "verification[document][back]=".$file->id;
        User::upload_stripe_document($this->stripe['secret'], $user->stripe_account_id, $user->stripe_person_id, $field);
      }

      if(!empty($request->additional_document_front)){
        $file = Stripe\File::create(
          [
            'purpose' => 'identity_document',
            'file' => fopen($request->additional_document_front, 'r')
          ],
          ['stripe_account' => $user->stripe_account_id]
        );
        $field = "verification[additional_document][front]=".$file->id;
        User::upload_stripe_document($this->stripe['secret'], $user->stripe_account_id, $user->stripe_person_id, $field);
      }

      if(!empty($request->additional_document_back)){
        $file = Stripe\File::create(
          [
            'purpose' => 'identity_document',
            'file' => fopen($request->additional_document_back, 'r')
          ],
          ['stripe_account' => $user->stripe_account_id]
        );
        $field = "verification[additional_document][back]=".$file->id;
        User::upload_stripe_document($this->stripe['secret'], $user->stripe_account_id, $user->stripe_person_id, $field);
      }

      $accountdetails = Stripe\Account::retrieve($user->stripe_account_id);
      return response()->json([
          'StatusCode' => '200',
          'message' => 'document uploads successfully',
          'result' => array('stripe_account' => $accountdetails)
      ]);

      } catch (\Exception $e) {
          return response()->json([
              'StatusCode' => '500',
               'message' => $e->getMessage(), 
               'result' => new \stdClass
          ]);
      }
      
    }

    public function payamount(Request $request)
    {
        Stripe\Stripe::setApiKey($this->stripe['secret']);

        /*$card = Stripe\Token::create([
          'card' => [
            'number' => '5105105105105100',
            'exp_month' => 10,
            'exp_year' => 2020,
            'cvc' => '314'
          ]
        ]);*/

        $code = rand(100000, 999999);

       /* $charge1 = \Stripe\PaymentIntent::create([
            'amount' => 1000,
            'currency' => 'aud',
            'payment_method_types' => ['card'],
        ], [
            'stripe_account' => 'acct_1FOjAgEjrI2PGG7b'
        ]);
        $charge = Stripe\Charge::create([
          "amount" => 1000,
          "currency" => "aud",
          "source" => $card->id,
          "transfer_group" => $code,
        ]);*/

        // Create a Transfer to a connected account (later):
        $transfer = Stripe\Transfer::create([
          "amount" => 700,
          "currency" => "aud",
          "destination" => "acct_1FQt1TEcDeyEgYsL",
        ]);

        /*echo '<pre>';
        print_r($card);
        echo '</pre>';*/
        echo '<pre>';
        print_r($transfer);
        echo '</pre>';
        /*echo '<pre>';
        print_r($transfer);
        echo '</pre>';*/
    }
}
