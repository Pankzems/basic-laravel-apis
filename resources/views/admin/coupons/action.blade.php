@can('coupon_show')
    <a class="btn btn-xs btn-primary" href="{{ route('admin.coupons.show', $coupon->id) }}">
        {{ trans('global.view') }}
    </a>
@endcan
@can('coupon_edit')
    <a class="btn btn-xs btn-info" href="{{ route('admin.coupons.edit', $coupon->id) }}">
        {{ trans('global.edit') }}
    </a>
@endcan
@can('coupon_delete')
    <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
    </form>
@endcan
