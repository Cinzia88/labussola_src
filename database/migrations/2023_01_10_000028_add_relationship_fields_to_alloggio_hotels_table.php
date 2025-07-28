<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToAlloggioHotelsTable extends Migration
{
    public function up()
    {
        Schema::table('alloggio_hotels', function (Blueprint $table) {
            $table->unsignedBigInteger('fornitore_id')->nullable();
            $table->foreign('fornitore_id', 'fornitore_fk_7662776')->references('id')->on('fornitores');
        });
    }
}
