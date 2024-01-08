@extends('layouts.admin')
@section('content')
@can('shop_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.shops.create') }}">
                {{ trans('global.add') }} {{ trans('global.shop.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('global.shop.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="shop_table" class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>
                            ID
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Owner Name
                        </th>
                        <th>
                            Address
                        </th>
                        <th>
                            City
                        </th>
                        <th>
                            State
                        </th>
                        <th>
                            Country
                        </th>
                        <th>
                            Zipcode
                        </th>
                        <th>
                            Latitude
                        </th>
                        <th>
                            Longitude
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                
            </table>
        </div>
    </div>
</div>
@section('scripts')
@parent
<script>
    $(function () {
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.shops.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('shop_delete')
  dtButtons.push(deleteButton)
@endcan

  //$('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons })
})

</script>
<script>
        $('#shop_table').DataTable({
            serverSide: true,
            processing: true,
            responsive: true,
            ajax: "{{ route('admin.shops.list') }}",
            columns: [
                { name: 'id' },
                { name: 'name' },
                { name: 'user.name' },
                { name: 'address' },
                { name: 'city.name' },
                { name: 'state.name' },
                { name: 'country.name' },
                { name: 'zipcode' },
                { name: 'lat' },
                { name: 'lng' },
                { name: 'action', orderable: false, searchable: false }
            ],
        });
</script>
@endsection
@endsection