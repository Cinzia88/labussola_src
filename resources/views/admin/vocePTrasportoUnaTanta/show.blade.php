@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.vocePTrasportoUnaTantum.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.voce-p-trasporto-una-tanta.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePTrasportoUnaTantum.fields.id') }}
                        </th>
                        <td>
                            {{ $vocePTrasportoUnaTantum->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePTrasportoUnaTantum.fields.tipologia_trasporto') }}
                        </th>
                        <td>
                            {{ App\Models\VocePTrasportoUnaTantum::TIPOLOGIA_TRASPORTO_SELECT[$vocePTrasportoUnaTantum->tipologia_trasporto] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePTrasportoUnaTantum.fields.scorpora') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $vocePTrasportoUnaTantum->scorpora ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePTrasportoUnaTantum.fields.trasporto') }}
                        </th>
                        <td>
                            {{ $vocePTrasportoUnaTantum->trasporto->nome ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePTrasportoUnaTantum.fields.prezzo') }}
                        </th>
                        <td>
                            {{ $vocePTrasportoUnaTantum->prezzo }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePTrasportoUnaTantum.fields.preventivo') }}
                        </th>
                        <td>
                            {{ $vocePTrasportoUnaTantum->preventivo->oggetto ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePTrasportoUnaTantum.fields.informazioni_aggiuntive') }}
                        </th>
                        <td>
                            {{ $vocePTrasportoUnaTantum->informazioni_aggiuntive }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePTrasportoUnaTantum.fields.tipologia') }}
                        </th>
                        <td>
                            {{ App\Models\VocePTrasportoUnaTantum::TIPOLOGIA_SELECT[$vocePTrasportoUnaTantum->tipologia] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.voce-p-trasporto-una-tanta.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection