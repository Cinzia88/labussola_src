<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyVocePHotelPerNotteRequest;
use App\Http\Requests\StoreVocePHotelPerNotteRequest;
use App\Http\Requests\UpdateVocePHotelPerNotteRequest;
use App\Models\VocePHotel;
use App\Models\VocePHotelPerNotte;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class VocePHotelPerNotteController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('voce_p_hotel_per_notte_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = VocePHotelPerNotte::with(['voce_hotel'])->select(sprintf('%s.*', (new VocePHotelPerNotte())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'voce_p_hotel_per_notte_show';
                $editGate = 'voce_p_hotel_per_notte_edit';
                $deleteGate = 'voce_p_hotel_per_notte_delete';
                $crudRoutePart = 'voce-p-hotel-per-nottes';

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
            $table->editColumn('tipologia_stanza', function ($row) {
                return $row->tipologia_stanza ? VocePHotelPerNotte::TIPOLOGIA_STANZA_SELECT[$row->tipologia_stanza] : '';
            });
            $table->editColumn('numero_stanze', function ($row) {
                return $row->numero_stanze ? $row->numero_stanze : '';
            });
            $table->editColumn('costo_a_notte', function ($row) {
                return $row->costo_a_notte ? $row->costo_a_notte : '';
            });
            $table->addColumn('voce_hotel_info_aggiuntive', function ($row) {
                return $row->voce_hotel ? $row->voce_hotel->info_aggiuntive : '';
            });

            $table->editColumn('scorpora', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->scorpora ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'voce_hotel', 'scorpora']);

            return $table->make(true);
        }

        $voce_p_hotels = VocePHotel::get();

        return view('admin.vocePHotelPerNottes.index', compact('voce_p_hotels'));
    }

    public function create()
    {
        abort_if(Gate::denies('voce_p_hotel_per_notte_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $voce_hotels = VocePHotel::pluck('info_aggiuntive', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.vocePHotelPerNottes.create', compact('voce_hotels'));
    }

    public function store(StoreVocePHotelPerNotteRequest $request)
    {
        $vocePHotelPerNotte = VocePHotelPerNotte::create($request->all());

        return redirect()->route('admin.voce-p-hotel-per-nottes.index');
    }

    public function edit(VocePHotelPerNotte $vocePHotelPerNotte)
    {
        abort_if(Gate::denies('voce_p_hotel_per_notte_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $voce_hotels = VocePHotel::pluck('info_aggiuntive', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vocePHotelPerNotte->load('voce_hotel');

        return view('admin.vocePHotelPerNottes.edit', compact('vocePHotelPerNotte', 'voce_hotels'));
    }

    public function update(UpdateVocePHotelPerNotteRequest $request, VocePHotelPerNotte $vocePHotelPerNotte)
    {
        $vocePHotelPerNotte->update($request->all());

        return redirect()->route('admin.voce-p-hotel-per-nottes.index');
    }

    public function show(VocePHotelPerNotte $vocePHotelPerNotte)
    {
        abort_if(Gate::denies('voce_p_hotel_per_notte_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vocePHotelPerNotte->load('voce_hotel');

        return view('admin.vocePHotelPerNottes.show', compact('vocePHotelPerNotte'));
    }

    public function destroy(VocePHotelPerNotte $vocePHotelPerNotte)
    {
        abort_if(Gate::denies('voce_p_hotel_per_notte_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vocePHotelPerNotte->delete();

        return back();
    }

    public function massDestroy(MassDestroyVocePHotelPerNotteRequest $request)
    {
        VocePHotelPerNotte::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
