<?php

namespace App\Http\Requests;

use App\Cart;
use Illuminate\Foundation\Http\FormRequest;



class StoreCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    /*public function authorize()
    {
        return true;
    }*/

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => [
                'required',
            ],
            'shop_id' => [
                'required',
            ],
            'dress_id' => [
                'required',
            ],
            'quantity' => [
                'required',
            ],
            'price' => [
                'required',
            ],
        ];
    }
}
