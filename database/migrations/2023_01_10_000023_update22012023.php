<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Update22012023 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('voce_p_extra_una_tanta', function (Blueprint $table) {
            $table->longText('quota_comprende')->nullable();
        });
        Schema::table('voce_p_extra_per_personas', function (Blueprint $table) {
            $table->longText('quota_comprende')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('voce_p_extra_una_tanta', function (Blueprint $table) {
            $table->longText('quota_comprende')->nullable();
        });
        Schema::table('voce_p_extra_per_personas', function (Blueprint $table) {
            $table->longText('quota_comprende')->nullable();
        });
    }
}
