@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.vocePTrasportoPerPersona.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.voce-p-trasporto-per-personas.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePTrasportoPerPersona.fields.id') }}
                        </th>
                        <td>
                            {{ $vocePTrasportoPerPersona->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePTrasportoPerPersona.fields.tipologia_trasporto') }}
                        </th>
                        <td>
                            {{ App\Models\VocePTrasportoPerPersona::TIPOLOGIA_TRASPORTO_SELECT[$vocePTrasportoPerPersona->tipologia_trasporto] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePTrasportoPerPersona.fields.trasporto') }}
                        </th>
                        <td>
                            {{ $vocePTrasportoPerPersona->trasporto->nome ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePTrasportoPerPersona.fields.prezzo') }}
                        </th>
                        <td>
                            {{ $vocePTrasportoPerPersona->prezzo }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePTrasportoPerPersona.fields.preventivo') }}
                        </th>
                        <td>
                            {{ $vocePTrasportoPerPersona->preventivo->oggetto ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePTrasportoPerPersona.fields.informazioni_aggiuntive') }}
                        </th>
                        <td>
                            {{ $vocePTrasportoPerPersona->informazioni_aggiuntive }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePTrasportoPerPersona.fields.scorpora') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $vocePTrasportoPerPersona->scorpora ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePTrasportoPerPersona.fields.tipologia') }}
                        </th>
                        <td>
                            {{ App\Models\VocePTrasportoPerPersona::TIPOLOGIA_SELECT[$vocePTrasportoPerPersona->tipologia] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.voce-p-trasporto-per-personas.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection