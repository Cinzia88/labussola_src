<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreventivosTable extends Migration
{
    public function up()
    {
        Schema::create('preventivos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('oggetto')->nullable();
            $table->integer('numero')->nullable();
            $table->integer('anno')->nullable();
            $table->boolean('rg_fullname')->default(0)->nullable();
            $table->integer('numero_persone')->nullable();
            $table->string('status');
            $table->date('data_inzio_viaggio');
            $table->date('data_fine_viaggio');
            $table->boolean('date_indicative')->default(0)->nullable();
            $table->longText('informazioni_aggiuntive')->nullable();
            $table->string('guid')->unique();
            $table->string('viewkey')->unique();
            $table->string('luogo_di_partenza_andata')->nullable();
            $table->string('luogo_di_arrivo_andata')->nullable();
            $table->datetime('data_ora_partenza_andata')->nullable();
            $table->datetime('data_ora_rientro_andata')->nullable();
            $table->string('luogo_di_partenza_rientro')->nullable();
            $table->string('luogo_di_arrivo_rientro')->nullable();
            $table->datetime('data_ora_partenza_rientro')->nullable();
            $table->datetime('data_ora_rientro_rientro')->nullable();
            $table->integer('numero_gratuita');
            $table->decimal('markup', 15, 2);
            $table->integer('kg_bg_a_mano_andata')->nullable();
            $table->integer('kg_bg_a_mano_ritorno')->nullable();
            $table->integer('kg_bg_in_stiva_andata')->nullable();
            $table->integer('kg_bg_in_stiva_ritorno')->nullable();
            $table->longText('corpo_email')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
