<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('projet')->nullable();
            $table->unsignedBigInteger('membre')->nullable();                         
            $table->string('statut')->nullable();
            $table->foreign('projet')->references('id')->on('projets')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('membre')->references('id')->on('membres')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipes');
    }
}
