<?php


namespace App\Helpers;

use Illuminate\Database\Eloquent\Collection;

class Utilities
{
    /**
     * Posiziona la polizza in fondo alla collection, in questo modo sarà visualizzata
     * in fondo al preventivo
     *
     * @param Collection $serviziExtra
     */
    public static function posizionaPolizzaInFondo(Collection $serviziExtra) {
        $totalExtra = $serviziExtra->count();

        foreach ($serviziExtra as $key => $voce) {
            if ($key === ($totalExtra-1)) {
                break;
            }
            elseif (str_contains(strtolower($voce->servizio_extra->nome), 'polizza')) {
                $serviziExtra->forget($key);
                $serviziExtra->push($voce);
            }
        }
    }
}
