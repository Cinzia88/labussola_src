<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use App\Traits\MultiTenantModelTrait;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Preventivo extends Model implements HasMedia
{
    use SoftDeletes;
    use MultiTenantModelTrait;
    use InteractsWithMedia;
    use Auditable;
    use HasFactory;

    public const STATUS_SELECT = [
        'in_attesa'    => 'In Attesa',
        'inviato'      => 'Inviato',
        'visualizzato' => 'Visualizzato',
        'accettato'    => 'Accettato',
        'rifiutato'    => 'Rifiutato',
    ];

    public $table = 'preventivos';

    protected $appends = [
        'file_fornitore_trasporto',
        'file_fornitore_servizi_extra',
        'file_fornitore_hotel',
        'prezzo_pacchetto',
        'files_pratica',
        'file_personalizzato',
    ];

    protected $dates = [
        'data_inzio_viaggio',
        'data_fine_viaggio',
        'created_at',
        'data_ora_partenza_andata',
        'data_ora_rientro_andata',
        'data_ora_partenza_rientro',
        'data_ora_rientro_rientro',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'oggetto',
        'tag_id',
        'numero',
        'anno',
        'itinerario_id',
        'cliente_id',
        'rg_fullname',
        'numero_persone',
        'prezzo_per_persona',
        'status',
        'data_inzio_viaggio',
        'data_fine_viaggio',
        'date_indicative',
        'informazioni_aggiuntive',
        'created_at',
        'guid',
        'viewkey',
        'luogo_di_partenza_andata',
        'luogo_di_arrivo_andata',
        'data_ora_partenza_andata',
        'data_ora_rientro_andata',
        'luogo_di_partenza_rientro',
        'luogo_di_arrivo_rientro',
        'data_ora_partenza_rientro',
        'data_ora_rientro_rientro',
        'numero_gratuita',
        'markup_tipo',
        'markup',
        'kg_bg_a_mano_andata',
        'kg_bg_a_mano_ritorno',
        'kg_bg_in_stiva_andata',
        'kg_bg_in_stiva_ritorno',
        'andata_azienda_trasporto_id',
        'ritorno_azienda_trasporto_id',
        'corpo_email',
        'cc_email',
        'updated_at',
        'deleted_at',
        'created_by_id',
    ];

    public function andata_azienda_trasporto()
    {
        return $this->belongsTo(AziendeTrasporti::class, 'andata_azienda_trasporto_id');
    }

    public function ritorno_azienda_trasporto()
    {
        return $this->belongsTo(AziendeTrasporti::class, 'ritorno_azienda_trasporto_id');
    }

    public function trasportoPrincipaleAndata()
    {
        $trasporto = VocePTrasportoUnaTantum::where('preventivo_id', $this->id)->where('tipologia_trasporto', 'principale')->where('tipologia', 'andata')->first();
        if (!$trasporto) {
            $trasporto = VocePTrasportoPerPersona::where('preventivo_id', $this->id)->where('tipologia_trasporto', 'principale')->where('tipologia', 'andata')->first();
            if (!$trasporto) {
                return null;
            }
            return $trasporto;
        }


        return $trasporto;
    }

    public function trasportoPrincipaleRientro()
    {
        $trasporto = VocePTrasportoUnaTantum::where('preventivo_id', $this->id)->where('tipologia_trasporto', 'principale')->where('tipologia', 'ritorno')->first();
        if (!$trasporto) {
            $trasporto = VocePTrasportoPerPersona::where('preventivo_id', $this->id)->where('tipologia_trasporto', 'principale')->where('tipologia', 'ritorno')->first();
            if (!$trasporto) {
                return null;
            }
            return $trasporto;
        }

        return $trasporto;
    }

    public function trasportoPrincipaleAndataTipologia()
    {
        $trasporto = VocePTrasportoUnaTantum::where('preventivo_id', $this->id)->where('tipologia_trasporto', 'principale')->where('tipologia', 'andata')->first();
        if (!$trasporto) {
            return true;
        }

        return false;
    }

    public function trasportoPrincipaleRientroTipologia()
    {
        $trasporto = VocePTrasportoUnaTantum::where('preventivo_id', $this->id)->where('tipologia_trasporto', 'principale')->where('tipologia', 'ritorno')->first();
        if (!$trasporto) {
            return true;
        }

        return false;
    }

    public function hotels()
    {
        return VocePHotel::where('preventivo_id', $this->id)->get();
    }

    public function trasporto_persona()
    {
        return VocePTrasportoPerPersona::where('preventivo_id', $this->id)->where('tipologia_trasporto', '!=', 'principale')->get();
    }

    public function trasporto_una_tantum()
    {
        return VocePTrasportoUnaTantum::where('preventivo_id', $this->id)->where('tipologia_trasporto', '!=', 'principale')->get();
    }

    public function extra_persona()
    {
        return VocePExtraPerPersona::where('preventivo_id', $this->id)->get();
    }

    public function extra_una_tantum()
    {
        return VocePExtraUnaTantum::where('preventivo_id', $this->id)->get();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function preventivoScadenziarios()
    {
        return $this->hasMany(Scadenziario::class, 'preventivo_id', 'id');
    }

    public function itinerario()
    {
        return $this->belongsTo(Itinerari::class, 'itinerario_id');
    }


    public function cliente()
    {
        return $this->belongsTo(Clienti::class, 'cliente_id');
    }

    public function getDataInzioViaggioAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDataInzioViaggioAttribute($value)
    {
        $this->attributes['data_inzio_viaggio'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getDataFineViaggioAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDataFineViaggioAttribute($value)
    {
        $this->attributes['data_fine_viaggio'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getFileFornitoreTrasportoAttribute()
    {
        return $this->getMedia('file_fornitore_trasporto');
    }

    public function getFileFornitoreServiziExtraAttribute()
    {
        return $this->getMedia('file_fornitore_servizi_extra');
    }

    public function getFileFornitoreHotelAttribute()
    {
        return $this->getMedia('file_fornitore_hotel');
    }

    public function getDataOraPartenzaAndataAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }



    public function getDataOraPartenzaAndataFormattatoAttribute()
    {
        if (!$this->data_ora_partenza_andata) return null;
        return Carbon::createFromFormat('d/m/Y H:i:s', $this->data_ora_partenza_andata)->format('d/m');
    }

    public function getOraPartenzaAndataFormattatoAttribute()
    {
        if (!$this->data_ora_partenza_andata) return null;
        return Carbon::createFromFormat('d/m/Y H:i:s', $this->data_ora_partenza_andata)->format('H:i');
    }

    public function getDataOraArrivoAndataFormattatoAttribute()
    {
        if (!$this->data_ora_partenza_rientro) return null;
        return Carbon::createFromFormat('d/m/Y H:i:s', $this->data_ora_partenza_rientro)->format('d/m');
    }

    public function getOraArrivoAndataFormattatoAttribute()
    {
        if (!$this->data_ora_partenza_rientro) return null;
        return Carbon::createFromFormat('d/m/Y H:i:s', $this->data_ora_partenza_rientro)->format('H:i');
    }







    public function getDataOraPartenzaRientroFormattatoAttribute()
    {
        if (!$this->data_ora_rientro_andata) return null;
        return Carbon::createFromFormat('d/m/Y H:i:s', $this->data_ora_rientro_andata)->format('d/m');
    }

    public function getOraPartenzaRientroFormattatoAttribute()
    {
        if (!$this->data_ora_rientro_andata) return null;
        return Carbon::createFromFormat('d/m/Y H:i:s', $this->data_ora_rientro_andata)->format('H:i');
    }

    public function getDataOraArrivoRientroFormattatoAttribute()
    {
        if (!$this->data_ora_rientro_rientro) return null;
        return Carbon::createFromFormat('d/m/Y H:i:s', $this->data_ora_rientro_rientro)->format('d/m');
    }

    public function getOraArrivoRientroFormattatoAttribute()
    {
        if (!$this->data_ora_rientro_rientro) return null;
        return Carbon::createFromFormat('d/m/Y H:i:s', $this->data_ora_rientro_rientro)->format('H:i');
    }







    public function getCreatedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setDataOraPartenzaAndataAttribute($value)
    {
        $this->attributes['data_ora_partenza_andata'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getDataOraRientroAndataAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setDataOraRientroAndataAttribute($value)
    {
        $this->attributes['data_ora_rientro_andata'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getDataOraPartenzaRientroAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setDataOraPartenzaRientroAttribute($value)
    {
        $this->attributes['data_ora_partenza_rientro'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getDataOraRientroRientroAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setDataOraRientroRientroAttribute($value)
    {
        $this->attributes['data_ora_rientro_rientro'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getGiorniAttribute()
    {
        return $this->notti + 1;
    }

    public function getNottiAttribute()
    {
        if (!$this->data_inzio_viaggio || !$this->data_fine_viaggio) return 0;

        $dateCheckin = new DateTime(Carbon::createFromFormat(config('panel.date_format'),  $this->data_inzio_viaggio)->format('Y-m-d') . ' 00:00:00');
        $dateCheckout = new DateTime(Carbon::createFromFormat(config('panel.date_format'),  $this->data_fine_viaggio)->format('Y-m-d')  . ' 00:00:00');  //next Day Morning

        return $dateCheckin
            ->setTime(0, 0)
            ->diff($dateCheckout)
            ->format("%a");
    }

    public function getPrezzoParteAttribute()
    {
        $totale = 0;
        $notti = $this->notti;
        $gratuita = $this->numero_gratuita;
        $numero_persone = $this->numero_persone;

        //HOTEL
        $hotels = VocePHotel::where('preventivo_id', $this->id)->get();


        foreach ($hotels as $hotel) {
            $stanzePerNotte = VocePHotelPerNotte::where('voce_hotel_id', '=', $hotel->id)->where('scorpora', '=', '1')
                ->get();


            foreach ($stanzePerNotte as $stanza) {
                $totale += $stanza->numero_stanze *  $stanza->costo_a_notte * $notti;
            }


            $stanzePerPersona = VocePHotelPerPersona::where('voce_hotel_id', '=', $hotel->id)->where('scorpora', '=', '1')
                ->get();

            foreach ($stanzePerPersona as $stanza) {
                $totale += $stanza->numero_stanze * $stanza->tipologia_stanza *  $stanza->costo_a_notte * $notti;
            }
        }


        //EXTRAS
        $servizi_extra_per_persona = VocePExtraPerPersona::where('preventivo_id', $this->id)->where('scorpora', '=', '1')
            ->get();
        foreach ($servizi_extra_per_persona as $servizio) {
            $totale += $servizio->prezzo * $numero_persone * $servizio->quantita;
        }


        $servizi_unatantum = VocePExtraUnaTantum::where('preventivo_id', $this->id)->where('scorpora', '=', '1')
            ->get();
        foreach ($servizi_unatantum as $servizio) {
            $totale += $servizio->prezzo * $servizio->quantita;
        }

        //TRASPORTO
        $trasporto_per_persona = VocePTrasportoPerPersona::where('preventivo_id', $this->id)->where('scorpora', '=', '1')
            ->get();
        foreach ($trasporto_per_persona as $trasporto) {
            $totale += $trasporto->prezzo * $numero_persone;
        }


        $trasporto_unatantum = VocePTrasportoUnaTantum::where('preventivo_id', $this->id)->where('scorpora', '=', '1')
            ->get();
        foreach ($trasporto_unatantum as $trasporto) {
            $totale += $trasporto->prezzo;
        }


        return round($totale, 2);
    }

    public function getPrezzoHotelDettaglioAttribute()
    {
        $notti = $this->notti;
        $hotel_dettaglio = [];

        //HOTEL
        $hotels = VocePHotel::where('preventivo_id', $this->id)->get();


        foreach ($hotels as $hotel) {
            $stanzePerNotte = VocePHotelPerNotte::whereRaw('voce_hotel_id = ' . $hotel->id)
                ->get();

            foreach ($stanzePerNotte as $stanza) {
                array_push($hotel_dettaglio, [
                    'nome' => $hotel->hotel->nome,
                    'tipo' => 'per_notte',
                    'totale' => $stanza->numero_stanze *  $stanza->costo_a_notte * $notti,
                    'numero_stanze' => $stanza->numero_stanze,
                    'costo_a_notte' => $stanza->costo_a_notte,
                    'notti' => $notti]
                );
            }

            $stanzePerPersona = VocePHotelPerPersona::whereRaw('voce_hotel_id = ' . $hotel->id)
                ->get();

            foreach ($stanzePerPersona as $stanza) {
                array_push($hotel_dettaglio, [
                        'nome' => $hotel->hotel->nome,
                        'tipo' => 'per_persona',
                        'totale' => $stanza->numero_stanze * $stanza->tipologia_stanza *  $stanza->costo_a_notte * $notti,
                        'numero_stanze' => $stanza->numero_stanze,
                        'tipologia_stanza' => $stanza->tipologia_stanza,
                        'costo_a_notte' => $stanza->costo_a_notte,
                        'notti' => $notti]
                );
            }
        }

        return $hotel_dettaglio;
    }

    public function getPrezzoHotelTotaleAttribute()
    {
        $totale = 0;
        $notti = $this->notti;
        $gratuita = $this->numero_gratuita;
        $numero_persone = $this->numero_persone;

        //HOTEL
        $hotels = VocePHotel::where('preventivo_id', $this->id)->get();


        foreach ($hotels as $hotel) {
            $stanzePerNotte = VocePHotelPerNotte::whereRaw('voce_hotel_id = ' . $hotel->id)
                ->get();


            foreach ($stanzePerNotte as $stanza) {
                $totale += $stanza->numero_stanze *  $stanza->costo_a_notte * $notti;
            }


            $stanzePerPersona = VocePHotelPerPersona::whereRaw('voce_hotel_id = ' . $hotel->id)
                ->get();



            foreach ($stanzePerPersona as $stanza) {

                $totale += $stanza->numero_stanze * $stanza->tipologia_stanza *  $stanza->costo_a_notte * $notti;
            }
        }

        return $totale;
    }

    public function getPrezzoServiziExtraDettaglioAttribute()
    {
        $servizi_extra_dettagio = [];
        $numero_persone = $this->numero_persone;

        //EXTRAS
        $servizi_extra_per_persona = VocePExtraPerPersona::whereRaw('preventivo_id = ' . $this->id)
            ->get();
        foreach ($servizi_extra_per_persona as $servizio) {
            array_push($servizi_extra_dettagio, [
                    'nome' => $servizio->servizio_extra->nome,
                    'tipo' => 'per_persona',
                    'totale' => $servizio->prezzo * $numero_persone * $servizio->quantita,
                    'prezzo' => $servizio->prezzo,
                    'quantita' => $servizio->quantita,
                    'numero_persone' => $numero_persone]
            );
        }

        $servizi_unatantum = VocePExtraUnaTantum::whereRaw('preventivo_id = ' . $this->id)
            ->get();
        foreach ($servizi_unatantum as $servizio) {
            array_push($servizi_extra_dettagio, [
                'nome' => $servizio->servizio_extra->nome,
                'tipo' => 'una_tantum',
                'totale' => $servizio->prezzo * $servizio->quantita,
                'prezzo' => $servizio->prezzo,
                'quantita' => $servizio->quantita]
            );
        }

        return $servizi_extra_dettagio;
    }

    public function getPrezzoServiziTotaleAttribute()
    {
        $totale = 0;
        $notti = $this->notti;
        $gratuita = $this->numero_gratuita;
        $numero_persone = $this->numero_persone;

        //EXTRAS
        $servizi_extra_per_persona = VocePExtraPerPersona::whereRaw('preventivo_id = ' . $this->id)
            ->get();
        foreach ($servizi_extra_per_persona as $servizio) {
            $totale += $servizio->prezzo * $numero_persone * $servizio->quantita;;
        }


        $servizi_unatantum = VocePExtraUnaTantum::whereRaw('preventivo_id = ' . $this->id)
            ->get();
        foreach ($servizi_unatantum as $servizio) {
            $totale += $servizio->prezzo * $servizio->quantita;
        }


        return $totale;
    }

    public function getPrezzoTrasportiDettaglioAttribute()
    {
        $trasporto_dettagio = [];
        $numero_persone = $this->numero_persone;

        //TRASPORTO
        $trasporto_per_persona = VocePTrasportoPerPersona::whereRaw('preventivo_id = ' . $this->id)
            ->get();

        foreach ($trasporto_per_persona as $trasporto) {
            array_push($trasporto_dettagio, [
                    'nome' => $trasporto->trasporto->nome,
                    'tipo' => 'per_persona',
                    'totale' => $trasporto->prezzo * $numero_persone,
                    'prezzo' => $trasporto->prezzo,
                    'numero_persone' => $numero_persone]
            );
        }

        $trasporto_unatantum = VocePTrasportoUnaTantum::whereRaw('preventivo_id = ' . $this->id)
            ->get();
        foreach ($trasporto_unatantum as $trasporto) {
            array_push($trasporto_dettagio, [
                    'nome' => $trasporto->trasporto->nome,
                    'tipo' => 'una_tantum',
                    'totale' => $trasporto->prezzo]
            );
        }

        return $trasporto_dettagio;
    }

    public function getPrezzoTrasportiTotaleAttribute()
    {
        $totale = 0;
        $notti = $this->notti;
        $gratuita = $this->numero_gratuita;
        $numero_persone = $this->numero_persone;

        //TRASPORTO
        $trasporto_per_persona = VocePTrasportoPerPersona::whereRaw('preventivo_id = ' . $this->id)
            ->get();
        foreach ($trasporto_per_persona as $trasporto) {
            $totale += $trasporto->prezzo * $numero_persone;
        }

        $trasporto_unatantum = VocePTrasportoUnaTantum::whereRaw('preventivo_id = ' . $this->id)
            ->get();
        foreach ($trasporto_unatantum as $trasporto) {
            $totale += $trasporto->prezzo;
        }

        return $totale;
    }

    public function getPrezzoPacchettoAttribute()
    {
        $totale = 0;
        $notti = $this->notti;
        $gratuita = $this->numero_gratuita;
        $numero_persone = $this->numero_persone;

        //HOTEL
        $hotels = VocePHotel::where('preventivo_id', $this->id)->get();


        foreach ($hotels as $hotel) {
            $stanzePerNotte = VocePHotelPerNotte::whereRaw('(scorpora = "0" OR scorpora is NULL) AND voce_hotel_id = ' . $hotel->id)
                ->get();


            foreach ($stanzePerNotte as $stanza) {
                $totale += $stanza->numero_stanze *  $stanza->costo_a_notte * $notti;
            }


            $stanzePerPersona = VocePHotelPerPersona::whereRaw('(scorpora = "0" OR scorpora is NULL) AND voce_hotel_id = ' . $hotel->id)
                ->get();



            foreach ($stanzePerPersona as $stanza) {

                $totale += $stanza->numero_stanze * $stanza->tipologia_stanza *  $stanza->costo_a_notte * $notti;
            }
        }




        //EXTRAS
        $servizi_extra_per_persona = VocePExtraPerPersona::whereRaw('(scorpora = "0" OR scorpora is NULL) AND preventivo_id = ' . $this->id)
            ->get();
        foreach ($servizi_extra_per_persona as $servizio) {
            $totale += $servizio->prezzo * $numero_persone * $servizio->quantita;;
        }


        $servizi_unatantum = VocePExtraUnaTantum::whereRaw('(scorpora = "0" OR scorpora is NULL) AND preventivo_id = ' . $this->id)
            ->get();
        foreach ($servizi_unatantum as $servizio) {
            $totale += $servizio->prezzo * $servizio->quantita;
        }

        //TRASPORTO
        $trasporto_per_persona = VocePTrasportoPerPersona::whereRaw('(scorpora = "0" OR scorpora is NULL) AND preventivo_id = ' . $this->id)
            ->get();
        foreach ($trasporto_per_persona as $trasporto) {
            $totale += $trasporto->prezzo * $numero_persone;
        }


        $trasporto_unatantum = VocePTrasportoUnaTantum::whereRaw('(scorpora = "0" OR scorpora is NULL) AND preventivo_id = ' . $this->id)
            ->get();
        foreach ($trasporto_unatantum as $trasporto) {
            $totale += $trasporto->prezzo;
        }

        $npersonecalcolato = ($numero_persone - $gratuita);
        if ($npersonecalcolato == 0) return 0;


        $totaleReturn = $totale / $npersonecalcolato;
        $totaleReturn += $this->markup;
        return round($totaleReturn, 0);
    }
















    public function printQuotaComprende()
    {
        $included = '';
        $totale = 0;
        $notti = $this->notti;
        $gratuita = $this->numero_gratuita;
        $numero_persone = $this->numero_persone;
        //HOTEL
        $hotels = VocePHotel::where('preventivo_id', $this->id)->get();


        foreach ($hotels as $hotel) {
            $stanzePerNotte = VocePHotelPerNotte::whereRaw('(scorpora = "0" OR scorpora is NULL) AND voce_hotel_id = ' . $hotel->id)
                ->first();
            $stanzePerPersona = VocePHotelPerPersona::whereRaw('(scorpora = "0" OR scorpora is NULL) AND voce_hotel_id = ' . $hotel->id)
                ->first();
            if ($stanzePerNotte || $stanzePerPersona) {
                $included .=
                    '<table style="text-align:left;">
            <tr>
            <td style="width:30px;padding: 0px;">
            <img style="width:100%;" src="' . "/images/LA-BUSSOLA_Icone-21-1.png" . '">
            </td>
                <td>
                        <span class="seriale-h4">' .
                    $hotel->hotel->nome
                    . ' ';
                $stanzePerNotte = VocePHotelPerNotte::whereRaw('(scorpora = "0" OR scorpora is NULL) AND voce_hotel_id = ' . $hotel->id)
                    ->get();


                foreach ($stanzePerNotte as $stanza) {
                    if ($stanza->tipologia_stanza == 'multipla') {
                        $included .= ', ' . \App\Models\VocePHotelPerNotte::TIPOLOGIA_STANZA_SELECT[$stanza->tipologia_stanza];
                    } else {
                        $included .= ', ' . \App\Models\VocePHotelPerNotte::TIPOLOGIA_STANZA_SELECT[$stanza->tipologia_stanza] . ' con una quantità ' . $stanza->numero_stanze;
                    }
                }


                $stanzePerPersona = VocePHotelPerPersona::whereRaw('(scorpora = "0" OR scorpora is NULL) AND voce_hotel_id = ' . $hotel->id)
                    ->get();

                foreach ($stanzePerPersona as $stanza) {

                    $included .= ', ' . \App\Models\VocePHotelPerPersona::TIPOLOGIA_STANZA_SELECT[$stanza->tipologia_stanza] . ' con una quantità ' . $stanza->numero_stanze;
                }

                $included .=  ' </span>

        </td>
    </tr>
</table>
';
            }
            $included = str_replace("(, ", " (", $included);
        }


        //EXTRAS
        $servizi_extra_per_persona = VocePExtraPerPersona::whereRaw('(scorpora = "0" OR scorpora is NULL) AND preventivo_id = ' . $this->id)
            ->get();
        foreach ($servizi_extra_per_persona as $servizio) {

            $included .=
                '<table  style="text-align:left;">
            <tr>
                <td style="width:30px;padding: 0px;">

                        <img style="width:100%;" src="' . "/images/LA-BUSSOLA_Icone-21-1.png" . '">


                </td>
		    <td> <span class="seriale-h4">
' .
                $servizio->servizio_extra->nome . ' - Quantità: ' . $servizio->quantita . ' - (' . $servizio->quota_comprende . ') '
                . '
			</span></td>
            </tr>
        </table>';
        }


        $servizi_unatantum = VocePExtraUnaTantum::whereRaw('(scorpora = "0" OR scorpora is NULL) AND preventivo_id = ' . $this->id)
            ->get();
        foreach ($servizi_unatantum as $servizio) {

            $included .=
                '<table  style="text-align:left;">
            <tr>
                <td style="width:30px;padding: 0px;">

                        <img style="width:100%;" src="' . "/images/LA-BUSSOLA_Icone-21-1.png" . '">


                </td>
		    <td> <span class="seriale-h4">
' .
                $servizio->servizio_extra->nome . ' - Quantità: ' . $servizio->quantita . ' - (' . $servizio->quota_comprende . ') '
                . '
			</span></td>
            </tr>
        </table>';
        }

        //TRASPORTO
        $trasporto_per_persona = VocePTrasportoPerPersona::whereRaw('(scorpora = "0" OR scorpora is NULL) AND preventivo_id = ' . $this->id)
            ->get();
        foreach ($trasporto_per_persona as $trasporto) {
            $extra = '';
            if ($trasporto->tipologia_trasporto == 'principale') {
                $extra = ' ' . VocePTrasportoPerPersona::TIPOLOGIA_SELECT[$trasporto->tipologia];
            }

            $included .=

                '<table  style="text-align:left;">
        <tr>
            <td style="width:30px;padding: 0px;">

                    <img style="width:100%;" src="' . "/images/LA-BUSSOLA_Icone-21-1.png" . '">


            </td>
        <td> <span class="seriale-h4">
' .
                $trasporto->trasporto->nome
                . $extra . '
        </span></td>
        </tr>
    </table>';
        }


        $trasporto_unatantum = VocePTrasportoUnaTantum::whereRaw('(scorpora = "0" OR scorpora is NULL) AND preventivo_id = ' . $this->id)
            ->get();
        foreach ($trasporto_unatantum as $trasporto) {
            $extra = '';
            if ($trasporto->tipologia_trasporto == 'principale') {
                $extra = ' ' . VocePTrasportoUnaTantum::TIPOLOGIA_SELECT[$trasporto->tipologia];
            }

            $included .=

                '<table  style="text-align:left;">
        <tr>
            <td style="width:30px;padding: 0px;">

                    <img style="width:100%;" src="' . "/images/LA-BUSSOLA_Icone-21-1.png" . '">


            </td>
        <td> <span class="seriale-h4">
' .
                $trasporto->trasporto->nome
                . $extra . '
        </span></td>
        </tr>
    </table>';
        }


        $included = str_replace("- ()", "", $included);

        return $included;
    }































    public function printQuotaNonComprende()
    {
        $included = '';
        $totale = 0;
        $notti = $this->notti;
        $gratuita = $this->numero_gratuita;
        $numero_persone = $this->numero_persone;
        $numero_paganti = $this->numero_persone - $this->numero_gratuita;

        //HOTEL
        $hotels = VocePHotel::where('preventivo_id', $this->id)->get();

        foreach ($hotels as $hotel) {
            $stanzePerNotte = VocePHotelPerNotte::where('voce_hotel_id', '=', $hotel->id)->where('scorpora', '=', '1')
                ->first();
            $stanzePerPersona = VocePHotelPerPersona::where('scorpora', '=', '1')
                ->first();
            if ($stanzePerNotte || $stanzePerPersona) {
                $included .=
                    '<table style="text-align:left;">
            <tr>
            <td style="width:30px;padding: 0px;">
            <img style="width:100%;" src="' . "/images/LA-BUSSOLA_Icone-23-1.png" . '">
            </td>
                <td>
                        <span class="seriale-h4">' .
                    $hotel->hotel->nome
                    . ' ';
                $stanzePerNotte = VocePHotelPerNotte::where('voce_hotel_id', '=', $hotel->id)->where('scorpora', '=', '1')
                    ->get();


                foreach ($stanzePerNotte as $stanza) {
                    $prezzo = $stanza->numero_stanze *  $stanza->costo_a_notte * $notti;
                    if ($stanza->tipologia_stanza == 'multipla') {
                        $included .= ', ' . \App\Models\VocePHotelPerNotte::TIPOLOGIA_STANZA_SELECT[$stanza->tipologia_stanza] . ' [€' . $prezzo . ' - a persona €' . round($prezzo / $numero_paganti, 2) . ']';
                    } else {
                        $included .= ', ' . \App\Models\VocePHotelPerNotte::TIPOLOGIA_STANZA_SELECT[$stanza->tipologia_stanza] . ' con una quantità ' . $stanza->numero_stanze . ' [€' . $prezzo . ' - a persona €' . round($prezzo / $numero_paganti, 2) . ']';
                    }
                }


                $stanzePerPersona = VocePHotelPerPersona::where('voce_hotel_id', '=', $hotel->id)->where('scorpora', '=', '1')
                    ->get();

                foreach ($stanzePerPersona as $stanza) {
                    $prezzo = $stanza->numero_stanze * $stanza->tipologia_stanza *  $stanza->costo_a_notte * $notti;
                    $included .= ', ' . \App\Models\VocePHotelPerPersona::TIPOLOGIA_STANZA_SELECT[$stanza->tipologia_stanza] . ' con una quantità ' . $stanza->numero_stanze . ' [€' . $prezzo . ' - a persona €' . round($prezzo / $numero_paganti, 2) . ']';
                }

                $included .=  ' </span>

        </td>
    </tr>
</table>
';
            }
            $included = str_replace("(, ", " (", $included);
        }


        //EXTRAS
        $servizi_extra_per_persona = VocePExtraPerPersona::where('preventivo_id', $this->id)->where('scorpora', '=', '1')
            ->get();
        foreach ($servizi_extra_per_persona as $servizio) {

            $included .=
                '<table  style="text-align:left;">
            <tr>
                <td style="width:30px;padding: 0px;">

                        <img style="width:100%;" src="' . "/images/LA-BUSSOLA_Icone-23-1.png" . '">


                </td>
		    <td> <span class="seriale-h4">
' .
                $servizio->servizio_extra->nome . ' [€' . $servizio->prezzo * $numero_persone * $servizio->quantita . ' - a persona €' . round(($servizio->prezzo * $numero_persone * $servizio->quantita) / $numero_paganti, 2) . ']' . ' - Quantità: ' . $servizio->quantita . ' - (' . $servizio->info_aggiuntive . ') '

                . '
			</span></td>
            </tr>
        </table>';
        }


        $servizi_unatantum = VocePExtraUnaTantum::where('preventivo_id', $this->id)->where('scorpora', '=', '1')
            ->get();
        foreach ($servizi_unatantum as $servizio) {

            $included .=
                '<table  style="text-align:left;">
            <tr>
                <td style="width:30px;padding: 0px;">

                        <img style="width:100%;" src="' . "/images/LA-BUSSOLA_Icone-23-1.png" . '">


                </td>
		    <td> <span class="seriale-h4">
' .
                $servizio->servizio_extra->nome . ' [€' . $servizio->prezzo * $servizio->quantita . ' - a persona €' . round(($servizio->prezzo * $servizio->quantita) / $numero_paganti, 2) . ']' . ' - Quantità: ' . $servizio->quantita . ' - (' . $servizio->info_aggiuntive . ') '
                . '
			</span></td>
            </tr>
        </table>';
        }

        //TRASPORTO
        $trasporto_per_persona = VocePTrasportoPerPersona::where('preventivo_id', $this->id)->where('scorpora', '=', '1')
            ->get();
        foreach ($trasporto_per_persona as $trasporto) {
            $extra = '';
            if ($trasporto->tipologia_trasporto == 'principale') {
                $extra = ' ' . VocePTrasportoPerPersona::TIPOLOGIA_SELECT[$trasporto->tipologia];
            }
            $included .=

                '<table  style="text-align:left;">
        <tr>
            <td style="width:30px;padding: 0px;">

                    <img style="width:100%;" src="' . "/images/LA-BUSSOLA_Icone-23-1.png" . '">


            </td>
        <td> <span class="seriale-h4">
' .
                $trasporto->trasporto->nome . ' [€' . $trasporto->prezzo * $numero_persone . ' - a persona €' . round(($trasporto->prezzo * $numero_persone) / $numero_paganti, 2) . ']'
                . $extra . '
        </span></td>
        </tr>
    </table>';
        }


        $trasporto_unatantum = VocePTrasportoUnaTantum::where('preventivo_id', $this->id)->where('scorpora', '=', '1')
            ->get();
        foreach ($trasporto_unatantum as $trasporto) {
            $extra = '';
            if ($trasporto->tipologia_trasporto == 'principale') {
                $extra = ' ' . VocePTrasportoUnaTantum::TIPOLOGIA_SELECT[$trasporto->tipologia];
            }
            $included .=

                '<table  style="text-align:left;">
        <tr>
            <td style="width:30px;padding: 0px;">

                    <img style="width:100%;" src="' . "/images/LA-BUSSOLA_Icone-23-1.png" . '">


            </td>
        <td> <span class="seriale-h4">
' .
                $trasporto->trasporto->nome . ' [€' . $trasporto->prezzo . ' - a persona €' . round(($trasporto->prezzo * $numero_persone) / $numero_paganti, 2) . ']'
                . $extra . '
        </span></td>
        </tr>
    </table>';
        }


        $included = str_replace("- ()", "", $included);


        return $included;
    }


    public function getFilesPraticaAttribute()
    {
        return $this->getMedia('files_pratica');
    }

    public function getFilePersonalizzatoAttribute()
    {
        return $this->getMedia('file_personalizzato');
    }


    public static function boot()
    {
        parent::boot();
        Preventivo::observe(new \App\Observers\PreventivoObserver());
    }

    /**
     * @param string $searchString
     * @return mixed
     */
    public static function freeSearchInAllTable(string $searchString) {

        $preventivosColumnList = Schema::getColumnListing('preventivos');
        $preventivosColumnListPurged = [];
        foreach ($preventivosColumnList as $column) {
            if ( ! str_ends_with($column, 'id') && ! str_ends_with($column, '_at') ) {
                $preventivosColumnListPurged[] = $column;
            }
        }

        $preventivo = self::where(reset($preventivosColumnListPurged), 'like', "%$searchString%");

        foreach ($preventivosColumnListPurged as $key => $column) {
            if ( $key == 0 ) {
                continue;
            }

            $preventivo->orWhere($column, 'like', "%$searchString%");
        }

        return $preventivo->get();
    }
}
