<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveTypeDataFromParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('participants', function (Blueprint $table) {
            //
            $table->dropColumn('porteurProjet');
            $table->dropColumn('presentation1');
            $table->dropColumn('presentation2');
            $table->dropColumn('environnement');
            $table->dropColumn('financement');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('participants', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('porteurProjet');
            $table->unsignedBigInteger('presentation1');
            $table->unsignedBigInteger('presentation2');
            $table->unsignedBigInteger('environnement');
            $table->unsignedBigInteger('financement');
        });
    }
}
