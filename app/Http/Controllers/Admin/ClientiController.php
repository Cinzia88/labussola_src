<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyClientiRequest;
use App\Http\Requests\StoreClientiRequest;
use App\Http\Requests\UpdateClientiRequest;
use App\Models\Clienti;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ClientiController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('clienti_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Clienti::query()->select(sprintf('%s.*', (new Clienti())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'clienti_show';
                $editGate = 'clienti_edit';
                $deleteGate = 'clienti_delete';
                $crudRoutePart = 'clientis';

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

        return view('admin.clientis.index');
    }

    public function create()
    {
        abort_if(Gate::denies('clienti_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.clientis.create');
    }

    public function store(StoreClientiRequest $request)
    {
        $clienti = Clienti::create($request->all());

        return redirect()->route('admin.clientis.index');
    }

    public function edit(Clienti $clienti)
    {
        abort_if(Gate::denies('clienti_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.clientis.edit', compact('clienti'));
    }

    public function update(UpdateClientiRequest $request, Clienti $clienti)
    {
        $clienti->update($request->all());

        return redirect()->route('admin.clientis.index');
    }

    public function show(Clienti $clienti)
    {
        abort_if(Gate::denies('clienti_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $clienti->load('clientePreventivos');

        return view('admin.clientis.show', compact('clienti'));
    }

    public function destroy(Clienti $clienti)
    {
        abort_if(Gate::denies('clienti_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $clienti->delete();

        return back();
    }

    public function massDestroy(MassDestroyClientiRequest $request)
    {
        Clienti::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
