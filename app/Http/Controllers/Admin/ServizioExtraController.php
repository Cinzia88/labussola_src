<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyServizioExtraRequest;
use App\Http\Requests\StoreServizioExtraRequest;
use App\Http\Requests\UpdateServizioExtraRequest;
use App\Models\Fornitore;
use App\Models\ServizioExtra;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ServizioExtraController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('servizio_extra_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ServizioExtra::with(['fornitore'])->select(sprintf('%s.*', (new ServizioExtra())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'servizio_extra_show';
                $editGate = 'servizio_extra_edit';
                $deleteGate = 'servizio_extra_delete';
                $crudRoutePart = 'servizio-extras';

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
            $table->editColumn('descrizione', function ($row) {
                return $row->descrizione ? $row->descrizione : '';
            });
            $table->addColumn('fornitore_nome', function ($row) {
                return $row->fornitore ? $row->fornitore->nome : '';
            });

            $table->editColumn('fornitore.cognome', function ($row) {
                return $row->fornitore ? (is_string($row->fornitore) ? $row->fornitore : $row->fornitore->cognome) : '';
            });
            $table->editColumn('fornitore.ragione_sociale', function ($row) {
                return $row->fornitore ? (is_string($row->fornitore) ? $row->fornitore : $row->fornitore->ragione_sociale) : '';
            });
            $table->editColumn('foto', function ($row) {
                return $row->foto ? '<a href="' . $row->foto->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'fornitore', 'foto']);

            return $table->make(true);
        }

        $fornitores = Fornitore::get();

        return view('admin.servizioExtras.index', compact('fornitores'));
    }

    public function create()
    {
        abort_if(Gate::denies('servizio_extra_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fornitores = Fornitore::pluck('nome', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.servizioExtras.create', compact('fornitores'));
    }

    public function store(StoreServizioExtraRequest $request)
    {
        $servizioExtra = ServizioExtra::create($request->all());

        if ($request->input('foto', false)) {
            $servizioExtra->addMedia(storage_path('tmp/uploads/' . basename($request->input('foto'))))->toMediaCollection('foto');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $servizioExtra->id]);
        }

        return redirect()->route('admin.servizio-extras.index');
    }

    public function edit(ServizioExtra $servizioExtra)
    {
        abort_if(Gate::denies('servizio_extra_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fornitores = Fornitore::pluck('nome', 'id')->prepend(trans('global.pleaseSelect'), '');

        $servizioExtra->load('fornitore');

        return view('admin.servizioExtras.edit', compact('fornitores', 'servizioExtra'));
    }

    public function update(UpdateServizioExtraRequest $request, ServizioExtra $servizioExtra)
    {
        $servizioExtra->update($request->all());

        if ($request->input('foto', false)) {
            if (!$servizioExtra->foto || $request->input('foto') !== $servizioExtra->foto->file_name) {
                if ($servizioExtra->foto) {
                    $servizioExtra->foto->delete();
                }
                $servizioExtra->addMedia(storage_path('tmp/uploads/' . basename($request->input('foto'))))->toMediaCollection('foto');
            }
        } elseif ($servizioExtra->foto) {
            $servizioExtra->foto->delete();
        }

        return redirect()->route('admin.servizio-extras.index');
    }

    public function show(ServizioExtra $servizioExtra)
    {
        abort_if(Gate::denies('servizio_extra_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servizioExtra->load('fornitore');

        return view('admin.servizioExtras.show', compact('servizioExtra'));
    }

    public function destroy(ServizioExtra $servizioExtra)
    {
        abort_if(Gate::denies('servizio_extra_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servizioExtra->delete();

        return back();
    }

    public function massDestroy(MassDestroyServizioExtraRequest $request)
    {
        ServizioExtra::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('servizio_extra_create') && Gate::denies('servizio_extra_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new ServizioExtra();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
