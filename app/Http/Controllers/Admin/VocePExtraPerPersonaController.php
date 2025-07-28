<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyVocePExtraPerPersonaRequest;
use App\Http\Requests\StoreVocePExtraPerPersonaRequest;
use App\Http\Requests\UpdateVocePExtraPerPersonaRequest;
use App\Models\Preventivo;
use App\Models\ServizioExtra;
use App\Models\VocePExtraPerPersona;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class VocePExtraPerPersonaController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('voce_p_extra_per_persona_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = VocePExtraPerPersona::with(['servizio_extra', 'preventivo'])->select(sprintf('%s.*', (new VocePExtraPerPersona())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'voce_p_extra_per_persona_show';
                $editGate = 'voce_p_extra_per_persona_edit';
                $deleteGate = 'voce_p_extra_per_persona_delete';
                $crudRoutePart = 'voce-p-extra-per-personas';

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
            $table->addColumn('servizio_extra_nome', function ($row) {
                return $row->servizio_extra ? $row->servizio_extra->nome : '';
            });

            $table->editColumn('prezzo', function ($row) {
                return $row->prezzo ? $row->prezzo : '';
            });
            $table->editColumn('quantita', function ($row) {
                return $row->quantita ? $row->quantita : '';
            });
            $table->editColumn('scorpora', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->scorpora ? 'checked' : null) . '>';
            });
            $table->addColumn('preventivo_oggetto', function ($row) {
                return $row->preventivo ? $row->preventivo->oggetto : '';
            });

            $table->editColumn('info_aggiuntive', function ($row) {
                return $row->info_aggiuntive ? $row->info_aggiuntive : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'servizio_extra', 'scorpora', 'preventivo']);

            return $table->make(true);
        }

        $servizio_extras = ServizioExtra::get();
        $preventivos     = Preventivo::get();

        return view('admin.vocePExtraPerPersonas.index', compact('servizio_extras', 'preventivos'));
    }

    public function create()
    {
        abort_if(Gate::denies('voce_p_extra_per_persona_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servizio_extras = ServizioExtra::pluck('nome', 'id')->prepend(trans('global.pleaseSelect'), '');

        $preventivos = Preventivo::pluck('oggetto', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.vocePExtraPerPersonas.create', compact('preventivos', 'servizio_extras'));
    }

    public function store(StoreVocePExtraPerPersonaRequest $request)
    {
        $vocePExtraPerPersona = VocePExtraPerPersona::create($request->all());

        return redirect()->route('admin.voce-p-extra-per-personas.index');
    }

    public function edit(VocePExtraPerPersona $vocePExtraPerPersona)
    {
        abort_if(Gate::denies('voce_p_extra_per_persona_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servizio_extras = ServizioExtra::pluck('nome', 'id')->prepend(trans('global.pleaseSelect'), '');

        $preventivos = Preventivo::pluck('oggetto', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vocePExtraPerPersona->load('servizio_extra', 'preventivo');

        return view('admin.vocePExtraPerPersonas.edit', compact('preventivos', 'servizio_extras', 'vocePExtraPerPersona'));
    }

    public function update(UpdateVocePExtraPerPersonaRequest $request, VocePExtraPerPersona $vocePExtraPerPersona)
    {
        $vocePExtraPerPersona->update($request->all());

        return redirect()->route('admin.voce-p-extra-per-personas.index');
    }

    public function show(VocePExtraPerPersona $vocePExtraPerPersona)
    {
        abort_if(Gate::denies('voce_p_extra_per_persona_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vocePExtraPerPersona->load('servizio_extra', 'preventivo');

        return view('admin.vocePExtraPerPersonas.show', compact('vocePExtraPerPersona'));
    }

    public function destroy(VocePExtraPerPersona $vocePExtraPerPersona)
    {
        abort_if(Gate::denies('voce_p_extra_per_persona_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vocePExtraPerPersona->delete();

        return back();
    }

    public function massDestroy(MassDestroyVocePExtraPerPersonaRequest $request)
    {
        VocePExtraPerPersona::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
