<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvenementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evenements', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->text('description')->nullable();
            $table->timestamp('date_evenement');
            $table->time('heure_debut');
            $table->string('lieu');
            $table->integer('prix')->nullable();
            $table->integer('places')->nullable();
            $table->integer('duree')->nullable();
            $table->string('image')->nullable();
            //$table->string('fichier')->nullable();
            // $table->unsignedBigInteger('organisateur');
            // $table->foreign('organisateur')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('evenements');
    }
}

