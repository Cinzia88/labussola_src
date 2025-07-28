@extends('layouts.admin')
@section('content')
    <div class="card" xmlns="http://www.w3.org/1999/html">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.preventivo.title') }}
        </div>
        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.preventivos.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                    <a class="btn btn-default" href="{{ route('download', $preventivo->guid) }}">
                        Download PDF
                    </a>
                    <a class="btn btn-default" href="{{ route('visualizza.preventivo', ['uuid'=>$preventivo->guid]) }}">
                        Visualizza nel browser
                    </a>
                    <a class="btn btn-default" onClick="return confirm('Sei sicuro di voler inviare il preventivo?')" href="{{ route('admin.invia.preventivo', $preventivo->id) }}">
                        Invia preventivo al cliente
                    </a>
                    @can('preventivo_edit')
                        @if( auth()->user()->id === $preventivo->created_by_id || auth()->user()->roles->contains(1))
                            <a class="btn btn-default" href="{{ route('admin.preventivos.edit', $preventivo->id) }}">
                                Modifica
                            </a>
                        @endif
                    @endcan
                    <a class="btn btn-default" onClick="return confirm('Sei sicuro di voler inviare il file?')" href="{{ route('admin.invia.personalizzato', $preventivo->id) }}">
                        Invia File personalizzato al cliente
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.preventivo.fields.numero') }}
                            </th>
                            <td>
                                {{ $preventivo->numero }}/{{ $preventivo->anno }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Tag id
                                <br />
                                <small>(identificativo uso interno)</small>
                            </th>
                            <td>
                                {{ $preventivo->tag_id ?? 'nessuno' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.preventivo.fields.oggetto') }}
                            </th>
                            <td>
                                {{ $preventivo->oggetto }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Date
                            </th>
                            <td>
                                Dal <b>{{ $preventivo->data_inzio_viaggio }}</b> al
                                <b>{{ $preventivo->data_fine_viaggio }}
                                    {{ $preventivo->date_indicative ? '(Date indicative)' : '' }}</b>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.preventivo.fields.numero_persone') }}
                            </th>
                            <td>
                                Persone: {{ $preventivo->numero_persone }} <br>
                                Paganti: {{ $preventivo->numero_persone - $preventivo->numero_gratuita }} <br>
                                Gratuiti: {{ $preventivo->numero_gratuita }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.preventivo.fields.prezzo_per_persona') }}
                            </th>
                            <td>
                                Prezzo per persona: {{ $preventivo->prezzo_per_persona }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.preventivo.fields.cliente') }}
                            </th>
                            <td>
                                {{ $preventivo->cliente->nome ?? '' }} {{ $preventivo->cliente->cognome ?? '' }}
                                {{ $preventivo->cliente->ragione_sociale ?? '' }}
                                {{ $preventivo->rg_fullname ? '(Nome visibile sul preventivo)' : '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Invio mail in copia conoscenza
                            </th>
                            <td>
                                {{ $preventivo->cc_email ?? 'no' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.preventivo.fields.itinerario') }}
                            </th>
                            <td>
                                {{ $preventivo->itinerario->nome ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.preventivo.fields.status') }}
                            </th>
                            <td>
                                {{ App\Models\Preventivo::STATUS_SELECT[$preventivo->status] ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.preventivo.fields.informazioni_aggiuntive') }}
                            </th>
                            <td>
                                {!! $preventivo->informazioni_aggiuntive !!}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.preventivo.fields.file_fornitore_trasporto') }}
                            </th>
                            <td>
                                @foreach($preventivo->file_fornitore_trasporto as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.preventivo.fields.file_fornitore_servizi_extra') }}
                            </th>
                            <td>
                                @foreach($preventivo->file_fornitore_servizi_extra as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.preventivo.fields.file_fornitore_hotel') }}
                            </th>
                            <td>
                                @foreach($preventivo->file_fornitore_hotel as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>
                                File Pratica Attiva
                            </th>
                            <td>
                                @foreach($preventivo->files_pratica as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.preventivo.fields.file_personalizzato') }}
                            </th>
                            <td>
                                @foreach($preventivo->file_personalizzato as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.preventivo.fields.created_by') }}
                            </th>
                            <td>
                                {{ $preventivo->created_by->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Prezzo pacchetto
                            </th>
                            <td>
                                € {{ $preventivo->prezzo_pacchetto }}  / pagante
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Da pagare a parte
                            </th>
                            <td>
                                € {{ $preventivo->prezzo_parte }} separatamente
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Prezzi dettaglio hotel
                            </th>
                            <td>
                                @foreach($preventivo->prezzo_hotel_dettaglio as $hotel_dettaglio)
                                    @if ($hotel_dettaglio['tipo'] === 'per_notte')
                                        <p>{{ $hotel_dettaglio['nome'] }} = {{ $hotel_dettaglio['totale'] }}
                                            (numero stanze {{ $hotel_dettaglio['numero_stanze'] }} x
                                            costo a notte {{ $hotel_dettaglio['costo_a_notte'] }} x
                                            notti {{ $hotel_dettaglio['notti'] }})</p>
                                    @elseif ($hotel_dettaglio['tipo'] === 'per_persona')
                                        <p>{{ $hotel_dettaglio['nome'] }} = {{ $hotel_dettaglio['totale'] }}
                                            (numero stanze {{ $hotel_dettaglio['numero_stanze'] }} x
                                            tipologia stanze {{ $hotel_dettaglio['tipologia_stanza'] }} x
                                            costo a notte {{ $hotel_dettaglio['costo_a_notte'] }} x
                                            notti {{ $hotel_dettaglio['notti'] }})</p>
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Prezzo totale hotel
                            </th>
                            <td>
                                € {{ $preventivo->prezzo_hotel_totale }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Prezzi dettaglio trasporti
                            </th>
                            <td>
                                @foreach($preventivo->prezzo_trasporti_dettaglio as $trasporti_dettaglio)
                                    @if ($trasporti_dettaglio['tipo'] === 'per_persona')
                                        <p>{{ $trasporti_dettaglio['nome'] }} = {{ $trasporti_dettaglio['totale'] }}
                                            (numero persone {{ $trasporti_dettaglio['numero_persone'] }} x
                                            prezzo {{ $trasporti_dettaglio['prezzo'] }})</p>
                                    @elseif ($trasporti_dettaglio['tipo'] === 'una_tantum')
                                        <p>{{ $trasporti_dettaglio['nome'] }} = {{ $trasporti_dettaglio['totale'] }}
                                            (una tantum)</p>
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Prezzi totale trasporti
                            </th>
                            <td>
                                € {{ $preventivo->prezzo_trasporti_totale }}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Prezzi dettaglio servizi
                            </th>
                            <td>
                                @foreach($preventivo->prezzo_servizi_extra_dettaglio as $servizio_extra)
                                    @if ($servizio_extra['tipo'] === 'per_persona')
                                        <p>{{ $servizio_extra['nome'] }} = {{ $servizio_extra['totale'] }}
                                            (numero persone {{ $servizio_extra['numero_persone'] }} x
                                            prezzo {{ $servizio_extra['prezzo'] }})</p>
                                    @elseif ($servizio_extra['tipo'] === 'una_tantum')
                                        <p>{{ $servizio_extra['nome'] }} = {{ $servizio_extra['totale'] }}
                                            (una tantum)</p>
                                    @endif
                                @endforeach
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Prezzo totale servizi
                            </th>
                            <td>
                                € {{ $preventivo->prezzo_servizi_totale }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Markup
                            </th>
                            <td>
                                € {{ $preventivo->markup }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                TOTALE
                            </th>
                            <td>
                                € {{ $preventivo->prezzo_trasporti_totale + $preventivo->prezzo_servizi_totale + $preventivo->prezzo_hotel_totale + $preventivo->prezzo_parte }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.preventivos.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                    <a class="btn btn-default" href="{{ route('admin.duplica.preventivo', ['id'=>$preventivo->id]) }}">
                        Duplica preventivo
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            {{ trans('global.relatedData') }}
        </div>
        <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
            <li class="nav-item">
                <a class="nav-link" href="#preventivo_scadenziarios" role="tab" data-toggle="tab">
                    {{ trans('cruds.scadenziario.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="preventivo_scadenziarios">
                @includeIf('admin.preventivos.relationships.preventivoScadenziarios', [
                    'scadenziarios' => $preventivo->preventivoScadenziarios,
                ])
            </div>
        </div>
    </div>
@endsection
