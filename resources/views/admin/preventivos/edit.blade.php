@extends('layouts.admin')
@section('content')
    <style>
        @media (max-width:801px) {
            .col-6 {
                flex: 0 0 100% !important;
                max-width: 100%;
            }

            .col-4 {
                flex: 0 0 100% !important;
                max-width: 100%;
            }

            .col-3 {
                flex: 0 0 100% !important;
                max-width: 100%;
            }
        }
    </style>
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.preventivo.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.preventivos.update', [$preventivo->id]) }}"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label class="required" for="oggetto">{{ trans('cruds.preventivo.fields.oggetto') }}</label>
                            <input required class="form-control {{ $errors->has('oggetto') ? 'is-invalid' : '' }}"
                                type="text" name="oggetto" id="oggetto"
                                value="{{ old('oggetto', $preventivo->oggetto) }}">
                            @if ($errors->has('oggetto'))
                                <span class="text-danger">{{ $errors->first('oggetto') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.preventivo.fields.oggetto_helper') }}</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="tag_id">Tag id</label>
                            <input class="form-control {{ $errors->has('tag_id') ? 'is-invalid' : '' }}"
                                   type="text" name="tag_id" id="tag_id" value="{{ old('tag_id', $preventivo->tag_id) }}">
                            @if ($errors->has('tag_id'))
                                <span class="text-danger">{{ $errors->first('tag_id') }}</span>
                            @endif
                            <span class="help-block text-secondary">Identificativo ad uso interno <small>(non verrà mostrato nel preventivo)</small></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label class="required"
                                for="numero_persone">{{ trans('cruds.preventivo.fields.numero_persone') }}</label>
                            <input class="form-control {{ $errors->has('numero_persone') ? 'is-invalid' : '' }}"
                                type="number" required name="numero_persone" id="numero_persone"
                                value="{{ old('numero_persone', $preventivo->numero_persone) }}" min="1"
                                step="1">
                            @if ($errors->has('numero_persone'))
                                <span class="text-danger">{{ $errors->first('numero_persone') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.preventivo.fields.numero_persone_helper') }}</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class=""
                                for="prezzo_per_persona">{{ trans('cruds.preventivo.fields.prezzo_per_persona') }}</label>
                            <input class="form-control {{ $errors->has('prezzo_per_persona') ? 'is-invalid' : '' }}"
                                type="number" name="prezzo_per_persona" id="prezzo_per_persona"
                                value="{{ old('prezzo_per_persona', $preventivo->prezzo_per_persona) }}" min="0"
                                step="1">
                            @if ($errors->has('prezzo_per_persona'))
                                <span class="text-danger">{{ $errors->first('prezzo_per_persona') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.preventivo.fields.prezzo_per_persona_helper') }}</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="required"
                                for="numero_gratuita">{{ trans('cruds.preventivo.fields.numero_gratuita') }}</label>
                            <input class="form-control {{ $errors->has('numero_gratuita') ? 'is-invalid' : '' }}"
                                type="number" name="numero_gratuita" id="numero_gratuita"
                                value="{{ old('numero_gratuita', $preventivo->numero_gratuita) }}" step="1"
                                min="0" required>
                            @if ($errors->has('numero_gratuita'))
                                <span class="text-danger">{{ $errors->first('numero_gratuita') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.preventivo.fields.numero_gratuita_helper') }}</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="required" for="markup">{{ trans('cruds.preventivo.fields.markup') }}</label>
                            <input class="form-control {{ $errors->has('markup') ? 'is-invalid' : '' }}" type="number"
                                   name="markup" id="markup" value="{{ old('markup', $preventivo->markup) }}"
                                   step="0.01" required>
                            @if ($errors->has('markup'))
                                <span class="text-danger">{{ $errors->first('markup') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.preventivo.fields.markup_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label class="required" for="cliente_id">{{ trans('cruds.preventivo.fields.cliente') }}</label>
                            <select class="form-control select2 {{ $errors->has('cliente') ? 'is-invalid' : '' }}"
                                name="cliente_id" id="cliente_id" required>
                                @foreach ($clientes as $id => $entry)
                                    <option value="{{ $id }}"
                                        {{ (old('cliente_id') ? old('cliente_id') : $preventivo->cliente->id ?? '') == $id ? 'selected' : '' }}>
                                        {{ $entry }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('cliente'))
                                <span class="text-danger">{{ $errors->first('cliente') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.preventivo.fields.cliente_helper') }}</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="cc_email">Email cc</label>
                            <input class="form-control {{ $errors->has('cc_email') ? 'is-invalid' : '' }}" type="email"
                                   name="cc_email" id="cc_email" value="{{ old('cc_email', $preventivo->cc_email) }}">
                            @if ($errors->has('cc_email'))
                                <span class="text-danger">{{ $errors->first('cc_email') }}</span>
                            @endif
                            <span class="help-block text-secondary">Invia mail in copia conoscenza</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="itinerario_id">{{ trans('cruds.preventivo.fields.itinerario') }}</label>
                            <select class="form-control select2 {{ $errors->has('itinerario') ? 'is-invalid' : '' }}"
                                name="itinerario_id" id="itinerario_id">
                                @foreach ($itinerarios as $id => $entry)
                                    <option value="{{ $id }}"
                                        {{ (old('itinerario_id') ? old('itinerario_id') : $preventivo->itinerario->id ?? '') == $id ? 'selected' : '' }}>
                                        {{ $entry }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('itinerario'))
                                <span class="text-danger">{{ $errors->first('itinerario') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.preventivo.fields.itinerario_helper') }}</span>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="required"
                                        for="data_inzio_viaggio">{{ trans('cruds.preventivo.fields.data_inzio_viaggio') }}</label>
                                    <input
                                        class="form-control date {{ $errors->has('data_inzio_viaggio') ? 'is-invalid' : '' }}"
                                        type="text" name="data_inzio_viaggio" id="data_inzio_viaggio"
                                        value="{{ old('data_inzio_viaggio', $preventivo->data_inzio_viaggio) }}" required>
                                    @if ($errors->has('data_inzio_viaggio'))
                                        <span class="text-danger">{{ $errors->first('data_inzio_viaggio') }}</span>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.preventivo.fields.data_inzio_viaggio_helper') }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="required"
                                        for="data_fine_viaggio">{{ trans('cruds.preventivo.fields.data_fine_viaggio') }}</label>
                                    <input
                                        class="form-control date {{ $errors->has('data_fine_viaggio') ? 'is-invalid' : '' }}"
                                        type="text" name="data_fine_viaggio" id="data_fine_viaggio"
                                        value="{{ old('data_fine_viaggio', $preventivo->data_fine_viaggio) }}" required>
                                    @if ($errors->has('data_fine_viaggio'))
                                        <span class="text-danger">{{ $errors->first('data_fine_viaggio') }}</span>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.preventivo.fields.data_fine_viaggio_helper') }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="created_by_id">{{ trans('cruds.preventivo.fields.created_by') }}</label>
                                    <select
                                        class="form-control select2 {{ $errors->has('created_by') ? 'is-invalid' : '' }}"
                                        name="created_by_id" id="created_by_id">
                                        @foreach ($created_bies as $id => $entry)
                                            <option value="{{ $id }}"
                                                {{ (old('created_by_id') ? old('created_by_id') : $preventivo->created_by->id ?? '') == $id ? 'selected' : '' }}>
                                                {{ $entry }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('created_by'))
                                        <span class="text-danger">{{ $errors->first('created_by') }}</span>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.preventivo.fields.created_by_helper') }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="required">{{ trans('cruds.preventivo.fields.status') }}</label>
                                    <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}"
                                        name="status" id="status" required>
                                        <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>
                                            {{ trans('global.pleaseSelect') }}</option>
                                        @foreach (App\Models\Preventivo::STATUS_SELECT as $key => $label)
                                            <option value="{{ $key }}"
                                                {{ old('status', $preventivo->status) === (string) $key ? 'selected' : '' }}>
                                                {{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('status'))
                                        <span class="text-danger">{{ $errors->first('status') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.preventivo.fields.status_helper') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Corpo email</label>
                            <select id="emailslist" class="form-control">
                                <option value disabled>
                                    {{ trans('global.pleaseSelect') }}
                                </option>
                                @foreach ($emails as $email)
                                    <option data-text="{{ $email->id }}">
                                        {{ $email->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="corpo_email">{{ trans('cruds.preventivo.fields.corpo_email') }}</label>
                            <textarea class="form-control ckEditorCustom {{ $errors->has('corpo_email') ? 'is-invalid' : '' }}"
                                name="corpo_email" id="corpo_email">{!! old('corpo_email', $preventivo->corpo_email) !!}</textarea>
                            @if ($errors->has('corpo_email'))
                                <span class="text-danger">{{ $errors->first('corpo_email') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.preventivo.fields.corpo_email_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="informazioni_aggiuntive">Campo "Attenzione:" (sotto quota non comprende)</label>
                            <textarea class="form-control ckeditor {{ $errors->has('informazioni_aggiuntive') ? 'is-invalid' : '' }}"
                                name="informazioni_aggiuntive" id="informazioni_aggiuntive">{!! old('informazioni_aggiuntive', $preventivo->informazioni_aggiuntive) !!}</textarea>
                            @if ($errors->has('informazioni_aggiuntive'))
                                <span class="text-danger">{{ $errors->first('informazioni_aggiuntive') }}</span>
                            @endif
                            <span
                                class="help-block">{{ trans('cruds.preventivo.fields.informazioni_aggiuntive_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label
                                for="file_fornitore_trasporto">{{ trans('cruds.preventivo.fields.file_fornitore_trasporto') }}</label>
                            <div class="needsclick dropzone {{ $errors->has('file_fornitore_trasporto') ? 'is-invalid' : '' }}"
                                id="file_fornitore_trasporto-dropzone">
                            </div>
                            @if ($errors->has('file_fornitore_trasporto'))
                                <span class="text-danger">{{ $errors->first('file_fornitore_trasporto') }}</span>
                            @endif
                            <span
                                class="help-block">{{ trans('cruds.preventivo.fields.file_fornitore_trasporto_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label
                                for="file_fornitore_servizi_extra">{{ trans('cruds.preventivo.fields.file_fornitore_servizi_extra') }}</label>
                            <div class="needsclick dropzone {{ $errors->has('file_fornitore_servizi_extra') ? 'is-invalid' : '' }}"
                                id="file_fornitore_servizi_extra-dropzone">
                            </div>
                            @if ($errors->has('file_fornitore_servizi_extra'))
                                <span class="text-danger">{{ $errors->first('file_fornitore_servizi_extra') }}</span>
                            @endif
                            <span
                                class="help-block">{{ trans('cruds.preventivo.fields.file_fornitore_servizi_extra_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label
                                for="file_fornitore_hotel">{{ trans('cruds.preventivo.fields.file_fornitore_hotel') }}</label>
                            <div class="needsclick dropzone {{ $errors->has('file_fornitore_hotel') ? 'is-invalid' : '' }}"
                                id="file_fornitore_hotel-dropzone">
                            </div>
                            @if ($errors->has('file_fornitore_hotel'))
                                <span class="text-danger">{{ $errors->first('file_fornitore_hotel') }}</span>
                            @endif
                            <span
                                class="help-block">{{ trans('cruds.preventivo.fields.file_fornitore_hotel_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="files_pratica">{{ trans('cruds.preventivo.fields.files_pratica') }}</label>
                            <div class="needsclick dropzone {{ $errors->has('files_pratica') ? 'is-invalid' : '' }}"
                                id="files_pratica-dropzone">
                            </div>
                            @if ($errors->has('files_pratica'))
                                <span class="text-danger">{{ $errors->first('files_pratica') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.preventivo.fields.files_pratica_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="file_personalizzato">{{ trans('cruds.preventivo.fields.file_personalizzato') }}</label>
                            <div class="needsclick dropzone {{ $errors->has('file_personalizzato') ? 'is-invalid' : '' }}"
                                id="file_personalizzato-dropzone">
                            </div>
                            @if ($errors->has('file_personalizzato'))
                                <span class="text-danger">{{ $errors->first('file_personalizzato') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.preventivo.fields.file_personalizzato_helper') }}</span>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-header">
                        Hotel / Alloggio
                    </div>
                    <div class="card-body">
                        <!--begin::Repeater-->
                        <div id="repeaterhotel">
                            <div class="form-group">
                                <div data-repeater-list="repeaterhotel">
                                    <div data-repeater-item>
                                        <div class="card" style="background-color:#f2fcf5">
                                            <div class="card-header d-flex flex-column">
                                                <div class="row ">
                                                    <div class="col-11">
                                                        Nuovo Hotel
                                                    </div>
                                                    <div class="col-md-1" role="group">
                                                        <p class="float-right">
                                                            <a href="javascript:;" data-repeater-delete
                                                                class="btn btn-sm btn-danger ">
                                                                <i class="la la-trash-o"></i>Elimina
                                                            </a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">

                                                <div class="form-group">
                                                    <label class="required"
                                                        for="hotel_id">{{ trans('cruds.vocePHotel.fields.hotel') }}</label>
                                                    <select style="width:100%" class="form-control select2"
                                                        name="hotel_id" id="hotel_id" required>
                                                        @foreach ($hotels as $id => $entry)
                                                            <option value="{{ $id }}">
                                                                {{ $entry }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="info_aggiuntive">Cosa è compreso / informazioni:</label>
                                                    <textarea class="form-control" name="info_aggiuntive" id="info_aggiuntive"></textarea>
                                                </div>



                                                <div class="card">
                                                    <div class="card-header">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                Stanze costo a notte
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div id="repeater_stanza_costo_a_notte">
                                                            <div data-repeater-list="repeater_stanza_costo_a_notte">
                                                                <div class="form-group">
                                                                    <div data-repeater-item>
                                                                        <div class="card">
                                                                            <div class="card-header">
                                                                                <div class="row "
                                                                                    style="margin-bottom:-20px;">
                                                                                    <div class="col-11">
                                                                                        Stanza
                                                                                    </div>
                                                                                    <div class="col-md-1" role="group">
                                                                                        <p class="float-right">
                                                                                            <a href="javascript:;"
                                                                                                data-repeater-delete
                                                                                                class="btn btn-sm btn-danger ">
                                                                                                <i
                                                                                                    class="la la-trash-o"></i>Elimina
                                                                                            </a>
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <div class="row">
                                                                                    <div class="col-4">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                class="required">{{ trans('cruds.vocePHotelPerNotte.fields.tipologia_stanza') }}</label>
                                                                                            <select class="form-control"
                                                                                                name="tipologia_stanza"
                                                                                                id="tipologia_stanza"
                                                                                                required>
                                                                                                <option value disabled>
                                                                                                    {{ trans('global.pleaseSelect') }}
                                                                                                </option>
                                                                                                @foreach (App\Models\VocePHotelPerNotte::TIPOLOGIA_STANZA_SELECT as $key => $label)
                                                                                                    <option
                                                                                                        value="{{ $key }}">
                                                                                                        {{ $label }}
                                                                                                    </option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-4">
                                                                                        <div class="form-group">
                                                                                            <label class="required"
                                                                                                for="numero_stanze">N
                                                                                                Stanze / N Persone (se
                                                                                                multipla)</label>
                                                                                            <input class="form-control"
                                                                                                type="number"
                                                                                                name="numero_stanze"
                                                                                                id="numero_stanze"
                                                                                                value=""
                                                                                                min="0"
                                                                                                step="1" required>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-4">
                                                                                        <div class="form-group">
                                                                                            <label class="required"
                                                                                                for="costo_a_notte">{{ trans('cruds.vocePHotelPerNotte.fields.costo_a_notte') }}/Notte</label>
                                                                                            <input class="form-control"
                                                                                                type="number"
                                                                                                name="costo_a_notte"
                                                                                                id="costo_a_notte"
                                                                                                value=""
                                                                                                min="0"
                                                                                                step="0.01" required>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="form-check">
                                                                                        <input type="hidden"
                                                                                            name="scorpora"
                                                                                            value="0">
                                                                                        <input class="form-check-input"
                                                                                            type="checkbox"
                                                                                            name="scorpora" id="scorpora"
                                                                                            value="1">
                                                                                        <label class="form-check-label"
                                                                                            for="scorpora">{{ trans('cruds.vocePHotelPerNotte.fields.scorpora') }}</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mt-5">
                                                                <a href="javascript:;" data-repeater-create
                                                                    class="btn btn-success">
                                                                    <i class="la la-plus"></i>Nuova Stanza
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Form group-->

                            <!--begin::Form group-->
                            <div class="form-group mt-5">
                                <a href="javascript:;" data-repeater-create class="btn btn-success">
                                    <i class="la la-plus"></i>Nuovo Hotel/Alloggio
                                </a>
                            </div>
                            <!--end::Form group-->
                        </div>
                        <!--end::Repeater-->
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        Trasporto
                    </div>

                    <div class="card-body">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-6">
                                        Trasporto principale
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label
                                                for="trasporto_id">{{ trans('cruds.vocePTrasportoPerPersona.fields.trasporto') }}</label>
                                            <select class="form-control select2"
                                                name="trasportoprincipaleandata[trasporto_id]" id="trasporto_id">
                                                @foreach ($trasportos as $id => $entry)
                                                    <option value="{{ $id }}"
                                                        @if ($preventivo->trasportoPrincipaleAndata()) {{ ($preventivo->trasportoPrincipaleAndata()->trasporto_id ?? '') == $id ? 'selected' : '' }} @endif>
                                                        {{ $entry }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Tipologia di trasporto andata</label>
                                            <select name="trasportoprincipaleandata[tipologia]" class="form-control">
                                                @if ($preventivo->trasportoPrincipaleAndataTipologia())
                                                    <option selected value="persona">
                                                        Costo a persona
                                                    </option>
                                                    <option value="tantum">
                                                        Costo una tantum
                                                    </option>
                                                @else
                                                    <option value="persona">
                                                        Costo a persona
                                                    </option>
                                                    <option selected value="tantum">
                                                        Costo una tantum
                                                    </option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="prezzo">Prezzo</label>
                                            <input class="form-control" type="number"
                                                name="trasportoprincipaleandata[prezzo]" id="prezzo" min="0"
                                                step="0.01"
                                                @if ($preventivo->trasportoPrincipaleAndata()) value="{{ $preventivo->trasportoPrincipaleAndata()->prezzo }}" @endif>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input type="hidden" name="trasportoprincipaleandata[scorpora]"
                                                    value="0">
                                                <input class="form-check-input" type="checkbox"
                                                    name="trasportoprincipaleandata[scorpora]"
                                                    id="trasportoprincipaleandata[scorpora]" value="1"
                                                    @if ($preventivo->trasportoPrincipaleAndata()) {{ $preventivo->trasportoPrincipaleAndata()->scorpora === 1 ? 'checked' : '' }} @endif>
                                                <label class="form-check-label"
                                                    for="trasportoprincipaleandata[scorpora]">{{ trans('cruds.vocePHotelPerNotte.fields.scorpora') }}</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label
                                                for="luogo_di_partenza_andata">{{ trans('cruds.preventivo.fields.luogo_di_partenza_andata') }}</label>
                                            <input
                                                class="form-control {{ $errors->has('luogo_di_partenza_andata') ? 'is-invalid' : '' }}"
                                                type="text" name="luogo_di_partenza_andata"
                                                id="luogo_di_partenza_andata"
                                                value="{{ old('luogo_di_partenza_andata', $preventivo->luogo_di_partenza_andata) }}">
                                            @if ($errors->has('luogo_di_partenza_andata'))
                                                <span
                                                    class="text-danger">{{ $errors->first('luogo_di_partenza_andata') }}</span>
                                            @endif
                                            <span class="help-block">
                                                {{ trans('cruds.preventivo.fields.luogo_di_partenza_andata_helper') }}</span>
                                        </div>
                                        <div class="form-group">
                                            <label
                                                for="luogo_di_arrivo_andata">{{ trans('cruds.preventivo.fields.luogo_di_arrivo_andata') }}</label>
                                            <input
                                                class="form-control {{ $errors->has('luogo_di_arrivo_andata') ? 'is-invalid' : '' }}"
                                                type="text" name="luogo_di_arrivo_andata" id="luogo_di_arrivo_andata"
                                                value="{{ old('luogo_di_arrivo_andata', $preventivo->luogo_di_arrivo_andata) }}">
                                            @if ($errors->has('luogo_di_arrivo_andata'))
                                                <span
                                                    class="text-danger">{{ $errors->first('luogo_di_arrivo_andata') }}</span>
                                            @endif
                                            <span
                                                class="help-block">{{ trans('cruds.preventivo.fields.luogo_di_arrivo_andata_helper') }}</span>
                                        </div>
                                        <div class="form-group">
                                            <label
                                                for="data_ora_partenza_andata">{{ trans('cruds.preventivo.fields.data_ora_partenza_andata') }}</label>
                                            <input
                                                class="form-control datetime {{ $errors->has('data_ora_partenza_andata') ? 'is-invalid' : '' }}"
                                                type="text" name="data_ora_partenza_andata"
                                                id="data_ora_partenza_andata"
                                                value="{{ old('data_ora_partenza_andata', $preventivo->data_ora_partenza_andata) }}">
                                            @if ($errors->has('data_ora_partenza_andata'))
                                                <span
                                                    class="text-danger">{{ $errors->first('data_ora_partenza_andata') }}</span>
                                            @endif
                                            <span
                                                class="help-block">{{ trans('cruds.preventivo.fields.data_ora_partenza_andata_helper') }}</span>
                                        </div>
                                        <div class="form-group">
                                            <label
                                                for="data_ora_rientro_andata">{{ trans('cruds.preventivo.fields.data_ora_rientro_andata') }}</label>
                                            <input
                                                class="form-control datetime {{ $errors->has('data_ora_rientro_andata') ? 'is-invalid' : '' }}"
                                                type="text" name="data_ora_rientro_andata"
                                                id="data_ora_rientro_andata"
                                                value="{{ old('data_ora_rientro_andata', $preventivo->data_ora_rientro_andata) }}">
                                            @if ($errors->has('data_ora_rientro_andata'))
                                                <span
                                                    class="text-danger">{{ $errors->first('data_ora_rientro_andata') }}</span>
                                            @endif
                                            <span
                                                class="help-block">{{ trans('cruds.preventivo.fields.data_ora_rientro_andata_helper') }}</span>
                                        </div>
                                        <div class="form-group">
                                            <label
                                                for="kg_bg_a_mano_andata">{{ trans('cruds.preventivo.fields.kg_bg_a_mano_andata') }}</label>
                                            <input
                                                class="form-control {{ $errors->has('kg_bg_a_mano_andata') ? 'is-invalid' : '' }}"
                                                type="number" name="kg_bg_a_mano_andata" id="kg_bg_a_mano_andata"
                                                value="{{ old('kg_bg_a_mano_andata', $preventivo->kg_bg_a_mano_andata) }}"
                                                step="1">
                                            @if ($errors->has('kg_bg_a_mano_andata'))
                                                <span
                                                    class="text-danger">{{ $errors->first('kg_bg_a_mano_andata') }}</span>
                                            @endif
                                            <span
                                                class="help-block">{{ trans('cruds.preventivo.fields.kg_bg_a_mano_andata_helper') }}</span>
                                        </div>
                                        <div class="form-group">
                                            <label
                                                for="kg_bg_in_stiva_andata">{{ trans('cruds.preventivo.fields.kg_bg_in_stiva_andata') }}</label>
                                            <input
                                                class="form-control {{ $errors->has('kg_bg_in_stiva_andata') ? 'is-invalid' : '' }}"
                                                type="number" name="kg_bg_in_stiva_andata" id="kg_bg_in_stiva_andata"
                                                value="{{ old('kg_bg_in_stiva_andata', $preventivo->kg_bg_in_stiva_andata) }}"
                                                step="1">
                                            @if ($errors->has('kg_bg_in_stiva_andata'))
                                                <span
                                                    class="text-danger">{{ $errors->first('kg_bg_in_stiva_andata') }}</span>
                                            @endif
                                            <span
                                                class="help-block">{{ trans('cruds.preventivo.fields.kg_bg_in_stiva_andata_helper') }}</span>
                                        </div>
                                        <div class="form-group">
                                            <label
                                                for="andata_azienda_trasporto_id">{{ trans('cruds.preventivo.fields.andata_azienda_trasporto') }}</label>
                                            <select
                                                class="form-control select2 {{ $errors->has('andata_azienda_trasporto') ? 'is-invalid' : '' }}"
                                                name="andata_azienda_trasporto_id" id="andata_azienda_trasporto_id">
                                                @foreach ($andata_azienda_trasportos as $id => $entry)
                                                    <option value="{{ $id }}"
                                                        {{ (old('andata_azienda_trasporto_id') ? old('andata_azienda_trasporto_id') : $preventivo->andata_azienda_trasporto->id ?? '') == $id ? 'selected' : '' }}>
                                                        {{ $entry }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('andata_azienda_trasporto'))
                                                <span
                                                    class="text-danger">{{ $errors->first('andata_azienda_trasporto') }}</span>
                                            @endif
                                            <span
                                                class="help-block">{{ trans('cruds.preventivo.fields.andata_azienda_trasporto_helper') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label
                                                for="trasporto_id">{{ trans('cruds.vocePTrasportoPerPersona.fields.trasporto') }}</label>
                                            <select class="form-control select2"
                                                name="trasportoprincipalerientro[trasporto_id]" id="trasporto_id">
                                                @foreach ($trasportos as $id => $entry)
                                                    <option value="{{ $id }}"
                                                        @if ($preventivo->trasportoPrincipaleRientro()) {{ $preventivo->trasportoPrincipaleRientro()->trasporto_id == $id ? 'selected' : '' }} @endif>
                                                        {{ $entry }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Tipologia di trasporto rientro</label>
                                            <select name="trasportoprincipalerientro[tipologia]" class="form-control">
                                                @if ($preventivo->trasportoPrincipaleRientroTipologia())
                                                    <option selected value="persona">
                                                        Costo a persona
                                                    </option>
                                                    <option value="tantum">
                                                        Costo una tantum
                                                    </option>
                                                @else
                                                    <option value="persona">
                                                        Costo a persona
                                                    </option>
                                                    <option selected value="tantum">
                                                        Costo una tantum
                                                    </option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="trasportoprincipalerientro[prezzo]">Prezzo</label>
                                            <input class="form-control" type="number"
                                                name="trasportoprincipalerientro[prezzo]"
                                                id="trasportoprincipalerientro[prezzo]" min="0" step="0.01"
                                                @if ($preventivo->trasportoPrincipaleRientro()) value="{{ $preventivo->trasportoPrincipaleRientro()->prezzo }}" @endif>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input type="hidden" name="trasportoprincipalerientro[scorpora]"
                                                    value="0">
                                                <input class="form-check-input" type="checkbox"
                                                    name="trasportoprincipalerientro[scorpora]"
                                                    id="trasportoprincipalerientro[scorpora]" value="1"
                                                    @if ($preventivo->trasportoPrincipaleRientro()) {{ $preventivo->trasportoPrincipaleRientro()->scorpora === 1 ? 'checked' : '' }} @endif>
                                                <label class="form-check-label"
                                                    for="trasportoprincipalerientro[scorpora]">{{ trans('cruds.vocePHotelPerNotte.fields.scorpora') }}</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label
                                                for="luogo_di_partenza_rientro">{{ trans('cruds.preventivo.fields.luogo_di_partenza_rientro') }}</label>
                                            <input
                                                class="form-control {{ $errors->has('luogo_di_partenza_rientro') ? 'is-invalid' : '' }}"
                                                type="text" name="luogo_di_partenza_rientro"
                                                id="luogo_di_partenza_rientro"
                                                value="{{ old('luogo_di_partenza_rientro', $preventivo->luogo_di_partenza_rientro) }}">
                                            @if ($errors->has('luogo_di_partenza_rientro'))
                                                <span
                                                    class="text-danger">{{ $errors->first('luogo_di_partenza_rientro') }}</span>
                                            @endif
                                            <span
                                                class="help-block">{{ trans('cruds.preventivo.fields.luogo_di_partenza_rientro_helper') }}</span>
                                        </div>
                                        <div class="form-group">
                                            <label
                                                for="luogo_di_arrivo_rientro">{{ trans('cruds.preventivo.fields.luogo_di_arrivo_rientro') }}</label>
                                            <input
                                                class="form-control {{ $errors->has('luogo_di_arrivo_rientro') ? 'is-invalid' : '' }}"
                                                type="text" name="luogo_di_arrivo_rientro"
                                                id="luogo_di_arrivo_rientro"
                                                value="{{ old('luogo_di_arrivo_rientro', $preventivo->luogo_di_arrivo_rientro) }}">
                                            @if ($errors->has('luogo_di_arrivo_rientro'))
                                                <span
                                                    class="text-danger">{{ $errors->first('luogo_di_arrivo_rientro') }}</span>
                                            @endif
                                            <span
                                                class="help-block">{{ trans('cruds.preventivo.fields.luogo_di_arrivo_rientro_helper') }}</span>
                                        </div>
                                        <div class="form-group">
                                            <label
                                                for="data_ora_partenza_rientro">{{ trans('cruds.preventivo.fields.data_ora_partenza_rientro') }}</label>
                                            <input
                                                class="form-control datetime {{ $errors->has('data_ora_partenza_rientro') ? 'is-invalid' : '' }}"
                                                type="text" name="data_ora_partenza_rientro"
                                                id="data_ora_partenza_rientro"
                                                value="{{ old('data_ora_partenza_rientro', $preventivo->data_ora_partenza_rientro) }}">
                                            @if ($errors->has('data_ora_partenza_rientro'))
                                                <span
                                                    class="text-danger">{{ $errors->first('data_ora_partenza_rientro') }}</span>
                                            @endif
                                            <span
                                                class="help-block">{{ trans('cruds.preventivo.fields.data_ora_partenza_rientro_helper') }}</span>
                                        </div>
                                        <div class="form-group">
                                            <label
                                                for="data_ora_rientro_rientro">{{ trans('cruds.preventivo.fields.data_ora_rientro_rientro') }}</label>
                                            <input
                                                class="form-control datetime {{ $errors->has('data_ora_rientro_rientro') ? 'is-invalid' : '' }}"
                                                type="text" name="data_ora_rientro_rientro"
                                                id="data_ora_rientro_rientro"
                                                value="{{ old('data_ora_rientro_rientro', $preventivo->data_ora_rientro_rientro) }}">
                                            @if ($errors->has('data_ora_rientro_rientro'))
                                                <span
                                                    class="text-danger">{{ $errors->first('data_ora_rientro_rientro') }}</span>
                                            @endif
                                            <span
                                                class="help-block">{{ trans('cruds.preventivo.fields.data_ora_rientro_rientro_helper') }}</span>
                                        </div>
                                        <div class="form-group">
                                            <label
                                                for="kg_bg_a_mano_ritorno">{{ trans('cruds.preventivo.fields.kg_bg_a_mano_ritorno') }}</label>
                                            <input
                                                class="form-control {{ $errors->has('kg_bg_a_mano_ritorno') ? 'is-invalid' : '' }}"
                                                type="number" name="kg_bg_a_mano_ritorno" id="kg_bg_a_mano_ritorno"
                                                value="{{ old('kg_bg_a_mano_ritorno', $preventivo->kg_bg_a_mano_ritorno) }}"
                                                step="1">
                                            @if ($errors->has('kg_bg_a_mano_ritorno'))
                                                <span
                                                    class="text-danger">{{ $errors->first('kg_bg_a_mano_ritorno') }}</span>
                                            @endif
                                            <span
                                                class="help-block">{{ trans('cruds.preventivo.fields.kg_bg_a_mano_ritorno_helper') }}</span>
                                        </div>
                                        <div class="form-group">
                                            <label
                                                for="kg_bg_in_stiva_ritorno">{{ trans('cruds.preventivo.fields.kg_bg_in_stiva_ritorno') }}</label>
                                            <input
                                                class="form-control {{ $errors->has('kg_bg_in_stiva_ritorno') ? 'is-invalid' : '' }}"
                                                type="number" name="kg_bg_in_stiva_ritorno" id="kg_bg_in_stiva_ritorno"
                                                value="{{ old('kg_bg_in_stiva_ritorno', $preventivo->kg_bg_in_stiva_ritorno) }}"
                                                step="1">
                                            @if ($errors->has('kg_bg_in_stiva_ritorno'))
                                                <span
                                                    class="text-danger">{{ $errors->first('kg_bg_in_stiva_ritorno') }}</span>
                                            @endif
                                            <span
                                                class="help-block">{{ trans('cruds.preventivo.fields.kg_bg_in_stiva_ritorno_helper') }}</span>
                                        </div>
                                        <div class="form-group">
                                            <label
                                                for="ritorno_azienda_trasporto_id">{{ trans('cruds.preventivo.fields.ritorno_azienda_trasporto') }}</label>
                                            <select
                                                class="form-control select2 {{ $errors->has('ritorno_azienda_trasporto') ? 'is-invalid' : '' }}"
                                                name="ritorno_azienda_trasporto_id" id="ritorno_azienda_trasporto_id">
                                                @foreach ($ritorno_azienda_trasportos as $id => $entry)
                                                    <option value="{{ $id }}"
                                                        {{ (old('ritorno_azienda_trasporto_id') ? old('ritorno_azienda_trasporto_id') : $preventivo->ritorno_azienda_trasporto->id ?? '') == $id ? 'selected' : '' }}>
                                                        {{ $entry }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('ritorno_azienda_trasporto'))
                                                <span
                                                    class="text-danger">{{ $errors->first('ritorno_azienda_trasporto') }}</span>
                                            @endif
                                            <span
                                                class="help-block">{{ trans('cruds.preventivo.fields.ritorno_azienda_trasporto_helper') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-6">
                                        Trasporti costo a persona
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" style="background-color:#cce3ff">
                                <div id="repeater_trasporto_costo_a_persona">
                                    <div data-repeater-list="repeater_trasporto_costo_a_persona">
                                        <div class="form-group">
                                            <div data-repeater-item>
                                                <div class="card">
                                                    <div class="card-header">
                                                        <div class="row " style="margin-bottom:-20px;">
                                                            <div class="col-11">
                                                                Trasporto con costo a persona
                                                            </div>
                                                            <div class="col-md-1" role="group">
                                                                <p class="float-right">
                                                                    <a href="javascript:;" data-repeater-delete
                                                                        class="btn btn-sm btn-danger ">
                                                                        <i class="la la-trash-o"></i>Elimina
                                                                    </a>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label class="required"
                                                                        for="trasporto_id">{{ trans('cruds.vocePTrasportoPerPersona.fields.trasporto') }}</label>
                                                                    <select class="form-control select2"
                                                                        name="trasporto_id" id="trasporto_id" required>
                                                                        @foreach ($trasportos as $id => $entry)
                                                                            <option value="{{ $id }}"
                                                                                {{ old('trasporto_id') == $id ? 'selected' : '' }}>
                                                                                {{ $entry }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="required"
                                                                        for="prezzo">{{ trans('cruds.vocePTrasportoPerPersona.fields.prezzo') }}</label>
                                                                    <input class="form-control" type="number"
                                                                        name="prezzo" id="prezzo" min="0"
                                                                        step="0.01" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="form-check">
                                                                        <input type="hidden" name="scorpora"
                                                                            value="0">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            name="scorpora" id="scorpora"
                                                                            value="1">
                                                                        <label class="form-check-label"
                                                                            for="scorpora">{{ trans('cruds.vocePHotelPerNotte.fields.scorpora') }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="informazioni_aggiuntive">{!! trans('cruds.vocePTrasportoPerPersona.fields.informazioni_aggiuntive') !!}</label>
                                                                    <textarea class="form-control" name="informazioni_aggiuntive" id="informazioni_aggiuntive"></textarea>

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-5">
                                        <a href="javascript:;" data-repeater-create class="btn btn-success">
                                            <i class="la la-plus"></i>Nuovo Trasporto
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-6">
                                        Trasporti costi una tantum
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" style="background-color:#cce3ff">
                                <div id="repeater_trasporto_costo_una_tantum">
                                    <div data-repeater-list="repeater_trasporto_costo_una_tantum">
                                        <div class="form-group">
                                            <div data-repeater-item>
                                                <div class="card">
                                                    <div class="card-header">
                                                        <div class="row " style="margin-bottom:-20px;">
                                                            <div class="col-11">
                                                                Trasporto con costo una tantum
                                                            </div>
                                                            <div class="col-md-1" role="group">
                                                                <p class="float-right">
                                                                    <a href="javascript:;" data-repeater-delete
                                                                        class="btn btn-sm btn-danger ">
                                                                        <i class="la la-trash-o"></i>Elimina
                                                                    </a>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label class="required"
                                                                        for="trasporto_id">{{ trans('cruds.vocePTrasportoPerPersona.fields.trasporto') }}</label>
                                                                    <select class="form-control select2"
                                                                        name="trasporto_id" id="trasporto_id" required>
                                                                        @foreach ($trasportos as $id => $entry)
                                                                            <option value="{{ $id }}"
                                                                                {{ old('trasporto_id') == $id ? 'selected' : '' }}>
                                                                                {{ $entry }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="required" for="prezzo">Prezzo</label>
                                                                    <input class="form-control" type="number"
                                                                        name="prezzo" id="prezzo" min="0"
                                                                        step="0.01" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="form-check">
                                                                        <input type="hidden" name="scorpora"
                                                                            value="0">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            name="scorpora" id="scorpora"
                                                                            value="1">
                                                                        <label class="form-check-label"
                                                                            for="scorpora">{{ trans('cruds.vocePHotelPerNotte.fields.scorpora') }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="informazioni_aggiuntive">{!! trans('cruds.vocePTrasportoPerPersona.fields.informazioni_aggiuntive') !!}</label>
                                                                    <textarea class="form-control" name="informazioni_aggiuntive" id="informazioni_aggiuntive"></textarea>

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-5">
                                        <a href="javascript:;" data-repeater-create class="btn btn-success">
                                            <i class="la la-plus"></i>Nuovo Trasporto
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        Servizi extra
                    </div>
                    <div class="card-body">
                        <div class="card" style="background-color:#feffed">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-6">
                                        Servizi costi una tantum
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="repeater_serviziextra_costo_una_tantum">
                                    <div data-repeater-list="repeater_serviziextra_costo_una_tantum">
                                        <div class="form-group">
                                            <div data-repeater-item>
                                                <div class="card">
                                                    <div class="card-header">
                                                        <div class="row " style="margin-bottom:-20px;">
                                                            <div class="col-11">
                                                                Servizi con costo una tantum
                                                            </div>
                                                            <div class="col-md-1" role="group">
                                                                <p class="float-right">
                                                                    <a href="javascript:;" data-repeater-delete
                                                                        class="btn btn-sm btn-danger ">
                                                                        <i class="la la-trash-o"></i>Elimina
                                                                    </a>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label class="required"
                                                                        for="servizio_extra_id">{{ trans('cruds.vocePExtraUnaTantum.fields.servizio_extra') }}</label>
                                                                    <select class="form-control select2"
                                                                        name="servizio_extra_id" id="servizio_extra_id"
                                                                        required>
                                                                        @foreach ($servizio_extras as $id => $entry)
                                                                            <option value="{{ $id }}">
                                                                                {{ $entry }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="required" for="prezzo">Prezzo</label>
                                                                    <input class="form-control" type="number"
                                                                        name="prezzo" id="prezzo" min="0"
                                                                        step="0.01" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="required"
                                                                        for="quantita">{{ trans('cruds.vocePExtraPerPersona.fields.quantita') }}</label>
                                                                    <input class="form-control " type="number"
                                                                        name="quantita" id="quantita" value="1"
                                                                        step="1" min="1" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="form-check">
                                                                        <input type="hidden" name="scorpora"
                                                                            value="0">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            name="scorpora" id="scorpora"
                                                                            value="1">
                                                                        <label class="form-check-label"
                                                                            for="scorpora">{{ trans('cruds.vocePHotelPerNotte.fields.scorpora') }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="informazioni_aggiuntive">{!! trans('cruds.vocePTrasportoPerPersona.fields.informazioni_aggiuntive') !!}</label>
                                                                    <textarea class="form-control" name="informazioni_aggiuntive" id="informazioni_aggiuntive"></textarea>

                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="quota_comprende">La quota comprende</label>
                                                                    <textarea class="form-control" name="quota_comprende" id="quota_comprende"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-5">
                                        <a href="javascript:;" data-repeater-create class="btn btn-success">
                                            <i class="la la-plus"></i>Nuovo Servizio
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card" style="background-color:#feffed">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-6">
                                        Servizi costi a persona
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="repeater_serviziextra_costo_a_persona">
                                    <div data-repeater-list="repeater_serviziextra_costo_a_persona">
                                        <div class="form-group">
                                            <div data-repeater-item>
                                                <div class="card">
                                                    <div class="card-header">
                                                        <div class="row " style="margin-bottom:-20px;">
                                                            <div class="col-11">
                                                                Servizi con costo a persona
                                                            </div>
                                                            <div class="col-md-1" role="group">
                                                                <p class="float-right">
                                                                    <a href="javascript:;" data-repeater-delete
                                                                        class="btn btn-sm btn-danger ">
                                                                        <i class="la la-trash-o"></i>Elimina
                                                                    </a>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label class="required"
                                                                        for="servizio_extra_id">{{ trans('cruds.vocePExtraUnaTantum.fields.servizio_extra') }}</label>
                                                                    <select class="form-control select2"
                                                                        name="servizio_extra_id" id="servizio_extra_id"
                                                                        required>
                                                                        @foreach ($servizio_extras as $id => $entry)
                                                                            <option value="{{ $id }}">
                                                                                {{ $entry }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="required" for="prezzo">Prezzo</label>
                                                                    <input class="form-control" type="number"
                                                                        name="prezzo" id="prezzo" min="0"
                                                                        step="0.01" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="required" for="quantita">Quantità
                                                                        servizi per persona</label>
                                                                    <input class="form-control " type="number"
                                                                        name="quantita" id="quantita" value="1"
                                                                        step="1" min="1" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="form-check">
                                                                        <input type="hidden" name="scorpora"
                                                                            value="0">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            name="scorpora" id="scorpora"
                                                                            value="1">
                                                                        <label class="form-check-label"
                                                                            for="scorpora">{{ trans('cruds.vocePHotelPerNotte.fields.scorpora') }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="informazioni_aggiuntive">{!! trans('cruds.vocePTrasportoPerPersona.fields.informazioni_aggiuntive') !!}</label>
                                                                    <textarea class="form-control" name="informazioni_aggiuntive" id="informazioni_aggiuntive"></textarea>

                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="quota_comprende">La quota comprende</label>
                                                                    <textarea class="form-control" name="quota_comprende" id="quota_comprende"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-5">
                                        <a href="javascript:;" data-repeater-create class="btn btn-success">
                                            <i class="la la-plus"></i>Nuovo Servizio
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @foreach ($emails as $email)
                    <div style="display:none" id="email_{{ $email->id }}">
                        {!! $email->corpo_email !!}
                    </div>
                @endforeach

                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        Dropzone.autoDiscover = false;
    </script>
    <script>
        $(document).ready(function() {
            function SimpleUploadAdapter(editor) {
                editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
                    return {
                        upload: function() {
                            return loader.file
                                .then(function(file) {
                                    return new Promise(function(resolve, reject) {
                                        // Init request
                                        var xhr = new XMLHttpRequest();
                                        xhr.open('POST',
                                            '{{ route('admin.email-standards.storeCKEditorImages') }}',
                                            true);
                                        xhr.setRequestHeader('x-csrf-token', window._token);
                                        xhr.setRequestHeader('Accept', 'application/json');
                                        xhr.responseType = 'json';

                                        // Init listeners
                                        var genericErrorText =
                                            `Couldn't upload file: ${ file.name }.`;
                                        xhr.addEventListener('error', function() {
                                            reject(genericErrorText)
                                        });
                                        xhr.addEventListener('abort', function() {
                                            reject()
                                        });
                                        xhr.addEventListener('load', function() {
                                            var response = xhr.response;

                                            if (!response || xhr.status !== 201) {
                                                return reject(response && response
                                                    .message ?
                                                    `${genericErrorText}\n${xhr.status} ${response.message}` :
                                                    `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`
                                                );
                                            }

                                            $('form').append(
                                                '<input type="hidden" name="ck-media[]" value="' +
                                                response.id + '">');

                                            resolve({
                                                default: response.url
                                            });
                                        });

                                        if (xhr.upload) {
                                            xhr.upload.addEventListener('progress', function(
                                                e) {
                                                if (e.lengthComputable) {
                                                    loader.uploadTotal = e.total;
                                                    loader.uploaded = e.loaded;
                                                }
                                            });
                                        }

                                        // Send request
                                        var data = new FormData();
                                        data.append('upload', file);
                                        data.append('crud_id',
                                            '{{ $emailStandard->id ?? 0 }}');
                                        xhr.send(data);
                                    });
                                })
                        }
                    };
                }
            }

            var allEditors = document.querySelectorAll('.ckEditorCustom');
            for (var i = 0; i < allEditors.length; ++i) {
                ClassicEditor.create(
                    allEditors[i], {
                        extraPlugins: [SimpleUploadAdapter]
                    }
                ).then(editor => {
                    $('#emailslist').change(function() {
                        var selectedOption = $(this).find('option:selected');
                        var dataText = selectedOption.attr('data-text');

                        editor.setData($('#email_' + dataText).html());
                    });
                });
            }

            var allEditors = document.querySelectorAll('.ckeditor');
            for (var i = 0; i < allEditors.length; ++i) {
                ClassicEditor.create(
                    allEditors[i], {
                        extraPlugins: [SimpleUploadAdapter]
                    }
                ).then(editor => {

                });
            }

        });
    </script>
    <script>
        $(document).ready(function() {

            let numero_gratuita = document.querySelector('#numero_gratuita');

            numero_gratuita.addEventListener('input', function() {
                checkValue();
            });
            let numero_persone = document.querySelector('#numero_persone');

            numero_persone.addEventListener('input', function() {
                checkValue();
            });


            function checkValue() {
                var maxValue = $('#numero_persone').val();
                val = $('#numero_gratuita').val();
                if (Number(val) > Number(maxValue)) {
                    $('#numero_gratuita').val(Number(maxValue));
                }
            }

            var $repeaterhotel = $('#repeaterhotel').repeater({
                initEmpty: false,

                repeaters: [{
                    initEmpty: false,
                    selector: '#repeater_stanza_costo_a_notte',
                    show: function() {
                        $(this).slideDown();
                    },

                    hide: function(deleteElement) {
                        $(this).slideUp(deleteElement);
                    }
                }],

                show: function() {
                    $(this).slideDown();
                    $('.select2-container').remove();
                    $('.select2').select2({
                        placeholder: "Seleziona hotel",
                        allowClear: true
                    });
                    $('.select2-container').css('width', '100%');
                },

                hide: function(deleteElement) {
                    $(this).slideUp(deleteElement);
                },
                ready: function(setIndexes) {

                    setIndexes(); // this will reindex the list

                },

            });

            $repeaterhotel.setList([
                @php
                    $hotels = $preventivo->hotels();
                @endphp
                @foreach ($hotels as $hotel)
                    {
                        'info_aggiuntive': `{!! preg_replace('/\s\s+/', '\n', $hotel->info_aggiuntive) !!}`,
                        'hotel_id': {{ $hotel->hotel->id }},
                        @php
                            $counterStanze = 0;
                        @endphp
                        @foreach ($hotel->vociNotti() as $voceNotte)
                            @php $counterStanze++; @endphp
                        @endforeach
                        @if ($counterStanze != 0)
                            'repeater_stanza_costo_a_notte': [
                                @foreach ($hotel->vociNotti() as $voceNotte)
                                    {
                                        @if ($voceNotte->tipologia_stanza)
                                            'tipologia_stanza': '{{ $voceNotte->tipologia_stanza }}',
                                        @endif
                                        @if ($voceNotte->numero_stanze)
                                            'numero_stanze': {{ $voceNotte->numero_stanze }},
                                        @endif
                                        @if ($voceNotte->costo_a_notte)
                                            'costo_a_notte': {{ $voceNotte->costo_a_notte }},
                                        @endif
                                        @if ($voceNotte->scorpora)
                                            'scorpora': {{ $voceNotte->scorpora }}
                                        @endif
                                    },
                                @endforeach
                            ],
                        @endif
                    },
                @endforeach
            ]);


            var $repeater_trasporto_costo_a_persona = $('#repeater_trasporto_costo_a_persona').repeater({
                initEmpty: false,


                show: function() {
                    $(this).slideDown();
                    $('.select2-container').remove();
                    $('.select2').select2({
                        placeholder: "Seleziona trasporto",
                        allowClear: true
                    });
                    $('.select2-container').css('width', '100%');
                },

                hide: function(deleteElement) {
                    $(this).slideUp(deleteElement);
                },
                ready: function(setIndexes) {

                    setIndexes(); // this will reindex the list

                },

            });

            $repeater_trasporto_costo_a_persona.setList([
                @foreach ($preventivo->trasporto_persona() as $trasporto)
                    {
                        @if ($trasporto->prezzo)
                            'prezzo': {{ $trasporto->prezzo }},
                        @endif
                        @if ($trasporto->informazioni_aggiuntive)

                            'informazioni_aggiuntive': `{!! preg_replace('/\s\s+/', '\n', $trasporto->informazioni_aggiuntive) !!}`,
                        @endif
                        @if ($trasporto->scorpora)
                            'scorpora': {{ $trasporto->scorpora }},
                        @endif
                        @if ($trasporto->trasporto_id)
                            'trasporto_id': {{ $trasporto->trasporto_id }},
                        @endif
                    },
                @endforeach
            ]);


            var $repeater_trasporto_costo_una_tantum = $('#repeater_trasporto_costo_una_tantum').repeater({
                initEmpty: false,


                show: function() {
                    $(this).slideDown();
                    $('.select2-container').remove();
                    $('.select2').select2({
                        placeholder: "Seleziona trasporto",
                        allowClear: true
                    });
                    $('.select2-container').css('width', '100%');
                },

                hide: function(deleteElement) {
                    $(this).slideUp(deleteElement);
                },
                ready: function(setIndexes) {

                    setIndexes(); // this will reindex the list

                },

            });


            $repeater_trasporto_costo_una_tantum.setList([
                @foreach ($preventivo->trasporto_una_tantum() as $trasporto)
                    {
                        @if ($trasporto->prezzo)
                            'prezzo': {{ $trasporto->prezzo }},
                        @endif
                        @if ($trasporto->informazioni_aggiuntive)
                            'informazioni_aggiuntive': `{!! preg_replace('/\s\s+/', '\n', $trasporto->informazioni_aggiuntive) !!}`,
                        @endif
                        @if ($trasporto->scorpora)
                            'scorpora': {{ $trasporto->scorpora }},
                        @endif
                        @if ($trasporto->trasporto_id)
                            'trasporto_id': {{ $trasporto->trasporto_id }},
                        @endif
                    },
                @endforeach
            ]);


            var $repeater_serviziextra_costo_una_tantum = $('#repeater_serviziextra_costo_una_tantum').repeater({
                initEmpty: true,


                show: function() {
                    $(this).slideDown();
                    $('.select2-container').remove();
                    $('.select2').select2({
                        placeholder: "Seleziona servizio extra",
                        allowClear: true
                    });
                    $('.select2-container').css('width', '100%');
                },

                hide: function(deleteElement) {
                    $(this).slideUp(deleteElement);
                },
                ready: function(setIndexes) {

                    setIndexes(); // this will reindex the list

                },

            });

            $repeater_serviziextra_costo_una_tantum.setList([
                @foreach ($preventivo->extra_una_tantum() as $servizio)
                    {
                        @if ($servizio->prezzo)
                            'prezzo': {{ $servizio->prezzo }},
                        @endif
                        'informazioni_aggiuntive':
                        `{!! preg_replace('/\s\s+/', '\n', $servizio->info_aggiuntive ?? '') !!}`,
                        'quota_comprende':
                        `{!! preg_replace('/\s\s+/', '\n', $servizio->quota_comprende ?? '') !!}`,
                        @if ($servizio->quantita)
                            'quantita': {{ $servizio->quantita }},
                        @endif
                        @if ($servizio->scorpora)
                            'scorpora': {{ $servizio->scorpora }},
                        @endif
                        @if ($servizio->servizio_extra_id)
                            'servizio_extra_id': {{ $servizio->servizio_extra_id }},
                        @endif
                    },
                @endforeach
            ]);



            var $repeater_serviziextra_costo_a_persona = $('#repeater_serviziextra_costo_a_persona').repeater({
                initEmpty: false,


                show: function() {
                    $(this).slideDown();
                    $('.select2-container').remove();
                    $('.select2').select2({
                        placeholder: "Seleziona servizio extra",
                        allowClear: true
                    });
                    $('.select2-container').css('width', '100%');
                },

                hide: function(deleteElement) {
                    $(this).slideUp(deleteElement);
                },
                ready: function(setIndexes) {

                    setIndexes(); // this will reindex the list

                },

            });
            $repeater_serviziextra_costo_a_persona.setList([
                @foreach ($preventivo->extra_persona() as $servizio)
                    {
                        @if ($servizio->prezzo)
                            'prezzo': {{ $servizio->prezzo }},
                        @endif
                        'informazioni_aggiuntive':
                        `{!! preg_replace('/\s\s+/', '\n', $servizio->info_aggiuntive ?? '') !!}`,
                        'quota_comprende':
                        `{!! preg_replace('/\s\s+/', '\n', $servizio->quota_comprende ?? '') !!}`,
                        @if ($servizio->quantita)
                            'quantita': {{ $servizio->quantita }},
                        @endif
                        @if ($servizio->scorpora)
                            'scorpora': {{ $servizio->scorpora }},
                        @endif
                        @if ($servizio->servizio_extra_id)
                            'servizio_extra_id': {{ $servizio->servizio_extra_id }},
                        @endif
                    },
                @endforeach
            ]);



            var uploadedFileFornitoreServiziExtraMap = {}
            var file_fornitore_servizi_extra = new Dropzone("#file_fornitore_servizi_extra-dropzone", {
                url: '{{ route('admin.preventivos.storeMedia') }}',
                maxFilesize: 80, // MB
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                params: {
                    size: 80
                },
                success: function(file, response) {
                    $('form').append(
                        '<input type="hidden" name="file_fornitore_servizi_extra[]" value="' +
                        response
                        .name + '">')
                    uploadedFileFornitoreServiziExtraMap[file.name] = response.name
                },
                removedfile: function(file) {
                    file.previewElement.remove()
                    var name = ''
                    if (typeof file.file_name !== 'undefined') {
                        name = file.file_name
                    } else {
                        name = uploadedFileFornitoreServiziExtraMap[file.name]
                    }
                    $('form').find('input[name="file_fornitore_servizi_extra[]"][value="' + name + '"]')
                        .remove()
                },
                init: function() {
                    @if (isset($preventivo) && $preventivo->file_fornitore_servizi_extra)
                        var files =
                            {!! json_encode($preventivo->file_fornitore_servizi_extra) !!}
                        for (var i in files) {
                            var file = files[i]
                            this.options.addedfile.call(this, file)
                            file.previewElement.classList.add('dz-complete')
                            $('form').append(
                                '<input type="hidden" name="file_fornitore_servizi_extra[]" value="' +
                                file
                                .file_name + '">')
                        }
                    @endif
                },
                error: function(file, response) {
                    if ($.type(response) === 'string') {
                        var message = response //dropzone sends it's own error messages in string
                    } else {
                        var message = response.errors.file
                    }
                    file.previewElement.classList.add('dz-error')
                    _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                    _results = []
                    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                        node = _ref[_i]
                        _results.push(node.textContent = message)
                    }

                    return _results
                }
            });


            var uploadedFileFornitoreTrasportoMap = {}
            var file_fornitore_trasporto = new Dropzone("#file_fornitore_trasporto-dropzone", {
                url: '{{ route('admin.preventivos.storeMedia') }}',
                maxFilesize: 80, // MB
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                params: {
                    size: 80
                },
                success: function(file, response) {
                    $('form').append(
                        '<input type="hidden" name="file_fornitore_trasporto[]" value="' +
                        response.name +
                        '">')
                    uploadedFileFornitoreTrasportoMap[file.name] = response.name
                },
                removedfile: function(file) {
                    file.previewElement.remove()
                    var name = ''
                    if (typeof file.file_name !== 'undefined') {
                        name = file.file_name
                    } else {
                        name = uploadedFileFornitoreTrasportoMap[file.name]
                    }
                    $('form').find('input[name="file_fornitore_trasporto[]"][value="' + name +
                            '"]')
                        .remove()
                },
                init: function() {
                    @if (isset($preventivo) && $preventivo->file_fornitore_trasporto)
                        var files =
                            {!! json_encode($preventivo->file_fornitore_trasporto) !!}
                        for (var i in files) {
                            var file = files[i]
                            this.options.addedfile.call(this, file)
                            file.previewElement.classList.add('dz-complete')
                            $('form').append(
                                '<input type="hidden" name="file_fornitore_trasporto[]" value="' +
                                file
                                .file_name + '">')
                        }
                    @endif
                },
                error: function(file, response) {
                    if ($.type(response) === 'string') {
                        var message =
                            response //dropzone sends it's own error messages in string
                    } else {
                        var message = response.errors.file
                    }
                    file.previewElement.classList.add('dz-error')
                    _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                    _results = []
                    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                        node = _ref[_i]
                        _results.push(node.textContent = message)
                    }

                    return _results
                }
            });

            var uploadedFileFornitoreHotelMap = {}
            var file_fornitore_hotel = new Dropzone("#file_fornitore_hotel-dropzone", {
                url: '{{ route('admin.preventivos.storeMedia') }}',
                maxFilesize: 80, // MB
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                params: {
                    size: 80
                },
                success: function(file, response) {
                    $('form').append(
                        '<input type="hidden" name="file_fornitore_hotel[]" value="' +
                        response
                        .name +
                        '">')
                    uploadedFileFornitoreHotelMap[file.name] = response.name
                },
                removedfile: function(file) {
                    file.previewElement.remove()
                    var name = ''
                    if (typeof file.file_name !== 'undefined') {
                        name = file.file_name
                    } else {
                        name = uploadedFileFornitoreHotelMap[file.name]
                    }
                    $('form').find('input[name="file_fornitore_hotel[]"][value="' + name + '"]')
                        .remove()
                },
                init: function() {
                    @if (isset($preventivo) && $preventivo->file_fornitore_hotel)
                        var files =
                            {!! json_encode($preventivo->file_fornitore_hotel) !!}
                        for (var i in files) {
                            var file = files[i]
                            this.options.addedfile.call(this, file)
                            file.previewElement.classList.add('dz-complete')
                            $('form').append(
                                '<input type="hidden" name="file_fornitore_hotel[]" value="' +
                                file
                                .file_name + '">')
                        }
                    @endif
                },
                error: function(file, response) {
                    if ($.type(response) === 'string') {
                        var message =
                            response //dropzone sends it's own error messages in string
                    } else {
                        var message = response.errors.file
                    }
                    file.previewElement.classList.add('dz-error')
                    _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                    _results = []
                    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                        node = _ref[_i]
                        _results.push(node.textContent = message)
                    }

                    return _results
                }
            });

            var uploadedFilesPraticaMap = {}
            var files_pratica = new Dropzone("#files_pratica-dropzone", {
                url: '{{ route('admin.preventivos.storeMedia') }}',
                maxFilesize: 50, // MB
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                params: {
                    size: 50
                },
                success: function(file, response) {
                    $('form').append('<input type="hidden" name="files_pratica[]" value="' +
                        response.name +
                        '">')
                    uploadedFilesPraticaMap[file.name] = response.name
                },
                removedfile: function(file) {
                    file.previewElement.remove()
                    var name = ''
                    if (typeof file.file_name !== 'undefined') {
                        name = file.file_name
                    } else {
                        name = uploadedFilesPraticaMap[file.name]
                    }
                    $('form').find('input[name="files_pratica[]"][value="' + name + '"]')
                        .remove()
                },
                init: function() {
                    @if (isset($preventivo) && $preventivo->files_pratica)
                        var files =
                            {!! json_encode($preventivo->files_pratica) !!}
                        for (var i in files) {
                            var file = files[i]
                            this.options.addedfile.call(this, file)
                            file.previewElement.classList.add('dz-complete')
                            $('form').append(
                                '<input type="hidden" name="files_pratica[]" value="' + file
                                .file_name +
                                '">')
                        }
                    @endif
                },
                error: function(file, response) {
                    if ($.type(response) === 'string') {
                        var message =
                            response //dropzone sends it's own error messages in string
                    } else {
                        var message = response.errors.file
                    }
                    file.previewElement.classList.add('dz-error')
                    _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                    _results = []
                    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                        node = _ref[_i]
                        _results.push(node.textContent = message)
                    }

                    return _results
                }
            });

            var uploadedFilePersonalizzatoMap = {}
            var file_personalizzato = new Dropzone("#file_personalizzato-dropzone", {
                url: '{{ route('admin.preventivos.storeMedia') }}',
                maxFilesize: 80, // MB
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                params: {
                    size: 80
                },
                success: function(file, response) {
                    $('form').append('<input type="hidden" name="file_personalizzato[]" value="' +
                        response.name +
                        '">')
                    uploadedFilePersonalizzatoMap[file.name] = response.name
                },
                removedfile: function(file) {
                    file.previewElement.remove()
                    var name = ''
                    if (typeof file.file_name !== 'undefined') {
                        name = file.file_name
                    } else {
                        name = uploadedFilePersonalizzatoMap[file.name]
                    }
                    $('form').find('input[name="file_personalizzato[]"][value="' + name + '"]')
                        .remove()
                },
                init: function() {
                    @if (isset($preventivo) && $preventivo->file_personalizzato)
                        var files =
                            {!! json_encode($preventivo->file_personalizzato) !!}
                        for (var i in files) {
                            var file = files[i]
                            this.options.addedfile.call(this, file)
                            file.previewElement.classList.add('dz-complete')
                            $('form').append(
                                '<input type="hidden" name="file_personalizzato[]" value="' + file
                                .file_name +
                                '">')
                        }
                    @endif
                },
                error: function(file, response) {
                    if ($.type(response) === 'string') {
                        var message =
                            response //dropzone sends it's own error messages in string
                    } else {
                        var message = response.errors.file
                    }
                    file.previewElement.classList.add('dz-error')
                    _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                    _results = []
                    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                        node = _ref[_i]
                        _results.push(node.textContent = message)
                    }

                    return _results
                }
            });

        });
    </script>



    <script></script>
    <script></script>
    <script></script>
@endsection
