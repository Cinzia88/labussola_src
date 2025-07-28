<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyVocePHotelRequest;
use App\Http\Requests\StoreVocePHotelRequest;
use App\Http\Requests\UpdateVocePHotelRequest;
use App\Models\AlloggioHotel;
use App\Models\Preventivo;
use App\Models\VocePHotel;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class VocePHotelController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('voce_p_hotel_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = VocePHotel::with(['hotel', 'preventivo'])->select(sprintf('%s.*', (new VocePHotel())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'voce_p_hotel_show';
                $editGate = 'voce_p_hotel_edit';
                $deleteGate = 'voce_p_hotel_delete';
                $crudRoutePart = 'voce-p-hotels';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('info_aggiuntive', function ($row) {
                return $row->info_aggiuntive ? $row->info_aggiuntive : '';
            });
            $table->addColumn('hotel_nome', function ($row) {
                return $row->hotel ? $row->hotel->nome : '';
            });

            $table->addColumn('preventivo_oggetto', function ($row) {
                return $row->preventivo ? $row->preventivo->oggetto : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'hotel', 'preventivo']);

            return $table->make(true);
        }

        $alloggio_hotels = AlloggioHotel::get();
        $preventivos     = Preventivo::get();

        return view('admin.vocePHotels.index', compact('alloggio_hotels', 'preventivos'));
    }

    public function create()
    {
        abort_if(Gate::denies('voce_p_hotel_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $hotels = AlloggioHotel::pluck('nome', 'id')->prepend(trans('global.pleaseSelect'), '');

        $preventivos = Preventivo::pluck('oggetto', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.vocePHotels.create', compact('hotels', 'preventivos'));
    }

    public function store(StoreVocePHotelRequest $request)
    {
        $vocePHotel = VocePHotel::create($request->all());

        return redirect()->route('admin.voce-p-hotels.index');
    }

    public function edit(VocePHotel $vocePHotel)
    {
        abort_if(Gate::denies('voce_p_hotel_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $hotels = AlloggioHotel::pluck('nome', 'id')->prepend(trans('global.pleaseSelect'), '');

        $preventivos = Preventivo::pluck('oggetto', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vocePHotel->load('hotel', 'preventivo');

        return view('admin.vocePHotels.edit', compact('hotels', 'preventivos', 'vocePHotel'));
    }

    public function update(UpdateVocePHotelRequest $request, VocePHotel $vocePHotel)
    {
        $vocePHotel->update($request->all());

        return redirect()->route('admin.voce-p-hotels.index');
    }

    public function show(VocePHotel $vocePHotel)
    {
        abort_if(Gate::denies('voce_p_hotel_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vocePHotel->load('hotel', 'preventivo');

        return view('admin.vocePHotels.show', compact('vocePHotel'));
    }

    public function destroy(VocePHotel $vocePHotel)
    {
        abort_if(Gate::denies('voce_p_hotel_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vocePHotel->delete();

        return back();
    }

    public function massDestroy(MassDestroyVocePHotelRequest $request)
    {
        VocePHotel::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
