@extends('layouts.admin')
@section('content')
    @can('clienti_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.clientis.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.clienti.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.clienti.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Clienti">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.clienti.fields.id') }}
                        </th>
                        <th>
                            &nbsp;
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
                            {{ trans('cruds.clienti.fields.piva_cf') }}
                        </th>
                        <th>
                            {{ trans('cruds.clienti.fields.indirizzo') }}
                        </th>
                        <th>
                            {{ trans('cruds.clienti.fields.citta') }}
                        </th>
                        <th>
                            {{ trans('cruds.clienti.fields.cap') }}
                        </th>
                        <th>
                            {{ trans('cruds.clienti.fields.provincia') }}
                        </th>
                        <th>
                            {{ trans('cruds.clienti.fields.stato') }}
                        </th>
                        <th>
                            {{ trans('cruds.clienti.fields.email') }}
                        </th>
                        <th>
                            {{ trans('cruds.clienti.fields.telefono') }}
                        </th>
                     
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
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
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            $.extend(true, $.fn.dataTable.defaults, {
                columnDefs: [{
                        orderable: false,
                        className: 'select-checkbox',
                        targets: 0
                    }, {
                        orderable: true,
                        searchable: true,
                        targets: -1
                    },
                    {
                        orderable: false,
                        searchable: false,
                        targets: 2
                    }
                ],
            });
            @can('clienti_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.clientis.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).data(), function(entry) {
                            return entry.id
                        });

                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.zero_selected') }}')

                            return
                        }

                        if (confirm('{{ trans('global.areYouSure') }}')) {
                            $.ajax({
                                    headers: {
                                        'x-csrf-token': _token
                                    },
                                    method: 'POST',
                                    url: config.url,
                                    data: {
                                        ids: ids,
                                        _method: 'DELETE'
                                    }
                                })
                                .done(function() {
                                    location.reload()
                                })
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
                ajax: "{{ route('admin.clientis.index') }}",
                columns: [{
                        data: 'placeholder',
                        name: 'placeholder'
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'actions',
                        name: '{{ trans('global.actions') }}'
                    },
                    {
                        data: 'nome',
                        name: 'nome'
                    },
                    {
                        data: 'cognome',
                        name: 'cognome'
                    },
                    {
                        data: 'ragione_sociale',
                        name: 'ragione_sociale'
                    },
                    {
                        data: 'piva_cf',
                        name: 'piva_cf'
                    },
                    {
                        data: 'indirizzo',
                        name: 'indirizzo'
                    },
                    {
                        data: 'citta',
                        name: 'citta'
                    },
                    {
                        data: 'cap',
                        name: 'cap'
                    },
                    {
                        data: 'provincia',
                        name: 'provincia'
                    },
                    {
                        data: 'stato',
                        name: 'stato'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'telefono',
                        name: 'telefono'
                    },
                  
                ],
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,
            };
            let table = $('.datatable-Clienti').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            let visibleColumnsIndexes = null;
            $('.datatable thead').on('input', '.search', function() {
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
