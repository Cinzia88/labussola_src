<div class="m-3">
    @can('scadenziario_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.scadenziarios.create') }}?preventivo={{ $preventivo->id }}">
                    {{ trans('global.add') }} {{ trans('cruds.scadenziario.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.scadenziario.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-preventivoScadenziarios">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.scadenziario.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.scadenziario.fields.nome') }}
                            </th>
                            <th>
                                {{ trans('cruds.scadenziario.fields.data') }}
                            </th>
                            <th>
                                {{ trans('cruds.scadenziario.fields.eseguito') }}
                            </th>
                            <th>
                                {{ trans('cruds.scadenziario.fields.preventivo') }}
                            </th>
                            <th>
                                {{ trans('cruds.preventivo.fields.anno') }}
                            </th>
                            <th>
                                {{ trans('cruds.scadenziario.fields.created_by') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($scadenziarios as $key => $scadenziario)
                            <tr data-entry-id="{{ $scadenziario->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $scadenziario->id ?? '' }}
                                </td>
                                <td>
                                    {{ $scadenziario->nome ?? '' }}
                                </td>
                                <td>
                                    {{ $scadenziario->data ?? '' }}
                                </td>
                                <td>
                                    <span style="display:none">{{ $scadenziario->eseguito ?? '' }}</span>
                                    <input type="checkbox" disabled="disabled" {{ $scadenziario->eseguito ? 'checked' : '' }}>
                                </td>
                                <td>
                                    {{ $scadenziario->preventivo->numero ?? '' }}
                                </td>
                                <td>
                                    {{ $scadenziario->preventivo->anno ?? '' }}
                                </td>
                                <td>
                                    {{ $scadenziario->created_by->name ?? '' }}
                                </td>
                                <td>
                                    @can('scadenziario_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.scadenziarios.show', $scadenziario->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('scadenziario_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.scadenziarios.edit', $scadenziario->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('scadenziario_delete')
                                        <form action="{{ route('admin.scadenziarios.destroy', $scadenziario->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                        </form>
                                    @endcan

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('scadenziario_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.scadenziarios.massDestroy') }}",
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
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-preventivoScadenziarios:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection