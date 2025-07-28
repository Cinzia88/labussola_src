@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.aziendeTrasporti.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.aziende-trasportis.update", [$aziendeTrasporti->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="nome">{{ trans('cruds.aziendeTrasporti.fields.nome') }}</label>
                <input class="form-control {{ $errors->has('nome') ? 'is-invalid' : '' }}" type="text" name="nome" id="nome" value="{{ old('nome', $aziendeTrasporti->nome) }}" required>
                @if($errors->has('nome'))
                    <span class="text-danger">{{ $errors->first('nome') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.aziendeTrasporti.fields.nome_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="immagine">{{ trans('cruds.aziendeTrasporti.fields.immagine') }}</label>
                <div class="needsclick dropzone {{ $errors->has('immagine') ? 'is-invalid' : '' }}" id="immagine-dropzone">
                </div>
                @if($errors->has('immagine'))
                    <span class="text-danger">{{ $errors->first('immagine') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.aziendeTrasporti.fields.immagine_helper') }}</span>
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
    Dropzone.options.immagineDropzone = {
    url: '{{ route('admin.aziende-trasportis.storeMedia') }}',
    maxFilesize: 50, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 50
    },
    success: function (file, response) {
      $('form').find('input[name="immagine"]').remove()
      $('form').append('<input type="hidden" name="immagine" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="immagine"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($aziendeTrasporti) && $aziendeTrasporti->immagine)
      var file = {!! json_encode($aziendeTrasporti->immagine) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="immagine" value="' + file.file_name + '">')
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