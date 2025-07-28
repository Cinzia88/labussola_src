@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.vocePExtraPerPersona.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.voce-p-extra-per-personas.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePExtraPerPersona.fields.id') }}
                        </th>
                        <td>
                            {{ $vocePExtraPerPersona->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePExtraPerPersona.fields.servizio_extra') }}
                        </th>
                        <td>
                            {{ $vocePExtraPerPersona->servizio_extra->nome ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePExtraPerPersona.fields.prezzo') }}
                        </th>
                        <td>
                            {{ $vocePExtraPerPersona->prezzo }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePExtraPerPersona.fields.quantita') }}
                        </th>
                        <td>
                            {{ $vocePExtraPerPersona->quantita }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePExtraPerPersona.fields.scorpora') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $vocePExtraPerPersona->scorpora ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePExtraPerPersona.fields.preventivo') }}
                        </th>
                        <td>
                            {{ $vocePExtraPerPersona->preventivo->oggetto ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePExtraPerPersona.fields.info_aggiuntive') }}
                        </th>
                        <td>
                            {{ $vocePExtraPerPersona->info_aggiuntive }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.voce-p-extra-per-personas.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection