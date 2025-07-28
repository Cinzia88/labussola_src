<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyVocePHotelPerPersonaRequest;
use App\Http\Requests\StoreVocePHotelPerPersonaRequest;
use App\Http\Requests\UpdateVocePHotelPerPersonaRequest;
use App\Models\VocePHotel;
use App\Models\VocePHotelPerPersona;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class VocePHotelPerPersonaController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('voce_p_hotel_per_persona_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = VocePHotelPerPersona::with(['voce_hotel'])->select(sprintf('%s.*', (new VocePHotelPerPersona())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'voce_p_hotel_per_persona_show';
                $editGate = 'voce_p_hotel_per_persona_edit';
                $deleteGate = 'voce_p_hotel_per_persona_delete';
                $crudRoutePart = 'voce-p-hotel-per-personas';

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
                return $row->tipologia_stanza ? VocePHotelPerPersona::TIPOLOGIA_STANZA_SELECT[$row->tipologia_stanza] : '';
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

        return view('admin.vocePHotelPerPersonas.index', compact('voce_p_hotels'));
    }

    public function create()
    {
        abort_if(Gate::denies('voce_p_hotel_per_persona_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $voce_hotels = VocePHotel::pluck('info_aggiuntive', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.vocePHotelPerPersonas.create', compact('voce_hotels'));
    }

    public function store(StoreVocePHotelPerPersonaRequest $request)
    {
        $vocePHotelPerPersona = VocePHotelPerPersona::create($request->all());

        return redirect()->route('admin.voce-p-hotel-per-personas.index');
    }

    public function edit(VocePHotelPerPersona $vocePHotelPerPersona)
    {
        abort_if(Gate::denies('voce_p_hotel_per_persona_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $voce_hotels = VocePHotel::pluck('info_aggiuntive', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vocePHotelPerPersona->load('voce_hotel');

        return view('admin.vocePHotelPerPersonas.edit', compact('vocePHotelPerPersona', 'voce_hotels'));
    }

    public function update(UpdateVocePHotelPerPersonaRequest $request, VocePHotelPerPersona $vocePHotelPerPersona)
    {
        $vocePHotelPerPersona->update($request->all());

        return redirect()->route('admin.voce-p-hotel-per-personas.index');
    }

    public function show(VocePHotelPerPersona $vocePHotelPerPersona)
    {
        abort_if(Gate::denies('voce_p_hotel_per_persona_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vocePHotelPerPersona->load('voce_hotel');

        return view('admin.vocePHotelPerPersonas.show', compact('vocePHotelPerPersona'));
    }

    public function destroy(VocePHotelPerPersona $vocePHotelPerPersona)
    {
        abort_if(Gate::denies('voce_p_hotel_per_persona_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vocePHotelPerPersona->delete();

        return back();
    }

    public function massDestroy(MassDestroyVocePHotelPerPersonaRequest $request)
    {
        VocePHotelPerPersona::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
