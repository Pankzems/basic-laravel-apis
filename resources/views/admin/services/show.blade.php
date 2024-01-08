@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('global.service.title') }}
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        {{ trans('global.service.fields.shop') }}
                    </th>
                    <td>
                        {{ $service->shop->name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.service.fields.dress') }}
                    </th>
                    <td>
                        {{$service->dress->name}}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.service.fields.iron') }}
                    </th>
                    <td>
                        {{$service->iron==1 ? 'Yes' : 'No'}}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.service.fields.wash') }}
                    </th>
                    <td>
                        {{$service->wash==1 ? 'Yes' : 'No'}}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.service.fields.quantity') }}
                    </th>
                    <td>
                        {{$service->quantity}}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.service.fields.amount') }}
                    </th>
                    <td>
                        {{$service->amount}}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.service.fields.delivery_time') }}
                    </th>
                    <td>
                        {{$service->delivery_time}}
                    </td>
                </tr>
                
            </tbody>
        </table>
    </div>
</div>


@endsection