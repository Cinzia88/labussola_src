@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.trasporto.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.trasportos.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.trasporto.fields.id') }}
                        </th>
                        <td>
                            {{ $trasporto->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.trasporto.fields.nome') }}
                        </th>
                        <td>
                            {{ $trasporto->nome }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.trasporto.fields.descrizione') }}
                        </th>
                        <td>
                            {{ $trasporto->descrizione }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.trasporto.fields.foto') }}
                        </th>
                        <td>
                            @foreach($trasporto->foto as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.trasporto.fields.fornitore') }}
                        </th>
                        <td>
                            {{ $trasporto->fornitore->nome ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.trasportos.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection