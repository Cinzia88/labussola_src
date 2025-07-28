<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyVocePTrasportoUnaTantumRequest;
use App\Http\Requests\StoreVocePTrasportoUnaTantumRequest;
use App\Http\Requests\UpdateVocePTrasportoUnaTantumRequest;
use App\Models\Preventivo;
use App\Models\Trasporto;
use App\Models\VocePTrasportoUnaTantum;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class VocePTrasportoUnaTantumController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('voce_p_trasporto_una_tantum_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = VocePTrasportoUnaTantum::with(['trasporto', 'preventivo'])->select(sprintf('%s.*', (new VocePTrasportoUnaTantum())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'voce_p_trasporto_una_tantum_show';
                $editGate = 'voce_p_trasporto_una_tantum_edit';
                $deleteGate = 'voce_p_trasporto_una_tantum_delete';
                $crudRoutePart = 'voce-p-trasporto-una-tanta';

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
                return $row->tipologia_trasporto ? VocePTrasportoUnaTantum::TIPOLOGIA_TRASPORTO_SELECT[$row->tipologia_trasporto] : '';
            });
            $table->editColumn('scorpora', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->scorpora ? 'checked' : null) . '>';
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
            $table->editColumn('tipologia', function ($row) {
                return $row->tipologia ? VocePTrasportoUnaTantum::TIPOLOGIA_SELECT[$row->tipologia] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'scorpora', 'trasporto', 'preventivo']);

            return $table->make(true);
        }

        $trasportos  = Trasporto::get();
        $preventivos = Preventivo::get();

        return view('admin.vocePTrasportoUnaTanta.index', compact('trasportos', 'preventivos'));
    }

    public function create()
    {
        abort_if(Gate::denies('voce_p_trasporto_una_tantum_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $trasportos = Trasporto::pluck('nome', 'id')->prepend(trans('global.pleaseSelect'), '');

        $preventivos = Preventivo::pluck('oggetto', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.vocePTrasportoUnaTanta.create', compact('preventivos', 'trasportos'));
    }

    public function store(StoreVocePTrasportoUnaTantumRequest $request)
    {
        $vocePTrasportoUnaTantum = VocePTrasportoUnaTantum::create($request->all());

        return redirect()->route('admin.voce-p-trasporto-una-tanta.index');
    }

    public function edit(VocePTrasportoUnaTantum $vocePTrasportoUnaTantum)
    {
        abort_if(Gate::denies('voce_p_trasporto_una_tantum_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $trasportos = Trasporto::pluck('nome', 'id')->prepend(trans('global.pleaseSelect'), '');

        $preventivos = Preventivo::pluck('oggetto', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vocePTrasportoUnaTantum->load('trasporto', 'preventivo');

        return view('admin.vocePTrasportoUnaTanta.edit', compact('preventivos', 'trasportos', 'vocePTrasportoUnaTantum'));
    }

    public function update(UpdateVocePTrasportoUnaTantumRequest $request, VocePTrasportoUnaTantum $vocePTrasportoUnaTantum)
    {
        $vocePTrasportoUnaTantum->update($request->all());

        return redirect()->route('admin.voce-p-trasporto-una-tanta.index');
    }

    public function show(VocePTrasportoUnaTantum $vocePTrasportoUnaTantum)
    {
        abort_if(Gate::denies('voce_p_trasporto_una_tantum_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vocePTrasportoUnaTantum->load('trasporto', 'preventivo');

        return view('admin.vocePTrasportoUnaTanta.show', compact('vocePTrasportoUnaTantum'));
    }

    public function destroy(VocePTrasportoUnaTantum $vocePTrasportoUnaTantum)
    {
        abort_if(Gate::denies('voce_p_trasporto_una_tantum_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vocePTrasportoUnaTantum->delete();

        return back();
    }

    public function massDestroy(MassDestroyVocePTrasportoUnaTantumRequest $request)
    {
        VocePTrasportoUnaTantum::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
