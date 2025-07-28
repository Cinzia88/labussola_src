<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyVocePTrasportoPerPersonaRequest;
use App\Http\Requests\StoreVocePTrasportoPerPersonaRequest;
use App\Http\Requests\UpdateVocePTrasportoPerPersonaRequest;
use App\Models\Preventivo;
use App\Models\Trasporto;
use App\Models\VocePTrasportoPerPersona;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class VocePTrasportoPerPersonaController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('voce_p_trasporto_per_persona_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = VocePTrasportoPerPersona::with(['trasporto', 'preventivo'])->select(sprintf('%s.*', (new VocePTrasportoPerPersona())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'voce_p_trasporto_per_persona_show';
                $editGate = 'voce_p_trasporto_per_persona_edit';
                $deleteGate = 'voce_p_trasporto_per_persona_delete';
                $crudRoutePart = 'voce-p-trasporto-per-personas';

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
            $table->editColumn('tipologia_trasporto', function ($row) {
                return $row->tipologia_trasporto ? VocePTrasportoPerPersona::TIPOLOGIA_TRASPORTO_SELECT[$row->tipologia_trasporto] : '';
            });
            $table->addColumn('trasporto_nome', function ($row) {
                return $row->trasporto ? $row->trasporto->nome : '';
            });

            $table->editColumn('prezzo', function ($row) {
                return $row->prezzo ? $row->prezzo : '';
            });
            $table->addColumn('preventivo_oggetto', function ($row) {
                return $row->preventivo ? $row->preventivo->oggetto : '';
            });

            $table->editColumn('informazioni_aggiuntive', function ($row) {
                return $row->informazioni_aggiuntive ? $row->informazioni_aggiuntive : '';
            });
            $table->editColumn('scorpora', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->scorpora ? 'checked' : null) . '>';
            });
            $table->editColumn('tipologia', function ($row) {
                return $row->tipologia ? VocePTrasportoPerPersona::TIPOLOGIA_SELECT[$row->tipologia] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'trasporto', 'preventivo', 'scorpora']);

            return $table->make(true);
        }

        $trasportos  = Trasporto::get();
        $preventivos = Preventivo::get();

        return view('admin.vocePTrasportoPerPersonas.index', compact('trasportos', 'preventivos'));
    }

    public function create()
    {
        abort_if(Gate::denies('voce_p_trasporto_per_persona_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $trasportos = Trasporto::pluck('nome', 'id')->prepend(trans('global.pleaseSelect'), '');

        $preventivos = Preventivo::pluck('oggetto', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.vocePTrasportoPerPersonas.create', compact('preventivos', 'trasportos'));
    }

    public function store(StoreVocePTrasportoPerPersonaRequest $request)
    {
        $vocePTrasportoPerPersona = VocePTrasportoPerPersona::create($request->all());

        return redirect()->route('admin.voce-p-trasporto-per-personas.index');
    }

    public function edit(VocePTrasportoPerPersona $vocePTrasportoPerPersona)
    {
        abort_if(Gate::denies('voce_p_trasporto_per_persona_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $trasportos = Trasporto::pluck('nome', 'id')->prepend(trans('global.pleaseSelect'), '');

        $preventivos = Preventivo::pluck('oggetto', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vocePTrasportoPerPersona->load('trasporto', 'preventivo');

        return view('admin.vocePTrasportoPerPersonas.edit', compact('preventivos', 'trasportos', 'vocePTrasportoPerPersona'));
    }

    public function update(UpdateVocePTrasportoPerPersonaRequest $request, VocePTrasportoPerPersona $vocePTrasportoPerPersona)
    {
        $vocePTrasportoPerPersona->update($request->all());

        return redirect()->route('admin.voce-p-trasporto-per-personas.index');
    }

    public function show(VocePTrasportoPerPersona $vocePTrasportoPerPersona)
    {
        abort_if(Gate::denies('voce_p_trasporto_per_persona_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vocePTrasportoPerPersona->load('trasporto', 'preventivo');

        return view('admin.vocePTrasportoPerPersonas.show', compact('vocePTrasportoPerPersona'));
    }

    public function destroy(VocePTrasportoPerPersona $vocePTrasportoPerPersona)
    {
        abort_if(Gate::denies('voce_p_trasporto_per_persona_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vocePTrasportoPerPersona->delete();

        return back();
    }

    public function massDestroy(MassDestroyVocePTrasportoPerPersonaRequest $request)
    {
        VocePTrasportoPerPersona::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
