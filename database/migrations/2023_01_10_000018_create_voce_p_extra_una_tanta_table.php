<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVocePExtraUnaTantaTable extends Migration
{
    public function up()
    {
        Schema::create('voce_p_extra_una_tanta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('prezzo', 15, 2);
            $table->integer('quantita');
            $table->boolean('scorpora')->default(0)->nullable();
            $table->longText('info_aggiuntive')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
