<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToScadenziariosTable extends Migration
{
    public function up()
    {
        Schema::table('scadenziarios', function (Blueprint $table) {
            $table->unsignedBigInteger('preventivo_id')->nullable();
            $table->foreign('preventivo_id', 'preventivo_fk_7620890')->references('id')->on('preventivos');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_7620957')->references('id')->on('users');
        });
    }
}
