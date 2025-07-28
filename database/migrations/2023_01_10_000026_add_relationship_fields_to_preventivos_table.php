<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPreventivosTable extends Migration
{
    public function up()
    {
        Schema::table('preventivos', function (Blueprint $table) {
            $table->unsignedBigInteger('itinerario_id')->nullable();
            $table->foreign('itinerario_id', 'itinerario_fk_7689587')->references('id')->on('itineraris');
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->foreign('cliente_id', 'cliente_fk_7609387')->references('id')->on('clientis');
            $table->unsignedBigInteger('andata_azienda_trasporto_id')->nullable();
            $table->foreign('andata_azienda_trasporto_id', 'andata_azienda_trasporto_fk_7849146')->references('id')->on('aziende_trasportis');
            $table->unsignedBigInteger('ritorno_azienda_trasporto_id')->nullable();
            $table->foreign('ritorno_azienda_trasporto_id', 'ritorno_azienda_trasporto_fk_7849147')->references('id')->on('aziende_trasportis');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_7609334')->references('id')->on('users');
        });
    }
}
