@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.settingsDinamici.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.settings-dinamicis.update", [$settingsDinamici->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="progressivo">{{ trans('cruds.settingsDinamici.fields.progressivo') }}</label>
                <input class="form-control {{ $errors->has('progressivo') ? 'is-invalid' : '' }}" type="text" name="progressivo" id="progressivo" value="{{ old('progressivo', $settingsDinamici->progressivo) }}" required>
                @if($errors->has('progressivo'))
                    <span class="text-danger">{{ $errors->first('progressivo') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.settingsDinamici.fields.progressivo_helper') }}</span>
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