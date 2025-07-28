<?php

namespace App\Exports;

use App\Models\Preventivo;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class PreventivoCreatedAtBetweenExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting, ShouldAutoSize
{
    use Exportable;

    private Carbon $dateFrom;
    private Carbon $dateTo;

    public function __construct(Carbon $dateFrom, Carbon $dateTo)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public function headings(): array
    {
        return [
            'tag id',
            'numero',
            'anno',
            'oggetto',
            'ragione sociale',
            'cliente',
            'itinerario',
            'creato da',
            'email',
            'status',
            'numero persone',
            'data inizio viaggio',
            'data fine viaggio',
            'creato il',
            'markup'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'L' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'M' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'N' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'O' => NumberFormat::FORMAT_CURRENCY_EUR_INTEGER
        ];
    }

    public function map($preventivo): array
    {
        $cliente = $preventivo->cliente->nome ?? '';
        $cliente .= " ";
        $cliente .= $preventivo->cliente->cognome ?? '';

        $carbonDataInizioViaggio = Carbon::createFromFormat('d/m/Y', $preventivo->data_inzio_viaggio);
        $carbonDataFineViaggio = Carbon::createFromFormat('d/m/Y', $preventivo->data_fine_viaggio);
        $carbonCreatedAt = Carbon::createFromFormat('d/m/Y H:i:s', $preventivo->created_at);

        $markup = number_format($preventivo->markup, 2, ',', '.');

        return [
            $preventivo->tag_id,
            $preventivo->numero,
            $preventivo->anno,
            $preventivo->oggetto,
            $preventivo->cliente->ragione_sociale ?? '',
            $cliente,
            $preventivo->itinerario->nome ?? '',
            $preventivo->created_by->name ?? '',
            $preventivo->cliente->email ?? '',
            \App\Models\Preventivo::STATUS_SELECT[$preventivo->status] ?? '',
            $preventivo->numero_persone,
            Date::dateTimeToExcel($carbonDataInizioViaggio->toDateTimeImmutable()),
            Date::dateTimeToExcel($carbonDataFineViaggio->toDateTimeImmutable()),
            Date::dateTimeToExcel($carbonCreatedAt->toDateTimeImmutable()),
            $markup
        ];
    }

    public function collection()
    {
        return Preventivo::withoutGlobalScope('created_by_id')
            ->with('cliente')
            ->with('created_by')
            ->with('itinerario')
            ->whereBetween('preventivos.created_at', [$this->dateFrom, $this->dateTo])
            ->get();
    }
}
