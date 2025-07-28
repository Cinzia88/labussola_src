@extends('layouts.admin')

@section('styles')
    <style type="text/css">
        ul.pagination > li.paginate_button {
            padding: 0!important;
            margin: 0!important;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            Report preventivi per data di creazione
        </div>

        <div class="card-body">
            <p class="text-secondary">
                <small>
                    Questo report recupera un elenco di preventivi in base alla data di creazione.<br />
                    Verrà mostrata una preview dei dati reperiti e sarà possibile poi, scaricare l'excel della tabella stessa
                </small>
            </p>
            <form method="get">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="dateFrom" class="form-label">Data dal</label>
                            <input type="date" name="dateFrom" required class="form-control" id="dateFrom" max="{{\Carbon\Carbon::now()->format('Y-m-d')}}" @if($dateFrom) value="{{$dateFrom}}" @endif>
                            <small id="dateFromHelp" class="form-text text-secondary">Recupera tutti i preventivi creati dal</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="dateTo" class="form-label">Data al</label>
                            <input type="date" name="dateTo" required class="form-control" id="dateTo" max="{{\Carbon\Carbon::now()->format('Y-m-d')}}" @if($dateTo) value="{{$dateTo}}" @endif>
                            <small id="dateToHelp" class="form-text text-secondary">Recupera tutti i preventivi creati fino al</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <button type="submit" id="btn-recupera" class="btn btn-primary">Recupera</button>
                        <div class="spinner-border text-success d-none" id="spinner-recupera" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @if($reportData->isNotEmpty())
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                 <div>
                     Preview del risultato della ricerca
                 </div>
                <form method="get">
                    @csrf
                    <input type="hidden" name="dateFrom" @if($dateFrom) value="{{$dateFrom}}" @endif>
                    <input type="hidden" name="dateTo" @if($dateTo) value="{{$dateTo}}" @endif>
                    <input type="hidden" name="excel" value="1">
                    <button type="submit" class="btn btn-info text-white">Genera e scarica Excel</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <table id="table-preventivo-list" class="table table-bordered table-striped table-hover ajaxTable datatable datatable-Preventivo">
                <thead>
                <tr>
                    <th data-table-title="tag_id">
                        tag id
                    </th>
                    <th data-table-title="numero">
                        numero
                    </th>
                    <th data-table-title="anno">
                        anno
                    </th>
                    <th data-table-title="oggetto">
                        oggetto
                    </th>
                    <th data-table-title="ragione sociale">
                        ragione sociale
                    </th>
                    <th data-table-title="cliente">
                        cliente
                    </th>
                    <th data-table-title="itinerario">
                        itinerario
                    </th>
                    <th data-table-title="creato da">
                        creato da
                    </th>
                    <th data-table-title="email">
                        email
                    </th>
                    <th data-table-title="status">
                        status
                    </th>
                    <th data-table-title="numero persone">
                        numero persone
                    </th>
                    <th data-table-title="data inizio viaggio">
                        data inizio viaggio
                    </th>
                    <th data-table-title="data fine viaggio">
                        data fine viaggio
                    </th>
                    <th data-table-title="creato il">
                        creato il
                    </th>
                    <th data-table-title="markup">
                        markup
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($reportData as $preventivo)
                    <tr>
                        <td data-table-title="tag_id">
                            {{$preventivo->tag_id}}
                        </td>
                        <td data-table-title="numero">
                            {{$preventivo->numero}}
                        </td>
                        <td data-table-title="anno">
                            {{$preventivo->anno}}
                        </td>
                        <td data-table-title="oggetto">
                            {{$preventivo->oggetto}}
                        </td>
                        <td data-table-title="ragione sociale">
                            {{$preventivo->cliente->ragione_sociale ?? ''}}
                        </td>
                        <td data-table-title="cliente">
                            {{$preventivo->cliente->nome ?? '' }} {{$preventivo->cliente->cognome ?? ''}}
                        </td>
                        <td data-table-title="itinerario">
                            {{$preventivo->itinerario->nome ?? ''}}
                        </td>
                        <td data-table-title="creato da">
                            {{$preventivo->created_by->name ?? ''}}
                        </td>
                        <td data-table-title="email">
                            {{$preventivo->cliente->email ?? ''}}
                        </td>
                        <td data-table-title="status">
                            {{\App\Models\Preventivo::STATUS_SELECT[$preventivo->status] ?? ''}}
                        </td>
                        <td data-table-title="numero persone">
                            {{$preventivo->numero_persone}}
                        </td>
                        <td data-table-title="data inizio viaggio">
                            {{$preventivo->data_inzio_viaggio}}
                        </td>
                        <td data-table-title="data fine viaggio">
                            {{$preventivo->data_fine_viaggio}}
                        </td>
                        <td data-table-title="creato il">
                            {{$preventivo->created_at}}
                        </td>
                        <td data-table-title="markup">
                            {{$preventivo->markup}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
@endsection

@section('scripts')
    @parent
    @if($reportData)
    <script>
        var btnRecupera = document.getElementById('btn-recupera');
        var spinnerRecupera = document.getElementById('spinner-recupera');

        btnRecupera.addEventListener('click', function() {
           btnRecupera.classList.add('d-none');
           spinnerRecupera.classList.remove('d-none');
        });

        setTimeout(function() {
            var table = $('#table-preventivo-list').DataTable({
                scrollX: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/it-IT.json',
                }
            });
        });
    </script>
    @endif
@endsection
