@extends('layouts.admin')
@section('content')
@can('voce_p_trasporto_per_persona_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.voce-p-trasporto-per-personas.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.vocePTrasportoPerPersona.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.vocePTrasportoPerPersona.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-VocePTrasportoPerPersona">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.vocePTrasportoPerPersona.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.vocePTrasportoPerPersona.fields.tipologia_trasporto') }}
                    </th>
                    <th>
                        {{ trans('cruds.vocePTrasportoPerPersona.fields.trasporto') }}
                    </th>
                    <th>
                        {{ trans('cruds.vocePTrasportoPerPersona.fields.prezzo') }}
                    </th>
                    <th>
                        {{ trans('cruds.vocePTrasportoPerPersona.fields.preventivo') }}
                    </th>
                    <th>
                        {{ trans('cruds.vocePTrasportoPerPersona.fields.informazioni_aggiuntive') }}
                    </th>
                    <th>
                        {{ trans('cruds.vocePTrasportoPerPersona.fields.scorpora') }}
                    </th>
                    <th>
                        {{ trans('cruds.vocePTrasportoPerPersona.fields.tipologia') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <select class="search" strict="true">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach(App\Models\VocePTrasportoPerPersona::TIPOLOGIA_TRASPORTO_SELECT as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($trasportos as $key => $item)
                                <option value="{{ $item->nome }}">{{ $item->nome }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($preventivos as $key => $item)
                                <option value="{{ $item->oggetto }}">{{ $item->oggetto }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                    </td>
                    <td>
                        <select class="search" strict="true">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach(App\Models\VocePTrasportoPerPersona::TIPOLOGIA_SELECT as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                    </td>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('voce_p_trasporto_per_persona_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.voce-p-trasporto-per-personas.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
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

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.voce-p-trasporto-per-personas.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'tipologia_trasporto', name: 'tipologia_trasporto' },
{ data: 'trasporto_nome', name: 'trasporto.nome' },
{ data: 'prezzo', name: 'prezzo' },
{ data: 'preventivo_oggetto', name: 'preventivo.oggetto' },
{ data: 'informazioni_aggiuntive', name: 'informazioni_aggiuntive' },
{ data: 'scorpora', name: 'scorpora' },
{ data: 'tipologia', name: 'tipologia' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-VocePTrasportoPerPersona').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
let visibleColumnsIndexes = null;
$('.datatable thead').on('input', '.search', function () {
      let strict = $(this).attr('strict') || false
      let value = strict && this.value ? "^" + this.value + "$" : this.value

      let index = $(this).parent().index()
      if (visibleColumnsIndexes !== null) {
        index = visibleColumnsIndexes[index]
      }

      table
        .column(index)
        .search(value, strict)
        .draw()
  });
table.on('column-visibility.dt', function(e, settings, column, state) {
      visibleColumnsIndexes = []
      table.columns(":visible").every(function(colIdx) {
          visibleColumnsIndexes.push(colIdx);
      });
  })
});

</script>
@endsection