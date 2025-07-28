<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScadenziariosTable extends Migration
{
    public function up()
    {
        Schema::create('scadenziarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->date('data');
            $table->boolean('eseguito')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
