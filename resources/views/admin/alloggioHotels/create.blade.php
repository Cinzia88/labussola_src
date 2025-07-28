@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.alloggioHotel.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.alloggio-hotels.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="nome">{{ trans('cruds.alloggioHotel.fields.nome') }}</label>
                <input class="form-control {{ $errors->has('nome') ? 'is-invalid' : '' }}" type="text" name="nome" id="nome" value="{{ old('nome', '') }}" required>
                @if($errors->has('nome'))
                    <span class="text-danger">{{ $errors->first('nome') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.alloggioHotel.fields.nome_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="indirizzo">{{ trans('cruds.alloggioHotel.fields.indirizzo') }}</label>
                <input class="form-control {{ $errors->has('indirizzo') ? 'is-invalid' : '' }}" type="text" name="indirizzo" id="indirizzo" value="{{ old('indirizzo', '') }}">
                @if($errors->has('indirizzo'))
                    <span class="text-danger">{{ $errors->first('indirizzo') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.alloggioHotel.fields.indirizzo_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="descrizione">{{ trans('cruds.alloggioHotel.fields.descrizione') }}</label>
                <textarea class="form-control {{ $errors->has('descrizione') ? 'is-invalid' : '' }}" name="descrizione" id="descrizione">{{ old('descrizione') }}</textarea>
                @if($errors->has('descrizione'))
                    <span class="text-danger">{{ $errors->first('descrizione') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.alloggioHotel.fields.descrizione_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="foto">{{ trans('cruds.alloggioHotel.fields.foto') }}</label>
                <div class="needsclick dropzone {{ $errors->has('foto') ? 'is-invalid' : '' }}" id="foto-dropzone">
                </div>
                @if($errors->has('foto'))
                    <span class="text-danger">{{ $errors->first('foto') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.alloggioHotel.fields.foto_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.alloggioHotel.fields.stelle') }}</label>
                <select class="form-control {{ $errors->has('stelle') ? 'is-invalid' : '' }}" name="stelle" id="stelle" required>
                    <option value disabled {{ old('stelle', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\AlloggioHotel::STELLE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('stelle', 'non_ha_stelle') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('stelle'))
                    <span class="text-danger">{{ $errors->first('stelle') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.alloggioHotel.fields.stelle_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="fornitore_id">{{ trans('cruds.alloggioHotel.fields.fornitore') }}</label>
                <select class="form-control select2 {{ $errors->has('fornitore') ? 'is-invalid' : '' }}" name="fornitore_id" id="fornitore_id">
                    @foreach($fornitores as $id => $entry)
                        <option value="{{ $id }}" {{ old('fornitore_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('fornitore'))
                    <span class="text-danger">{{ $errors->first('fornitore') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.alloggioHotel.fields.fornitore_helper') }}</span>
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
    var uploadedFotoMap = {}
Dropzone.options.fotoDropzone = {
    url: '{{ route('admin.alloggio-hotels.storeMedia') }}',
    maxFilesize: 20, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 20,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="foto[]" value="' + response.name + '">')
      uploadedFotoMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedFotoMap[file.name]
      }
      $('form').find('input[name="foto[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($alloggioHotel) && $alloggioHotel->foto)
      var files = {!! json_encode($alloggioHotel->foto) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="foto[]" value="' + file.file_name + '">')
        }
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