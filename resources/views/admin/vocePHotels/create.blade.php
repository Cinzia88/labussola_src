@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.vocePHotel.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.voce-p-hotels.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="info_aggiuntive">{{ trans('cruds.vocePHotel.fields.info_aggiuntive') }}</label>
                <textarea class="form-control {{ $errors->has('info_aggiuntive') ? 'is-invalid' : '' }}" name="info_aggiuntive" id="info_aggiuntive">{{ old('info_aggiuntive') }}</textarea>
                @if($errors->has('info_aggiuntive'))
                    <span class="text-danger">{{ $errors->first('info_aggiuntive') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.vocePHotel.fields.info_aggiuntive_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="hotel_id">{{ trans('cruds.vocePHotel.fields.hotel') }}</label>
                <select class="form-control select2 {{ $errors->has('hotel') ? 'is-invalid' : '' }}" name="hotel_id" id="hotel_id" required>
                    @foreach($hotels as $id => $entry)
                        <option value="{{ $id }}" {{ old('hotel_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('hotel'))
                    <span class="text-danger">{{ $errors->first('hotel') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.vocePHotel.fields.hotel_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="preventivo_id">{{ trans('cruds.vocePHotel.fields.preventivo') }}</label>
                <select class="form-control select2 {{ $errors->has('preventivo') ? 'is-invalid' : '' }}" name="preventivo_id" id="preventivo_id">
                    @foreach($preventivos as $id => $entry)
                        <option value="{{ $id }}" {{ old('preventivo_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('preventivo'))
                    <span class="text-danger">{{ $errors->first('preventivo') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.vocePHotel.fields.preventivo_helper') }}</span>
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