<?php

namespace App\Http\Controllers;

use App\Helpers\Utilities;
use App\Models\Preventivo;
use App\Models\VocePExtraPerPersona;
use App\Models\VocePExtraUnaTantum;
use App\Models\VocePHotel;
use App\Models\VocePTrasportoPerPersona;
use App\Models\VocePTrasportoUnaTantum;
use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\Response;

class FrontendController extends Controller
{

    public function download(Request $request)
    {

        $preventivo = Preventivo::withoutGlobalScope('created_by_id')->where('guid', '=', $request->uuid)->first();
        abort_if(!$preventivo, Response::HTTP_NOT_FOUND, '404 Non esistente');


        $preventivo->refresh();

        $vociPExtraPerPersona = VocePExtraPerPersona::where('preventivo_id', $preventivo->id)->get();
        Utilities::posizionaPolizzaInFondo($vociPExtraPerPersona);
        $vociPExtraUnaTantum = VocePExtraUnaTantum::where('preventivo_id', $preventivo->id)->get();
        Utilities::posizionaPolizzaInFondo($vociPExtraUnaTantum);
        $vociPTrasportoPerPersona = VocePTrasportoPerPersona::where('preventivo_id', $preventivo->id)->where('tipologia_trasporto', 'trasporti')->get();
        $vociPTrasportoUnaTantum = VocePTrasportoUnaTantum::where('preventivo_id', $preventivo->id)->where('tipologia_trasporto', 'trasporti')->get();

        $vociHotel = VocePHotel::where('preventivo_id', $preventivo->id)->get();
        $ciSonoHotel = VocePHotel::where('preventivo_id', $preventivo->id)->count();
        if ($ciSonoHotel > 0) {
            $ciSonoHotel = true;
        } else {
            $ciSonoHotel = false;
        }

        $trasportoPrincipaleAndata = VocePTrasportoPerPersona::where('preventivo_id', $preventivo->id)->where('tipologia_trasporto', 'principale')->where('tipologia', 'andata')->first();
        $trasportoPrincipaleRientro = VocePTrasportoPerPersona::where('preventivo_id', $preventivo->id)->where('tipologia_trasporto', 'principale')->where('tipologia', 'ritorno')->first();

        if (!$trasportoPrincipaleAndata) {
            $trasportoPrincipaleAndata = VocePTrasportoUnaTantum::where('preventivo_id', $preventivo->id)->where('tipologia_trasporto', 'principale')->where('tipologia', 'andata')->first();
        }

        if (!$trasportoPrincipaleRientro) {
            $trasportoPrincipaleRientro = VocePTrasportoUnaTantum::where('preventivo_id', $preventivo->id)->where('tipologia_trasporto', 'principale')->where('tipologia', 'ritorno')->first();
        }


        $pdf = Pdf::loadView('frontend.pdfnew', compact('ciSonoHotel', 'preventivo', 'vociHotel', 'vociPExtraPerPersona', 'vociPExtraUnaTantum', 'vociPTrasportoPerPersona', 'vociPTrasportoUnaTantum', 'trasportoPrincipaleAndata', 'trasportoPrincipaleRientro'));
        return $pdf->download('Preventivo LaBussola '. $preventivo->numero.'/'.$preventivo->anno .'.pdf');
    }

    public function preLoadVisualizzaPreventivo(Request $request)
    {
        $preventivo = Preventivo::withoutGlobalScope('created_by_id')->where('guid', '=', $request->uuid)->first();
        abort_if(!$preventivo, Response::HTTP_NOT_FOUND, '404 Non esistente');
        $preventivo = Preventivo::withoutGlobalScope('created_by_id')->find($preventivo->id);

        if ($preventivo->status == 'in_attesa' || $preventivo->status == 'inviato') {
            if ($request->view_key == $preventivo->viewkey) {
                $preventivo->status = 'visualizzato';
                $preventivo->save();
            }
        }

        return redirect()->route('visualizza.preventivo', ['uuid' => $request->uuid]);
    }

