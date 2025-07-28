<?php

namespace App\Console\Commands;

use App\Models\SettingsDinamici;
use Illuminate\Console\Command;

class ResettaProgressivo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ResettaProgressivo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resetta progressivo preventivi';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $settingsDinamici = SettingsDinamici::first();
        $settingsDinamici->progressivo = 1;
        $settingsDinamici->save();

        return 0;
    }
}
