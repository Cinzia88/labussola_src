@extends('layouts.admin')
@section('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style type="text/css">
        ul.pagination > li.paginate_button {
            padding: 0!important;
            margin: 0!important;
        }
        .buttons-columnVisibility, .button-page-length{
            position: relative;
            margin: 0;
            width: 100%;
        }
    </style>
@endsection

@section('content')
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
            <div class="table-container">
                <table id="table-preventivo-list" class="table table-bordered table-striped table-hover ajaxTable datatable datatable-Preventivo">
                    <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th data-table-title="creato da">
                            creato da
                        </th>
                        <th data-table-title="creato il">
                            creato il
                        </th>
                        <th data-table-title="status">
                            status
                        </th>
                        <th data-table-title="data inizio viaggio">
                            data inizio viaggio
                        </th>
                        <th data-table-title="data fine viaggio">
                            data fine viaggio
                        </th>
                        <th data-table-title="numero">
                            numero
                        </th>
                        <th data-table-title="anno">
                            anno
                        </th>
                        <th data-table-title="itinerario">
                            itinerario
                        </th>
                        <th data-table-title="oggetto">
                            oggetto
                        </th>
                        <th data-table-title="tag_id">
                            tag id
                        </th>
                        <th data-table-title="numero persone">
                            numero persone
                        </th>
                        <th data-table-title="cliente">
                            cliente
                        </th>
                        <th data-table-title="email">
                            email
                        </th>
                        <th data-table-title="markup">
                            markup
                        </th>
                        <th data-table-title="ragione sociale">
                            ragione sociale
                        </th>
                    </tr>
                    <tr>
                        <td>
                            <span class="d-none">azioni</span>
                        </td>
                        <th data-table-title="creato da">
                            <span class="d-none">creato da</span>
                            <select id="npt_creato_da" class="search">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach ($users as $user)
                                    <option
                                        {{-- @if($authUserId === $user->id) selected @endif --}}
                                        value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </th>
                        <th data-table-title="creato il">
                            <span class="d-none">creato il</span>
                            <input id="npt_creato_il" class="search" type="date" placeholder="{{ trans('global.search') }}">
                        </th>
                        <th data-table-title="status">
                            <span class="d-none">stato</span>
                            <select id="npt_status" class="search">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach (App\Models\Preventivo::STATUS_SELECT as $key => $item)
                                    <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </th>
                        <th data-table-title="data inizio viaggio">
                            <span class="d-none">data inizio viaggio</span>
                            <input id="npt_trip_start" class="search" type="date" placeholder="{{ trans('global.search') }}">
                        </th>
                        <th data-table-title="data fine viaggio">
                            <span class="d-none">data fine viaggio</span>
                            <input id="npt_trip_end" class="search" type="date" placeholder="{{ trans('global.search') }}">
                        </th>
                        <td data-table-title="numero">
                            <span class="d-none">numero</span>
                            <input id="npt_number" class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <th data-table-title="anno">
                            <span class="d-none">anno</span>
                            <input id="npt_year" class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </th>
                        <th data-table-title="itinerario">
                            <span class="d-none">itinerario</span>
                            <input id="npt_trip" class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </th>
                        <th data-table-title="oggetto">
                            <span class="d-none">oggetto</span>
                            <input id="npt_subject" class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </th>
                        <td data-table-title="tag_id">
                            <span class="d-none">tag id</span>
                            <input id="npt_tag" class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <th data-table-title="numero persone">
                            <span class="d-none">numero persone</span>
                            <input id="npt_people" class="search" type="number" min="0" placeholder="{{ trans('global.search') }}">
                        </th>
                        <th data-table-title="cliente">
                            <span class="d-none">cliente</span>
                            <input id="npt_customer" class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </th>
                        <th data-table-title="email">
                            <span class="d-none">email</span>
                            <input id="npt_email" class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </th>
                        <th data-table-title="markup">
                            <span class="d-none">markup</span>
                            <input id="npt_markup" class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </th>
                        <th data-table-title="ragione sociale">
                            <span class="d-none">ragione sociale</span>
                            <input id="npt_rg" class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            creato da
                        </th>
                        <th>
                            creato il
                        </th>
                        <th>
                            status
                        </th>
                        <th>
                            data inizio viaggio
                        </th>
                        <th>
                            data fine viaggio
                        </th>
                        <th>
                            numero
                        </th>
                        <th>
                            anno
                        </th>
                        <th>
                            itinerario
                        </th>
                        <th>
                            oggetto
                        </th>
                        <th>
                            tag id
                        </th>
                        <th>
                            numero persone
                        </th>
                        <th>
                            cliente
                        </th>
                        <th>
                            email
                        </th>
                        <th>
                            markup
                        </th>
                        <th>
                            ragione sociale
                        </th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script>

        /**
         * costruisce un array contenente gli id di ogni colonna.
         * E' stato richiesto di salvare per ogni utente quali colonne devono o meno
         * essere visibili, questa informazione viene inviata tramite la variabile
         * $columnVisibilityList.
         */
        function buildTableColumn() {

            var tableColumn = [
                { data: 'action' },
                { data: 'created_by_id' },
                { data: 'created_at' },
                { data: 'status' },
                { data: 'data_inizio_viaggio' },
                { data: 'data_fine_viaggio' },
                { data: 'numero' },
                { data: 'anno' },
                { data: 'itinerario' },
                { data: 'oggetto' },
                { data: 'tag_id' },
                { data: 'numero_persone' },
                { data: 'cliente' },
                { data: 'email' },
                { data: 'markup' },
                { data: 'ragione_sociale' }
            ];

            return tableColumn;
        }

        function buildColumnDefs() {
            var columDefs = [
                { orderable: false, targets: 0, name: 'azioni' }
            ];

            return columDefs;
        }

        /**
         * Costruisce il datatable, richieste:
         * - al caricamento della pagina l'utente deve vedere solo i propri preventivi, e poi può cambiare
         * - al caricamente della pagina l'utente deve vedere solo le colonne che ha scelto di vedere e questa impostazione
         * deve esseremantenuta anche al cambio utente
         */
        function buildDatatable() {
            var cleanUpLocalStorage = localStorage.getItem('localStorageHasCleaned');
            if( ! cleanUpLocalStorage ) {
                localStorage.clear();
                localStorage.setItem('localStorageHasCleaned', new Date().toLocaleDateString());
            }

            return $('#table-preventivo-list').DataTable({
                columnDefs: buildColumnDefs(),
                dom: 'Bfrtip',
                stateSave: true,
                stateDuration: -1,
                lengthMenu: [
                    [ 10, 25, 50, -1 ],
                    [ '10 righe', '25 righe', '50 righe', 'Vedi tutte' ]
                ],
                buttons: [
                    { extend: 'pageLength', className: 'buttons-select-all btn-primary' },
                    { extend: 'copy', className: 'btn-default' },
                    { extend: 'csv', className: 'btn-default' },
                    { extend: 'excel', className: 'btn-default' },
                    { extend: 'pdf', className: 'btn-default' },
                    { extend: 'print', className: 'btn-default' },
                    {
                        extend: 'colvis',
                        className: 'buttons-select-all btn-primary'
                    },
                    {
                        text: 'Vedi solo creati da me',
                        className: 'btn-info action-filter-my-data',
                        action: function ( e, dt, node, config ) {
                            dt.columns(1).search({{ $authUserId }}).draw()
                            $('#npt_creato_da').val({{ $authUserId }}).change();
                        }
                    },
                    {
                        text: 'Reset filtri ricerca',
                        className: 'btn-warning action-reset-table',
                        action: function ( e, dt, node, config ) {
                            var nptSearch = document.getElementsByClassName('search');
                            for (var i = 0; i < nptSearch.length; i++) {
                                nptSearch.item(i).value = "";
                            }

                            dt.search("");
                            dt.columns().search('').draw();
                        }
                    }
                ],
                ajax: '/admin/dataTable',
                processing: true,
                serverSide: true,
                pageLength: 10,
                scrollX: true,
                columns: buildTableColumn(),
                order: [[1, 'desc']],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/it-IT.json',
                }
            });

            var visibleColumnsIndexes = null;
            $('.datatable thead').on('input', '.search', function() {
                var strict = $(this).attr('strict') || false
                var value = strict && this.value ? "^" + this.value + "$" : this.value

                var index = $(this).parent().index()
                if (visibleColumnsIndexes !== null) {
                    index = visibleColumnsIndexes[index]
                }

                table
                    .column(index)
                    .search(value, strict)
                    .draw()
            });
        }

        setTimeout(() => {
            var table = buildDatatable();
            setTimeout(function() {
                $('.action-filter-my-data').click();

                setTimeout(function() {

                    var columnVisibilityList = @json($columnVisibilityList);
                    if ( columnVisibilityList instanceof Array ) {
                        if ( columnVisibilityList.length > 0 ) {
                            for (var i = 0; i < columnVisibilityList.length; i++) {
                                if ( columnVisibilityList[i] === 'false' ) {
                                    $('#table-preventivo-list').DataTable().columns(i).visible(false);
                                }else{
                                    $('#table-preventivo-list').DataTable().columns(i).visible(true);
                                }
                            }
                        }
                    }

                }, 400);
            }, 400);
        }, 200);

        /**
         * Singoli filtri delle colonne con funzioni apposite che lanciano il table draw alla selezione.
         * Ho dovuto farlo perchè altrimenti con tutte la complessità richiesta del datatable quando premi su
         * un bottone custom non vanno più i filtri, così ho ovviato il problema
         */
        $(document).on('change', '#npt_creato_da', function() {
            var createdById = $(this).val();
            $('#table-preventivo-list').DataTable().columns(1).search(createdById).draw();
        });

        $(document).on('change', '#npt_creato_il', function() {
            var createdAt = $(this).val();
            $('#table-preventivo-list').DataTable().columns(2).search(createdAt).draw();
        });

        $(document).on('change', '#npt_status', function() {
            var status = $(this).val();
            $('#table-preventivo-list').DataTable().columns(3).search(status).draw();
        });

        $(document).on('change', '#npt_trip_start', function() {
            var npt_trip_start = $(this).val();
            $('#table-preventivo-list').DataTable().columns(4).search(npt_trip_start).draw();
        });

        $(document).on('change', '#npt_trip_end', function() {
            var npt_trip_end = $(this).val();
            $('#table-preventivo-list').DataTable().columns(5).search(npt_trip_end).draw();
        });

        $(document).on('change', '#npt_number', function() {
            var npt_number = $(this).val();
            $('#table-preventivo-list').DataTable().columns(6).search(npt_number).draw();
        });

        $(document).on('change', '#npt_year', function() {
            var npt_year = $(this).val();
            $('#table-preventivo-list').DataTable().columns(7).search(npt_year).draw();
        });

        $(document).on('change', '#npt_trip', function() {
            var npt_trip = $(this).val();
            $('#table-preventivo-list').DataTable().columns(8).search(npt_trip).draw();
        });

        $(document).on('change', '#npt_subject', function() {
            var npt_subject = $(this).val();
            $('#table-preventivo-list').DataTable().columns(9).search(npt_subject).draw();
        });

        $(document).on('change', '#npt_tag', function() {
            var npt_tag = $(this).val();
            $('#table-preventivo-list').DataTable().columns(10).search(npt_tag).draw();
        });

        $(document).on('change', '#npt_people', function() {
            var npt_people = $(this).val();
            $('#table-preventivo-list').DataTable().columns(11).search(npt_people).draw();
        });

        $(document).on('change', '#npt_customer', function() {
            var npt_customer = $(this).val();
            $('#table-preventivo-list').DataTable().columns(12).search(npt_customer).draw();
        });

        $(document).on('change', '#npt_email', function() {
            var npt_email = $(this).val();
            $('#table-preventivo-list').DataTable().columns(13).search(npt_email).draw();
        });

        $(document).on('change', '#npt_markup', function() {
            var npt_markup = $(this).val();
            $('#table-preventivo-list').DataTable().columns(14).search(npt_markup).draw();
        });

        $(document).on('change', '#npt_rg', function() {
            var npt_rg = $(this).val();
            $('#table-preventivo-list').DataTable().columns(15).search(npt_rg).draw();
        });

        // click sul botton reset filtri
        $(document).on('click', '.action-reset-table', function() {
            setTimeout(function() {
                $('#table-preventivo-list').DataTable().destroy();
                setTimeout(() => {
                    var table = buildDatatable();
                }, 200);
            }, 300);
        });

        /**
         * column visibility storage
         *
         */
        $(document).on('click', '.buttons-columnVisibility', function() {

            var columnVisiblityList = [];

            $('.buttons-columnVisibility').each(function(){
                if ( $(this).hasClass('dt-button-active') ) {
                    columnVisiblityList.push(true);
                }else{
                    columnVisiblityList.push(false);
                }
            });

            var customerId = {!! auth()->user()->id ?? 0 !!};

            if ( customerId > 0 ) {

                $.post('/admin/dataTable-column-visibility', {
                    'customerId' : {!! auth()->user()->id ?? 0 !!},
                    'columnVisiblityList' : columnVisiblityList
                });
            }
        })
    </script>
@endsection
