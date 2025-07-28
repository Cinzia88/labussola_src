<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySettingsDinamiciRequest;
use App\Http\Requests\StoreSettingsDinamiciRequest;
use App\Http\Requests\UpdateSettingsDinamiciRequest;
use App\Models\SettingsDinamici;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SettingsDinamiciController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('settings_dinamici_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SettingsDinamici::query()->select(sprintf('%s.*', (new SettingsDinamici())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'settings_dinamici_show';
                $editGate = 'settings_dinamici_edit';
                $deleteGate = 'settings_dinamici_delete';
                $crudRoutePart = 'settings-dinamicis';

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
            $table->editColumn('progressivo', function ($row) {
                return $row->progressivo ? $row->progressivo : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.settingsDinamicis.index');
    }

    public function create()
    {
        abort_if(Gate::denies('settings_dinamici_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.settingsDinamicis.create');
    }

    public function store(StoreSettingsDinamiciRequest $request)
    {
        $settingsDinamici = SettingsDinamici::create($request->all());

        return redirect()->route('admin.settings-dinamicis.index');
    }

    public function edit(SettingsDinamici $settingsDinamici)
    {
        abort_if(Gate::denies('settings_dinamici_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.settingsDinamicis.edit', compact('settingsDinamici'));
    }

    public function update(UpdateSettingsDinamiciRequest $request, SettingsDinamici $settingsDinamici)
    {
        $settingsDinamici->update($request->all());

        return redirect()->route('admin.settings-dinamicis.index');
    }

    public function show(SettingsDinamici $settingsDinamici)
    {
        abort_if(Gate::denies('settings_dinamici_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.settingsDinamicis.show', compact('settingsDinamici'));
    }

    public function destroy(SettingsDinamici $settingsDinamici)
    {
        abort_if(Gate::denies('settings_dinamici_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $settingsDinamici->delete();

        return back();
    }

    public function massDestroy(MassDestroySettingsDinamiciRequest $request)
    {
        SettingsDinamici::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
