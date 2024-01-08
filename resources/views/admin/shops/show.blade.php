@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('global.shop.title') }}
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        {{ trans('global.shop.fields.name') }}
                    </th>
                    <td>
                        {{ $shop->name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.shop.fields.owner') }}
                    </th>
                    <td>
                        {{$shop->user->name}}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.shop.fields.address') }}
                    </th>
                    <td>
                        {{$shop->address}}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.shop.fields.city') }}
                    </th>
                    <td>
                        {{$shop->city->name}}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.shop.fields.state') }}
                    </th>
                    <td>
                        {{$shop->state->name}}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.shop.fields.country') }}
                    </th>
                    <td>
                        {{$shop->country->name}}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.shop.fields.zipcode') }}
                    </th>
                    <td>
                        {{$shop->zipcode}}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.shop.fields.lat') }}
                    </th>
                    <td>
                        {{$shop->lat}}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.shop.fields.lng') }}
                    </th>
                    <td>
                        {{$shop->lng}}
                    </td>
                </tr>

                <tr>
                    <th>
                        {{ trans('global.shop.fields.image') }}
                    </th>
                    <td>
                        <img src="{{$shop->image->url()}}">
                    </td>
                </tr>
                
            </tbody>
        </table>
    </div>
</div>


<div class="card">
    <div class="card-header">
        Services
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>
                            ID
                        </th>
                        <th>
                            Dress
                        </th>
                        <th>
                            Quantity
                        </th>
                        <th>
                            Iron
                        </th>
                        <th>
                            Wash
                        </th>
                        <th>
                            Amount
                        </th>
                        <th>
                            Delivery (in days)
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($shop->services) > 0)
                    @foreach($shop->services as $key => $val)
                        <tr>
                            <td>
                                {{$val->id}}
                            </td>
                            <td>
                                {{$val->dress->name }}
                            </td>
                            <td>
                                {{$val->quantity }}
                            </td>
                            <td>
                                {{$val->iron=='1' ? 'Yes' : 'No' }}
                            </td>
                            <td>
                                {{$val->wash=='1' ? 'Yes' : 'No'}}
                            </td>
                            <td>
                                {{$val->amount}}
                            </td>
                            <td>
                                {{$val->delivery_time}}
                            </td>
                        </tr>
                    @endforeach
                    @else 
                    <tr><td colspan="7" style="text-align: center;">No address found</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection