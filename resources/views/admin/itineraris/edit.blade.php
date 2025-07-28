@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.itinerari.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.itineraris.update', [$itinerari->id]) }}"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="nome">{{ trans('cruds.itinerari.fields.nome') }}</label>
                    <input class="form-control {{ $errors->has('nome') ? 'is-invalid' : '' }}" type="text" name="nome"
                        id="nome" value="{{ old('nome', $itinerari->nome) }}" required>
                    @if ($errors->has('nome'))
                        <span class="text-danger">{{ $errors->first('nome') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.itinerari.fields.nome_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="descrizione">{{ trans('cruds.itinerari.fields.descrizione') }}</label>
                    <textarea class="form-control ckeditor {{ $errors->has('descrizione') ? 'is-invalid' : '' }}" name="descrizione"
                        id="descrizione">{!! old('descrizione', $itinerari->descrizione) !!}</textarea>
                    @if ($errors->has('descrizione'))
                        <span class="text-danger">{{ $errors->first('descrizione') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.itinerari.fields.descrizione_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                        for="foto_introduttiva">{{ trans('cruds.itinerari.fields.foto_introduttiva') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('foto_introduttiva') ? 'is-invalid' : '' }}"
                        id="foto_introduttiva-dropzone">
                    </div>
                    @if ($errors->has('foto_introduttiva'))
                        <span class="text-danger">{{ $errors->first('foto_introduttiva') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.itinerari.fields.foto_introduttiva_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="immagini">{{ trans('cruds.itinerari.fields.immagini') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('immagini') ? 'is-invalid' : '' }}"
                        id="immagini-dropzone">
                    </div>
                    @if ($errors->has('immagini'))
                        <span class="text-danger">{{ $errors->first('immagini') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.itinerari.fields.immagini_helper') }}</span>
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
        $(document).ready(function() {
            function SimpleUploadAdapter(editor) {
                editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
                    return {
                        upload: function() {
                            return loader.file
                                .then(function(file) {
                                    return new Promise(function(resolve, reject) {
                                        // Init request
                                        var xhr = new XMLHttpRequest();
                                        xhr.open('POST',
                                            '{{ route('admin.itineraris.storeCKEditorImages') }}',
                                            true);
                                        xhr.setRequestHeader('x-csrf-token', window._token);
                                        xhr.setRequestHeader('Accept', 'application/json');
                                        xhr.responseType = 'json';

                                        // Init listeners
                                        var genericErrorText =
                                            `Couldn't upload file: ${ file.name }.`;
                                        xhr.addEventListener('error', function() {
                                            reject(genericErrorText)
                                        });
                                        xhr.addEventListener('abort', function() {
                                            reject()
                                        });
                                        xhr.addEventListener('load', function() {
                                            var response = xhr.response;

                                            if (!response || xhr.status !== 201) {
                                                return reject(response && response
                                                    .message ?
                                                    `${genericErrorText}\n${xhr.status} ${response.message}` :
                                                    `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`
                                                    );
                                            }

                                            $('form').append(
                                                '<input type="hidden" name="ck-media[]" value="' +
                                                response.id + '">');

                                            resolve({
                                                default: response.url
                                            });
                                        });

                                        if (xhr.upload) {
                                            xhr.upload.addEventListener('progress', function(
                                            e) {
                                                if (e.lengthComputable) {
                                                    loader.uploadTotal = e.total;
                                                    loader.uploaded = e.loaded;
                                                }
                                            });
                                        }

                                        // Send request
                                        var data = new FormData();
                                        data.append('upload', file);
                                        data.append('crud_id', '{{ $itinerari->id ?? 0 }}');
                                        xhr.send(data);
                                    });
                                })
                        }
                    };
                }
            }

            var allEditors = document.querySelectorAll('.ckeditor');
            for (var i = 0; i < allEditors.length; ++i) {
                ClassicEditor.create(
                    allEditors[i], {
                        extraPlugins: [SimpleUploadAdapter]
                    }
                );
            }
        });
    </script>

    <script>
        Dropzone.options.fotoIntroduttivaDropzone = {
            url: '{{ route('admin.itineraris.storeMedia') }}',
            maxFilesize: 50, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 50,
                width: 15000,
                height: 15000
            },
            success: function(file, response) {
                $('form').find('input[name="foto_introduttiva"]').remove()
                $('form').append('<input type="hidden" name="foto_introduttiva" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="foto_introduttiva"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function() {
                @if (isset($itinerari) && $itinerari->foto_introduttiva)
                    var file = {!! json_encode($itinerari->foto_introduttiva) !!}
                    this.options.addedfile.call(this, file)
                    this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="foto_introduttiva" value="' + file.file_name +
                        '">')
                    this.options.maxFiles = this.options.maxFiles - 1
                @endif
            },
            error: function(file, response) {
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
    <script>
        var uploadedImmaginiMap = {}
        Dropzone.options.immaginiDropzone = {
            url: '{{ route('admin.itineraris.storeMedia') }}',
            maxFilesize: 500, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 500,
                width: 500000,
                height: 500000
            },
            success: function(file, response) {
                $('form').append('<input type="hidden" name="immagini[]" value="' + response.name + '">')
                uploadedImmaginiMap[file.name] = response.name
            },
            removedfile: function(file) {
                console.log(file)
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedImmaginiMap[file.name]
                }
                $('form').find('input[name="immagini[]"][value="' + name + '"]').remove()
            },
            init: function() {
                @if (isset($itinerari) && $itinerari->immagini)
                    var files = {!! json_encode($itinerari->immagini) !!}
                    for (var i in files) {
                        var file = files[i]
                        this.options.addedfile.call(this, file)
                        this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
                        file.previewElement.classList.add('dz-complete')
                        $('form').append('<input type="hidden" name="immagini[]" value="' + file.file_name + '">')
                    }
                @endif
            },
            error: function(file, response) {
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
