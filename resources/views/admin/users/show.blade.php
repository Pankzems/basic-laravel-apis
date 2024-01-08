@extends('layouts.admin')
@section('content')
<?php
/*echo '<pre>';
print_r($user);
echo '</pre>';*/
//echo $user->user_addresses;

?>

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('global.user.title') }}
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        {{ trans('global.user.fields.name') }}
                    </th>
                    <td>
                        {{ $user->name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.user.fields.email') }}
                    </th>
                    <td>
                        {{ $user->email }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.user.fields.phone') }}
                    </th>
                    <td>
                        {{ $user->phone }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.user.fields.gender') }}
                    </th>
                    <td>
                        {{ $user->gender=='male' ? 'Male' : 'Female' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.user.fields.email_verified_at') }}
                    </th>
                    <td>
                        {{ $user->email_verified_at }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Roles
                    </th>
                    <td>
                        @foreach($user->roles as $id => $roles)
                            <span class="label label-info label-many">{{ $roles->title }}</span>
                        @endforeach
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>



<div class="card">
    <div class="card-header">
        User Addresses
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>
                            Address
                        </th>
                        <th>
                            City
                        </th>
                        <th>
                            State
                        </th>
                        <th>
                            Country
                        </th>
                        <th>
                            Zipcode
                        </th>
                        <th>
                            Latitude
                        </th>
                        <th>
                            Longitude
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($user->addresses) > 0)
                    @foreach($user->addresses as $key => $val)
                        <tr>
                            <td>
                                {{$val->address}}
                            </td>
                            <td>
                                {{$val->city->name }}
                            </td>
                            <td>
                                {{$val->state->name }}
                            </td>
                            <td>
                                {{$val->country->name }}
                            </td>
                            <td>
                                {{$val->zipcode}}
                            </td>
                            <td>
                                {{$val->lat}}
                            </td>
                            <td>
                                {{$val->lng}}
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