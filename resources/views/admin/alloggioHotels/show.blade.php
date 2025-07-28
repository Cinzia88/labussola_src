@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.alloggioHotel.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.alloggio-hotels.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.alloggioHotel.fields.id') }}
                        </th>
                        <td>
                            {{ $alloggioHotel->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.alloggioHotel.fields.nome') }}
                        </th>
                        <td>
                            {{ $alloggioHotel->nome }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.alloggioHotel.fields.indirizzo') }}
                        </th>
                        <td>
                            {{ $alloggioHotel->indirizzo }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.alloggioHotel.fields.descrizione') }}
                        </th>
                        <td>
                            {{ $alloggioHotel->descrizione }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.alloggioHotel.fields.foto') }}
                        </th>
                        <td>
                            @foreach($alloggioHotel->foto as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.alloggioHotel.fields.stelle') }}
                        </th>
                        <td>
                            {{ App\Models\AlloggioHotel::STELLE_SELECT[$alloggioHotel->stelle] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.alloggioHotel.fields.fornitore') }}
                        </th>
                        <td>
                            {{ $alloggioHotel->fornitore->nome ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.alloggio-hotels.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#hotel_voce_p_hotels" role="tab" data-toggle="tab">
                {{ trans('cruds.vocePHotel.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="hotel_voce_p_hotels">
            @includeIf('admin.alloggioHotels.relationships.hotelVocePHotels', ['vocePHotels' => $alloggioHotel->hotelVocePHotels])
        </div>
    </div>
</div>

@endsection