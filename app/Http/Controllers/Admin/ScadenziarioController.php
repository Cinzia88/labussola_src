<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyScadenziarioRequest;
use App\Http\Requests\StoreScadenziarioRequest;
use App\Http\Requests\UpdateScadenziarioRequest;
use App\Models\Preventivo;
use App\Models\Scadenziario;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ScadenziarioController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('scadenziario_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Scadenziario::with(['preventivo', 'created_by'])->select(sprintf('%s.*', (new Scadenziario())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'scadenziario_show';
                $editGate = 'scadenziario_edit';
                $deleteGate = 'scadenziario_delete';
                $crudRoutePart = 'scadenziarios';

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
            $table->editColumn('nome', function ($row) {
                return $row->nome ? $row->nome : '';
            });

            $table->editColumn('eseguito', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->eseguito ? 'checked' : null) . '>';
            });
            $table->addColumn('preventivo_numero', function ($row) {
                return $row->preventivo ? $row->preventivo->numero : '';
            });

            $table->editColumn('preventivo.anno', function ($row) {
                return $row->preventivo ? (is_string($row->preventivo) ? $row->preventivo : $row->preventivo->anno) : '';
            });
            $table->addColumn('created_by_name', function ($row) {
                return $row->created_by ? $row->created_by->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'eseguito', 'preventivo', 'created_by']);

            return $table->make(true);
        }

        $preventivos = Preventivo::get();
        $users       = User::get();

        return view('admin.scadenziarios.index', compact('preventivos', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('scadenziario_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $preventivos = Preventivo::all();

        $created_bies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.scadenziarios.create', compact('created_bies', 'preventivos'));
    }

    public function store(StoreScadenziarioRequest $request)
    {
        $scadenziario = Scadenziario::create($request->all());

        return redirect()->route('admin.scadenziarios.index');
    }

    public function edit(Scadenziario $scadenziario)
    {
        abort_if(Gate::denies('scadenziario_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $preventivos = Preventivo::all();

        $created_bies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $scadenziario->load('preventivo', 'created_by');

        return view('admin.scadenziarios.edit', compact('created_bies', 'preventivos', 'scadenziario'));
    }

    public function update(UpdateScadenziarioRequest $request, Scadenziario $scadenziario)
    {
        $scadenziario->update($request->all());

        return redirect()->route('admin.scadenziarios.index');
    }

    public function show(Scadenziario $scadenziario)
    {
        abort_if(Gate::denies('scadenziario_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $scadenziario->load('preventivo', 'created_by');

        return view('admin.scadenziarios.show', compact('scadenziario'));
    }

    public function destroy(Scadenziario $scadenziario)
    {
        abort_if(Gate::denies('scadenziario_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $scadenziario->delete();

        return back();
    }

    public function massDestroy(MassDestroyScadenziarioRequest $request)
    {
        Scadenziario::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
