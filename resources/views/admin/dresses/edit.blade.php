@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('global.dress.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.dresses.update", [$dress->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">{{ trans('global.dress.fields.name') }}*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($dress) ? $dress->name : '') }}">
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.dress.fields.name_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
                <label for="category_id">{{ trans('global.dress.fields.category') }}*</label>
               <select id="category_id" name="category_id" class="form-control selct2option">
                   <option value="">Select Category</option>
                   @if(count($categories) > 0)
                   @foreach($categories as $category)
                   <option value="{{$category->id}}" {{ $category->id == $dress->category_id ? 'selected="selected"' : '' }}>{{$category->name}}</option>
                   @endforeach
                   @endif
               </select>
                @if($errors->has('category_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('category_id') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.service.fields.dress_helper') }}
                </p>
            </div>
            
            
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>

@endsection