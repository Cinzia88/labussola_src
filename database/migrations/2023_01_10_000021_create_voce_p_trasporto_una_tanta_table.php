<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVocePTrasportoUnaTantaTable extends Migration
{
    public function up()
    {
        Schema::create('voce_p_trasporto_una_tanta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipologia_trasporto')->nullable();
            $table->boolean('scorpora')->default(0)->nullable();
            $table->decimal('prezzo', 15, 2);
            $table->longText('informazioni_aggiuntive')->nullable();
            $table->string('tipologia');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
