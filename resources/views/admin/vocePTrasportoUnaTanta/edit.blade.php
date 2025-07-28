@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.vocePTrasportoUnaTantum.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.voce-p-trasporto-una-tanta.update", [$vocePTrasportoUnaTantum->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label>{{ trans('cruds.vocePTrasportoUnaTantum.fields.tipologia_trasporto') }}</label>
                <select class="form-control {{ $errors->has('tipologia_trasporto') ? 'is-invalid' : '' }}" name="tipologia_trasporto" id="tipologia_trasporto">
                    <option value disabled {{ old('tipologia_trasporto', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\VocePTrasportoUnaTantum::TIPOLOGIA_TRASPORTO_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('tipologia_trasporto', $vocePTrasportoUnaTantum->tipologia_trasporto) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('tipologia_trasporto'))
                    <span class="text-danger">{{ $errors->first('tipologia_trasporto') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.vocePTrasportoUnaTantum.fields.tipologia_trasporto_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('scorpora') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="scorpora" value="0">
                    <input class="form-check-input" type="checkbox" name="scorpora" id="scorpora" value="1" {{ $vocePTrasportoUnaTantum->scorpora || old('scorpora', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="scorpora">{{ trans('cruds.vocePTrasportoUnaTantum.fields.scorpora') }}</label>
                </div>
                @if($errors->has('scorpora'))
                    <span class="text-danger">{{ $errors->first('scorpora') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.vocePTrasportoUnaTantum.fields.scorpora_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="trasporto_id">{{ trans('cruds.vocePTrasportoUnaTantum.fields.trasporto') }}</label>
                <select class="form-control select2 {{ $errors->has('trasporto') ? 'is-invalid' : '' }}" name="trasporto_id" id="trasporto_id" required>
                    @foreach($trasportos as $id => $entry)
                        <option value="{{ $id }}" {{ (old('trasporto_id') ? old('trasporto_id') : $vocePTrasportoUnaTantum->trasporto->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('trasporto'))
                    <span class="text-danger">{{ $errors->first('trasporto') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.vocePTrasportoUnaTantum.fields.trasporto_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="prezzo">{{ trans('cruds.vocePTrasportoUnaTantum.fields.prezzo') }}</label>
                <input class="form-control {{ $errors->has('prezzo') ? 'is-invalid' : '' }}" type="number" name="prezzo" id="prezzo" value="{{ old('prezzo', $vocePTrasportoUnaTantum->prezzo) }}" step="0.01" required>
                @if($errors->has('prezzo'))
                    <span class="text-danger">{{ $errors->first('prezzo') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.vocePTrasportoUnaTantum.fields.prezzo_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="preventivo_id">{{ trans('cruds.vocePTrasportoUnaTantum.fields.preventivo') }}</label>
                <select class="form-control select2 {{ $errors->has('preventivo') ? 'is-invalid' : '' }}" name="preventivo_id" id="preventivo_id" required>
                    @foreach($preventivos as $id => $entry)
                        <option value="{{ $id }}" {{ (old('preventivo_id') ? old('preventivo_id') : $vocePTrasportoUnaTantum->preventivo->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('preventivo'))
                    <span class="text-danger">{{ $errors->first('preventivo') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.vocePTrasportoUnaTantum.fields.preventivo_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="informazioni_aggiuntive">{{ trans('cruds.vocePTrasportoUnaTantum.fields.informazioni_aggiuntive') }}</label>
                <textarea class="form-control {{ $errors->has('informazioni_aggiuntive') ? 'is-invalid' : '' }}" name="informazioni_aggiuntive" id="informazioni_aggiuntive">{{ old('informazioni_aggiuntive', $vocePTrasportoUnaTantum->informazioni_aggiuntive) }}</textarea>
                @if($errors->has('informazioni_aggiuntive'))
                    <span class="text-danger">{{ $errors->first('informazioni_aggiuntive') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.vocePTrasportoUnaTantum.fields.informazioni_aggiuntive_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.vocePTrasportoUnaTantum.fields.tipologia') }}</label>
                <select class="form-control {{ $errors->has('tipologia') ? 'is-invalid' : '' }}" name="tipologia" id="tipologia" required>
                    <option value disabled {{ old('tipologia', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\VocePTrasportoUnaTantum::TIPOLOGIA_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('tipologia', $vocePTrasportoUnaTantum->tipologia) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('tipologia'))
                    <span class="text-danger">{{ $errors->first('tipologia') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.vocePTrasportoUnaTantum.fields.tipologia_helper') }}</span>
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