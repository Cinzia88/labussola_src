@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.vocePExtraUnaTantum.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.voce-p-extra-una-tanta.update", [$vocePExtraUnaTantum->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="servizio_extra_id">{{ trans('cruds.vocePExtraUnaTantum.fields.servizio_extra') }}</label>
                <select class="form-control select2 {{ $errors->has('servizio_extra') ? 'is-invalid' : '' }}" name="servizio_extra_id" id="servizio_extra_id" required>
                    @foreach($servizio_extras as $id => $entry)
                        <option value="{{ $id }}" {{ (old('servizio_extra_id') ? old('servizio_extra_id') : $vocePExtraUnaTantum->servizio_extra->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('servizio_extra'))
                    <span class="text-danger">{{ $errors->first('servizio_extra') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.vocePExtraUnaTantum.fields.servizio_extra_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="prezzo">{{ trans('cruds.vocePExtraUnaTantum.fields.prezzo') }}</label>
                <input class="form-control {{ $errors->has('prezzo') ? 'is-invalid' : '' }}" type="number" name="prezzo" id="prezzo" value="{{ old('prezzo', $vocePExtraUnaTantum->prezzo) }}" step="0.01" required>
                @if($errors->has('prezzo'))
                    <span class="text-danger">{{ $errors->first('prezzo') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.vocePExtraUnaTantum.fields.prezzo_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="quantita">{{ trans('cruds.vocePExtraUnaTantum.fields.quantita') }}</label>
                <input class="form-control {{ $errors->has('quantita') ? 'is-invalid' : '' }}" type="number" name="quantita" id="quantita" value="{{ old('quantita', $vocePExtraUnaTantum->quantita) }}" step="1" required>
                @if($errors->has('quantita'))
                    <span class="text-danger">{{ $errors->first('quantita') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.vocePExtraUnaTantum.fields.quantita_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('scorpora') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="scorpora" value="0">
                    <input class="form-check-input" type="checkbox" name="scorpora" id="scorpora" value="1" {{ $vocePExtraUnaTantum->scorpora || old('scorpora', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="scorpora">{{ trans('cruds.vocePExtraUnaTantum.fields.scorpora') }}</label>
                </div>
                @if($errors->has('scorpora'))
                    <span class="text-danger">{{ $errors->first('scorpora') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.vocePExtraUnaTantum.fields.scorpora_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="preventivo_id">{{ trans('cruds.vocePExtraUnaTantum.fields.preventivo') }}</label>
                <select class="form-control select2 {{ $errors->has('preventivo') ? 'is-invalid' : '' }}" name="preventivo_id" id="preventivo_id" required>
                    @foreach($preventivos as $id => $entry)
                        <option value="{{ $id }}" {{ (old('preventivo_id') ? old('preventivo_id') : $vocePExtraUnaTantum->preventivo->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('preventivo'))
                    <span class="text-danger">{{ $errors->first('preventivo') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.vocePExtraUnaTantum.fields.preventivo_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="info_aggiuntive">{{ trans('cruds.vocePExtraUnaTantum.fields.info_aggiuntive') }}</label>
                <textarea class="form-control {{ $errors->has('info_aggiuntive') ? 'is-invalid' : '' }}" name="info_aggiuntive" id="info_aggiuntive">{{ old('info_aggiuntive', $vocePExtraUnaTantum->info_aggiuntive) }}</textarea>
                @if($errors->has('info_aggiuntive'))
                    <span class="text-danger">{{ $errors->first('info_aggiuntive') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.vocePExtraUnaTantum.fields.info_aggiuntive_helper') }}</span>
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