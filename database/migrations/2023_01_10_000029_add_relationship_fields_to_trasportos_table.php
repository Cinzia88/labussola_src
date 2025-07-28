<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTrasportosTable extends Migration
{
    public function up()
    {
        Schema::table('trasportos', function (Blueprint $table) {
            $table->unsignedBigInteger('fornitore_id')->nullable();
            $table->foreign('fornitore_id', 'fornitore_fk_7662128')->references('id')->on('fornitores');
        });
    }
}