    public function visualizzaPreventivo(Request $request)
    {
        $preventivo = Preventivo::withoutGlobalScope('created_by_id')->where('guid', '=', $request->uuid)->first();
        abort_if(!$preventivo, Response::HTTP_NOT_FOUND, '404 Non esistente');

        $ciSonoHotel = VocePHotel::where('preventivo_id', $preventivo->id)->count();
        if ($ciSonoHotel > 0) {
            $ciSonoHotel = true;
        } else {
            $ciSonoHotel = false;
        }

        $vociPExtraPerPersona = VocePExtraPerPersona::where('preventivo_id', $preventivo->id)->get();
        Utilities::posizionaPolizzaInFondo($vociPExtraPerPersona);
        $vociPExtraUnaTantum = VocePExtraUnaTantum::where('preventivo_id', $preventivo->id)->get();
        Utilities::posizionaPolizzaInFondo($vociPExtraUnaTantum);

        $vociPTrasportoPerPersona = VocePTrasportoPerPersona::where('preventivo_id', $preventivo->id)->where('tipologia_trasporto', 'trasporti')->get();
        $vociPTrasportoUnaTantum = VocePTrasportoUnaTantum::where('preventivo_id', $preventivo->id)->where('tipologia_trasporto', 'trasporti')->get();

        $vociHotel = VocePHotel::where('preventivo_id', $preventivo->id)->get();

        $trasportoPrincipaleAndata = VocePTrasportoPerPersona::where('preventivo_id', $preventivo->id)->where('tipologia_trasporto', 'principale')->where('tipologia', 'andata')->first();
        $trasportoPrincipaleRientro = VocePTrasportoPerPersona::where('preventivo_id', $preventivo->id)->where('tipologia_trasporto', 'principale')->where('tipologia', 'ritorno')->first();

        if (!$trasportoPrincipaleAndata) {
            $trasportoPrincipaleAndata = VocePTrasportoUnaTantum::where('preventivo_id', $preventivo->id)->where('tipologia_trasporto', 'principale')->where('tipologia', 'andata')->first();
        }

        if (!$trasportoPrincipaleRientro) {
            $trasportoPrincipaleRientro = VocePTrasportoUnaTantum::where('preventivo_id', $preventivo->id)->where('tipologia_trasporto', 'principale')->where('tipologia', 'ritorno')->first();
        }

        return view('frontend.browser', compact('ciSonoHotel', 'preventivo', 'vociHotel', 'vociPExtraPerPersona', 'vociPExtraUnaTantum', 'vociPTrasportoPerPersona', 'vociPTrasportoUnaTantum', 'trasportoPrincipaleAndata', 'trasportoPrincipaleRientro'));
    }


    public function accettaPreventivo(Request $request)
    {
        $preventivo = Preventivo::withoutGlobalScope('created_by_id')->where('guid', '=', $request->uuid)->first();
        abort_if(!$preventivo, Response::HTTP_NOT_FOUND, '404 Non esistente');

        if ($preventivo->status != 'accettato' && $preventivo->status != 'rifiutato') {
            $preventivo->status = 'accettato';
            $preventivo->save();
        }

        return redirect()->route('preventivo', ['uuid'=>$request->uuid]);
    }


    public function rifiutaPreventivo(Request $request)
    {
        $preventivo = Preventivo::withoutGlobalScope('created_by_id')->where('guid', '=', $request->uuid)->first();
        abort_if(!$preventivo, Response::HTTP_NOT_FOUND, '404 Non esistente');


        if ($preventivo->status != 'accettato' && $preventivo->status != 'rifiutato') {
            $preventivo->status = 'rifiutato';
            $preventivo->save();
        }

        return redirect()->route('preventivo', ['uuid'=>$request->uuid]);
    }
}
