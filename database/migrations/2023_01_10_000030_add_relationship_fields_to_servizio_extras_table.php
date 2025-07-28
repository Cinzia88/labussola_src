<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToServizioExtrasTable extends Migration
{
    public function up()
    {
        Schema::table('servizio_extras', function (Blueprint $table) {
            $table->unsignedBigInteger('fornitore_id')->nullable();
            $table->foreign('fornitore_id', 'fornitore_fk_7662127')->references('id')->on('fornitores');
        });
    }
}
