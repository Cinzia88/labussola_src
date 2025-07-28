<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToVocePHotelPerNottesTable extends Migration
{
    public function up()
    {
        Schema::table('voce_p_hotel_per_nottes', function (Blueprint $table) {
            $table->unsignedBigInteger('voce_hotel_id')->nullable();
            $table->foreign('voce_hotel_id', 'voce_hotel_fk_7689263')->references('id')->on('voce_p_hotels');
        });
    }
}
