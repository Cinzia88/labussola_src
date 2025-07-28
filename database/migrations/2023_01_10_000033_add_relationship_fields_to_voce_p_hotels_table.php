<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToVocePHotelsTable extends Migration
{
    public function up()
    {
        Schema::table('voce_p_hotels', function (Blueprint $table) {
            $table->unsignedBigInteger('hotel_id')->nullable();
            $table->foreign('hotel_id', 'hotel_fk_7689258')->references('id')->on('alloggio_hotels');
            $table->unsignedBigInteger('preventivo_id')->nullable();
            $table->foreign('preventivo_id', 'preventivo_fk_7689590')->references('id')->on('preventivos');
        });
    }
}
