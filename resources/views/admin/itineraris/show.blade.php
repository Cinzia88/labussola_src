@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.itinerari.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.itineraris.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.itinerari.fields.id') }}
                            </th>
                            <td>
                                {{ $itinerari->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.itinerari.fields.nome') }}
                            </th>
                            <td>
                                {{ $itinerari->nome }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.itinerari.fields.descrizione') }}
                            </th>
                            <td>
                                {!! $itinerari->descrizione !!}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.itinerari.fields.foto_introduttiva') }}
                            </th>
                            <td>
                                @if ($itinerari->foto_introduttiva)
                                    <a href="{{ $itinerari->foto_introduttiva->getUrl() }}" target="_blank"
                                        style="display: inline-block">
                                        <img src="{{ $itinerari->foto_introduttiva->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.itinerari.fields.immagini') }}
                            </th>
                            <td>
                                @foreach ($itinerari->immagini as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $media->getUrl('thumb') }}">
                                    </a>
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.itineraris.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                    <a class="btn btn-default" href="{{ route('admin.itineraris.duplica', $itinerari->id) }}">
                        Duplica itinerario
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
