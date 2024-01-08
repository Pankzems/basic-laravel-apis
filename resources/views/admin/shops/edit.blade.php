@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('global.shop.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route('admin.shops.update', [$shop->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">{{ trans('global.shop.fields.name') }}*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($shop) ? $shop->name : '') }}">
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.shop.fields.name_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
                <label for="user_id">{{ trans('global.shop.fields.owner') }}*</label>
               <select id="user" name="user_id" class="form-control selct2option">
                   <option value="">Select User</option>
                   @foreach($laundryusers as $laundryuser)
                   <option value="{{$laundryuser->user->id}}" {{ $laundryuser->user->id == $shop->user_id ? 'selected="selected"' : '' }}>{{$laundryuser->user->name}}</option>
                   @endforeach
               </select>
               
                @if($errors->has('user_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('user_id') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.shop.fields.country_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                <label for="address">{{ trans('global.shop.fields.address') }}</label>
                <textarea id="address" name="address" class="form-control ">{{ old('address', isset($shop) ? $shop->address : '') }}</textarea>
                @if($errors->has('address'))
                    <em class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.shop.fields.address_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('country_id') ? 'has-error' : '' }}">
                <label for="country_id">{{ trans('global.shop.fields.country') }}*</label>
               <select id="country" name="country_id" class="form-control selct2option">
                   <option value="">Select Country</option>
                   @foreach($countries as $country)
                   <option value="{{$country->id}}" {{ $country->id == $shop->country_id ? 'selected="selected"' : '' }}>{{$country->name}}</option>
                   @endforeach
               </select>
               
                @if($errors->has('country_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('country_id') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.shop.fields.country_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('state_id') ? 'has-error' : '' }}">
                <label for="state_id">{{ trans('global.shop.fields.state') }}*</label>
               <select id="state" name="state_id" class="form-control selct2option">
                   <option value="">Select State</option>
                   @foreach($states as $state)
                   <option value="{{$state->id}}" {{ $state->id == $shop->state_id ? 'selected="selected"' : '' }}>{{$state->name}}</option>
                   @endforeach
               </select>
               
                @if($errors->has('state_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('state_id') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.shop.fields.state_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('city_id') ? 'has-error' : '' }}">
                <label for="city_id">{{ trans('global.shop.fields.city') }}*</label>
               <select id="city" name="city_id" class="form-control selct2option">
                   <option value="">Select City</option>
                   @foreach($cities as $city)
                   <option value="{{$city->id}}" {{ $city->id == $shop->city_id ? 'selected="selected"' : '' }}>{{$city->name}}</option>
                   @endforeach
               </select>
               
                @if($errors->has('city_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('city_id') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.shop.fields.city_helper') }}
                </p>
            </div>
           


            <div class="form-group {{ $errors->has('zipcode') ? 'has-error' : '' }}">
                <label for="zipcode">{{ trans('global.shop.fields.zipcode') }}*</label>
                <input type="text" id="zipcode" name="zipcode" class="form-control" value="{{ old('zipcode', isset($shop) ? $shop->zipcode : '') }}">
                @if($errors->has('zipcode'))
                    <em class="invalid-feedback">
                        {{ $errors->first('zipcode') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.shop.fields.zipcode_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('lat') ? 'has-error' : '' }}">
                <label for="lat">{{ trans('global.shop.fields.lat') }}*</label>
                <input type="text" id="lat" name="lat" class="form-control" value="{{ old('lat', isset($shop) ? $shop->lat : '') }}">
                @if($errors->has('lat'))
                    <em class="invalid-feedback">
                        {{ $errors->first('lat') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.shop.fields.lat_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('lng') ? 'has-error' : '' }}">
                <label for="lng">{{ trans('global.shop.fields.lng') }}*</label>
                <input type="text" id="lng" name="lng" class="form-control" value="{{ old('lng', isset($shop) ? $shop->lng : '') }}">
                @if($errors->has('lng'))
                    <em class="invalid-feedback">
                        {{ $errors->first('lng') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.shop.fields.lng_helper') }}
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
        $('#country').select2();
        $('#state').select2();
        $('#city').select2();
        $('#user').select2();
    $('#country').on('change', function() {
        var countryID = $(this).val();
            if(countryID) {
            $.ajax({
                url: '/admin/country/states/',
                type: "GET",
                data: {'countryid':countryID},
                dataType: "json",
                success:function(data) {
                $('#state').empty();
                $('#city').empty();
                $('#state').append('<option value="">Select State</option>');
                $('#city').append('<option value="">Select City</option>');
                $.each(data, function(key, value) {
                    $('#state').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                });
                }
            });
            }else{
            $('#state').empty();
              }
           });

    $('#state').on('change', function() {
        var stateID = $(this).val();
            if(stateID) {
            $.ajax({
                url: '/admin/state/cities/',
                type: "GET",
                data: {'stateid':stateID},
                dataType: "json",
                success:function(data) {
                $('#city').empty();
                $('#city').append('<option value="">Select City</option>');
                $.each(data, function(key, value) {
                    $('#city').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                });
                }
            });
            }else{
            $('#city').empty();
              }
           });
        });
    </script>
@endsection


@endsection