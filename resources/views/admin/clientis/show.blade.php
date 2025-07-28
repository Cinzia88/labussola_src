@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.clienti.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.clientis.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.clienti.fields.id') }}
                        </th>
                        <td>
                            {{ $clienti->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.clienti.fields.nome') }}
                        </th>
                        <td>
                            {{ $clienti->nome }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.clienti.fields.cognome') }}
                        </th>
                        <td>
                            {{ $clienti->cognome }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.clienti.fields.ragione_sociale') }}
                        </th>
                        <td>
                            {{ $clienti->ragione_sociale }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.clienti.fields.piva_cf') }}
                        </th>
                        <td>
                            {{ $clienti->piva_cf }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.clienti.fields.indirizzo') }}
                        </th>
                        <td>
                            {{ $clienti->indirizzo }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.clienti.fields.citta') }}
                        </th>
                        <td>
                            {{ $clienti->citta }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.clienti.fields.cap') }}
                        </th>
                        <td>
                            {{ $clienti->cap }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.clienti.fields.provincia') }}
                        </th>
                        <td>
                            {{ $clienti->provincia }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.clienti.fields.stato') }}
                        </th>
                        <td>
                            {{ $clienti->stato }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.clienti.fields.email') }}
                        </th>
                        <td>
                            {{ $clienti->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.clienti.fields.telefono') }}
                        </th>
                        <td>
                            {{ $clienti->telefono }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.clientis.index') }}">
                    {{ trans('global.back_to_list') }}
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
            <a class="nav-link" href="#cliente_preventivos" role="tab" data-toggle="tab">
                {{ trans('cruds.preventivo.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="cliente_preventivos">
            @includeIf('admin.clientis.relationships.clientePreventivos', ['preventivos' => $clienti->clientePreventivos])
        </div>
    </div>
</div>

@endsection