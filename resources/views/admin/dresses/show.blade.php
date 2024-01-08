@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('global.dress.title') }}
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        {{ trans('global.dress.fields.name') }}
                    </th>
                    <td>
                        {{ $dress->name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.dress.fields.category') }}
                    </th>
                    <td>
                        {{ $dress->category->name }}
                    </td>
                </tr>
                
            </tbody>
        </table>
    </div>
</div>

@endsection