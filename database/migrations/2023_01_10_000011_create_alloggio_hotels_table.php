<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlloggioHotelsTable extends Migration
{
    public function up()
    {
        Schema::create('alloggio_hotels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->string('indirizzo')->nullable();
            $table->longText('descrizione')->nullable();
            $table->string('stelle');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
