<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsDinamicisTable extends Migration
{
    public function up()
    {
        Schema::create('settings_dinamicis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('progressivo');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
