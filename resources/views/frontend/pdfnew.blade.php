@php
    $public_path = public_path();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <style type="text/css" media="screen">
        html {
            font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            line-height: 1.15;
            margin: 0;
        }

        body {
            font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: left;
            background-color: #fff;
            font-size: 14px;
        }

        .stelle {
            width: 15px;
            height: 15px;
        }

        .width30px {
            width: 30px;
        }

        .width33 {
            width: 33%;
        }

        .width10 {
            width: 10% !important;
        }

        .width20 {
            width: 20% !important;
        }

        .width30 {
            width: 30% !important;
        }

        .width40 {
            width: 40% !important;
        }

        .width50 {
            width: 50% !important;
        }

        .width60 {
            width: 60% !important;
        }

        .width70 {
            width: 70% !important;
        }

        .width80 {
            width: 80% !important;
        }

        .width90 {
            width: 90% !important;
        }

        .width100 {
            width: 100% !important;
        }

        h4 {
            margin-top: 0;
            margin-bottom: 0.5rem;
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        strong {
            font-weight: bolder;
        }

        .inlineDisplay {
            display: inline;
        }

        img {
            vertical-align: middle;
            border-style: none;
        }

        table {
            border-collapse: collapse;
        }

        th {
            text-align: inherit;
        }

        h4,
        .h4 {
            margin-bottom: 0.5rem;
            font-weight: 500;
            line-height: 1.2;
        }

        h4,
        .h4 {
            font-size: 1.5rem;
        }

        .table {
            width: 100%;
            color: #212529;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
        }

        .tableHeader {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }

        .tableHeader th,
        .tableHeader td {
            padding: 0pt;
            vertical-align: top;
        }

        .blu {
            color: #2054AD !important;
        }

        .table.table-items td {
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .mt-5 {
            margin-top: 3rem !important;
        }

        .pr-0,
        .px-0 {
            padding-right: 0 !important;
        }

        .pl-0,
        .px-0 {
            padding-left: 0 !important;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .text-uppercase {
            text-transform: uppercase !important;
        }

        * {
            font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        }

        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        table,
        th,
        tr,
        td,
        p,
        div {
            line-height: 1.1;
        }

        .party-header {
            font-size: 1.5rem;
            font-weight: 400;
        }

        .total-amount {
            font-size: 12px;
            font-weight: 700;
        }

        .border-0 {
            border: none !important;
        }

        .cool-gray {
            color: #6B7280;
        }

        .seriale {
            font-size: 0.7rem;
            font-weight: 400;
        }

        .seriale-h4 {
            font-size: 0.7rem;
            font-weight: 400;
        }

        .seriale-h5 {
            font-size: 0.6rem;
            font-weight: 400;
        }

        .seriale-h1 {
            font-size: 1.3rem;
            font-weight: 400;
        }

        .seriale-h2 {
            font-size: 1rem;
            font-weight: 400;
        }

        .borderedRadiusImage {
            border-radius: 39px 39px 39px 39px;
        }

        .oggetto {
            color: #12913C !important;
            font-size: 2.5rem;
            font-weight: 600;
        }

        .verde {
            color: #12913C !important;
        }

        .rightText {
            text-align: right !important;
        }

        .rigaVerdeChiaro {
            background-color: #D3ECC0 !important;
            padding-left: 10px;
            padding-top: 10pt;
            padding-bottom: 10pt;
        }

        .rigaVerdeScuro {
            background-color: #B7DEBF !important;
            padding-left: 10px;
            padding-top: 10pt;
            padding-bottom: 10pt;
        }

        .page_break {
            page-break-before: always;
        }
    </style>
</head>

<body style="padding-top: 20pt;">
    <table class="tableHeader" style="position: relative; left:30pt; top: -36pt;margin-bottom:-20px;">
        <thead>
            <tr>
                <th class="border-0 pl-0">
                    &nbsp;
                </th>
                <th class="border-0">
                    &nbsp;
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: right;padding-left:50pt;padding-top:37px;" style="text-align: left;">
                    <div>
                        <img style="width:240px;" src="{{ public_path('/images/Logo-LaBussola-1-1024x395.png') }}" />
                    </div>
                </td>

                <td style="text-align: right;padding-right:125px;padding-top:34px;">
                    <p class="seriale-h2">Preventivo
                        n°<strong>{{ $preventivo->numero }}</strong>/{{ $preventivo->anno }}<br />
                        del {{ substr($preventivo->created_at, 0, 10) }}</p>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="table" style="position: relative; top: -36pt;">
        <thead>
            <tr>
                <th class="border-0 pl-0">
                    &nbsp;
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="background-color: #ECECED !important;padding:20px;text-align: center;">
                    <span class="seriale-h5">
                        Spett. {{ $preventivo->cliente->nome }} {{ $preventivo->cliente->cognome }} - <strong>
                            {{ $preventivo->cliente->ragione_sociale }}</strong><br />
                        <strong>La Bussola S.r.l</strong> è lieta di presentarvi il preventivo
                        per</span>
                </td>
            </tr>
        </tbody>
    </table>
    <table
        style="position: relative; top: -36pt;padding-top:30px;padding-left:36pt;padding-right:36pt;width:100%; table-layout: fixed;">
        <thead>
            <tr>
                <th class="border-0">
                    &nbsp;
                </th>
                @if ($preventivo->itinerario)
                    <th class="border-0">
                        &nbsp;
                    </th>
                @endif
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center;" @if ($preventivo->itinerario) class="width50" @endif>
                    <div style="margin-top:13px;">
                        <p class="oggetto seriale-h2"><strong> {{ $preventivo->oggetto }} </strong> </p>
                    </div>
                </td>
                @if ($preventivo->itinerario)
                    <td style="text-align: right;" class="width50">
                        <div style="margin-top:-30px;">

                            <img style="width:300px;"
                                src="{{ public_path(substr($preventivo->itinerario->foto_introduttiva->getUrl(), 32)) }}"
                                class="borderedRadiusImage" />

                        </div>
                    </td>
                @endif
            </tr>
        </tbody>
    </table>
    <table style="padding:36pt;padding-top:0px !important;">
        <tbody>
            <tr>
                <td style="text-align: center;" style="padding-right:20px;">
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <img width="50"
                                        src="{{ public_path('/images/Icone_0028_LA-BUSSOLA_Icone_Tavola-disegno-1.png') }}" />
                                </td>
                                <td style="padding-top:18px;padding-left:20px;">
                                    <h3 class="seriale-h5">
                                        <span class="verde"><strong>{{ $preventivo->giorni }}</strong></span>
                                        <span class="seriale-h4">giorni</span>
                                    </h3>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td style="text-align: center;" style="padding-right:20px;">
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <img width="43"
                                        src="{{ public_path('/images/Icone_0029_LA-BUSSOLA_Icone-02.png') }}" />
                                </td>
                                <td style="padding-top:18px;padding-left:20px;">
                                    <h3 class="seriale-h5">
                                        <span class="verde"><strong>{{ $preventivo->notti }}</strong></span>
                                        <span class="seriale-h4">notti</span>
                                    </h3>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td style="text-align: center;" style="padding-right:20px;">
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <img width="45"
                                        src="{{ public_path('/images/Icone_0027_LA-BUSSOLA_Icone-03.png') }}" />
                                </td>
                                <td style="padding-top:18px;padding-left:20px;">
                                    <h3 class="seriale-h5">
                                        <span class="seriale-h4">dal</span>
                                        <span
                                            class="verde"><strong>{{ $preventivo->data_inzio_viaggio }}</strong></span>
                                        <span class="seriale-h4">al</span>
                                        <span
                                            class="verde"><strong>{{ $preventivo->data_fine_viaggio }}</strong></span>
                                    </h3>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td style="text-align: center;" style="padding-right:20px;">
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <img width="50"
                                        src="{{ public_path('/images/Icone_0026_LA-BUSSOLA_Icone-04.png') }}" />
                                </td>
                                <td style="padding-top:18px;padding-left:20px;">
                                    <h3 class="seriale-h5">
                                        <span class="verde"><strong>{{ $preventivo->numero_persone - $preventivo->numero_gratuita}}</strong></span>
                                        <span class="seriale-h4">paganti</span>
                                    </h3>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td style="text-align: center;padding-right:20px;">
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <img width="50"
                                        src="{{ public_path('/images/Icone_0025_LA-BUSSOLA_Icone-05.png') }}" />
                                </td>
                                <td style="padding-top:18px;padding-left:20px;">
                                    <h3 class="seriale-h5">
                                        <span class="verde">
                                            <strong>{{ $preventivo->numero_gratuita }}</strong></span>
                                        <span class="seriale-h4">gratuità</span>
                                    </h3>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    @if ($trasportoPrincipaleAndata || $trasportoPrincipaleRientro)
        <table style="padding:36pt;padding-top:5pt !important;padding-bottom:5pt;">
            <tbody>
                <tr>
                    <td>
                        @if ($trasportoPrincipaleAndata)
                            @foreach ($trasportoPrincipaleAndata->trasporto->foto as $key => $media)
                                <img style="width:100px;" src="{{ public_path(substr($media->getUrl(), 32)) }}" />
                            @endforeach
                        @elseif($trasportoPrincipaleRientro)
                            @foreach ($trasportoPrincipaleRientro->trasporto->foto as $key => $media)
                                <img style="width:100px;" src="{{ public_path(substr($media->getUrl(), 32)) }}" />
                            @endforeach
                        @endif
                    </td>
                    <td>
                        <table style="padding-left:30px;">
                            <thead style="border:3px solid #12913C;">
                                @if ($trasportoPrincipaleAndata || $trasportoPrincipaleRientro)
                                    <th style="padding-left:5pt;padding-top:5pt;padding-bottom:5pt;">
                                        <span class="seriale-h2">
                                            <strong>Orari andata </strong>
                                        </span>
                                    </th>
                                    <th style="padding-left:5pt;padding-top:5pt;padding-bottom:5pt;">
                                        <span class="seriale-h2">
                                            <strong>Orari ritorno </strong>
                                        </span>
                                    </th>
                                @endif
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding-top:10px;">
                                        @if (
                                            $preventivo->data_ora_partenza_andata_formattato ||
                                                $preventivo->luogo_di_partenza_andata ||
                                                $preventivo->ora_partenza_andata_formattato)
                                            <table class="width100 rigaVerdeChiaro">
                                                <tr>
                                                    <td class="width20">
                                                        <span class="seriale-h4">
                                                            <strong>
                                                                {{ $preventivo->data_ora_partenza_andata_formattato }}</strong>
                                                        </span>
                                                    </td>
                                                    <td class="width60">
                                                        <span class="seriale-h4">
                                                            {{ $preventivo->luogo_di_partenza_andata }}
                                                        </span>
                                                    </td>
                                                    <td class="width20">
                                                        <span class="seriale-h4">
                                                            {{ $preventivo->ora_partenza_andata_formattato }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </table>
                                        @endif
                                    </td>


                                    <td style="padding-top:10px;">
                                        @if (
                                            $preventivo->data_ora_arrivo_andata_formattato ||
                                                $preventivo->luogo_di_partenza_rientro  ||
                                                $preventivo->ora_arrivo_andata_formattato)
                                            <table class="width100 rigaVerdeChiaro">
                                                <tr>
                                                    <td class="width20">
                                                        <span class="seriale-h4">
                                                            <strong>
                                                                {{ $preventivo->data_ora_arrivo_andata_formattato }}
                                                            </strong>
                                                        </span>
                                                    </td>
                                                    <td class="width60">
                                                        <span class="seriale-h4">
                                                            {{ $preventivo->luogo_di_partenza_rientro  }}
                                                        </span>
                                                    </td>
                                                    <td class="width20">
                                                        <span class="seriale-h4">
                                                            {{ $preventivo->ora_arrivo_andata_formattato }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </table>
                                        @endif
                                    </td>


                                </tr>
                                <tr>
                                    <td style="padding-top:10px;">
                                        @if (
                                            $preventivo->data_ora_partenza_rientro_formattato ||
                                                $preventivo->luogo_di_arrivo_andata  ||
                                                $preventivo->ora_partenza_rientro_formattato)
                                            <table class="width100 rigaVerdeScuro">
                                                <tr>
                                                    <td class="width20">
                                                        <span class="seriale-h4">
                                                            <strong>
                                                                {{ $preventivo->data_ora_partenza_rientro_formattato }}
                                                            </strong>
                                                        </span>
                                                    </td>
                                                    <td class="width60">
                                                        <span class="seriale-h4">
                                                            {{ $preventivo->luogo_di_arrivo_andata  }}
                                                        </span>
                                                    </td>
                                                    <td class="width20">
                                                        <span class="seriale-h4">
                                                            {{ $preventivo->ora_partenza_rientro_formattato }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </table>
                                        @endif
                                    </td>
                                    <td style="padding-top:10px;">
                                        @if (
                                            $preventivo->data_ora_arrivo_rientro_formattato ||
                                                $preventivo->luogo_di_arrivo_rientro ||
                                                $preventivo->ora_arrivo_rientro_formattato)
                                            <table class="width100 rigaVerdeScuro">
                                                <tr>
                                                    <td class="width20">
                                                        <span class="seriale-h4">
                                                            <strong>{{ $preventivo->data_ora_arrivo_rientro_formattato }}
                                                            </strong>
                                                        </span>
                                                    </td>
                                                    <td class="width60">
                                                        <span class="seriale-h4">
                                                            {{ $preventivo->luogo_di_arrivo_rientro }}
                                                        </span>
                                                    </td>
                                                    <td class="width20">
                                                        <span class="seriale-h4">
                                                            {{ $preventivo->ora_arrivo_rientro_formattato }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </table>
                                        @endif
                                    </td>
                                </tr>
                                @if ($preventivo->andata_azienda_trasporto || $preventivo->ritorno_azienda_trasporto)
                                    <tr>
                                        <td style="background-color:#EEEFEF !important;padding-top:10px;">
                                            @if ($preventivo->andata_azienda_trasporto)
                                                <img style="padding-left:5px;" width="50px"
                                                    src="{{ $preventivo->andata_azienda_trasporto->immagine->getUrl() }}" />
                                            @endif
                                        </td>
                                        <td style="background-color:#EEEFEF !important;padding-top:10px;">
                                            @if ($preventivo->ritorno_azienda_trasporto)
                                                <img style="padding-left:5px;" width="50px"
                                                    src="{{ $preventivo->ritorno_azienda_trasporto->immagine->getUrl() }}" />
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    @endif
    @if (
        $preventivo->kg_bg_a_mano_andata ||
            $preventivo->kg_bg_a_mano_ritorno ||
            $preventivo->kg_bg_in_stiva_andata ||
            $preventivo->kg_bg_in_stiva_ritorno)
        <table style="padding:36pt;padding-top:5pt;">
            <tbody>
                <tr>
                    <td>
                        <img style="width:100px;"
                            src="{{ public_path('/images/Icone_0022_LA-BUSSOLA_Icone-08-1024x853.png') }}" />
                    </td>
                    <td>
                        <table style="padding-left:30px;">
                            <tbody>
                                <tr>
                                    <td>
                                        <span class="seriale-h2">
                                            <strong>
                                                Bagaglio a mano
                                            </strong>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="seriale-h2">
                                            Andata Kg {{ $preventivo->kg_bg_a_mano_andata }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="seriale-h2">
                                            Ritorno Kg {{ $preventivo->kg_bg_a_mano_ritorno }}
                                        </span>
                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                        <span class="seriale-h2">
                                            <strong>
                                                Bagaglio in stiva
                                            </strong>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="seriale-h2">
                                            Andata Kg {{ $preventivo->kg_bg_in_stiva_andata }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="seriale-h2">
                                            Ritorno Kg {{ $preventivo->kg_bg_in_stiva_ritorno }}
                                        </span>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    @endif
    @if ($preventivo->itinerario)
        <table style="padding:36pt;padding-top:0px;">
            <tbody>
                <tr>
                    <td>
                        <img style="width:50px;"
                            src="{{ public_path('/images/Icone_0021_LA-BUSSOLA_Icone-09.png') }}" />
                    </td>
                    <td style="width:90%;padding-left:20px;padding-top:25px;">
                        <span class="blu seriale-h1">
                            <strong>Itinerario</strong>
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
        <div style="padding:36pt;padding-top:0px;padding-bottom:0px;">
            <span class="seriale-h4">
                {!! $preventivo->itinerario->descrizione !!}
            </span>
        </div>

        <div style="padding:36pt;padding-top:5pt;padding-bottom:10pt;">
            <table>
                <tr>
                    @foreach ($preventivo->itinerario->immagini as $key => $media)
                        <td class="width33">
                            <img style="width:230px;height:152px;" src="{{ public_path(substr($media->getUrl(), 32)) }}"
                                class="borderedRadiusImage" />
                        </td>
                    @endforeach
                </tr>
            </table>
        </div>
    @endif

    @if ($ciSonoHotel)
        <table style="padding:36pt;padding-bottom:0px;padding-top:10pt;">
            <tbody>
                <tr>
                    <td>
                        <img style="width:50px;"
                            src="{{ public_path('/images/Icone_0017_LA-BUSSOLA_Icone-13-1024x480.png') }}" />
                    </td>
                    <td style="width:90%;padding-left:20px;padding-top:25px;">
                        <span class="blu seriale-h1">
                            <strong>Sistemazioni</strong>
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    @endif
    @foreach ($vociHotel as $hotel)
        <table style="padding:36pt;padding-bottom:0pt;padding-top:10pt;">
            <tbody>
                <tr>
                    <td style="width100">
                        <span class="verde seriale-h4">
                            <strong>{{ $hotel->hotel->nome }}</strong> &nbsp; {!! str_replace('src="', 'src="' . $public_path, $hotel->hotel->stella) !!}
                        </span>

                        <br> <br>
                        <span class="seriale-h4">
                            <strong>{{ $hotel->hotel->indirizzo }}</strong>
                        </span><br><br>
                        <span class="seriale-h4">{{ $hotel->hotel->descrizione }}</span><br><br>
                    </td>
                </tr>
            </tbody>
        </table>
        <table style="padding:36pt;padding-top:10px;width:100%; table-layout: fixed;">
            <tbody>
                <tr>
                    <td class="width50">
                        <span class="seriale-h4">
                            <strong>Cosa è compreso / informazioni:</strong>
                        </span><br>
                        <span class="seriale-h4">
                            {{ $hotel->info_aggiuntive }}
                        </span>
                    </td>
                    <td style="vertical-align: top;" class="width50">
                        <table class="width100">
                            <thead style="box-sizing: border-box;border:3px solid #12913C;">
                                <th style="padding-left:5pt;padding-top:5pt;padding-bottom:5pt;">
                                    <span class="seriale-h4">
                                        <strong>Stanza</strong>
                                    </span>
                                </th>
                                <th class="rightText" style="padding-left:5pt;padding-top:5pt;padding-bottom:5pt;">
                                    <span class="seriale-h4">
                                        <strong>Quantità</strong>
                                    </span>
                                </th>
                            </thead>

                            <tbody>

                                @php
                                    $pariDispari = 0;
                                @endphp
                                @if ($hotel->vociPersona())
                                    @foreach ($hotel->vociPersona() as $voce)
                                        @if ($pariDispari % 2)
                                            <tr class="rigaVerdeChiaro" style="padding-top:5pt;padding-bottom:5pt;">
                                                <td>
                                                    <span style="padding-left:5pt;" class="seriale-h4">
                                                        {{ App\Models\VocePHotelPerNotte::TIPOLOGIA_STANZA_SELECT[$voce->tipologia_stanza] }}
                                                    </span>
                                                </td>
                                                <td class="rightText" style="padding-top:5pt;padding-bottom:5pt;">
                                                    <span style="padding-right:5pt;" class="seriale-h4">
                                                        @if ($voce->tipologia_stanza == 'multipla')
                                                            #
                                                        @else
                                                            {{ $voce->numero_stanze }}
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>
                                        @else
                                            <tr class="rigaVerdeScuro" style="padding-top:5pt;padding-bottom:5pt;">
                                                <td>
                                                    <span style="padding-left:5pt;" class="seriale-h4">
                                                        {{ App\Models\VocePHotelPerNotte::TIPOLOGIA_STANZA_SELECT[$voce->tipologia_stanza] }}
                                                    </span>
                                                </td>
                                                <td class="rightText" style="padding-top:5pt;padding-bottom:5pt;">
                                                    <span style="padding-right:5pt;" class="seriale-h4">
                                                        @if ($voce->tipologia_stanza == 'multipla')
                                                            #
                                                        @else
                                                            {{ $voce->numero_stanze }}
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>
                                        @endif
                                        @php
                                            $pariDispari++;
                                        @endphp
                                    @endforeach
                                @endif
                                @if ($hotel->vociNotti())
                                    @foreach ($hotel->vociNotti() as $voce)
                                        @if ($pariDispari % 2)
                                            <tr class="rigaVerdeChiaro" style="padding-top:5pt;padding-bottom:5pt;">
                                                <td>
                                                    <span style="padding-left:5pt;" class="seriale-h4">
                                                        {{ App\Models\VocePHotelPerNotte::TIPOLOGIA_STANZA_SELECT[$voce->tipologia_stanza] }}
                                                    </span>
                                                </td>
                                                <td class="rightText" style="padding-top:5pt;padding-bottom:5pt;">
                                                    <span style="padding-right:5pt;" class="seriale-h4">
                                                        @if ($voce->tipologia_stanza == 'multipla')
                                                            #
                                                        @else
                                                            {{ $voce->numero_stanze }}
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>
                                        @else
                                            <tr class="rigaVerdeScuro" style="padding-top:5pt;padding-bottom:5pt;">
                                                <td>
                                                    <span style="padding-left:5pt;" class="seriale-h4">
                                                        {{ App\Models\VocePHotelPerNotte::TIPOLOGIA_STANZA_SELECT[$voce->tipologia_stanza] }}
                                                    </span>
                                                </td>
                                                <td class="rightText" style="padding-top:5pt;padding-bottom:5pt;">
                                                    <span style="padding-right:5pt;" class="seriale-h4">
                                                        @if ($voce->tipologia_stanza == 'multipla')
                                                            #
                                                        @else
                                                            {{ $voce->numero_stanze }}
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>
                                        @endif
                                        @php
                                            $pariDispari++;
                                        @endphp
                                    @endforeach
                                @endif
                            <tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>

        <div style="padding-left:36pt;padding-right:36pt;padding-bottom:36pt;">
            <table>
                <tr>
                    @foreach ($hotel->hotel->foto as $key => $media)
                        <td class="width33">
                            <img style="width:230px;height:152px;" src="{{ public_path(substr($media->getUrl(), 32)) }}"
                                class="borderedRadiusImage" />
                        </td>
                    @endforeach
                </tr>
            </table>
        </div>
    @endforeach


    @if (!$vociPTrasportoPerPersona->isEmpty() || !$vociPTrasportoUnaTantum->isEmpty())
        <table style="padding:36pt;">
            <tbody>
                <tr>
                    <td>
                        <img style="width:50px;"
                            src="{{ public_path('/images/Icone_0020_LA-BUSSOLA_Icone-10.png') }}" />
                    </td>
                    <td style="width:90%;padding-left:20px;padding-top:25px;">
                        <span class="blu seriale-h1">
                            <strong>Trasporti</strong>
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    @endif
    @if ($vociPTrasportoPerPersona)
        @foreach ($vociPTrasportoPerPersona as $trasporto)
            <table style="padding-left:36pt;padding-right:36pt;">
                <tr>
                    <td>
                        @foreach ($trasporto->trasporto->foto as $key => $media)
                            <img style="width:50px;" src="{{ public_path(substr($media->getUrl(), 32)) }}" />
                        @endforeach
                    </td>
                    <td style="padding-left:20px;padding-top:20px;">
                        <span style="color:#81C749" class="seriale-h2">
                            <strong> {{ $trasporto->trasporto->nome }}</strong>
			</span><br>
                        @if ($trasporto->informazioni_aggiuntive)
                        <span class="seriale-h4">
                            Informazioni aggiuntive: {{ $trasporto->informazioni_aggiuntive }}
                        </span><br>
                        @endif
                        <span class="seriale-h4">
                            {{ $trasporto->trasporto->descrizione }}
                        </span>
                    </td>
                </tr>
            </table>
        @endforeach
    @endif
    @if ($vociPTrasportoUnaTantum)
        @foreach ($vociPTrasportoUnaTantum as $trasporto)
            <table style="padding-left:36pt;padding-right:36pt;">
                <tr>
                    <td>
                        @foreach ($trasporto->trasporto->foto as $key => $media)
                            <img style="width:50px;" src="{{ public_path(substr($media->getUrl(), 32)) }}" />
                        @endforeach
                    </td>
                    <td style="padding-left:20px;padding-top:20px;">
                        <span style="color:#81C749" class="seriale-h2">
                            <strong> {{ $trasporto->trasporto->nome }}</strong>
                        </span><br>
                        <span class="seriale-h4">
                            {{ $trasporto->trasporto->descrizione }}
                        </span>
                    </td>
                </tr>
            </table>
        @endforeach
    @endif



    @if (!$vociPExtraPerPersona->isEmpty() || !$vociPExtraUnaTantum->isEmpty())
        <table class="table">
            <tbody>
                <tr>
                    <td style="background-color: #ECECED !important;padding:20px;text-align: center;">
                        <span class="blu seriale-h1">
                            <strong>Servizi & Extra</strong>
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    @endif
    @foreach ($vociPExtraUnaTantum as $voce)
        <table style="padding-left:36pt;padding-right:36pt;padding-bottom:15pt;padding-top:15pt;">
            <tbody>

                <tr>
                    <td>
                        @if ($voce->servizio_extra->foto)
                            <img style="width:50px;"
                                src="{{ public_path(substr($voce->servizio_extra->foto->getUrl(), 32)) }}" />
                        @endif
                    </td>
                    <td style="width:90%;padding-left:20px;padding-top:25px;">
                        <span class="blu seriale-h1">
                            <strong>{{ $voce->servizio_extra->nome }} - Quantità {{ $voce->quantita }}</strong>
                        </span>
                    </td>
                </tr>

            </tbody>
        </table>
        @if ($voce->info_aggiuntive)
            <div style="padding-left:72pt;padding-right:36pt;">

                {!! $voce->info_aggiuntive !!}
            </div>
        @endif

        <div style="padding-left:72pt;padding-right:36pt;">
            {!! str_replace('src="', 'src="' . $public_path, $voce->servizio_extra->descrizione) !!}
        </div>
    @endforeach
    @foreach ($vociPExtraPerPersona as $voce)
        <table style="padding-left:36pt;padding-right:36pt;padding-bottom:15pt;padding-top:15pt;">
            <tbody>

                <tr>
                    <td>
                        @if ($voce->servizio_extra->foto)
                            <img style="width:50px;"
                                src="{{ public_path(substr($voce->servizio_extra->foto->getUrl(), 32)) }}" />
                        @endif
                    </td>
                    <td style="width:90%;padding-left:20px;padding-top:25px;">
                        <span class="blu seriale-h1">
                            <strong>{{ $voce->servizio_extra->nome }} - Quantità per persona:
                                {{ $voce->quantita }}</strong>
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
        <div style="padding-left:72pt;padding-right:36pt;">
            {!! str_replace('src="', 'src="' . $public_path, $voce->servizio_extra->descrizione) !!}
        </div>
        @if ($voce->info_aggiuntive)
            <div style="padding-left:72pt;padding-right:36pt;">

                {!! $voce->info_aggiuntive !!}
            </div>
        @endif
    @endforeach

    <table class="table" style="padding-top:36pt;padding-bottom:36pt;padding-top:15pt;">
        <tbody>
            <tr>
                <td style="background-color: #D3ECC0 !important;padding:20px;text-align: center;">
                    <span style="font-size:30px !important" class="verde seriale-h3">
                        <strong>
                            La quota di partecipazione per persona è di
                        </strong>
                    </span>
                    <br>
                    <span style="font-size:50px !important" class="verde seriale-h1">
                        <b>
                            € {{ $preventivo->prezzo_per_persona != '' ? $preventivo->prezzo_per_persona : $preventivo->prezzo_pacchetto }}
                        </b>
                    </span>
                    <br>
                    @if ($preventivo->prezzo_parte)
                        <span class="seriale-h4">
                            <strong>€ {{ round($preventivo->prezzo_parte / ($preventivo->numero_persone - $preventivo->numero_gratuita), 2) }}</strong> da pagare a persona
                            per servizi non inclusi nella quota di partecipazione
                            </strong>
                        </span>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
    <div style="page-break-inside: auto;padding-left:36pt;padding-right:36pt;">


        <span class="blu seriale-h1">
            <strong>Riepilogo</strong>
        </span>

        <br><br>
        <!-- INCLUSO -->
        @if ($preventivo->printQuotaComprende() != '')
            <span class="seriale-h4">
                <strong>La quota comprende:</strong>
            </span><br><br>
            <!-- INCLUSO -->

            {!! str_replace('src="', 'src="' . $public_path, $preventivo->printQuotaComprende()) !!}
        @endif

        <!-- ESCLUSO -->
        @if ($preventivo->printQuotaNonComprende() != '')
            <br><br>
            <span class="seriale-h4">
                <strong>
                    La quota non comprende:
                </strong>
            </span>
            <br><br>
            <!-- ESCLUSO -->
            {!! str_replace('src="', 'src="' . $public_path, $preventivo->printQuotaNonComprende()) !!}
        @endif
    </div>

    @if ($preventivo->informazioni_aggiuntive)
        <table style="padding:36pt;padding-top:10pt;padding-bottom:10px;">
            <tbody>
                <tr>
                    <td>
                        <img style="width:50px;" src="{{ public_path('/images/altraicona.png') }}" />
                    </td>
                    <td style="width:90%;padding-left:20px;padding-top:25px;">
                        <span class="blu seriale-h1">
                            <strong>Attenzione</strong>
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    @endif

    @if ($preventivo->informazioni_aggiuntive)
        <div style="page-break-inside: auto;padding-left:36pt;padding-right:36pt;">

            <span class="seriale-h4">
                {!! $preventivo->informazioni_aggiuntive !!}
            </span>

        </div>
    @endif

    <div style="margin-bottom:500px;">
        &nbsp;
    </div>
    <div style="position: absolute;bottom:0px;">
        <div
            style="page-break-inside: avoid;padding:36pt;padding-top:10pt;padding-bottom:10pt;margin: 36pt; margin-top:10pt;background-color: #C7D4EA; border-radius: 41px;">
            <div class="seriale-h1 blu" style="text-align: center !important;">
                <strong>ASSISTENZA PRIMA - DURANTE - DOPO IL VIAGGIO</strong>
            </div>
            <table style="width: 100%;padding-top:10pt;">
                <tr>
                    <td style="padding-right:10pt;">
                        <img style="width:50px;"
                            src="{{ public_path('/images/Icone_0006_LA-BUSSOLA_Icone-24-1024x894.png') }}">
                    </td>
                    <td style="text-align:left;">
                        <span class="seriale-h4"> <strong class="blu">Assistenza</strong> in fase di realizzazione
                            del
                            viaggio e itinerario da
                            parte
                            del nostro personale qualificato.</span>
                    </td>
                </tr>
            </table>
            <table style="width: 100%;padding-top:10pt;">
                <tr>
                    <td style="padding-right:10pt;">
                        <img style="width:50px;"
                            src="{{ public_path('/images/Icone_0005_LA-BUSSOLA_Icone-25.png') }}">
                    </td>
                    <td style="text-align:left;">
                        <span class="seriale-h4"> <strong class="blu">Assistenza Centrale operativa</strong>
                            24h su 24 e 365 giorni
                            l’anno
                            per
                            qualsiasi esigenza medica <strong class="blu">Help-Line attiva </strong> tutti i giorni
                            24h
                            su
                            24
                            tutti
                            i giorni da parte del nostro personale via telefono e anche tramite <strong
                                class="blu">app
                                iOS
                                e
                                Android La Bussola on the road</strong>. </span>
                    </td>
                </tr>
            </table>
            @if ($preventivo->created_by)
                <table style="width: 100%;padding-top:20pt;">
                    <tr>
                        <td style="padding-right:10pt;">
                            <img style="width:50px;"
                                src="{{ public_path('/images/Icone_0004_LA-BUSSOLA_Icone-26.png') }}">
                        </td>
                        <td style="text-align:left;">
                            <span class="seriale-h4"> Preventivo realizzato da <strong>
                                    {{ $preventivo->created_by->name }} </strong>, contatti
                                telefonici {{ $preventivo->created_by->telefono }}
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        </td>
                    </tr>
                </table>
            @endif
        </div>


        <div style="page-break-inside: avoid;">
            <table class="table">
                <tbody>
                    <tr>
                        <td style="background-color: #2054AD !important;padding:15px;text-align: center;">
                            <span style="color:white" class="seriale-h1">
                                <strong>
                                    Hai dubbi o domande?
                                </strong>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table style="background-color: #ECECED !important;padding:36pt;padding-top:10pt;padding-bottom:15pt;"
                class="table">
                <tbody>
                    <tr>
                        <td style="width:33%;vertical-align: middle;">

                            <img style="width:100%"
                                src="{{ public_path('/images/Logo-LaBussola-1-1024x395.png') }}"><br>
                            <span class="seriale-h4">
                                Via Altaguardia, 1 – 20135 – Milano – IT<br>
                                Cod. Fisc. / P. IVA 08114120960<br>
                                REA: MI – 2003676 – Capitale Sociale: € 10.000<br>
                            </span>
                        </td>
                        <td style="width:33%">
                            <span class="seriale-h4">
                                <strong>LA BUSSOLA srl – Agenzia viaggi e tour operator</strong>
                            </span><br><br>
                            <div
                                style="background-color: #2054AD !important;
                    border-radius: 36px 36px 36px 36px;padding:4pt;color:white;
                    width:100%;margin-bottom:-20px;">
                                <img style="width:10px;padding-top:3px;"
                                    src="{{ public_path('/images/Icone_0003_LA-BUSSOLA_Icone-27-1024x985.png') }}">
                                <span style="padding-left:10px;" class="seriale-h4">
                                    <strong>
                                       +39  02 8219 6055
                                    </strong>
                                </span>
                            </div><br><br>
                            <div
                                style="background-color: #2054AD !important;
                    border-radius: 36px 36px 36px 36px;padding:4pt;color:white;
                    width:100%;margin-bottom:-20px;">
                                <img style="width:10px;padding-top:3px;"
                                    src="{{ public_path('/images/Icone_0002_LA-BUSSOLA_Icone-28.png') }}">
                                <span style="padding-left:10px;" class="seriale-h4">
                                    <strong>
                                        +39 02 8088 6574
                                    </strong>
                                </span>
                            </div><br><br>
                            <div
                                style="background-color: #2054AD !important;
                    border-radius: 36px 36px 36px 36px;padding:4pt;color:white;
                    width:100%;margin-bottom:-20px;">
                                <img style="width:10px;padding-top:3px;"
                                    src="{{ public_path('/images/Icone_0001_LA-BUSSOLA_Icone-29-1024x681.png') }}">
                                <span style="padding-left:10px;" class="seriale-h4">
                                    <strong>
                                        preventivi@labussola.it
                                    </strong>
                                </span>
                            </div><br><br>
                            <div
                                style="background-color: #2054AD !important;
                    border-radius: 36px 36px 36px 36px;padding:4pt;color:white;
                    width:100%;margin-bottom:-20px;">
                                <img style="width:10px;padding-top:3px;"
                                    src="{{ public_path('/images/Icone_0000_LA-BUSSOLA_Icone-30-1024x759.png') }}">
                                <span style="padding-left:10px;" class="seriale-h4">
                                    <strong>
                                        labussolamilano@pec.it
                                    </strong>
                                </span>
                            </div>
                        </td>
                        <td style="width:33%;text-align:center;vertical-align: middle;">
                            <span style="padding-left:10px;" class="seriale-h4">
                                <strong>
                                    Scarica la nostra app<br>
                                    “La Bussola on the road”!
                                </strong>
                            </span><br><br>
                            <img style="width:60%;padding-left:5pt;padding-right:5pt;"
                                src="{{ public_path('/images/Immagine-2022-12-28-200645.jpg') }}">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
