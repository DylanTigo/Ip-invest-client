<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemovePartenaireIdFromEvenementPartnerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('evenement_partner', function (Blueprint $table) {
            //
            $table->dropColumn('partenaire_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('evenement_partner', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('partenaire_id');
        });
    }
}
