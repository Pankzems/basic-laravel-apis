<?php

namespace App\Http\Requests;

use App\Dress;
use Illuminate\Foundation\Http\FormRequest;

class StoreDressRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('dress_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
            ],
            'category_id' => [
                'required',
            ],
        ];
    }
}
