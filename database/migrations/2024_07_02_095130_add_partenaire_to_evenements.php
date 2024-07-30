<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPartenaireToEvenementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('evenements', function (Blueprint $table) {
            $table->unsignedBigInteger('partenaire_image')->nullable();
            $table->foreign('partenaire_image')->references('id')->on('partenaires')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('evenements', function (Blueprint $table) {
            $table->dropForeign(['partenaire_image']);
            $table->dropColumn('partenaire_image');
        });
    }
}