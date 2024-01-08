@extends('layouts.admin')
@section('content')
@can('coupon_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.coupons.create") }}">
                {{ trans('global.add') }} {{ trans('global.coupon.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('global.coupon.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="coupon_table" class=" table table-bordered table-striped table-hover datatable">
                <thead>
                  <tr> 
                  <th>ID</th>
                  <th>Name</th>
                  <th>Code</th>
                  <th>Valid From</th>
                  <th>Valid To</th>
                  <th>Amount</th>
                  <th>Discount(%)</th>
                  <th>Attempts</th>
                  <th>Duration</th>
                  <th>&nbsp;</th>
                </tr>
                </thead>
                
            </table>
        </div>
    </div>
</div>
@section('scripts')
@parent
<script>
    // $(function () {
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.dresses.massDestroy') }}",
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
@can('dress_delete')
  dtButtons.push(deleteButton)
@endcan

  // $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  //$('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons })
// })

</script>
<script>
    //$(function() {
        $('#coupon_table').DataTable({
            serverSide: true,
            processing: true,
            responsive: true,
            ajax: "{{ route('admin.coupons.list') }}",
            columns: [
                { name: 'id' },
                { name: 'name' },
                { name: 'code' },
                { name: 'valid_from' },
                { name: 'valid_to' },
                { name: 'amount' },
                { name: 'discount' },
                { name: 'attempts' },
                { name: 'duration' },
                { name: 'action', orderable: false, searchable: false }
            ],
        });
    //});
</script>

@endsection
@endsection