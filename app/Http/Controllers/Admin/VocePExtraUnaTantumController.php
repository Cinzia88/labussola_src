<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyVocePExtraUnaTantumRequest;
use App\Http\Requests\StoreVocePExtraUnaTantumRequest;
use App\Http\Requests\UpdateVocePExtraUnaTantumRequest;
use App\Models\Preventivo;
use App\Models\ServizioExtra;
use App\Models\VocePExtraUnaTantum;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class VocePExtraUnaTantumController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('voce_p_extra_una_tantum_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = VocePExtraUnaTantum::with(['servizio_extra', 'preventivo'])->select(sprintf('%s.*', (new VocePExtraUnaTantum())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'voce_p_extra_una_tantum_show';
                $editGate = 'voce_p_extra_una_tantum_edit';
                $deleteGate = 'voce_p_extra_una_tantum_delete';
                $crudRoutePart = 'voce-p-extra-una-tanta';

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
            $table->editColumn('scorpora', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->scorpora ? 'checked' : null) . '>';
            });
            $table->addColumn('preventivo_oggetto', function ($row) {
                return $row->preventivo ? $row->preventivo->oggetto : '';
            });

            $table->editColumn('info_aggiuntive', function ($row) {
                return $row->info_aggiuntive ? $row->info_aggiuntive : '';
            });
            $table->editColumn('quantita', function ($row) {
                return $row->quantita ? $row->quantita : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'servizio_extra', 'scorpora', 'preventivo']);

            return $table->make(true);
        }

        $servizio_extras = ServizioExtra::get();
        $preventivos     = Preventivo::get();

        return view('admin.vocePExtraUnaTanta.index', compact('servizio_extras', 'preventivos'));
    }

    public function create()
    {
        abort_if(Gate::denies('voce_p_extra_una_tantum_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servizio_extras = ServizioExtra::pluck('nome', 'id')->prepend(trans('global.pleaseSelect'), '');

        $preventivos = Preventivo::pluck('oggetto', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.vocePExtraUnaTanta.create', compact('preventivos', 'servizio_extras'));
    }

    public function store(StoreVocePExtraUnaTantumRequest $request)
    {
        $vocePExtraUnaTantum = VocePExtraUnaTantum::create($request->all());

        return redirect()->route('admin.voce-p-extra-una-tanta.index');
    }

    public function edit(VocePExtraUnaTantum $vocePExtraUnaTantum)
    {
        abort_if(Gate::denies('voce_p_extra_una_tantum_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servizio_extras = ServizioExtra::pluck('nome', 'id')->prepend(trans('global.pleaseSelect'), '');

        $preventivos = Preventivo::pluck('oggetto', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vocePExtraUnaTantum->load('servizio_extra', 'preventivo');

        return view('admin.vocePExtraUnaTanta.edit', compact('preventivos', 'servizio_extras', 'vocePExtraUnaTantum'));
    }

    public function update(UpdateVocePExtraUnaTantumRequest $request, VocePExtraUnaTantum $vocePExtraUnaTantum)
    {
        $vocePExtraUnaTantum->update($request->all());

        return redirect()->route('admin.voce-p-extra-una-tanta.index');
    }

    public function show(VocePExtraUnaTantum $vocePExtraUnaTantum)
    {
        abort_if(Gate::denies('voce_p_extra_una_tantum_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vocePExtraUnaTantum->load('servizio_extra', 'preventivo');

        return view('admin.vocePExtraUnaTanta.show', compact('vocePExtraUnaTantum'));
    }

    public function destroy(VocePExtraUnaTantum $vocePExtraUnaTantum)
    {
        abort_if(Gate::denies('voce_p_extra_una_tantum_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vocePExtraUnaTantum->delete();

        return back();
    }

    public function massDestroy(MassDestroyVocePExtraUnaTantumRequest $request)
    {
        VocePExtraUnaTantum::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
