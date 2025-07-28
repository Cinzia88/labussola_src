<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVocePHotelsTable extends Migration
{
    public function up()
    {
        Schema::create('voce_p_hotels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('info_aggiuntive')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
