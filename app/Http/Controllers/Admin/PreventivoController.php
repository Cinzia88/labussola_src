<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPreventivoRequest;
use App\Http\Requests\UpdatePreventivoRequest;
use App\Models\AlloggioHotel;
use App\Models\AziendeTrasporti;
use App\Models\Clienti;
use App\Models\EmailStandard;
use App\Models\Itinerari;
use App\Models\Preventivo;
use App\Models\ServizioExtra;
use App\Models\Trasporto;
use App\Models\User;
use App\Models\VocePExtraPerPersona;
use App\Models\VocePExtraUnaTantum;
use App\Models\VocePHotel;
use App\Models\VocePHotelPerNotte;
use App\Models\VocePHotelPerPersona;
use App\Models\VocePTrasportoPerPersona;
use App\Models\VocePTrasportoUnaTantum;
use App\Notifications\InvioPreventivo;
use App\Notifications\InvioFilePersonalizzato;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class PreventivoController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('preventivo_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $columnVisibilityList = [];
        if (Storage::disk('public')->exists('js/datatableColumnVisibility/customer_' . auth()->user()->id . '.json')) {
            $columnVisibilityList = json_decode(Storage::disk('public')->get('js/datatableColumnVisibility/customer_' . auth()->user()->id . '.json'));
        }

        return view('admin.preventivos.index', [
            'itineraris' => Itinerari::get(),
            'clientis' => Clienti::get(),
            'aziende_trasportis' => AziendeTrasporti::get(),
            'users' => User::all(),
            'authUserId' => auth()->user()->id ?? 0,
            'preventivosFilterCreatedByMe' => true,
            'columnVisibilityList' => $columnVisibilityList
        ]);
    }

    public function dataTable(Request $request)
    {
        abort_if(Gate::denies('preventivo_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dataToColumn = [
            'id' => 'preventivos.id',
            'oggetto' => 'preventivos.oggetto',
            'tag_id' => 'preventivos.tag_id',
            'numero' => 'preventivos.numero',
            'anno' => 'preventivos.anno',
            'status' => 'preventivos.status',
            'data_inzio_viaggio' => 'preventivos.data_inzio_viaggio',
            'data_fine_viaggio' => 'preventivos.data_fine_viaggio',
            'created_by_id' => 'preventivos.created_by_id',
            'preventivos_created_at' => 'preventivos.created_at',
            'preventivos_updated_at' => 'preventivos.updated_at',
            'preventivos_deleted_at' => 'preventivos.deleted_at',
            'numero_persone' => 'preventivos.numero_persone',
            'markup' => 'preventivos.markup',
            'cliente_nome' => 'clientis.nome',
            'cliente_cognome' => 'clientis.cognome',
            'cliente_ragione_sociale' => 'clientis.ragione_sociale',
            'cliente_email' => 'clientis.email',
            'itinerario' => 'itineraris.mome',
        ];

        $preventivoQuery = DB::table('preventivos')
            ->select(
                'preventivos.id',
                'preventivos.oggetto',
                'preventivos.tag_id',
                'preventivos.numero',
                'preventivos.anno',
                'preventivos.status',
                'preventivos.data_inzio_viaggio',
                'preventivos.data_fine_viaggio',
                'preventivos.created_by_id',
                'preventivos.created_at as preventivos_created_at',
                'preventivos.numero_persone',
                'preventivos.markup',
                'clientis.nome as cliente_nome',
                'clientis.cognome as cliente_cognome',
                'clientis.ragione_sociale as cliente_ragione_sociale',
                'clientis.email as cliente_email',
                'itineraris.nome as itinerario_nome',
                'users.name as created_by_name'
            )
            ->leftJoin('clientis', 'preventivos.cliente_id', '=', 'clientis.id')
            ->leftJoin('itineraris', 'preventivos.itinerario_id', '=', 'itineraris.id')
            ->leftJoin('users', 'preventivos.created_by_id', '=', 'users.id');

        // ordinamento predefinito
        $columnToOrder = 'preventivos.id';
        $dir = 'desc';

        // recupero le colonne dalle tabelle preventivos e clientis
        $preventivosColumn = Schema::getColumnListing("preventivos");
        $clientesColumn = Schema::getColumnListing('clientis');
        $columnNameWithSearchEqualTo = [
            'numero' => 'numero',
            'anno' => 'anno',
            'tag_id' => 'tag_id',
            'numero_persone' => 'numero_persone',
            'created_by_id' => 'created_by_id',
            'data_inizio_viaggio' => 'data_inzio_viaggio',
            'data_fine_viaggio' => 'data_fine_viaggio'
        ];
        $aggregatedColumn = ['cliente', 'itinerario'];

        // ordinamento per colonna
        foreach ($request->order as $order) {
            if ($order['column'] !== "0") {
                if (in_array($order['column'], $preventivosColumn)) {
                    $columnToOrder = "preventivos" . $order['column'];
                    $dir = $order['dir'];
                }
                break;
            }
        }

        // campo di ricerca generale
        if (! empty($request->search['value']) && strlen($request->search['value']) > 3) {

            $preventivoIdListSearch = $clienteIdListSearch = [];

            $allTablePreventivo = Preventivo::freeSearchInAllTable($request->search['value']);
            foreach ($allTablePreventivo as $preventivo) {
                $preventivoIdListSearch[] = $preventivo->id;
            }

            $allTableCliente = Clienti::freeSearchInAllTable($request->search['value']);
            foreach ($allTableCliente as $cliente) {
                $clienteIdListSearch[] = $cliente->id;
            }

            if (! empty($preventivoIdListSearch)) {
                $preventivoQuery->whereIn('preventivos.id', $preventivoIdListSearch);
            }

            if (! empty($clienteIdListSearch) && ! empty($preventivoIdListSearch)) {
                $preventivoQuery->orWhereIn('preventivos.cliente_id', $clienteIdListSearch);
            } elseif (! empty($clienteIdListSearch)) {
                $preventivoQuery->whereIn('preventivos.cliente_id', $clienteIdListSearch);
            }
        } else {

            // filtri di ricerca specifici per colonna
            foreach ($request->columns as $columnRow) {

                if ($columnRow['data'] === 'action') {
                    continue;
                }

                if (empty($columnRow['search']['value'])) {
                    continue;
                }

                $searchColumnName = $columnRow['data'];
                $searchColumnValue = $columnRow['search']['value'];

                // se fa parte di una colonna con select
                if (in_array($searchColumnName, array_keys($columnNameWithSearchEqualTo))) {

                    if (in_array($searchColumnName, array_keys($dataToColumn))) {
                        $searchColumnName = $dataToColumn[$searchColumnName];
                    }

                    $columnNameKey = array_search($searchColumnName, array_keys($columnNameWithSearchEqualTo));

                    $preventivoQuery->where(
                        $columnNameKey ? array_values($columnNameWithSearchEqualTo)[$columnNameKey] : $searchColumnName,
                        '=',
                        $searchColumnValue
                    );

                    // se è una colonna aggregata
                } elseif (in_array($searchColumnName, $aggregatedColumn)) {

                    switch ($searchColumnName) {
                        case 'cliente':

                            $preventivoQuery->where('clientis.nome', 'like', "%" . $searchColumnValue . "%");
                            $preventivoQuery->orWhere('clientis.cognome', 'like', "%" . $searchColumnValue . "%");
                            $preventivoQuery->orWhere('clientis.ragione_sociale', 'like', "%" . $searchColumnValue . "%");

                            break;
                        case 'itinerario':

                            $preventivoQuery->where('itineraris.nome', 'like', "%" . $searchColumnValue . "%");
                            break;
                    }

                    // se fa parte delle colonne della tabella preventivos
                } elseif (in_array($searchColumnName, $preventivosColumn)) {

                    $preventivoQuery->where("preventivos.$searchColumnName", 'like', "%" . $searchColumnValue . "%");

                    // se fa parte delle colonne della tabella clientis
                } elseif (in_array($columnRow['data'], $clientesColumn)) {

                    $preventivoQuery->where("clientis.$searchColumnName", 'like', "%" . $searchColumnValue . "%");
                }
            }
        }

        $preventivoList = $preventivoQuery->clone();
        $preventivoList->orderBy($columnToOrder, $dir)
            ->offset($request->start)
            ->limit($request->length);

        $response = new \stdClass();
        $response->data = [];

        $countResult = 0;
        foreach ($preventivoList->get() as $preventivo) {
            $cliente = $preventivo->cliente_nome ?? '';
            $cliente .= " ";
            $cliente .= $preventivo->cliente_cognome ?? '';

            $response->data[] = [
                'action' => view('partials.adminHomedatatablesActions', [
                    'viewGate' => 'preventivo_show',
                    'editGate' => 'preventivo_edit',
                    'deleteGate' => 'preventivo_delete',
                    'crudRoutePart' => 'preventivos',
                    'row' => $preventivo
                ])->render(),
                'created_by_id' => $preventivo->created_by_name ?? '',
                'created_at' => Carbon::parse($preventivo->preventivos_created_at)->format('d/m/Y'),
                'status' => Preventivo::STATUS_SELECT[$preventivo->status] ?? '',
                'data_inizio_viaggio' => Carbon::parse($preventivo->data_inzio_viaggio)->format('d/m/Y'),
                'data_fine_viaggio' => Carbon::parse($preventivo->data_fine_viaggio)->format('d/m/Y'),
                'numero' => $preventivo->numero ?? '',
                'anno' => $preventivo->anno ?? '',
                'itinerario' => $preventivo->itinerario_nome ?? '',
                'oggetto' => $preventivo->oggetto ?? '',
                'tag_id' => $preventivo->tag_id ?? '',
                'numero_persone' => $preventivo->numero_persone,
                'cliente' => $cliente,
                'email' => $preventivo->cliente_email ?? '',
                'markup' => $preventivo->markup ?? '',
                'ragione_sociale' => $preventivo->cliente_ragione_sociale ?? ''
            ];
            $countResult++;
        }

        $response->draw = $request->draw;
        $response->recordsTotal = $preventivoQuery->count();
        $response->recordsFiltered = $preventivoQuery->count();

        return \response()->json($response);
    }

    public function columnVisibility(Request $request)
    {

        $validate = $request->validate([
            'customerId' => 'required|exists:users,id',
            'columnVisiblityList' => 'required'
        ]);

        Storage::disk('public')->put('js/datatableColumnVisibility/customer_' . $request->customerId . '.json', json_encode($request->columnVisiblityList));
    }

    public function create()
    {
        abort_if(Gate::denies('preventivo_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $itinerarios = Itinerari::pluck('nome', 'id')->prepend(trans('global.pleaseSelect'), '');

        $clientes = Clienti::all();

        $clientes = $clientes->pluck('nome_completo', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $hotels = AlloggioHotel::pluck('nome', 'id')->prepend(trans('global.pleaseSelect'), '');

        $trasportos = Trasporto::pluck('nome', 'id')->prepend(trans('global.pleaseSelect'), '');

        $servizio_extras = ServizioExtra::pluck('nome', 'id')->prepend(trans('global.pleaseSelect'), '');

        $andata_azienda_trasportos = AziendeTrasporti::pluck('nome', 'id')->prepend(trans('global.pleaseSelect'), '');

        $ritorno_azienda_trasportos = AziendeTrasporti::pluck('nome', 'id')->prepend(trans('global.pleaseSelect'), '');

        $emails = EmailStandard::all();

        return view('admin.preventivos.create', compact('emails', 'clientes', 'created_bies', 'itinerarios', 'hotels', 'trasportos', 'servizio_extras', 'andata_azienda_trasportos', 'ritorno_azienda_trasportos'));
    }


    public function inviaPreventivo(Request $request)
    {
        $preventivo = Preventivo::where('id', $request->id)->first();
        abort_if(!$preventivo, Response::HTTP_NOT_FOUND, '404 Non esistente');


        Notification::route('mail', $preventivo->cliente->email)->notify(new InvioPreventivo($preventivo));

        if ($preventivo->status = 'in_attesa') {
            $preventivo->status = 'inviato';
            $preventivo->save();
        }


        return redirect()->route('admin.preventivos.show', ['preventivo' => $preventivo->id]);
    }

    public function inviaFilePersonalizzato(Request $request)
    {
        $preventivo = Preventivo::where('id', $request->id)->first();
        abort_if(!$preventivo, Response::HTTP_NOT_FOUND, '404 Non esistente');


        Notification::route('mail', $preventivo->cliente->email)->notify(new InvioFilePersonalizzato($preventivo));

        if ($preventivo->status = 'in_attesa') {
            $preventivo->status = 'inviato';
            $preventivo->save();
        }


        return redirect()->route('admin.preventivos.show', ['preventivo' => $preventivo->id]);
    }

    public function store(Request $request)
    {
        $request->merge([
            'status' => 'in_attesa',
            'guid' => (string)Str::uuid(),
            'viewkey' => (string)Str::uuid(),
        ]);

        $preventivo = Preventivo::create($request->all());

        //HOTELS
        $hotels = $request->repeaterhotel;

        if (isset($hotels)) {
            foreach ($hotels as $hotel) {
                $hotelCrud = VocePHotel::create([
                    'hotel_id' => $hotel['hotel_id'],
                    'info_aggiuntive' =>  $hotel['info_aggiuntive'],
                    'preventivo_id' => $preventivo->id
                ]);

                if (isset($hotel["repeater_stanza_costo_a_persona"])) {
                    foreach ($hotel["repeater_stanza_costo_a_persona"] as $stanza) {
                        $scorpora =  null;
                        if ($stanza['scorpora']) $scorpora = 1;

                        $stanzacreata = VocePHotelPerPersona::create([
                            'voce_hotel_id' => $hotelCrud->id,
                            'numero_stanze' => $stanza['numero_stanze'],
                            'costo_a_notte' => $stanza['costo_a_notte'],
                            'tipologia_stanza' => $stanza['tipologia_stanza'],
                            'scorpora' =>  $scorpora,
                        ]);
                    }
                }

                if (isset($hotel["repeater_stanza_costo_a_notte"])) {
                    foreach ($hotel["repeater_stanza_costo_a_notte"] as $stanza) {
                        $scorpora =  null;
                        if ($stanza['scorpora']) $scorpora = 1;

                        $stanzacreata = VocePHotelPerNotte::create([
                            'voce_hotel_id' => $hotelCrud->id,
                            'numero_stanze' => $stanza['numero_stanze'],
                            'costo_a_notte' => $stanza['costo_a_notte'],
                            'tipologia_stanza' => $stanza['tipologia_stanza'],
                            'scorpora' => $scorpora,
                        ]);
                    }
                }
            }
        }

        //TRASPORTO PRINCIPALE ANDATA
        $trasporto_princiapale_andata = $request->trasportoprincipaleandata;
        if ($trasporto_princiapale_andata['trasporto_id'] && $trasporto_princiapale_andata['prezzo']) {
            if ($trasporto_princiapale_andata['tipologia'] == 'persona') {
                $voce = VocePTrasportoPerPersona::create([
                    'preventivo_id' => $preventivo->id,
                    'trasporto_id' => $trasporto_princiapale_andata['trasporto_id'],
                    'tipologia_trasporto' => 'principale',
                    'prezzo' => $trasporto_princiapale_andata['prezzo'],
                    'scorpora' => $trasporto_princiapale_andata['scorpora'],
                    'tipologia' => 'andata',
                ]);
            } else {
                $voce = VocePTrasportoUnaTantum::create([
                    'preventivo_id' => $preventivo->id,
                    'trasporto_id' => $trasporto_princiapale_andata['trasporto_id'],
                    'tipologia_trasporto' => 'principale',
                    'prezzo' => $trasporto_princiapale_andata['prezzo'],
                    'scorpora' => $trasporto_princiapale_andata['scorpora'],
                    'tipologia' => 'andata',
                ]);
            }
        }

        //TRASPORTO PRINCIPALE RIENTRO
        $trasporto_princiapale_rientro = $request->trasportoprincipalerientro;
        if ($trasporto_princiapale_rientro['trasporto_id'] && $trasporto_princiapale_rientro['prezzo']) {
            if ($trasporto_princiapale_rientro['tipologia'] == 'persona') {
                VocePTrasportoPerPersona::create([
                    'preventivo_id' => $preventivo->id,
                    'trasporto_id' => $trasporto_princiapale_rientro['trasporto_id'],
                    'tipologia_trasporto' => 'principale',
                    'tipologia' => 'ritorno',
                    'prezzo' => $trasporto_princiapale_rientro['prezzo'],
                    'scorpora' => $trasporto_princiapale_rientro['scorpora'],
                ]);
            } else {
                VocePTrasportoUnaTantum::create([
                    'preventivo_id' => $preventivo->id,
                    'trasporto_id' => $trasporto_princiapale_rientro['trasporto_id'],
                    'tipologia_trasporto' => 'principale',
                    'tipologia' => 'ritorno',
                    'prezzo' => $trasporto_princiapale_rientro['prezzo'],
                    'scorpora' => $trasporto_princiapale_rientro['scorpora'],
                ]);
            }
        }

        // TRASPORTI UNATANTUM
        $trasporti_perpersona = $request->repeater_trasporto_costo_a_persona;
        if (isset($trasporti_perpersona)) {
            foreach ($trasporti_perpersona as $trasporto) {
                $scorpora =  null;
                if ($trasporto['scorpora']) $scorpora = 1;


                VocePTrasportoPerPersona::create([
                    'preventivo_id' => $preventivo->id,
                    'trasporto_id' => $trasporto['trasporto_id'],
                    'tipologia_trasporto' => 'trasporti',
                    'prezzo' => $trasporto['prezzo'],
                    'scorpora' => $scorpora,
                    'tipologia' => 'non_specifico',
                    'informazioni_aggiuntive' => $trasporto['informazioni_aggiuntive'],
                ]);
            }
        }

        // TRASPORTI UNATANTUM
        $trasporti_unatantum = $request->repeater_trasporto_costo_una_tantum;
        if (isset($trasporti_unatantum)) {
            foreach ($trasporti_unatantum as $trasporto) {
                $scorpora =  null;
                if ($trasporto['scorpora']) $scorpora = 1;


                VocePTrasportoUnaTantum::create([
                    'preventivo_id' => $preventivo->id,
                    'trasporto_id' => $trasporto['trasporto_id'],
                    'prezzo' => $trasporto['prezzo'],
                    'tipologia_trasporto' => 'trasporti',
                    'scorpora' =>  $scorpora,
                    'tipologia' => 'non_specifico',
                    'informazioni_aggiuntive' => $trasporto['informazioni_aggiuntive'],
                ]);
            }
        }


        // TRASPORTI UNATANTUM
        $serviziextra_perpersona = $request->repeater_serviziextra_costo_a_persona;
        if (isset($serviziextra_perpersona)) {
            foreach ($serviziextra_perpersona as $extra) {
                $scorpora =  null;
                if ($extra['scorpora']) $scorpora = 1;


                VocePExtraPerPersona::create([
                    'preventivo_id' => $preventivo->id,
                    'servizio_extra_id' => $extra['servizio_extra_id'],
                    'prezzo' => $extra['prezzo'],
                    'scorpora' => $scorpora,
                    'quantita' => $extra['quantita'],
                    'info_aggiuntive' => $extra['informazioni_aggiuntive'],
                    'quota_comprende'  => $extra['quota_comprende'],
                ]);
            }
        }


        // TRASPORTI UNATANTUM
        $serviziextra_unatantum = $request->repeater_serviziextra_costo_una_tantum;
        if (isset($serviziextra_unatantum)) {
            foreach ($serviziextra_unatantum as $extra) {
                $scorpora =  null;
                if ($extra['scorpora']) $scorpora = 1;

                VocePExtraUnaTantum::create([
                    'preventivo_id' => $preventivo->id,
                    'servizio_extra_id' => $extra['servizio_extra_id'],
                    'prezzo' => $extra['prezzo'],
                    'scorpora' => $scorpora,
                    'quantita' => $extra['quantita'],
                    'info_aggiuntive' => $extra['informazioni_aggiuntive'],
                    'quota_comprende'  => $extra['quota_comprende'],
                ]);
            }
        }

        foreach ($request->input('file_fornitore_trasporto', []) as $file) {
            $preventivo->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('file_fornitore_trasporto');
        }

        foreach ($request->input('file_fornitore_servizi_extra', []) as $file) {
            $preventivo->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('file_fornitore_servizi_extra');
        }

        foreach ($request->input('file_fornitore_hotel', []) as $file) {
            $preventivo->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('file_fornitore_hotel');
        }

        foreach ($request->input('files_pratica', []) as $file) {
            $preventivo->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('files_pratica');
        }

        foreach ($request->input('file_personalizzato', []) as $file) {
            $preventivo->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('file_personalizzato');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $preventivo->id]);
        }


        return redirect()->route('admin.preventivos.show', $preventivo->id);
    }

    public function edit(Preventivo $preventivo)
    {
        abort_if(Gate::denies('preventivo_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');


        $itinerarios = Itinerari::pluck('nome', 'id')->prepend(trans('global.pleaseSelect'), '');

        $clientes = Clienti::all();

        $clientes = $clientes->pluck('nome_completo', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $hotels = AlloggioHotel::pluck('nome', 'id')->prepend(trans('global.pleaseSelect'), '');

        $trasportos = Trasporto::pluck('nome', 'id')->prepend(trans('global.pleaseSelect'), '');

        $servizio_extras = ServizioExtra::pluck('nome', 'id')->prepend(trans('global.pleaseSelect'), '');

        $andata_azienda_trasportos = AziendeTrasporti::pluck('nome', 'id')->prepend(trans('global.pleaseSelect'), '');

        $ritorno_azienda_trasportos = AziendeTrasporti::pluck('nome', 'id')->prepend(trans('global.pleaseSelect'), '');

        $emails = EmailStandard::all();

        $preventivo->load('itinerario', 'cliente', 'andata_azienda_trasporto', 'ritorno_azienda_trasporto', 'created_by');

        return view('admin.preventivos.edit', compact('preventivo', 'emails', 'clientes', 'created_bies', 'itinerarios', 'hotels', 'trasportos', 'servizio_extras', 'andata_azienda_trasportos', 'ritorno_azienda_trasportos'));
    }

    public function update(UpdatePreventivoRequest $request, Preventivo $preventivo)
    {
        $preventivo->update($request->all());

        if (count($preventivo->file_fornitore_trasporto) > 0) {
            foreach ($preventivo->file_fornitore_trasporto as $media) {
                if (!in_array($media->file_name, $request->input('file_fornitore_trasporto', []))) {
                    $media->delete();
                }
            }
        }
        $media = $preventivo->file_fornitore_trasporto->pluck('file_name')->toArray();
        foreach ($request->input('file_fornitore_trasporto', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $preventivo->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('file_fornitore_trasporto');
            }
        }
        if (count($preventivo->file_fornitore_servizi_extra) > 0) {
            foreach ($preventivo->file_fornitore_servizi_extra as $media) {
                if (!in_array($media->file_name, $request->input('file_fornitore_servizi_extra', []))) {
                    $media->delete();
                }
            }
        }
        $media = $preventivo->file_fornitore_servizi_extra->pluck('file_name')->toArray();
        foreach ($request->input('file_fornitore_servizi_extra', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $preventivo->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('file_fornitore_servizi_extra');
            }
        }

        if (count($preventivo->file_fornitore_hotel) > 0) {
            foreach ($preventivo->file_fornitore_hotel as $media) {
                if (!in_array($media->file_name, $request->input('file_fornitore_hotel', []))) {
                    $media->delete();
                }
            }
        }
        $media = $preventivo->file_fornitore_hotel->pluck('file_name')->toArray();
        foreach ($request->input('file_fornitore_hotel', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $preventivo->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('file_fornitore_hotel');
            }
        }

        if (count($preventivo->files_pratica) > 0) {
            foreach ($preventivo->files_pratica as $media) {
                if (!in_array($media->file_name, $request->input('files_pratica', []))) {
                    $media->delete();
                }
            }
        }
        $media = $preventivo->files_pratica->pluck('file_name')->toArray();
        foreach ($request->input('files_pratica', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $preventivo->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('files_pratica');
            }
        }

        $media = $preventivo->file_personalizzato->pluck('file_name')->toArray();
        foreach ($request->input('file_personalizzato', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $preventivo->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('file_personalizzato');
            }
        }


        $vociHotel = VocePHotel::where('preventivo_id', $preventivo->id)->get();
        foreach ($vociHotel as $voceHotel) {
            $voci = VocePHotelPerPersona::whereIn('voce_hotel_id', [$voceHotel->id])->get();
            foreach ($voci as $voce) $voce->delete();
            $voci = VocePHotelPerNotte::whereIn('voce_hotel_id', [$voceHotel->id])->get();
            foreach ($voci as $voce) $voce->delete();
        }
        foreach ($vociHotel as $voce) $voce->delete();
        $voci = VocePTrasportoUnaTantum::whereIn('preventivo_id', [$preventivo->id])->get();
        foreach ($voci as $voce) $voce->delete();
        $voci = VocePTrasportoPerPersona::whereIn('preventivo_id', [$preventivo->id])->get();
        foreach ($voci as $voce) $voce->delete();
        $voci = VocePExtraUnaTantum::whereIn('preventivo_id', [$preventivo->id])->get();
        foreach ($voci as $voce) $voce->delete();
        $voci = VocePExtraPerPersona::whereIn('preventivo_id', [$preventivo->id])->get();
        foreach ($voci as $voce) $voce->delete();


        //HOTELS
        $hotels = $request->repeaterhotel;

        if (isset($hotels)) {
            foreach ($hotels as $hotel) {
                $hotelCrud = VocePHotel::create([
                    'hotel_id' => $hotel['hotel_id'],
                    'info_aggiuntive' =>  $hotel['info_aggiuntive'],
                    'preventivo_id' => $preventivo->id
                ]);

                if (isset($hotel["repeater_stanza_costo_a_persona"])) {
                    foreach ($hotel["repeater_stanza_costo_a_persona"] as $stanza) {
                        $scorpora =  null;
                        if ($stanza['scorpora']) $scorpora = 1;

                        $stanzacreata = VocePHotelPerPersona::create([
                            'voce_hotel_id' => $hotelCrud->id,
                            'numero_stanze' => $stanza['numero_stanze'],
                            'costo_a_notte' => $stanza['costo_a_notte'],
                            'tipologia_stanza' => $stanza['tipologia_stanza'],
                            'scorpora' =>  $scorpora,
                        ]);
                    }
                }

                if (isset($hotel["repeater_stanza_costo_a_notte"])) {
                    foreach ($hotel["repeater_stanza_costo_a_notte"] as $stanza) {
                        $scorpora =  null;
                        if ($stanza['scorpora']) $scorpora = 1;

                        $stanzacreata = VocePHotelPerNotte::create([
                            'voce_hotel_id' => $hotelCrud->id,
                            'numero_stanze' => $stanza['numero_stanze'],
                            'costo_a_notte' => $stanza['costo_a_notte'],
                            'tipologia_stanza' => $stanza['tipologia_stanza'],
                            'scorpora' => $scorpora,
                        ]);
                    }
                }
            }
        }

        //TRASPORTO PRINCIPALE ANDATA
        $trasporto_princiapale_andata = $request->trasportoprincipaleandata;
        if ($trasporto_princiapale_andata['trasporto_id'] && $trasporto_princiapale_andata['prezzo']) {
            if ($trasporto_princiapale_andata['tipologia'] == 'persona') {
                $voce = VocePTrasportoPerPersona::create([
                    'preventivo_id' => $preventivo->id,
                    'trasporto_id' => $trasporto_princiapale_andata['trasporto_id'],
                    'tipologia_trasporto' => 'principale',
                    'prezzo' => $trasporto_princiapale_andata['prezzo'],
                    'scorpora' => $trasporto_princiapale_andata['scorpora'],
                    'tipologia' => 'andata',
                ]);
            } else {
                $voce = VocePTrasportoUnaTantum::create([
                    'preventivo_id' => $preventivo->id,
                    'trasporto_id' => $trasporto_princiapale_andata['trasporto_id'],
                    'tipologia_trasporto' => 'principale',
                    'prezzo' => $trasporto_princiapale_andata['prezzo'],
                    'scorpora' => $trasporto_princiapale_andata['scorpora'],
                    'tipologia' => 'andata',
                ]);
            }
        }

        //TRASPORTO PRINCIPALE RIENTRO
        $trasporto_princiapale_rientro = $request->trasportoprincipalerientro;
        if ($trasporto_princiapale_rientro['trasporto_id'] && $trasporto_princiapale_rientro['prezzo']) {
            if ($trasporto_princiapale_rientro['tipologia'] == 'persona') {
                VocePTrasportoPerPersona::create([
                    'preventivo_id' => $preventivo->id,
                    'trasporto_id' => $trasporto_princiapale_rientro['trasporto_id'],
                    'tipologia_trasporto' => 'principale',
                    'tipologia' => 'ritorno',
                    'prezzo' => $trasporto_princiapale_rientro['prezzo'],
                    'scorpora' => $trasporto_princiapale_rientro['scorpora'],
                ]);
            } else {
                VocePTrasportoUnaTantum::create([
                    'preventivo_id' => $preventivo->id,
                    'trasporto_id' => $trasporto_princiapale_rientro['trasporto_id'],
                    'tipologia_trasporto' => 'principale',
                    'tipologia' => 'ritorno',
                    'prezzo' => $trasporto_princiapale_rientro['prezzo'],
                    'scorpora' => $trasporto_princiapale_rientro['scorpora'],
                ]);
            }
        }

        // TRASPORTI UNATANTUM
        $trasporti_perpersona = $request->repeater_trasporto_costo_a_persona;
        if (isset($trasporti_perpersona)) {
            foreach ($trasporti_perpersona as $trasporto) {
                $scorpora =  null;
                if ($trasporto['scorpora']) $scorpora = 1;


                VocePTrasportoPerPersona::create([
                    'preventivo_id' => $preventivo->id,
                    'trasporto_id' => $trasporto['trasporto_id'],
                    'tipologia_trasporto' => 'trasporti',
                    'prezzo' => $trasporto['prezzo'],
                    'scorpora' => $scorpora,
                    'tipologia' => 'non_specifico',
                    'informazioni_aggiuntive' => $trasporto['informazioni_aggiuntive'],
                ]);
            }
        }

        // TRASPORTI UNATANTUM
        $trasporti_unatantum = $request->repeater_trasporto_costo_una_tantum;
        if (isset($trasporti_unatantum)) {
            foreach ($trasporti_unatantum as $trasporto) {
                $scorpora =  null;
                if ($trasporto['scorpora']) $scorpora = 1;


                VocePTrasportoUnaTantum::create([
                    'preventivo_id' => $preventivo->id,
                    'trasporto_id' => $trasporto['trasporto_id'],
                    'prezzo' => $trasporto['prezzo'],
                    'tipologia_trasporto' => 'trasporti',
                    'scorpora' =>  $scorpora,
                    'tipologia' => 'non_specifico',
                    'informazioni_aggiuntive' => $trasporto['informazioni_aggiuntive'],
                ]);
            }
        }


        // TRASPORTI UNATANTUM
        $serviziextra_perpersona = $request->repeater_serviziextra_costo_a_persona;
        if (isset($serviziextra_perpersona)) {
            foreach ($serviziextra_perpersona as $extra) {
                $scorpora =  null;
                if ($extra['scorpora']) $scorpora = 1;


                VocePExtraPerPersona::create([
                    'preventivo_id' => $preventivo->id,
                    'servizio_extra_id' => $extra['servizio_extra_id'],
                    'prezzo' => $extra['prezzo'],
                    'scorpora' => $scorpora,
                    'quantita' => $extra['quantita'],
                    'info_aggiuntive' => $extra['informazioni_aggiuntive'],
                    'quota_comprende'  => $extra['quota_comprende'],
                ]);
            }
        }


        // TRASPORTI UNATANTUM
        $serviziextra_unatantum = $request->repeater_serviziextra_costo_una_tantum;
        if (isset($serviziextra_unatantum)) {
            foreach ($serviziextra_unatantum as $extra) {
                $scorpora =  null;
                if ($extra['scorpora']) $scorpora = 1;

                VocePExtraUnaTantum::create([
                    'preventivo_id' => $preventivo->id,
                    'servizio_extra_id' => $extra['servizio_extra_id'],
                    'prezzo' => $extra['prezzo'],
                    'scorpora' => $scorpora,
                    'quantita' => $extra['quantita'],
                    'info_aggiuntive' => $extra['informazioni_aggiuntive'],
                    'quota_comprende'  => $extra['quota_comprende'],
                ]);
            }
        }



        return redirect()->route('admin.preventivos.show', $preventivo->id);
    }

    public function duplicaPreventivo(Request $request)
    {
        $preventivoOriginale = Preventivo::withoutGlobalScope('created_by_id')->where('id', $request->id)->first();

        $preventivoDuplicato = Preventivo::create([
            'oggetto' => $preventivoOriginale->oggetto,
            'itinerario_id' => $preventivoOriginale->itinerario_id,
            'cliente_id' => $preventivoOriginale->cliente_id,
            'numero_persone' => $preventivoOriginale->numero_persone,
            'prezzo_per_persona' => $preventivoOriginale->prezzo_per_persona,
            'data_inzio_viaggio' => $preventivoOriginale->data_inzio_viaggio,
            'data_fine_viaggio' => $preventivoOriginale->data_fine_viaggio,
            'date_indicative' => $preventivoOriginale->date_indicative,
            'informazioni_aggiuntive' => $preventivoOriginale->informazioni_aggiuntive,
            'luogo_di_partenza_andata' => $preventivoOriginale->luogo_di_partenza_andata,
            'luogo_di_arrivo_andata' => $preventivoOriginale->luogo_di_arrivo_andata,
            'data_ora_partenza_andata' => $preventivoOriginale->data_ora_partenza_andata,
            'data_ora_rientro_andata' => $preventivoOriginale->data_ora_rientro_andata,
            'luogo_di_partenza_rientro' => $preventivoOriginale->luogo_di_partenza_rientro,
            'luogo_di_arrivo_rientro' => $preventivoOriginale->luogo_di_arrivo_rientro,
            'data_ora_partenza_rientro' => $preventivoOriginale->data_ora_partenza_rientro,
            'data_ora_rientro_rientro' => $preventivoOriginale->data_ora_rientro_rientro,
            'numero_gratuita' => $preventivoOriginale->numero_gratuita,
            'markup' => $preventivoOriginale->markup,
            'kg_bg_a_mano_andata' => $preventivoOriginale->kg_bg_a_mano_andata,
            'kg_bg_a_mano_ritorno' => $preventivoOriginale->kg_bg_a_mano_ritorno,
            'kg_bg_in_stiva_andata' => $preventivoOriginale->kg_bg_in_stiva_andata,
            'kg_bg_in_stiva_ritorno' => $preventivoOriginale->kg_bg_in_stiva_ritorno,
            'andata_azienda_trasporto_id' => $preventivoOriginale->andata_azienda_trasporto_id,
            'ritorno_azienda_trasporto_id' => $preventivoOriginale->ritorno_azienda_trasporto_id,
            'corpo_email' => $preventivoOriginale->corpo_email,
            'created_by_id' => auth()->user()->id,
            'status' => 'in_attesa',
            'guid' => (string)Str::uuid(),
            'viewkey' => (string)Str::uuid(),
        ]);


        $vociHotel = VocePHotel::where('preventivo_id', $preventivoOriginale->id)->get();
        foreach ($vociHotel as $voceHotel) {
            $voceHotelNuova = VocePhotel::create([
                'info_aggiuntive' => $voceHotel->info_aggiuntive,
                'hotel_id' => $voceHotel->hotel_id,
                'preventivo_id' => $preventivoDuplicato->id,
            ]);


            $voci = VocePHotelPerPersona::whereIn('voce_hotel_id', [$voceHotel->id])->get();
            foreach ($voci as $voce) {
                VocePHotelPerPersona::create([
                    'tipologia_stanza' => $voce->tipologia_stanza,
                    'numero_stanze' => $voce->numero_stanze,
                    'costo_a_notte' => $voce->costo_a_notte,
                    'scorpora' => $voce->scorpora,
                    'voce_hotel_id' => $voceHotelNuova->id,
                ]);
            }

            $voci = VocePHotelPerNotte::whereIn('voce_hotel_id', [$voceHotel->id])->get();
            foreach ($voci as $voce) {
                VocePHotelPerNotte::create([
                    'tipologia_stanza' => $voce->tipologia_stanza,
                    'numero_stanze' => $voce->numero_stanze,
                    'costo_a_notte' => $voce->costo_a_notte,
                    'scorpora' => $voce->scorpora,
                    'voce_hotel_id' => $voceHotelNuova->id,
                ]);
            }
        }
        foreach ($voci as $voce) {
        }

        $voci = VocePTrasportoUnaTantum::whereIn('preventivo_id', [$preventivoOriginale->id])->get();
        foreach ($voci as $voce) {
            VocePTrasportoUnaTantum::create([
                'tipologia_trasporto' => $voce->tipologia_trasporto,
                'scorpora' => $voce->scorpora,
                'trasporto_id' => $voce->trasporto_id,
                'prezzo' => $voce->prezzo,
                'informazioni_aggiuntive' => $voce->informazioni_aggiuntive,
                'tipologia' => $voce->tipologia,
                'preventivo_id' => $preventivoDuplicato->id,
            ]);
        }

        $voci = VocePTrasportoPerPersona::whereIn('preventivo_id', [$preventivoOriginale->id])->get();
        foreach ($voci as $voce) {
            VocePTrasportoPerPersona::create([
                'tipologia_trasporto' => $voce->tipologia_trasporto,
                'scorpora' => $voce->scorpora,
                'trasporto_id' => $voce->trasporto_id,
                'prezzo' => $voce->prezzo,
                'informazioni_aggiuntive' => $voce->informazioni_aggiuntive,
                'tipologia' => $voce->tipologia,
                'preventivo_id' => $preventivoDuplicato->id,
            ]);
        }

        $voci = VocePExtraUnaTantum::whereIn('preventivo_id', [$preventivoOriginale->id])->get();
        foreach ($voci as $voce) {
            VocePExtraUnaTantum::create([
                'servizio_extra_id' => $voce->servizio_extra_id,
                'prezzo' => $voce->prezzo,
                'scorpora' => $voce->scorpora,
                'info_aggiuntive' => $voce->info_aggiuntive,
                'quantita' => $voce->quantita,
                'preventivo_id' => $preventivoDuplicato->id,
            ]);
        }

        $voci = VocePExtraPerPersona::whereIn('preventivo_id', [$preventivoOriginale->id])->get();
        foreach ($voci as $voce) {
            VocePExtraPerPersona::create([
                'servizio_extra_id' => $voce->servizio_extra_id,
                'prezzo' => $voce->prezzo,
                'scorpora' => $voce->scorpora,
                'info_aggiuntive' => $voce->info_aggiuntive,
                'quantita' => $voce->quantita,
                'preventivo_id' => $preventivoDuplicato->id,
            ]);
        }

        return redirect()->route('admin.preventivos.index');
    }


    public function show(Request $request)
    {
        $preventivo = Preventivo::withoutGlobalScope('created_by_id')->where('id', $request->preventivo)->first();
        abort_if(Gate::denies('preventivo_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $preventivo->load('itinerario', 'cliente', 'created_by', 'preventivoScadenziarios');

        return view('admin.preventivos.show', compact('preventivo'));
    }

    public function destroy(Preventivo $preventivo)
    {
        abort_if(Gate::denies('preventivo_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $preventivo->delete();

        return back();
    }

    public function massDestroy(MassDestroyPreventivoRequest $request)
    {
        $preventivi = Preventivo::whereIn('id', request('ids'))->get();

        foreach ($preventivi as $preventivo) {
            $preventivo->delete();
        }
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('preventivo_create') && Gate::denies('preventivo_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Preventivo();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
