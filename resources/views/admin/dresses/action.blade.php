@can('shop_show')
    <a class="btn btn-xs btn-primary" href="{{ route('admin.dresses.show', $dress->id) }}">
        {{ trans('global.view') }}
    </a>
@endcan
@can('shop_edit')
    <a class="btn btn-xs btn-info" href="{{ route('admin.dresses.edit', $dress->id) }}">
        {{ trans('global.edit') }}
    </a>
@endcan
@can('shop_delete')
    <form action="{{ route('admin.dresses.destroy', $dress->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
    </form>
@endcan
