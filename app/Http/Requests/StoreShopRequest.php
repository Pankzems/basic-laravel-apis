<?php

namespace App\Http\Requests;

use App\Shop;
use Illuminate\Foundation\Http\FormRequest;

class StoreShopRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('shop_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
            ],
            'user_id' => [
                'required',
            ],
            'address' => [
                'required',
            ],
            'city_id' => [
                'required',
            ],
            'state_id' => [
                'required',
            ],
            'country_id' => [
                'required',
            ],
            'zipcode' => [
                'required',
            ],
            'lat' => [
                'required',
            ],
            'lng' => [
                'required',
            ],
        ];
    }
}
