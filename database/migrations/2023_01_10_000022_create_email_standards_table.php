<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailStandardsTable extends Migration
{
    public function up()
    {
        Schema::create('email_standards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->longText('corpo_email');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
