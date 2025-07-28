<?php

namespace App\Observers;

use App\Models\Preventivo;
use App\Models\SettingsDinamici;
use App\Models\VocePExtraPerPersona;
use App\Models\VocePExtraUnaTantum;
use App\Models\VocePHotel;
use App\Models\VocePHotelPerNotte;
use App\Models\VocePHotelPerPersona;
use App\Models\VocePTrasportoPerPersona;
use App\Models\VocePTrasportoUnaTantum;
use Illuminate\Support\Str;

class PreventivoObserver
{
    /**
     * Handle the Preventivo "created" event.
     *
     * @param  \App\Models\Preventivo  $preventivo
     * @return void
     */
    public function created(Preventivo $preventivo)
    {
        $settingsDinamici = SettingsDinamici::first();
        $settingsDinamici->progressivo += 1;
        $settingsDinamici->save();
    }

    //Creating handler
    public function creating(Preventivo $preventivo)
    {
        $settingsDinamici = SettingsDinamici::first();
        //controllo se esistono i settings dinamici altrementi creo
        if (!$settingsDinamici) SettingsDinamici::create(['progressivo' => 1]);

        $settingsDinamici = SettingsDinamici::first();
        $preventivo->numero =   $settingsDinamici->progressivo;
        $preventivo->anno = date('Y');
    }



    /**
     * Handle the Preventivo "updated" event.
     *
     * @param  \App\Models\Preventivo  $preventivo
     * @return void
     */
    public function updated(Preventivo $preventivo)
    {
        //
    }

    /**
     * Handle the Preventivo "deleted" event.
     *
     * @param  \App\Models\Preventivo  $preventivo
     * @return void
     */
    public function deleted(Preventivo $preventivo)
    {
        //
    }

    public function deleting(Preventivo $preventivo)
    {
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
    }


    /**
     * Handle the Preventivo "restored" event.
     *
     * @param  \App\Models\Preventivo  $preventivo
     * @return void
     */
    public function restored(Preventivo $preventivo)
    {
        //
    }

    /**
     * Handle the Preventivo "force deleted" event.
     *
     * @param  \App\Models\Preventivo  $preventivo
     * @return void
     */
    public function forceDeleted(Preventivo $preventivo)
    {
        //
    }
}
