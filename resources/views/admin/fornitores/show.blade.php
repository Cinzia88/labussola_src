@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.fornitore.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.fornitores.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.fornitore.fields.id') }}
                        </th>
                        <td>
                            {{ $fornitore->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fornitore.fields.nome') }}
                        </th>
                        <td>
                            {{ $fornitore->nome }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fornitore.fields.cognome') }}
                        </th>
                        <td>
                            {{ $fornitore->cognome }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fornitore.fields.ragione_sociale') }}
                        </th>
                        <td>
                            {{ $fornitore->ragione_sociale }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fornitore.fields.piva_cf') }}
                        </th>
                        <td>
                            {{ $fornitore->piva_cf }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fornitore.fields.indirizzo') }}
                        </th>
                        <td>
                            {{ $fornitore->indirizzo }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fornitore.fields.citta') }}
                        </th>
                        <td>
                            {{ $fornitore->citta }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fornitore.fields.cap') }}
                        </th>
                        <td>
                            {{ $fornitore->cap }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fornitore.fields.provincia') }}
                        </th>
                        <td>
                            {{ $fornitore->provincia }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fornitore.fields.stato') }}
                        </th>
                        <td>
                            {{ $fornitore->stato }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fornitore.fields.email') }}
                        </th>
                        <td>
                            {{ $fornitore->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fornitore.fields.telefono') }}
                        </th>
                        <td>
                            {{ $fornitore->telefono }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.fornitores.index') }}">
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
            <a class="nav-link" href="#fornitore_servizio_extras" role="tab" data-toggle="tab">
                {{ trans('cruds.servizioExtra.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="fornitore_servizio_extras">
            @includeIf('admin.fornitores.relationships.fornitoreServizioExtras', ['servizioExtras' => $fornitore->fornitoreServizioExtras])
        </div>
    </div>
</div>

@endsection