<?php

namespace App\Http\Requests;

use App\Dress;
use Gate;
use Illuminate\Foundation\Http\FormRequest;

class MassDestroyDressRequest extends FormRequest
{
    public function authorize()
    {
        return abort_if(Gate::denies('dress_delete'), 403, '403 Forbidden') ?? true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:dresses,id',
        ];
    }
}
