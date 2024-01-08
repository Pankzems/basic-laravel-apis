@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('global.coupon.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.coupons.update", [$coupon->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">{{ trans('global.coupon.fields.name') }}*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($coupon) ? $coupon->name : '') }}">
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.coupon.fields.name_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                <label for="code">{{ trans('global.coupon.fields.code') }}*</label>
                <input type="text" id="code" name="code" class="form-control" value="{{ old('code', isset($coupon) ? $coupon->code : '') }}">
                @if($errors->has('code'))
                    <em class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.coupon.fields.code_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('valid_from') ? 'has-error' : '' }}">
                <label for="valid_from">{{ trans('global.coupon.fields.valid_from') }}*</label>
                <input type="text" id="valid_from" name="valid_from" class="form-control" value="{{ old('valid_from', isset($valid_from) ? date('m/d/Y G:i A', strtotime($coupon->valid_from)) : '') }}">
                @if($errors->has('valid_from'))
                    <em class="invalid-feedback">
                        {{ $errors->first('valid_from') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.coupon.fields.valid_from_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('valid_to') ? 'has-error' : '' }}">
                <label for="valid_to">{{ trans('global.coupon.fields.valid_to') }}*</label>
                <input type="text" id="valid_to" name="valid_to" class="form-control" value="{{ old('valid_to', isset($valid_to) ? $coupon->valid_to : '') }}">
                @if($errors->has('valid_to'))
                    <em class="invalid-feedback">
                        {{ $errors->first('valid_to') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.coupon.fields.valid_to_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
                <label for="amount">{{ trans('global.coupon.fields.amount') }}*</label>
                <input type="text" id="amount" name="amount" class="form-control" value="{{ old('amount', isset($coupon) ? $coupon->amount : '') }}" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');">
                @if($errors->has('amount'))
                    <em class="invalid-feedback">
                        {{ $errors->first('amount') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.coupon.fields.amount_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('discount') ? 'has-error' : '' }}">
                <label for="discount">{{ trans('global.coupon.fields.discount') }}*</label>
                <input type="number" id="discount" name="discount" class="form-control" value="{{ old('discount', isset($coupon) ? $coupon->discount : '') }}" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');" min="0" max="100">
                @if($errors->has('discount'))
                    <em class="invalid-feedback">
                        {{ $errors->first('discount') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.coupon.fields.discount_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('attempts') ? 'has-error' : '' }}">
                <label for="attempts">{{ trans('global.coupon.fields.attempts') }}*</label>
                <input type="number" id="attempts" name="attempts" class="form-control" value="{{ old('attempts', isset($coupon) ? $coupon->attempts : '') }}" min="0" max="100" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');">
                @if($errors->has('attempts'))
                    <em class="invalid-feedback">
                        {{ $errors->first('attempts') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.coupon.fields.attempts_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('duration') ? 'has-error' : '' }}">
                <label for="duration">{{ trans('global.coupon.fields.duration') }}*</label>
               <select id="duration" name="duration" class="form-control selct2option">
                   <option value="">Select Duration</option>
                   <option value="daily" {{ $coupon->duration == 'daily' ? 'selected=selected' : '' }}>Daily</option>
                   <option value="weekly" {{ $coupon->duration == 'weekly' ? 'selected=selected' : '' }}>Weekly</option>
                   <option value="monthly" {{ $coupon->duration == 'monthly' ? 'selected=selected' : '' }}>Monthly</option>
                   <option value="yearly" {{ $coupon->duration == 'yearly' ? 'selected=selected' : '' }}>Yearly</option>
                   <option value="validity" {{ $coupon->duration=='validity' ? 'selected=selected' : '' }}>Validity</option>
               </select>
               
                @if($errors->has('duration'))
                    <em class="invalid-feedback">
                        {{ $errors->first('duration') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.coupon.fields.duration_helper') }}
                </p>
            </div>
            
            
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
@section('scripts')
@parent
 <script type="text/javascript">
    $(function () {
        $('#valid_from').datetimepicker({minDate: new Date(), format: 'YYYY-MM-DD HH:mm:ss'});
        $('#valid_to').datetimepicker({minDate: new Date(), format: 'YYYY-MM-DD HH:mm:ss'});
    });
</script>
@endsection

@endsection