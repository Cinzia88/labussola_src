@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.scadenziario.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.scadenziarios.update', [$scadenziario->id]) }}"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="nome">{{ trans('cruds.scadenziario.fields.nome') }}</label>
                    <input class="form-control {{ $errors->has('nome') ? 'is-invalid' : '' }}" type="text" name="nome"
                        id="nome" value="{{ old('nome', $scadenziario->nome) }}" required>
                    @if ($errors->has('nome'))
                        <span class="text-danger">{{ $errors->first('nome') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.scadenziario.fields.nome_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="data">{{ trans('cruds.scadenziario.fields.data') }}</label>
                    <input class="form-control date {{ $errors->has('data') ? 'is-invalid' : '' }}" type="text"
                        name="data" id="data" value="{{ old('data', $scadenziario->data) }}" required>
                    @if ($errors->has('data'))
                        <span class="text-danger">{{ $errors->first('data') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.scadenziario.fields.data_helper') }}</span>
                </div>
                <div class="form-group">
                    <div class="form-check {{ $errors->has('eseguito') ? 'is-invalid' : '' }}">
                        <input type="hidden" name="eseguito" value="0">
                        <input class="form-check-input" type="checkbox" name="eseguito" id="eseguito" value="1"
                            {{ $scadenziario->eseguito || old('eseguito', 0) === 1 ? 'checked' : '' }}>
                        <label class="form-check-label"
                            for="eseguito">{{ trans('cruds.scadenziario.fields.eseguito') }}</label>
                    </div>
                    @if ($errors->has('eseguito'))
                        <span class="text-danger">{{ $errors->first('eseguito') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.scadenziario.fields.eseguito_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="preventivo_id">{{ trans('cruds.scadenziario.fields.preventivo') }}</label>
                    <select class="form-control select2 {{ $errors->has('preventivo') ? 'is-invalid' : '' }}"
                        name="preventivo_id" id="preventivo_id" required>
                        @foreach ($preventivos as $preventivo)
                            <option value="{{ $preventivo->id }}"
                                {{ (old('preventivo_id') ? old('preventivo_id') : $scadenziario->preventivo->id ?? '') == $preventivo->id ? 'selected' : '' }}>
                                {{ $preventivo->numero }}/{{ $preventivo->anno }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('preventivo'))
                        <span class="text-danger">{{ $errors->first('preventivo') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.scadenziario.fields.preventivo_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="created_by_id">{{ trans('cruds.scadenziario.fields.created_by') }}</label>
                    <select class="form-control select2 {{ $errors->has('created_by') ? 'is-invalid' : '' }}"
                        name="created_by_id" id="created_by_id">
                        @foreach ($created_bies as $id => $entry)
                            <option value="{{ $id }}"
                                {{ (old('created_by_id') ? old('created_by_id') : $scadenziario->created_by->id ?? '') == $id ? 'selected' : '' }}>
                                {{ $entry }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('created_by'))
                        <span class="text-danger">{{ $errors->first('created_by') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.scadenziario.fields.created_by_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required">{{ trans('cruds.scadenziario.fields.colore_eticchetta') }}</label>
                    <select class="form-control {{ $errors->has('colore_eticchetta') ? 'is-invalid' : '' }}" name="colore_eticchetta" id="colore_eticchetta" required>
                        <option value disabled {{ old('colore_eticchetta', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\Scadenziario::COLORE_ETICCHETTA_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('colore_eticchetta', $scadenziario->colore_eticchetta) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('colore_eticchetta'))
                        <span class="text-danger">{{ $errors->first('colore_eticchetta') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.scadenziario.fields.colore_eticchetta_helper') }}</span>
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
