<?php

namespace App\Http\Requests;

use App\Service;
use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('service_create');
    }

    public function rules()
    {
        return [
            'shop_id' => [
                'required',
            ],
            'dress_id' => [
                'required',
            ],
            'iron' => [
                'required',
            ],
            'wash' => [
                'required',
            ],
            'quantity' => [
                'required',
            ],
            'amount' => [
                'required',
            ],
            'delivery_time' => [
                'required',
            ],
            
        ];
    }
}
