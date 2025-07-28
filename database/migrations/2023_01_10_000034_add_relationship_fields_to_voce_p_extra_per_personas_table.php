<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToVocePExtraPerPersonasTable extends Migration
{
    public function up()
    {
        Schema::table('voce_p_extra_per_personas', function (Blueprint $table) {
            $table->unsignedBigInteger('servizio_extra_id')->nullable();
            $table->foreign('servizio_extra_id', 'servizio_extra_fk_7689265')->references('id')->on('servizio_extras');
            $table->unsignedBigInteger('preventivo_id')->nullable();
            $table->foreign('preventivo_id', 'preventivo_fk_7689591')->references('id')->on('preventivos');
        });
    }
}
