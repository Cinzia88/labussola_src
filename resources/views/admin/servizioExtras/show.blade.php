@extends('layouts.admin')
@section('styles')
<style>
            @media (max-width:800px) {
            .stelle {
                width: 15px;
                height: 15px;
            }

            .width30px {
                width: 80%;
            }
        }

        @media (min-width:801px) {
            .stelle {
                width: 20px;
                height: 20px;
            }

            .width30px {
                width: 200px;
            }
        }
</style>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.servizioExtra.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.servizio-extras.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.servizioExtra.fields.id') }}
                            </th>
                            <td>
                                {{ $servizioExtra->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.servizioExtra.fields.nome') }}
                            </th>
                            <td>
                                {{ $servizioExtra->nome }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.servizioExtra.fields.descrizione') }}
                            </th>
                            <td>
                                {!! $servizioExtra->descrizione !!}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.servizioExtra.fields.fornitore') }}
                            </th>
                            <td>
                                {{ $servizioExtra->fornitore->nome ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.servizioExtra.fields.foto') }}
                            </th>
                            <td>
                                @if ($servizioExtra->foto)
                                    <a href="{{ $servizioExtra->foto->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img width="100px" src="{{ $servizioExtra->foto->getUrl() }}">
                                    </a>
                                @endif
                         
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.servizio-extras.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
