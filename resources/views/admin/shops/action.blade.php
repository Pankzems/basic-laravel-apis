@can('shop_show')
    <a class="btn btn-xs btn-primary" href="{{ route('admin.shops.show', $shop->id) }}">
        {{ trans('global.view') }}
    </a>
@endcan
@can('shop_edit')
    <a class="btn btn-xs btn-info" href="{{ route('admin.shops.edit', $shop->id) }}">
        {{ trans('global.edit') }}
    </a>
@endcan
@can('shop_delete')
    <form action="{{ route('admin.shops.destroy', $shop->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
    </form>
@endcan
