@extends('layouts.admin')
@section('content')
@can('dress_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.dresses.create") }}">
                {{ trans('global.add') }} {{ trans('global.dress.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('global.dress.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="dress-table" class=" table table-bordered table-striped table-hover datatable">
                <thead>
                  <tr> 
                  <th>ID</th>
                  <th>Name</th>
                  <th>Category</th>
                  <th>Action</th>
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
        $('#dress-table').DataTable({
            serverSide: true,
            processing: true,
            responsive: true,
            ajax: "{{ route('admin.dresses.list') }}",
            columns: [
                { name: 'id' },
                { name: 'name' },
                { name: 'category.name' },
                { name: 'action', orderable: false, searchable: false }
            ],
        });
    //});
</script>

@endsection
@endsection