<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PreventivoCreatedAtBetweenExport;
use App\Http\Controllers\Controller;
use App\Models\Preventivo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Gate;

class ReportController extends Controller
{
    public function preventivoDataCreazione(Request $request) {

        $reportData = new Collection();

        try{

            $validatedData = $request->validate([
                'dateFrom' => 'required|date',
                'dateTo' => 'required|date',
            ]);

            if ( $request->excel ) {

                $carbonDateFrom = Carbon::parse($request->dateFrom);
                $carbonDateTo = Carbon::parse($request->dateTo);

                $fileDateFrom = $carbonDateFrom->format('Y_m_d');
                $fileDateTo = $carbonDateTo->format('Y_m_d');
                $fileName = "export_preventivi_data_creazione_dal_".$fileDateFrom."_al_".$fileDateTo.'.xls';

                return Excel::download(new PreventivoCreatedAtBetweenExport($carbonDateFrom, $carbonDateTo), $fileName);

            }else {

                $reportData = Preventivo::withoutGlobalScope('created_by_id')
                    ->with('cliente')
                    ->with('created_by')
                    ->with('itinerario')
                    ->whereBetween('preventivos.created_at', [$request->dateFrom, $request->dateTo])
                    ->get();
            }

        }catch (ValidationException $validationException) {}

        return view('admin/report/preventivoDataCreazione', [
            'reportData' => $reportData,
            'dateFrom' => $request->dateFrom,
            'dateTo' => $request->dateTo
        ]);
    }
}
