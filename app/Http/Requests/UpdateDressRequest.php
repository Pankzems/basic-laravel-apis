<?php

namespace App\Http\Requests;

use App\Dress;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDressRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('dress_edit');
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
