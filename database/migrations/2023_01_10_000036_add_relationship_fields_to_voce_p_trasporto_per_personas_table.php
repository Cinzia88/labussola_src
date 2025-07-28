<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToVocePTrasportoPerPersonasTable extends Migration
{
    public function up()
    {
        Schema::table('voce_p_trasporto_per_personas', function (Blueprint $table) {
            $table->unsignedBigInteger('trasporto_id')->nullable();
            $table->foreign('trasporto_id', 'trasporto_fk_7689310')->references('id')->on('trasportos');
            $table->unsignedBigInteger('preventivo_id')->nullable();
            $table->foreign('preventivo_id', 'preventivo_fk_7689593')->references('id')->on('preventivos');
        });
    }
}
