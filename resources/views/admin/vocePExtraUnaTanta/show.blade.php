@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.vocePExtraUnaTantum.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.voce-p-extra-una-tanta.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePExtraUnaTantum.fields.id') }}
                        </th>
                        <td>
                            {{ $vocePExtraUnaTantum->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePExtraUnaTantum.fields.servizio_extra') }}
                        </th>
                        <td>
                            {{ $vocePExtraUnaTantum->servizio_extra->nome ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePExtraUnaTantum.fields.prezzo') }}
                        </th>
                        <td>
                            {{ $vocePExtraUnaTantum->prezzo }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePExtraUnaTantum.fields.quantita') }}
                        </th>
                        <td>
                            {{ $vocePExtraUnaTantum->quantita }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePExtraUnaTantum.fields.scorpora') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $vocePExtraUnaTantum->scorpora ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePExtraUnaTantum.fields.preventivo') }}
                        </th>
                        <td>
                            {{ $vocePExtraUnaTantum->preventivo->oggetto ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePExtraUnaTantum.fields.info_aggiuntive') }}
                        </th>
                        <td>
                            {{ $vocePExtraUnaTantum->info_aggiuntive }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.voce-p-extra-una-tanta.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection