<?php

namespace App\Http\Requests;

use App\Shop;
use Gate;
use Illuminate\Foundation\Http\FormRequest;

class MassDestroyShopRequest extends FormRequest
{
    public function authorize()
    {
        return abort_if(Gate::denies('shop_delete'), 403, '403 Forbidden') ?? true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:shops,id',
        ];
    }
}
