@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('global.coupon.title') }}
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        {{ trans('global.coupon.fields.name') }}
                    </th>
                    <td>
                        {{ $coupon->name }}
                    </td>
                </tr>

                <tr>
                    <th>
                        {{ trans('global.coupon.fields.code') }}
                    </th>
                    <td>
                        {{ $coupon->code }}
                    </td>
                </tr>

                <tr>
                    <th>
                        {{ trans('global.coupon.fields.valid_from') }}
                    </th>
                    <td>
                        {{ $coupon->valid_from }}
                    </td>
                </tr>

                <tr>
                    <th>
                        {{ trans('global.coupon.fields.valid_to') }}
                    </th>
                    <td>
                        {{ $coupon->valid_to }}
                    </td>
                </tr>

                <tr>
                    <th>
                        {{ trans('global.coupon.fields.amount') }}
                    </th>
                    <td>
                        {{ $coupon->amount }}
                    </td>
                </tr>

                <tr>
                    <th>
                        {{ trans('global.coupon.fields.discount') }}
                    </th>
                    <td>
                        {{ $coupon->discount }}
                    </td>
                </tr>

                <tr>
                    <th>
                        {{ trans('global.coupon.fields.attempts') }}
                    </th>
                    <td>
                        {{ $coupon->attempts }}
                    </td>
                </tr>

                <tr>
                    <th>
                        {{ trans('global.coupon.fields.duration') }}
                    </th>
                    <td>
                        {{ $coupon->duration }}
                    </td>
                </tr>
                
            </tbody>
        </table>
    </div>
</div>

@endsection