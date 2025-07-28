<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToVocePTrasportoUnaTantaTable extends Migration
{
    public function up()
    {
        Schema::table('voce_p_trasporto_una_tanta', function (Blueprint $table) {
            $table->unsignedBigInteger('trasporto_id')->nullable();
            $table->foreign('trasporto_id', 'trasporto_fk_7689619')->references('id')->on('trasportos');
            $table->unsignedBigInteger('preventivo_id')->nullable();
            $table->foreign('preventivo_id', 'preventivo_fk_7689630')->references('id')->on('preventivos');
        });
    }
}
