@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.scadenziario.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.scadenziarios.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.scadenziario.fields.id') }}
                        </th>
                        <td>
                            {{ $scadenziario->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.scadenziario.fields.nome') }}
                        </th>
                        <td>
                            {{ $scadenziario->nome }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.scadenziario.fields.data') }}
                        </th>
                        <td>
                            {{ $scadenziario->data }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.scadenziario.fields.eseguito') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $scadenziario->eseguito ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.scadenziario.fields.preventivo') }}
                        </th>
                        <td>
                            {{ $scadenziario->preventivo->numero ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.scadenziario.fields.colore_eticchetta') }}
                        </th>
                        <td>
                            {{ App\Models\Scadenziario::COLORE_ETICCHETTA_SELECT[$scadenziario->colore_eticchetta] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.scadenziario.fields.created_by') }}
                        </th>
                        <td>
                            {{ $scadenziario->created_by->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.scadenziarios.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection