@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.servizioExtra.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.servizio-extras.update", [$servizioExtra->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="nome">{{ trans('cruds.servizioExtra.fields.nome') }}</label>
                <input class="form-control {{ $errors->has('nome') ? 'is-invalid' : '' }}" type="text" name="nome" id="nome" value="{{ old('nome', $servizioExtra->nome) }}" required>
                @if($errors->has('nome'))
                    <span class="text-danger">{{ $errors->first('nome') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servizioExtra.fields.nome_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="descrizione">{{ trans('cruds.servizioExtra.fields.descrizione') }}</label>
                <textarea class="form-control {{ $errors->has('descrizione') ? 'is-invalid' : '' }}" name="descrizione" id="descrizione">{{ old('descrizione', $servizioExtra->descrizione) }}</textarea>
                @if($errors->has('descrizione'))
                    <span class="text-danger">{{ $errors->first('descrizione') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servizioExtra.fields.descrizione_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="fornitore_id">{{ trans('cruds.servizioExtra.fields.fornitore') }}</label>
                <select class="form-control select2 {{ $errors->has('fornitore') ? 'is-invalid' : '' }}" name="fornitore_id" id="fornitore_id">
                    @foreach($fornitores as $id => $entry)
                        <option value="{{ $id }}" {{ (old('fornitore_id') ? old('fornitore_id') : $servizioExtra->fornitore->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('fornitore'))
                    <span class="text-danger">{{ $errors->first('fornitore') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servizioExtra.fields.fornitore_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="foto">{{ trans('cruds.servizioExtra.fields.foto') }}</label>
                <div class="needsclick dropzone {{ $errors->has('foto') ? 'is-invalid' : '' }}" id="foto-dropzone">
                </div>
                @if($errors->has('foto'))
                    <span class="text-danger">{{ $errors->first('foto') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servizioExtra.fields.foto_helper') }}</span>
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

@section('scripts')
<script>
    Dropzone.options.fotoDropzone = {
    url: '{{ route('admin.servizio-extras.storeMedia') }}',
    maxFilesize: 500, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 500
    },
    success: function (file, response) {
      $('form').find('input[name="foto"]').remove()
      $('form').append('<input type="hidden" name="foto" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="foto"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($servizioExtra) && $servizioExtra->foto)
      var file = {!! json_encode($servizioExtra->foto) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="foto" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
@endsection