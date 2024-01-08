@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('global.service.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route('admin.services.update', [$service->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group {{ $errors->has('shop_id') ? 'has-error' : '' }}">
                <label for="shop_id">{{ trans('global.service.fields.shop') }}*</label>
               <select id="shop" name="shop_id" class="form-control selct2option">
                   <option value="">Select Shop</option>
                   @if(count($shops) > 0)
                   @foreach($shops as $shop)
                   <option value="{{$shop->id}}" {{ $service->shop_id == $shop->id ? 'selected="selected"' : '' }}>{{$shop->name}}</option>
                   @endforeach
                   @endif
               </select>
                @if($errors->has('shop_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('shop_id') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.service.fields.shop_helper') }}
                </p>
            </div>

             <div class="form-group {{ $errors->has('dress_id') ? 'has-error' : '' }}">
                <label for="dress_id">{{ trans('global.service.fields.dress') }}*</label>
               <select id="dress" name="dress_id" class="form-control selct2option">
                   <option value="">Select Dress</option>
                   @if(count($dresses) > 0)
                   @foreach($dresses as $dress)
                   <option value="{{$dress->id}}" {{ $service->dress_id == $dress->id ? 'selected="selected"' : '' }}>{{$dress->name}}</option>
                   @endforeach
                   @endif
               </select>
                @if($errors->has('dress_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('dress_id') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.service.fields.dress_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('iron') ? 'has-error' : '' }}">
                <label for="iron">{{ trans('global.service.fields.iron') }}*</label>
               <select id="iron" name="iron" class="form-control selct2option">
                   <option value="">Select Iron Option</option>
                   <option value="1" {{ $service->iron == 1 ? 'selected="selected"' : '' }}>Yes</option>
                   <option value="0" {{ $service->iron == 0 ? 'selected="selected"' : '' }}>No</option>
               </select>
                @if($errors->has('iron'))
                    <em class="invalid-feedback">
                        {{ $errors->first('iron') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.service.fields.iron_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('wash') ? 'has-error' : '' }}">
                <label for="wash">{{ trans('global.service.fields.wash') }}*</label>
               <select id="irowashn" name="wash" class="form-control selct2option">
                   <option value="">Select Wash Option</option>
                   <option value="1" {{ $service->wash == 1 ? 'selected="selected"' : '' }}>Yes</option>
                   <option value="0" {{ $service->wash == 0 ? 'selected="selected"' : '' }}>No</option>
               </select>
                @if($errors->has('wash'))
                    <em class="invalid-feedback">
                        {{ $errors->first('wash') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.service.fields.wash_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('quantity') ? 'has-error' : '' }}">
                <label for="quantity">{{ trans('global.service.fields.quantity') }}*</label>
                <input type="number" id="quantity" name="quantity" class="form-control" value="{{ old('quantity', isset($service) ? $service->quantity : '') }}" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');" min="1" >
                @if($errors->has('quantity'))
                    <em class="invalid-feedback">
                        {{ $errors->first('quantity') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.service.fields.quantity_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
                <label for="amount">{{ trans('global.service.fields.amount') }}*</label>
                <input type="text" id="amount" name="amount" class="form-control" value="{{ old('delivery_time', isset($service) ? $service->delivery_time : '') }}" >
                @if($errors->has('amount'))
                    <em class="invalid-feedback">
                        {{ $errors->first('amount') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.service.fields.amount_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('delivery_time') ? 'has-error' : '' }}">
                <label for="delivery_time">{{ trans('global.service.fields.delivery_time') }}*</label>
                <input type="number" id="delivery_time" name="delivery_time" class="form-control" value="{{ old('delivery_time', isset($service) ? $service->delivery_time : '') }}" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');" min="1" >
                @if($errors->has('delivery_time'))
                    <em class="invalid-feedback">
                        {{ $errors->first('delivery_time') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.service.fields.delivery_time_helper') }}
                </p>
            </div>

            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>
@section('scripts')
@parent
 <script type="text/javascript">
    $(document).ready(function() {
        $('#dress').select2();
        $('#shop').select2();
        });
    </script>
@endsection

@endsection