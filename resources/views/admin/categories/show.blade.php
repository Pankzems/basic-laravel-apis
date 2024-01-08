@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('global.category.title') }}
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        {{ trans('global.category.fields.name') }}
                    </th>
                    <td>
                        {{ $category->name }}
                    </td>
                </tr>
                
            </tbody>
        </table>
    </div>
</div>

@endsection