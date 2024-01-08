<?php

namespace App\Http\Requests;

use App\Service;
use Illuminate\Foundation\Http\FormRequest;

class StoreCouponRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('service_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
            ],
            'code' => [
                'required',
            ],
            'valid_from' => [
                'required',
            ],
            'valid_to' => [
                'required',
            ],
            'amount' => [
                'required',
            ],
            'discount' => [
                'required',
            ],
            'attempts' => [
                'required',
            ],
            'duration' => [
                'required',
            ],
        ];
    }
}
