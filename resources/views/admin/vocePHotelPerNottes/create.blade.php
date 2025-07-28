@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.vocePHotelPerNotte.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.voce-p-hotel-per-nottes.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required">{{ trans('cruds.vocePHotelPerNotte.fields.tipologia_stanza') }}</label>
                <select class="form-control {{ $errors->has('tipologia_stanza') ? 'is-invalid' : '' }}" name="tipologia_stanza" id="tipologia_stanza" required>
                    <option value disabled {{ old('tipologia_stanza', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\VocePHotelPerNotte::TIPOLOGIA_STANZA_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('tipologia_stanza', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('tipologia_stanza'))
                    <span class="text-danger">{{ $errors->first('tipologia_stanza') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.vocePHotelPerNotte.fields.tipologia_stanza_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="numero_stanze">{{ trans('cruds.vocePHotelPerNotte.fields.numero_stanze') }}</label>
                <input class="form-control {{ $errors->has('numero_stanze') ? 'is-invalid' : '' }}" type="number" name="numero_stanze" id="numero_stanze" value="{{ old('numero_stanze', '0') }}" step="1" required>
                @if($errors->has('numero_stanze'))
                    <span class="text-danger">{{ $errors->first('numero_stanze') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.vocePHotelPerNotte.fields.numero_stanze_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="costo_a_notte">{{ trans('cruds.vocePHotelPerNotte.fields.costo_a_notte') }}</label>
                <input class="form-control {{ $errors->has('costo_a_notte') ? 'is-invalid' : '' }}" type="number" name="costo_a_notte" id="costo_a_notte" value="{{ old('costo_a_notte', '0') }}" step="0.01" required>
                @if($errors->has('costo_a_notte'))
                    <span class="text-danger">{{ $errors->first('costo_a_notte') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.vocePHotelPerNotte.fields.costo_a_notte_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="voce_hotel_id">{{ trans('cruds.vocePHotelPerNotte.fields.voce_hotel') }}</label>
                <select class="form-control select2 {{ $errors->has('voce_hotel') ? 'is-invalid' : '' }}" name="voce_hotel_id" id="voce_hotel_id" required>
                    @foreach($voce_hotels as $id => $entry)
                        <option value="{{ $id }}" {{ old('voce_hotel_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('voce_hotel'))
                    <span class="text-danger">{{ $errors->first('voce_hotel') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.vocePHotelPerNotte.fields.voce_hotel_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('scorpora') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="scorpora" value="0">
                    <input class="form-check-input" type="checkbox" name="scorpora" id="scorpora" value="1" {{ old('scorpora', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="scorpora">{{ trans('cruds.vocePHotelPerNotte.fields.scorpora') }}</label>
                </div>
                @if($errors->has('scorpora'))
                    <span class="text-danger">{{ $errors->first('scorpora') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.vocePHotelPerNotte.fields.scorpora_helper') }}</span>
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