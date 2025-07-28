@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.vocePHotelPerNotte.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.voce-p-hotel-per-nottes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePHotelPerNotte.fields.id') }}
                        </th>
                        <td>
                            {{ $vocePHotelPerNotte->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePHotelPerNotte.fields.tipologia_stanza') }}
                        </th>
                        <td>
                            {{ App\Models\VocePHotelPerNotte::TIPOLOGIA_STANZA_SELECT[$vocePHotelPerNotte->tipologia_stanza] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePHotelPerNotte.fields.numero_stanze') }}
                        </th>
                        <td>
                            {{ $vocePHotelPerNotte->numero_stanze }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePHotelPerNotte.fields.costo_a_notte') }}
                        </th>
                        <td>
                            {{ $vocePHotelPerNotte->costo_a_notte }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePHotelPerNotte.fields.voce_hotel') }}
                        </th>
                        <td>
                            {{ $vocePHotelPerNotte->voce_hotel->info_aggiuntive ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePHotelPerNotte.fields.scorpora') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $vocePHotelPerNotte->scorpora ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.voce-p-hotel-per-nottes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection