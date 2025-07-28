<div class="m-3">
    @can('preventivo_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.preventivos.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.preventivo.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.preventivo.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-clientePreventivos">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.preventivo.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.preventivo.fields.numero') }}
                            </th>
                            <th>
                                {{ trans('cruds.preventivo.fields.anno') }}
                            </th>
                            <th>
                                {{ trans('cruds.preventivo.fields.itinerario') }}
                            </th>
                            <th>
                                {{ trans('cruds.preventivo.fields.cliente') }}
                            </th>
                            <th>
                                {{ trans('cruds.clienti.fields.nome') }}
                            </th>
                            <th>
                                {{ trans('cruds.clienti.fields.cognome') }}
                            </th>
                            <th>
                                {{ trans('cruds.clienti.fields.ragione_sociale') }}
                            </th>
                            <th>
                                {{ trans('cruds.preventivo.fields.numero_persone') }}
                            </th>
                            <th>
                                {{ trans('cruds.preventivo.fields.status') }}
                            </th>
                            <th>
                                {{ trans('cruds.preventivo.fields.data_inzio_viaggio') }}
                            </th>
                            <th>
                                {{ trans('cruds.preventivo.fields.data_fine_viaggio') }}
                            </th>
                            <th>
                                {{ trans('cruds.preventivo.fields.date_indicative') }}
                            </th>
                            <th>
                                {{ trans('cruds.preventivo.fields.created_at') }}
                            </th>
                            <th>
                                {{ trans('cruds.preventivo.fields.guid') }}
                            </th>
                            <th>
                                {{ trans('cruds.preventivo.fields.numero_gratuita') }}
                            </th>
                            <th>
                                {{ trans('cruds.preventivo.fields.markup') }}
                            </th>
                            <th>
                                {{ trans('cruds.preventivo.fields.created_by') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($preventivos as $key => $preventivo)
                            <tr data-entry-id="{{ $preventivo->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $preventivo->id ?? '' }}
                                </td>
                                <td>
                                    {{ $preventivo->numero ?? '' }}
                                </td>
                                <td>
                                    {{ $preventivo->anno ?? '' }}
                                </td>
                                <td>
                                    {{ $preventivo->itinerario->nome ?? '' }}
                                </td>
                                <td>
                                    {{ $preventivo->cliente->ragione_sociale ?? '' }}
                                </td>
                                <td>
                                    {{ $preventivo->cliente->nome ?? '' }}
                                </td>
                                <td>
                                    {{ $preventivo->cliente->cognome ?? '' }}
                                </td>
                                <td>
                                    {{ $preventivo->cliente->ragione_sociale ?? '' }}
                                </td>
                                <td>
                                    {{ $preventivo->numero_persone ?? '' }}
                                </td>
                                <td>
                                    {{ App\Models\Preventivo::STATUS_SELECT[$preventivo->status] ?? '' }}
                                </td>
                                <td>
                                    {{ $preventivo->data_inzio_viaggio ?? '' }}
                                </td>
                                <td>
                                    {{ $preventivo->data_fine_viaggio ?? '' }}
                                </td>
                                <td>
                                    <span style="display:none">{{ $preventivo->date_indicative ?? '' }}</span>
                                    <input type="checkbox" disabled="disabled" {{ $preventivo->date_indicative ? 'checked' : '' }}>
                                </td>
                                <td>
                                    {{ $preventivo->created_at ?? '' }}
                                </td>
                                <td>
                                    {{ $preventivo->guid ?? '' }}
                                </td>
                                <td>
                                    {{ $preventivo->numero_gratuita ?? '' }}
                                </td>
                                <td>
                                    {{ $preventivo->markup ?? '' }}
                                </td>
                                <td>
                                    {{ $preventivo->created_by->name ?? '' }}
                                </td>
                                <td>
                                    @can('preventivo_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.preventivos.show', $preventivo->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('preventivo_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.preventivos.edit', $preventivo->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('preventivo_delete')
                                        <form action="{{ route('admin.preventivos.destroy', $preventivo->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('preventivo_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.preventivos.massDestroy') }}",
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
  let table = $('.datatable-clientePreventivos:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection