@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.clienti.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.clientis.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="nome">{{ trans('cruds.clienti.fields.nome') }}</label>
                <input class="form-control {{ $errors->has('nome') ? 'is-invalid' : '' }}" type="text" name="nome" id="nome" value="{{ old('nome', '') }}" required>
                @if($errors->has('nome'))
                    <span class="text-danger">{{ $errors->first('nome') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.clienti.fields.nome_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="cognome">{{ trans('cruds.clienti.fields.cognome') }}</label>
                <input class="form-control {{ $errors->has('cognome') ? 'is-invalid' : '' }}" type="text" name="cognome" id="cognome" value="{{ old('cognome', '') }}" required>
                @if($errors->has('cognome'))
                    <span class="text-danger">{{ $errors->first('cognome') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.clienti.fields.cognome_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="ragione_sociale">{{ trans('cruds.clienti.fields.ragione_sociale') }}</label>
                <input class="form-control {{ $errors->has('ragione_sociale') ? 'is-invalid' : '' }}" type="text" name="ragione_sociale" id="ragione_sociale" value="{{ old('ragione_sociale', '') }}">
                @if($errors->has('ragione_sociale'))
                    <span class="text-danger">{{ $errors->first('ragione_sociale') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.clienti.fields.ragione_sociale_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="piva_cf">{{ trans('cruds.clienti.fields.piva_cf') }}</label>
                <input class="form-control {{ $errors->has('piva_cf') ? 'is-invalid' : '' }}" type="text" name="piva_cf" id="piva_cf" value="{{ old('piva_cf', '') }}">
                @if($errors->has('piva_cf'))
                    <span class="text-danger">{{ $errors->first('piva_cf') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.clienti.fields.piva_cf_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="indirizzo">{{ trans('cruds.clienti.fields.indirizzo') }}</label>
                <input class="form-control {{ $errors->has('indirizzo') ? 'is-invalid' : '' }}" type="text" name="indirizzo" id="indirizzo" value="{{ old('indirizzo', '') }}">
                @if($errors->has('indirizzo'))
                    <span class="text-danger">{{ $errors->first('indirizzo') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.clienti.fields.indirizzo_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="citta">{{ trans('cruds.clienti.fields.citta') }}</label>
                <input class="form-control {{ $errors->has('citta') ? 'is-invalid' : '' }}" type="text" name="citta" id="citta" value="{{ old('citta', '') }}">
                @if($errors->has('citta'))
                    <span class="text-danger">{{ $errors->first('citta') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.clienti.fields.citta_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="cap">{{ trans('cruds.clienti.fields.cap') }}</label>
                <input class="form-control {{ $errors->has('cap') ? 'is-invalid' : '' }}" type="text" name="cap" id="cap" value="{{ old('cap', '') }}">
                @if($errors->has('cap'))
                    <span class="text-danger">{{ $errors->first('cap') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.clienti.fields.cap_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="provincia">{{ trans('cruds.clienti.fields.provincia') }}</label>
                <input class="form-control {{ $errors->has('provincia') ? 'is-invalid' : '' }}" type="text" name="provincia" id="provincia" value="{{ old('provincia', '') }}">
                @if($errors->has('provincia'))
                    <span class="text-danger">{{ $errors->first('provincia') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.clienti.fields.provincia_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="stato">{{ trans('cruds.clienti.fields.stato') }}</label>
                <input class="form-control {{ $errors->has('stato') ? 'is-invalid' : '' }}" type="text" name="stato" id="stato" value="{{ old('stato', '') }}">
                @if($errors->has('stato'))
                    <span class="text-danger">{{ $errors->first('stato') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.clienti.fields.stato_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email">{{ trans('cruds.clienti.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email') }}">
                @if($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.clienti.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="telefono">{{ trans('cruds.clienti.fields.telefono') }}</label>
                <input class="form-control {{ $errors->has('telefono') ? 'is-invalid' : '' }}" type="text" name="telefono" id="telefono" value="{{ old('telefono', '') }}">
                @if($errors->has('telefono'))
                    <span class="text-danger">{{ $errors->first('telefono') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.clienti.fields.telefono_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection