@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('global.dress.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.dresses.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
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
               <select id="dress" name="category_id" class="form-control selct2option">
                   <option value="">Select Category</option>
                   @if(count($categories) > 0)
                   @foreach($categories as $category)
                   <option value="{{$category->id}}">{{$category->name}}</option>
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

            <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                <label for="lng">{{ trans('global.shop.fields.image') }}</label>
                <div><input type="file" id="image" name="image" ></div>
                @if($errors->has('image'))
                    <em class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.shop.fields.image_helper') }}
                </p>
            </div>
            
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>

@endsection