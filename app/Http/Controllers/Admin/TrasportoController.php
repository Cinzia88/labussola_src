<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyTrasportoRequest;
use App\Http\Requests\StoreTrasportoRequest;
use App\Http\Requests\UpdateTrasportoRequest;
use App\Models\Fornitore;
use App\Models\Trasporto;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TrasportoController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('trasporto_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Trasporto::with(['fornitore'])->select(sprintf('%s.*', (new Trasporto())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'trasporto_show';
                $editGate = 'trasporto_edit';
                $deleteGate = 'trasporto_delete';
                $crudRoutePart = 'trasportos';

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
            $table->editColumn('foto', function ($row) {
                if (!$row->foto) {
                    return '';
                }
                $links = [];
                foreach ($row->foto as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank"><img src="' . $media->getUrl('thumb') . '" width="50px" height="50px"></a>';
                }

                return implode(' ', $links);
            });
            $table->addColumn('fornitore_nome', function ($row) {
                return $row->fornitore ? $row->fornitore->nome : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'foto', 'fornitore']);

            return $table->make(true);
        }

        $fornitores = Fornitore::get();

        return view('admin.trasportos.index', compact('fornitores'));
    }

    public function create()
    {
        abort_if(Gate::denies('trasporto_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fornitores = Fornitore::pluck('nome', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.trasportos.create', compact('fornitores'));
    }

    public function store(StoreTrasportoRequest $request)
    {
        $trasporto = Trasporto::create($request->all());

        foreach ($request->input('foto', []) as $file) {
            $trasporto->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('foto');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $trasporto->id]);
        }

        return redirect()->route('admin.trasportos.index');
    }

    public function edit(Trasporto $trasporto)
    {
        abort_if(Gate::denies('trasporto_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fornitores = Fornitore::pluck('nome', 'id')->prepend(trans('global.pleaseSelect'), '');

        $trasporto->load('fornitore');

        return view('admin.trasportos.edit', compact('fornitores', 'trasporto'));
    }

    public function update(UpdateTrasportoRequest $request, Trasporto $trasporto)
    {
        $trasporto->update($request->all());

        if (count($trasporto->foto) > 0) {
            foreach ($trasporto->foto as $media) {
                if (!in_array($media->file_name, $request->input('foto', []))) {
                    $media->delete();
                }
            }
        }
        $media = $trasporto->foto->pluck('file_name')->toArray();
        foreach ($request->input('foto', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $trasporto->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('foto');
            }
        }

        return redirect()->route('admin.trasportos.index');
    }

    public function show(Trasporto $trasporto)
    {
        abort_if(Gate::denies('trasporto_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $trasporto->load('fornitore');

        return view('admin.trasportos.show', compact('trasporto'));
    }

    public function destroy(Trasporto $trasporto)
    {
        abort_if(Gate::denies('trasporto_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $trasporto->delete();

        return back();
    }

    public function massDestroy(MassDestroyTrasportoRequest $request)
    {
        Trasporto::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('trasporto_create') && Gate::denies('trasporto_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Trasporto();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
