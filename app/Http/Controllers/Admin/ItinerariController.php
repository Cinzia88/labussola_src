<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyItinerariRequest;
use App\Http\Requests\StoreItinerariRequest;
use App\Http\Requests\UpdateItinerariRequest;
use App\Models\Itinerari;
use Illuminate\Support\Facades\Storage;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ItinerariController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('itinerari_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Itinerari::query()->select(sprintf('%s.*', (new Itinerari())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'itinerari_show';
                $editGate = 'itinerari_edit';
                $deleteGate = 'itinerari_delete';
                $crudRoutePart = 'itineraris';

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

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.itineraris.index');
    }

    public function create()
    {
        abort_if(Gate::denies('itinerari_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.itineraris.create');
    }

    public function store(StoreItinerariRequest $request)
    {
        $itinerari = Itinerari::create($request->all());

        if ($request->input('foto_introduttiva', false)) {
            $itinerari->addMedia(storage_path('tmp/uploads/' . basename($request->input('foto_introduttiva'))))->toMediaCollection('foto_introduttiva');
        }

        foreach ($request->input('immagini', []) as $file) {
            $itinerari->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('immagini');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $itinerari->id]);
        }

        return redirect()->route('admin.itineraris.index');
    }

    public function edit(Itinerari $itinerari)
    {
        abort_if(Gate::denies('itinerari_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.itineraris.edit', compact('itinerari'));
    }

    public function update(UpdateItinerariRequest $request, Itinerari $itinerari)
    {
        $itinerari->update($request->all());

        if ($request->input('foto_introduttiva', false)) {
            if (!$itinerari->foto_introduttiva || $request->input('foto_introduttiva') !== $itinerari->foto_introduttiva->file_name) {
                if ($itinerari->foto_introduttiva) {
                    $itinerari->foto_introduttiva->delete();
                }
                $itinerari->addMedia(storage_path('tmp/uploads/' . basename($request->input('foto_introduttiva'))))->toMediaCollection('foto_introduttiva');
            }
        } elseif ($itinerari->foto_introduttiva) {
            $itinerari->foto_introduttiva->delete();
        }

        if (count($itinerari->immagini) > 0) {
            foreach ($itinerari->immagini as $media) {
                if (!in_array($media->file_name, $request->input('immagini', []))) {
                    $media->delete();
                }
            }
        }
        $media = $itinerari->immagini->pluck('file_name')->toArray();
        foreach ($request->input('immagini', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $itinerari->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('immagini');
            }
        }

        return redirect()->route('admin.itineraris.index');
    }

    public function show(Itinerari $itinerari)
    {
        abort_if(Gate::denies('itinerari_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.itineraris.show', compact('itinerari'));
    }

    public function destroy(Itinerari $itinerari)
    {
        abort_if(Gate::denies('itinerari_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $itinerari->delete();

        return back();
    }

    public function massDestroy(MassDestroyItinerariRequest $request)
    {
        Itinerari::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('itinerari_create') && Gate::denies('itinerari_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Itinerari();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function duplica(Request $request)
    {
        $itinerarioOriginale = Itinerari::withoutGlobalScope('created_by_id')->where('id', $request->id)->first();

        $itinerarioDuplicato = Itinerari::create([
            'nome' => $itinerarioOriginale->nome,
            'descrizione' => $itinerarioOriginale->descrizione,
        ]);

        if ($itinerarioOriginale->foto_introduttiva) {
            $origDir = array_slice( explode('/', $itinerarioOriginale->foto_introduttiva->getUrl()), -2, 1)[0];
            $origFile = array_slice( explode('/', $itinerarioOriginale->foto_introduttiva->getUrl()), -1, 1)[0];
            $copyFile = pathinfo($origFile)['filename'] . '2.' . pathinfo($origFile)['extension'];
            $origPath = 'public/'.$origDir.'/'.$origFile;
            $copyPath = 'public/'.$origDir.'/'.$copyFile;

            Storage::copy($origPath,$copyPath);
            $itinerarioDuplicato->addMedia(storage_path('app/'.$copyPath))->toMediaCollection('foto_introduttiva');
        }

        foreach ($itinerarioOriginale->immagini as $media) {
            $origDir = array_slice( explode('/', $media->getUrl()), -2, 1)[0];
            $origFile = array_slice( explode('/', $media->getUrl()), -1, 1)[0];
            $copyFile = pathinfo($origFile)['filename'] . '2.' . pathinfo($origFile)['extension'];
            $origPath = 'public/'.$origDir.'/'.$origFile;
	    $copyPath = 'public/'.$origDir.'/'.$copyFile;
	    Storage::copy($origPath,$copyPath);
            $itinerarioDuplicato->addMedia(storage_path('app/'.$copyPath))->toMediaCollection('immagini');
	}

        return redirect()->route('admin.itineraris.index');
    }
}
