@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.vocePHotel.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.voce-p-hotels.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePHotel.fields.id') }}
                        </th>
                        <td>
                            {{ $vocePHotel->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePHotel.fields.info_aggiuntive') }}
                        </th>
                        <td>
                            {{ $vocePHotel->info_aggiuntive }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePHotel.fields.hotel') }}
                        </th>
                        <td>
                            {{ $vocePHotel->hotel->nome ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vocePHotel.fields.preventivo') }}
                        </th>
                        <td>
                            {{ $vocePHotel->preventivo->oggetto ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.voce-p-hotels.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection