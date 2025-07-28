<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyAziendeTrasportiRequest;
use App\Http\Requests\StoreAziendeTrasportiRequest;
use App\Http\Requests\UpdateAziendeTrasportiRequest;
use App\Models\AziendeTrasporti;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AziendeTrasportiController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('aziende_trasporti_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = AziendeTrasporti::query()->select(sprintf('%s.*', (new AziendeTrasporti())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'aziende_trasporti_show';
                $editGate = 'aziende_trasporti_edit';
                $deleteGate = 'aziende_trasporti_delete';
                $crudRoutePart = 'aziende-trasportis';

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
            $table->editColumn('immagine', function ($row) {
                return $row->immagine ? '<a href="' . $row->immagine->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'immagine']);

            return $table->make(true);
        }

        return view('admin.aziendeTrasportis.index');
    }

    public function create()
    {
        abort_if(Gate::denies('aziende_trasporti_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.aziendeTrasportis.create');
    }

    public function store(StoreAziendeTrasportiRequest $request)
    {
        $aziendeTrasporti = AziendeTrasporti::create($request->all());

        if ($request->input('immagine', false)) {
            $aziendeTrasporti->addMedia(storage_path('tmp/uploads/' . basename($request->input('immagine'))))->toMediaCollection('immagine');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $aziendeTrasporti->id]);
        }

        return redirect()->route('admin.aziende-trasportis.index');
    }

    public function edit(AziendeTrasporti $aziendeTrasporti)
    {
        abort_if(Gate::denies('aziende_trasporti_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.aziendeTrasportis.edit', compact('aziendeTrasporti'));
    }

    public function update(UpdateAziendeTrasportiRequest $request, AziendeTrasporti $aziendeTrasporti)
    {
        $aziendeTrasporti->update($request->all());

        if ($request->input('immagine', false)) {
            if (!$aziendeTrasporti->immagine || $request->input('immagine') !== $aziendeTrasporti->immagine->file_name) {
                if ($aziendeTrasporti->immagine) {
                    $aziendeTrasporti->immagine->delete();
                }
                $aziendeTrasporti->addMedia(storage_path('tmp/uploads/' . basename($request->input('immagine'))))->toMediaCollection('immagine');
            }
        } elseif ($aziendeTrasporti->immagine) {
            $aziendeTrasporti->immagine->delete();
        }

        return redirect()->route('admin.aziende-trasportis.index');
    }

    public function show(AziendeTrasporti $aziendeTrasporti)
    {
        abort_if(Gate::denies('aziende_trasporti_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.aziendeTrasportis.show', compact('aziendeTrasporti'));
    }

    public function destroy(AziendeTrasporti $aziendeTrasporti)
    {
        abort_if(Gate::denies('aziende_trasporti_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $aziendeTrasporti->delete();

        return back();
    }

    public function massDestroy(MassDestroyAziendeTrasportiRequest $request)
    {
        AziendeTrasporti::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('aziende_trasporti_create') && Gate::denies('aziende_trasporti_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new AziendeTrasporti();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
