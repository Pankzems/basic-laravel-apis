@extends('layouts.admin')
@section('content')
@can('service_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.services.create') }}">
                {{ trans('global.add') }} {{ trans('global.service.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('global.service.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="service_table" class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>
                            ID
                        </th>
                        <th>
                            Shop
                        </th>
                        <th>
                            Dress
                        </th>
                        <th>
                            Iron
                        </th>
                        <th>
                            Wash
                        </th>
                        <th>
                            Quantity
                        </th>
                        <th>
                            Amount
                        </th>
                        <th>
                            Delivery Time
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
        $('#service_table').DataTable({
            serverSide: true,
            processing: true,
            responsive: true,
            ajax: "{{ route('admin.services.list') }}",
            columns: [
                { name: 'id' },
                { name: 'shop.name' },
                { name: 'dress.name' },
                { name: 'iron' },
                { name: 'wash' },
                { name: 'quantity' },
                { name: 'amount' },
                { name: 'delivery_time' },
                { name: 'action', orderable: false, searchable: false }
            ],
        });
</script>
@endsection
@endsection