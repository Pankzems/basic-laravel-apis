@can('service_show')
    <a class="btn btn-xs btn-primary" href="{{ route('admin.services.show', $service->id) }}">
        {{ trans('global.view') }}
    </a>
@endcan
@can('service_edit')
    <a class="btn btn-xs btn-info" href="{{ route('admin.services.edit', $service->id) }}">
        {{ trans('global.edit') }}
    </a>
@endcan
@can('service_delete')
    <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
    </form>
@endcan
