<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVocePHotelPerPersonasTable extends Migration
{
    public function up()
    {
        Schema::create('voce_p_hotel_per_personas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipologia_stanza');
            $table->integer('numero_stanze');
            $table->decimal('costo_a_notte', 15, 2);
            $table->boolean('scorpora')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
