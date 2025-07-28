@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.settingsDinamici.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.settings-dinamicis.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.settingsDinamici.fields.id') }}
                        </th>
                        <td>
                            {{ $settingsDinamici->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.settingsDinamici.fields.progressivo') }}
                        </th>
                        <td>
                            {{ $settingsDinamici->progressivo }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.settings-dinamicis.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection