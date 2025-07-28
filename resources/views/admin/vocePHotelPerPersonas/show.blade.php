@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.vocePHotelPerPersona.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.voce-p-hotel-per-personas.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePHotelPerPersona.fields.id') }}
                        </th>
                        <td>
                            {{ $vocePHotelPerPersona->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePHotelPerPersona.fields.tipologia_stanza') }}
                        </th>
                        <td>
                            {{ App\Models\VocePHotelPerPersona::TIPOLOGIA_STANZA_SELECT[$vocePHotelPerPersona->tipologia_stanza] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePHotelPerPersona.fields.numero_stanze') }}
                        </th>
                        <td>
                            {{ $vocePHotelPerPersona->numero_stanze }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePHotelPerPersona.fields.costo_a_notte') }}
                        </th>
                        <td>
                            {{ $vocePHotelPerPersona->costo_a_notte }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePHotelPerPersona.fields.voce_hotel') }}
                        </th>
                        <td>
                            {{ $vocePHotelPerPersona->voce_hotel->info_aggiuntive ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePHotelPerPersona.fields.scorpora') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $vocePHotelPerPersona->scorpora ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.voce-p-hotel-per-personas.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection