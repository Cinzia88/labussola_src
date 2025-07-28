<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEtichettaColori extends Migration
{
    public function up()
    {
        Schema::table('scadenziarios', function ($table) {
            $table->string('colore_eticchetta');
        });
    }
}
