<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrasportosTable extends Migration
{
    public function up()
    {
        Schema::create('trasportos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->longText('descrizione')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
