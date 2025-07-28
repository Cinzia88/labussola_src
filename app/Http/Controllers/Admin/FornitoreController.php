<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyFornitoreRequest;
use App\Http\Requests\StoreFornitoreRequest;
use App\Http\Requests\UpdateFornitoreRequest;
use App\Models\Fornitore;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class FornitoreController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('fornitore_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Fornitore::query()->select(sprintf('%s.*', (new Fornitore())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'fornitore_show';
                $editGate = 'fornitore_edit';
                $deleteGate = 'fornitore_delete';
                $crudRoutePart = 'fornitores';

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
            $table->editColumn('cognome', function ($row) {
                return $row->cognome ? $row->cognome : '';
            });
            $table->editColumn('ragione_sociale', function ($row) {
                return $row->ragione_sociale ? $row->ragione_sociale : '';
            });
            $table->editColumn('piva_cf', function ($row) {
                return $row->piva_cf ? $row->piva_cf : '';
            });
            $table->editColumn('indirizzo', function ($row) {
                return $row->indirizzo ? $row->indirizzo : '';
            });
            $table->editColumn('citta', function ($row) {
                return $row->citta ? $row->citta : '';
            });
            $table->editColumn('cap', function ($row) {
                return $row->cap ? $row->cap : '';
            });
            $table->editColumn('provincia', function ($row) {
                return $row->provincia ? $row->provincia : '';
            });
            $table->editColumn('stato', function ($row) {
                return $row->stato ? $row->stato : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->editColumn('telefono', function ($row) {
                return $row->telefono ? $row->telefono : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.fornitores.index');
    }

    public function create()
    {
        abort_if(Gate::denies('fornitore_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.fornitores.create');
    }

    public function store(StoreFornitoreRequest $request)
    {
        $fornitore = Fornitore::create($request->all());

        return redirect()->route('admin.fornitores.index');
    }

    public function edit(Fornitore $fornitore)
    {
        abort_if(Gate::denies('fornitore_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.fornitores.edit', compact('fornitore'));
    }

    public function update(UpdateFornitoreRequest $request, Fornitore $fornitore)
    {
        $fornitore->update($request->all());

        return redirect()->route('admin.fornitores.index');
    }

    public function show(Fornitore $fornitore)
    {
        abort_if(Gate::denies('fornitore_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fornitore->load('fornitoreServizioExtras');

        return view('admin.fornitores.show', compact('fornitore'));
    }

    public function destroy(Fornitore $fornitore)
    {
        abort_if(Gate::denies('fornitore_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fornitore->delete();

        return back();
    }

    public function massDestroy(MassDestroyFornitoreRequest $request)
    {
        Fornitore::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
