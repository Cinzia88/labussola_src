<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyAlloggioHotelRequest;
use App\Http\Requests\StoreAlloggioHotelRequest;
use App\Http\Requests\UpdateAlloggioHotelRequest;
use App\Models\AlloggioHotel;
use App\Models\Fornitore;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AlloggioHotelController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('alloggio_hotel_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = AlloggioHotel::with(['fornitore'])->select(sprintf('%s.*', (new AlloggioHotel())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'alloggio_hotel_show';
                $editGate = 'alloggio_hotel_edit';
                $deleteGate = 'alloggio_hotel_delete';
                $crudRoutePart = 'alloggio-hotels';

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
            $table->editColumn('indirizzo', function ($row) {
                return $row->indirizzo ? $row->indirizzo : '';
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
            $table->editColumn('stelle', function ($row) {
                return $row->stelle ? AlloggioHotel::STELLE_SELECT[$row->stelle] : '';
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

            $table->rawColumns(['actions', 'placeholder', 'foto', 'fornitore']);

            return $table->make(true);
        }

        $fornitores = Fornitore::get();

        return view('admin.alloggioHotels.index', compact('fornitores'));
    }

    public function create()
    {
        abort_if(Gate::denies('alloggio_hotel_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fornitores = Fornitore::pluck('nome', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.alloggioHotels.create', compact('fornitores'));
    }

    public function store(StoreAlloggioHotelRequest $request)
    {
        $alloggioHotel = AlloggioHotel::create($request->all());

        foreach ($request->input('foto', []) as $file) {
            $alloggioHotel->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('foto');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $alloggioHotel->id]);
        }

        return redirect()->route('admin.alloggio-hotels.index');
    }

    public function edit(AlloggioHotel $alloggioHotel)
    {
        abort_if(Gate::denies('alloggio_hotel_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fornitores = Fornitore::pluck('nome', 'id')->prepend(trans('global.pleaseSelect'), '');

        $alloggioHotel->load('fornitore');

        return view('admin.alloggioHotels.edit', compact('alloggioHotel', 'fornitores'));
    }

    public function update(UpdateAlloggioHotelRequest $request, AlloggioHotel $alloggioHotel)
    {
        $alloggioHotel->update($request->all());

        if (count($alloggioHotel->foto) > 0) {
            foreach ($alloggioHotel->foto as $media) {
                if (!in_array($media->file_name, $request->input('foto', []))) {
                    $media->delete();
                }
            }
        }
        $media = $alloggioHotel->foto->pluck('file_name')->toArray();
        foreach ($request->input('foto', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $alloggioHotel->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('foto');
            }
        }

        return redirect()->route('admin.alloggio-hotels.index');
    }

    public function show(AlloggioHotel $alloggioHotel)
    {
        abort_if(Gate::denies('alloggio_hotel_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $alloggioHotel->load('fornitore', 'hotelVocePHotels');

        return view('admin.alloggioHotels.show', compact('alloggioHotel'));
    }

    public function destroy(AlloggioHotel $alloggioHotel)
    {
        abort_if(Gate::denies('alloggio_hotel_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $alloggioHotel->delete();

        return back();
    }

    public function massDestroy(MassDestroyAlloggioHotelRequest $request)
    {
        AlloggioHotel::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('alloggio_hotel_create') && Gate::denies('alloggio_hotel_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new AlloggioHotel();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
